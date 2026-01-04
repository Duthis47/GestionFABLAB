<?php if (!isset($_SESSION)) {
    session_start();
} 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Réservation - FABLAB</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />

    <link rel="stylesheet" href="./../CSS/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../fullcalendar/packages/core/main.css">
    <link rel="stylesheet" href="./../fullcalendar/packages/daygrid/main.css">
    <script src="./../bootstrap/js/color-modes.js"></script>
    <meta name="theme-color" content="#712cf9" />
    
</head>

<body>
    <script src="./../fullcalendar/dist/index.global.min.js"></script>

    <?php
    include_once './../commun/header.php';
    $isSalleMode = !isset($_GET["estMateriel"]);
    $capaSalle = 0;
    if ($isSalleMode){
        $titreR = "Réservation de Salle";
        $script = "./sReservationSalle.php";
    }else {
        $titreR = "Réservation de Matériel";
        $script = "./sReservationMateriel.php";
    }
    ?>
    <div class="container mb-5">
        <h1 class="text-wrapper-4">Réserver un créneau</h1>
        <br /><br />
        <div id="filtre">
            <form>
                <div class="mb-3">
                    <label class="form-label me-3">Choisir
                        <a href="reservationUser.php" class="btn btn-sm <?= $isSalleMode ? 'btn-fablab-blue' : 'btn-outline-fablab-blue' ?>" >
                            Salle
                        </a>
                        <a href="reservationUser.php?estMateriel=true" class="btn btn-sm <?= !$isSalleMode ? 'btn-fablab-blue' : 'btn-outline-fablab-blue' ?>" >
                            Matériel
                        </a>
                    </label>
                    <?php                         
                    $tableauElement = [];
                    if ($isSalleMode) { ?>
                        <select class="form-select" id="salle" name="salle">
                                                    <?php 
                                                    //Liste des salles
                        include_once './../classesDAO/SalleDAO.php';
                        
                        $listeSalle = SalleDAO::getAllSalles();
                        $i = 1;
                        foreach ($listeSalle as $salle) {
                            $tableauElement[$salle["idR"]] = $salle['capaAccueil'];
                            if($i==1){
                                $capaSalle = $salle['capaAccueil'];
                            }
                            ?>
                            <option value="<?php echo $salle['idR']; ?>" 
                            <?php if (isset($_GET["estSalle"]) && $_GET["estSalle"] == $salle['idR']) {
                                echo "selected";
                            } ?>>
                            Salle <?php echo $i . " - " . $salle['Nom'] . " (Capacité : " . $salle['capaAccueil'] . " personnes)"; ?></option>
                            <?php 
                            $i++;
                        }
                        } else { 
                        include_once './../classesDAO/MaterielsDAO.php';
                        $listeMateriel = MaterielsDAO::getAllMateriels();
                        ?>
                        <select class="form-select" id="materiel" name="materiel">
                                                    <?php 
                        
                        $i = 1;
                        foreach ($listeMateriel as $materiel) {
                            $tableauElement[$materiel['idR']] = $materiel['Nombre'];
                            if ($i==1){
                                $capaSalle = $materiel['Nombre'];
                            }
                            ?>
                            <option value="<?php echo $materiel['idR'];?>" data-salle="<?= $materiel["idS"]?>" data-maxPlaceSalle="<?= $materiel['CapaAccueil'] ?>"
                            <?php if (isset($_GET["estMateriel"]) && $_GET["estMateriel"] == $materiel['idR']) {
                                echo "selected";
                            } ?>>
                            Matériel <?php echo $i . " - " . $materiel['Nom']; ?></option>
                            <?php 
                            $i++;
                        }
                        }
                        $tableauElement = json_encode($tableauElement) ?>
                    </select>
                </div>
                <input type="hidden" name="tableauElement[]" id="tableauElement" value="<?= htmlspecialchars($tableauElement, ENT_QUOTES, 'UTF-8')?>"/>
            </form>
        </div>
        <div id="Description"><!-- Faire un petit bloc de texte pour la description du materiel ou de la salle --></div>
        <div id="calendrier"></div>
        <div class="modal fade" id="popupResa" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel"><?= $titreR ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="bookingForm" method="POST" action="<?= $script ?>">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prenom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                            </div>
                            <div class="mb-3">
                                <label for="mail" class="form-label">Mail UPPA (@etud.univ-pau.fr) </label>
                                <input type="email" class="form-control" id="mail" name="mail" title="@etud.univ-pau.fr" pattern=".@etud.univ-pau.fr" required>
                            </div>

                            <!-- En cas de salle on demande le nombre d'occupant a enlever si on considère l'ajout de salle pour matériel -->
                            <?php 
                            //if ($isSalleMode){ ?>
                                <div class="mb-3">
                                    <label for="nbOccupant" class="form-label">nombre d'occupant</label>
                                    <input type="number" min="1" max="" class="form-control" id="nbOccupant" name="nbOccupants" required>
                                    <input type="hidden" value="<?= $capaSalle ?>" id="capaSalle" name="capaSalle"/>
                                    <input type="hidden" value="" id="placeRestante" name="placeRestante"/>
                                </div>
                            <?php //}
                            if(!$isSalleMode){
                                ?>
                                <input type="hidden" value="" id="numSalle" name="numSalle"/>
                            <?php
                            }else {?>
                                <input type="hidden" value="" id="numSalle" name="numSalle"/>
                            <?php
                            }
                            ?>
                            <p>Début : <input type="datetime-local" id="startInput" name="dateDebut"/></p>
                            <p>Fin : <input type="datetime-local" id="endInput" name="dateFin"/></p>
                            <input type="hidden" value="" id="numMateriel" name="numMateriel"/>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-fablab-blue" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-fablab-yellow" id="saveEventBtn">Confirmer</button>
                    </div>
                </form>

                </div>
            </div>
        </div>
                    <!-- Modal de matériel -->
        <script src="./../JS/calendrier.js"></script>
        <script src="./../bootstrap/JS/bootstrap.bundle.min.js"></script>
        <script src="./../JS/recupElement.js"></script>
                    
        <?php if ($isSalleMode) { ?>
            <script>
                laSalle = document.getElementById('salle')
                var t = document.getElementById('capaSalle').value;
                laSalle.addEventListener('change', function() {
                    lesElements = JSON.parse(document.getElementById('tableauElement').value);
                    salle = this.value;
                    document.getElementById('numSalle').value = salle;
                    document.getElementById('capaSalle').value = lesElements[salle];
                    document.getElementById('placeRestante').value = 3;
                    var t = document.getElementById('capaSalle').value;
                    recupSalle("etudiant", salle, t);
                });
                salle = laSalle.value;
                document.getElementById('numSalle').value = salle;
                document.getElementById('numMateriel').value = "";
                document.getElementById('placeRestante').value = 3    
                recupSalle("etudiant", salle, t);       
            </script>
        <?php } else { ?>
            <script>
                leMateriel = document.getElementById('materiel')
                var t = document.getElementById('capaSalle').value;
                leMateriel.addEventListener('change', function() {
                    lesElements = JSON.parse(document.getElementById('tableauElement').value);
                    materiel = this.value;
                    document.getElementById('numMateriel').value = materiel;
                    document.getElementById('capaSalle').value = lesElements[materiel];
                    var t = document.getElementById('capaSalle').value;
                    document.getElementById('numSalle').value = this.options[this.selectedIndex].getAttribute('data-salle');
                    recupMateriels("etudiant", materiel, t);
                });
                materiel = leMateriel.value;
                document.getElementById('numMateriel').value = materiel;
                document.getElementById('numSalle').value = leMateriel.selectedOptions[0].getAttribute('data-salle');
                recupMateriels("etudiant", materiel, t);
            </script>
            <?php
        } ?>
    </div>

    <?php
    include_once './../commun/footer.php';
    ?>
</body>

</html>