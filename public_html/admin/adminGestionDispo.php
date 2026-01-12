<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin'])) {
    header("Location: ./../index.php");
    exit();
}

ini_set('session.cookie_httponly', 1);

include_once './../classesDAO/SalleDAO.php';
include_once './../classesDAO/MaterielsDAO.php';
include_once './../classesDAO/ReservationDAO.php';

// Gestion du mode (Salle ou Matériel)
$isSalleMode = !isset($_GET["estMateriel"]);
$isSalleModeJson = json_encode($isSalleMode);

// Récupération des données pour le formulaire d'ajout
if (!$isSalleMode) {
    $titreF = "Gestion des indisponibilités - Matériels";
    $tableauElement = MaterielsDAO::getAllMateriels();
} else {
    $titreF = "Gestion des indisponibilités - Salles";
    $tableauElement = SalleDAO::getAllSalles();
}

if (isset($_GET["idErreur"]) && $_GET["idErreur"] != "") {
    $listeErreur = explode(separator: ",", string: $_GET["idErreur"]);
}

// Récupération des blocages actuels pour le tableau du bas
$blocagesActuels = ReservationDAO::getBlocagesFuturs($isSalleMode);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indisponibilités - FABLAB</title>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="./../CSS/style.css" />
    <script src="./../bootstrap/js/color-modes.js"></script>
    <meta name="theme-color" content="#712cf9" />
</head>

<body>
    <?php require_once './../commun/header.php'; ?>

    <div class="container mb-5 mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><?= $titreF ?></h2>
            <div>
                <a href="adminGestionDispo.php"
                    class="btn <?= $isSalleMode ? 'btn-fablab-blue ' : 'btn-outline-fablab-blue' ?>">Salles</a>
                <a href="adminGestionDispo.php?estMateriel=true"
                    class="btn <?= !$isSalleMode ? 'btn-fablab-blue' : 'btn-outline-fablab-blue' ?>">Matériels</a>
            </div>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-header">
                <h5 class="mb-0">Définir une période d'indisponibilité</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="./../scriptAdmin/scriptBlocDeblocGroupe.php">
                    <input type="hidden" name="action" value="bloquer">
                    <input type="hidden" name="isSalle" value="<?= $isSalleModeJson ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Début</label>
                            <input type="datetime-local" class="form-control" name="dateDebut" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fin</label>
                            <input type="datetime-local" class="form-control" name="dateFin" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold mb-0">Éléments indisponibles :</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                onclick="toggleAll('add')">Tout cocher / décocher</button>
                        </div>

                        <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                            <?php foreach ($tableauElement as $element): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="ids[]"
                                        value="<?= $element['idR'] ?>" id="add_<?= $element['idR'] ?>">
                                    <label class="form-check-label" for="add_<?= $element['idR'] ?>">
                                        <?= htmlspecialchars($element['Nom']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-fablab-yellow">Confirmer l'indisponibilité</button>
                    </div>
                </form>
            </div>
        </div>

        <h2 class='mb-4'>Indisponibilités programmées (Sélectionnez pour supprimer)</h2>

        <div class="card-body">
            <?php if (empty($blocagesActuels)): ?>
                <p class="text-muted text-center my-3">Aucune indisponibilité prévue pour le moment.</p>
            <?php else: ?>
                <form method="POST" action="./../scriptAdmin/scriptBlocDeblocGroupe.php">
                    <input type="hidden" name="action" value="debloquer">
                    <input type="hidden" name="isSalle" value="<?= $isSalleModeJson ?>">

                    <div class="table-responsive border rounded mb-3" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th style="width: 50px;"><input type="checkbox" class="form-check-input"
                                            onclick="toggleAll('del')"></th>
                                    <th>Élément</th>
                                    <th>Début</th>
                                    <th>Fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($blocagesActuels as $bloc): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input check-del" name="toDelete[]"
                                                value="<?= $bloc['idR'] ?>|<?= $bloc['dateDebut'] ?>">
                                        </td>
                                        <td class="fw-bold"><?= htmlspecialchars($bloc['nomElement']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($bloc['dateDebut'])) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($bloc['dateFin'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-fablab-blue">Libérer les créneaux sélectionnés</button>
                    </div>
                </form>
            <?php endif; ?>
            <?php if (isset($listeErreur)): ?>
                <div class="alert alert-danger shadow-sm" role="alert">
                    <h5 class="alert-heading fw-bold">Impossible de bloquer certains éléments</h5>
                    <p>Les éléments suivants possèdent déjà des réservations sur ce créneau et n'ont pas pu être rendus
                        indisponibles :</p>
                    <ul class="mb-0">
                        <?php
                        $nomsParId = [];
                        foreach ($tableauElement as $element) {
                            $nomsParId[$element['idR']] = $element['Nom'];
                        }
                        foreach ($listeErreur as $id) {
                            if (isset($nomsParId[$id])) {
                                echo "<li><strong>" . htmlspecialchars($nomsParId[$id]) . "</strong></li>";
                            } else {
                                echo "<li>Élément ID : " . htmlspecialchars($id) . "</li>";
                            }
                        }
                        ?>
                    </ul>
                    <hr>
                    <p class="mb-0 small">Veuillez d'abord supprimer les réservations existantes ou choisir une autre
                        période.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <div class="mt-3 pb-5 text-center">
        <a href="afficherCalendrierAdmin.php<?= !$isSalleMode ? '?estMateriel=true' : '' ?>"
            class="btn btn-secondary">Retour au calendrier global</a>
    </div>
    </div>

    <script>
        function toggleAll(type) {
            let inputs;
            if (type === 'add') inputs = document.querySelectorAll('input[name="ids[]"]');
            else inputs = document.querySelectorAll('.check-del');

            let allChecked = Array.from(inputs).every(cb => cb.checked);
            inputs.forEach(cb => cb.checked = !allChecked);
        }


    </script>
    <?php include_once './../commun/footer.php'; ?>
</body>

</html>