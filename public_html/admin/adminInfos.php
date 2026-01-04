<?php
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['isAdmin'])) {
    header("Location: ./../index.php");
    exit();
}

include_once './../classesDAO/ReservationDAO.php';
include_once './../classes/GestionConnexion.php';

$connexion = GestionConnexion::getConnexion();

$typeFilter = isset($_GET['type']) ? $_GET['type'] : 'toutes'; 
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'enattente'; 

$whereStatusSalle = '';
$whereStatusMateriel = '';
if ($statusFilter === 'enattente') {
    $whereStatusSalle = "AND rs.AutorisationFinal = 0";
    $whereStatusMateriel = "AND rm.AutorisationFinal = 0";
} elseif ($statusFilter === 'acceptees') {
    $whereStatusSalle = "AND rs.AutorisationFinal = 1";
    $whereStatusMateriel = "AND rm.AutorisationFinal = 1";
}

$sqlSalles = "SELECT rs.idU, rs.idR_salle, rs.DateTime_debut, rs.DateTime_fin, rs.Nb_occupant, rs.AutorisationFinal, u.nomU, u.prenomU, u.mailU, s.nomSalles as SalleName
    FROM ReserverSalles rs
    JOIN Utilisateur u ON u.idU = rs.idU
    JOIN Salles s ON s.idR = rs.idR_salle
    WHERE 1=1 $whereStatusSalle AND rs.Blocage = 0
    ORDER BY rs.DateTime_debut ASC";

$sqlMateriels = "SELECT rm.idU, rm.idR_materiel, rm.DateTime_debut, rm.DateTime_fin, rm.AutorisationFinal, u.nomU, u.prenomU, u.mailU, r.Nom as MaterielName
    FROM ReserverMateriels rm
    JOIN Utilisateur u ON u.idU = rm.idU
    JOIN Materiels m ON m.idR = rm.idR_materiel
    JOIN Reservables r ON r.idR = rm.idR_materiel
    WHERE 1=1 $whereStatusMateriel AND rm.Blocage = 0
    ORDER BY rm.DateTime_debut ASC";

$stmtSalles = $connexion->prepare($sqlSalles);
$stmtSalles->execute();
$reservationsSalles = $stmtSalles->fetchAll(PDO::FETCH_ASSOC);

$stmtMateriels = $connexion->prepare($sqlMateriels);
$stmtMateriels->execute();
$reservationsMateriels = $stmtMateriels->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion des Réservations - FABLAB</title>
        <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="./../CSS/style.css"/>
        <script src="./../bootstrap/js/color-modes.js"></script>
        <meta name="theme-color" content="#712cf9" />

    </head>
    <body>
        <?php require_once './../commun/header.php'; ?>
        
        <div class="container my-5">
            <h1 class="mb-4">Gestion des Réservations</h1>

            <form class="row g-3 align-items-end mb-4" method="GET">
                <div class="col-auto">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="toutes" <?= $typeFilter === 'toutes' ? 'selected' : '' ?>>Toutes</option>
                        <option value="salle" <?= $typeFilter === 'salle' ? 'selected' : '' ?>>Salles</option>
                        <option value="materiel" <?= $typeFilter === 'materiel' ? 'selected' : '' ?>>Matériels</option>
                    </select>
                </div>
                <div class="col-auto">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="enattente" <?= $statusFilter === 'enattente' ? 'selected' : '' ?>>En attente</option>
                        <option value="acceptees" <?= $statusFilter === 'acceptees' ? 'selected' : '' ?>>Acceptées</option>
                        <option value="toutes" <?= $statusFilter === 'toutes' ? 'selected' : '' ?>>Toutes</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-fablab-blue">Filtrer</button>
                </div>
            </form>

            <?php if ($typeFilter === 'toutes' || $typeFilter === 'salle'): ?>
            <section class="mb-5">
                <h2 class="h5 mb-3">Réservations — Salles</h2>
                <?php if (count($reservationsSalles) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Salle</th>
                                    <th>Réservant</th>
                                    <th>Email</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Nb occupants</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($reservationsSalles as $resa): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($resa['SalleName']) ?></strong></td>
                                    <td><?= htmlspecialchars($resa['prenomU'] . ' ' . $resa['nomU']) ?></td>
                                    <td><?= htmlspecialchars($resa['mailU']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($resa['DateTime_debut'])) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($resa['DateTime_fin'])) ?></td>
                                    <td><?= htmlspecialchars($resa['Nb_occupant']) ?></td>
                                    <td>
                                        <?= intval($resa['AutorisationFinal']) === 1 ? '<span class="badge bg-success">Acceptée</span>' : '<span class="badge bg-info">En attente</span>' ?>
                                    </td>
                                    <td>
                                        <form method="POST" action="./../scriptAdmin/scriptBtnAcceptRefus.php" style="display:inline-block;margin-right:6px;">
                                            <input type="hidden" name="Action" value="1">
                                            <input type="hidden" name="type" value="true">
                                            <input type="hidden" name="idU" value="<?= htmlspecialchars($resa['idU']) ?>">
                                            <input type="hidden" name="idR" value="<?= htmlspecialchars($resa['idR_salle']) ?>">
                                            <input type="hidden" name="dateDebut" value="<?= htmlspecialchars($resa['DateTime_debut']) ?>">
                                            <button type="submit" class="btn btn-sm btn-fablab-yellow">Accepter</button>
                                        </form>
                                        <form method="POST" action="./../scriptAdmin/scriptBtnAcceptRefus.php" style="display:inline-block;">
                                            <input type="hidden" name="Action" value="0">
                                            <input type="hidden" name="type" value="true">
                                            <input type="hidden" name="idU" value="<?= htmlspecialchars($resa['idU']) ?>">
                                            <input type="hidden" name="idR" value="<?= htmlspecialchars($resa['idR_salle']) ?>">
                                            <input type="hidden" name="dateDebut" value="<?= htmlspecialchars($resa['DateTime_debut']) ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-fablab-blue">Refuser</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Aucune réservation de salle correspondant aux filtres.</p>
                <?php endif; ?>
            </section>
            <?php endif; ?>

            <?php if ($typeFilter === 'toutes' || $typeFilter === 'materiel'): ?>
            <section class="mb-5">
                <h2 class="h5 mb-3">Réservations — Matériels</h2>
                <?php if (count($reservationsMateriels) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Matériel</th>
                                    <th>Réservant</th>
                                    <th>Email</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($reservationsMateriels as $resa): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($resa['MaterielName']) ?></strong></td>
                                    <td><?= htmlspecialchars($resa['prenomU'] . ' ' . $resa['nomU']) ?></td>
                                    <td><?= htmlspecialchars($resa['mailU']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($resa['DateTime_debut'])) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($resa['DateTime_fin'])) ?></td>
                                    <td>
                                        <?= intval($resa['AutorisationFinal']) === 1 ? '<span class="badge bg-success">Acceptée</span>' : '<span class="badge bg-info">En attente</span>' ?>
                                    </td>
                                    <td>
                                        <form method="POST" action="./../scriptAdmin/scriptBtnAcceptRefus.php" style="display:inline-block;margin-right:6px;">
                                            <input type="hidden" name="Action" value="1">
                                            <input type="hidden" name="type" value="false">
                                            <input type="hidden" name="idU" value="<?= htmlspecialchars($resa['idU']) ?>">
                                            <input type="hidden" name="idR" value="<?= htmlspecialchars($resa['idR_materiel']) ?>">
                                            <input type="hidden" name="dateDebut" value="<?= htmlspecialchars($resa['DateTime_debut']) ?>">
                                            <button type="submit" class="btn btn-sm btn-fablab-yellow">Accepter</button>
                                        </form>
                                        <form method="POST" action="./../scriptAdmin/scriptBtnAcceptRefus.php" style="display:inline-block;">
                                            <input type="hidden" name="Action" value="0">
                                            <input type="hidden" name="type" value="false">
                                            <input type="hidden" name="idU" value="<?= htmlspecialchars($resa['idU']) ?>">
                                            <input type="hidden" name="idR" value="<?= htmlspecialchars($resa['idR_materiel']) ?>">
                                            <input type="hidden" name="dateDebut" value="<?= htmlspecialchars($resa['DateTime_debut']) ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-fablab-blue">Refuser</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Aucune réservation de matériel correspondant aux filtres.</p>
                <?php endif; ?>
            </section>
            <?php endif; ?>

            <div class="mt-5 pt-4 border-top">
                <h3 class="h5 mb-3">Voir sur les calendriers</h3>
                <div class="d-flex gap-3">
                    <a href="./afficherCalendrierAdmin.php" class="btn btn-fablab-blue btn-lg">Calendrier — Salles</a>
                    <a href="./afficherCalendrierAdmin.php?estMateriel=true" class="btn btn-fablab-blue btn-lg">Calendrier — Matériels</a>
                </div>
            </div>

        </div>

        <?php require_once './../commun/footer.php'; ?>
    </body>
</html>
