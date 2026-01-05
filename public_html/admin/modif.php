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
        <h1 class="text-wrapper-4">Modifier les réservables</h1>
        <br /><br />
        <div id="filtre">
            <form>
                <div class="mb-3">
                    <label class="form-label me-3">Choisissez ce que vous voulez modifier/supprimer
                        <a href="modif.php" class="btn btn-sm <?= $isSalleMode ? 'btn-fablab-blue' : 'btn-outline-fablab-blue' ?>" >
                            Salle
                        </a>
                        <a href="modif.php?estMateriel=true" class="btn btn-sm <?= !$isSalleMode ? 'btn-fablab-blue' : 'btn-outline-fablab-blue' ?>" >
                            Matériel
                        </a>
                    </label>
                    <?php                         
                    $tableauElement = [];
                    $assocMatSalle = [];
                    $assocMatForm = [];
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
                            $assocMatSalle[$materiel['idR']] = $materiel['idS'];
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
                        $tableauElement = json_encode($tableauElement) ;
                        $assocMatSalleTxt = json_encode($assocMatSalle);
                        ?>
                    </select>
                </div>
                <input type="hidden" name="assocMatSalle[]" id="assocMatSalle" value="<?= htmlspecialchars($assocMatSalleTxt, ENT_QUOTES, 'UTF-8')?>"/>
                <input type="hidden" name="tableauElement[]" id="tableauElement" value="<?= htmlspecialchars($tableauElement, ENT_QUOTES, 'UTF-8')?>"/>
            </form>
        </div>
        <!-- TODO: Formulaire Salle-->
         <?php 
         if ($isSalleMode == "true"){
         ?>
        <div id="formSalle">
        <form>
                    <h2 class="mb-4 fw-bold">Modifier une salle</h2>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">

                            <form method="POST" action="" class="row g-3 needs-validation" novalidate>
                                
                                <div class="col-md-6">
                                    <label for="validationNom" class="form-label fw-semibold">Nom de la salle</label>
                                    <input type="textarea" class="form-control" name="nomRes" id="validationNom" value="" required placeholder="">
                                    <div class="invalid-feedback">Saisissez un nom.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCapaAccueil" class="form-label fw-semibold">Capacité d'accueil</label>
                                    <input type="number" class="form-control" name="capaRes" id="validationCapaAccueil" required placeholder="" min="1">
                                    <div class="invalid-feedback">Saisissez une capacité valide.</div>
                                </div>

                                <div class="col-md-12">
                                    <label for="validationCustomUsername" class="form-label fw-semibold">Ajouter une description de la salle</label>
                                    <input type="textarea" class="form-control" name="descRes" id="validationDesc" required placeholder="">
                                    <div class="invalid-feedback">
                                        Saisissez une description de la salle.
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                                    <input type="reset" name="btnCancel" value="Annuler" class="btn btn-outline-fablab-blue"/>
                                    <input type="submit" name="btnValider" value="Valider" class="btn btn-fablab-yellow"/>
                                </div>
        </form>
        </div>
        <script>
            laSalle = document.getElementById('salle')
            var t = document.getElementById('capaSalle').value;
            salle = laSalle.value;

            laSalle.addEventListener('change', function() {
                lesElements = JSON.parse(document.getElementById('tableauElement').value);
                salle = this.value;
                document.getElementById('numSalle').placeholder = ;
                document.getElementById('capaSalle').value = lesElements[salle];
                document.getElementById('placeRestante').value = 3;
            }); 
        </script>
        <?php 
         }else {
        ?>
        <!-- TODO: Formulaire Materiel-->
        <div id="formMateriel">
            <form>
                                
                                <div class="col-md-6">
                                    <label for="validationNom" class="form-label fw-semibold">Nom du matériel</label>
                                    <input type="textarea" class="form-control" name="nomMat" id="validationNom" required placeholder="">
                                    <div class="invalid-feedback">Saisissez un nom.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationDesc" class="form-label fw-semibold">Description</label>
                                    <input type="textarea" class="form-control" name="nomDesc" id="validationDesc" required placeholder="">
                                    <div class="invalid-feedback">Saisissez une description.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationTuto" class="form-label fw-semibold">Lien Tutoriel</label>
                                    <input type="textarea" class="form-control" name="nomTuto" id="validationTuto" required placeholder="">
                                    <div class="invalid-feedback">Saisissez un tutoriel.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationSecu" class="form-label fw-semibold">Règle de sécurité</label>
                                    <input type="textarea" class="form-control" name="nomSecu" id="validationSecu" required placeholder="">
                                    <div class="invalid-feedback">Saisissez des règles de sécurité.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationNombre" class="form-label fw-semibold">Ajouter un nombre d'exemplaires : </label>
                                    <input type="number" class="form-control" name="nbMat" id="validationNombre" value="" required placeholder="">
                                    <div class="invalid-feedback">
                                        Saisissez un nombre valide.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="validationFormMateriel" class="form-label fw-semibold">Formation obligatoire</label>
                                    <select class="form-select" aria-label="Default select example" name="formMat" id="formMat" required>
                                        <option value='0'>Aucune formation</option>
                                        <?php
                                            include_once './../classesDAO/FormationDAO.php';
                                            $lesFormations = FormationDAO::recupTout();
                                            foreach($lesFormations as $leTuple){
                                                echo '<option value="'.$leTuple['idF'].'">'.$leTuple['Intitule'].'</option>';
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="validationCustom02" class="form-label  fw-semibold">Ajouter une salle : </label>
                                    <select class="form-select" aria-label="Default select example" name="salleMat" id="salleMat" required>
                                        <?php 
                                            include_once './../classesDAO/SalleDAO.php';
                                            $listeSalle = SalleDAO::getAllSalles();
                                            foreach ($listeSalle as $salle){
                                                echo "<option value='".$salle['idR']."'>".$salle['Nom']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <br/>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                                    <input type="reset" name="btnCancel" value="Annuler" class="btn btn-outline-fablab-blue"/>
                                    <input type="submit" name="btnValider" value="Valider" class="btn btn-fablab-yellow"/>
                                </div>

         </form>
        </div>
        <script>            
            let tableauElement = document.getElementById('tableauElement');
            let assocData = JSON.parse(document.getElementById('assocMatSalle').value);

            leMateriel = document.getElementById('materiel');
            materiel = leMateriel.value;

            // Ajouter le selected 
            let idSalleCible = assocData[document.getElementById('materiel').value];
            document.getElementById('salleMat').value = idSalleCible;


            leMateriel.addEventListener('change', function() {
                lesElements = JSON.parse(document.getElementById('tableauElement').value);
                materiel = this.value;
                let idSalleCible = assocData[materiel];
                document.getElementById('salleMat').value = idSalleCible;
            });
        </script>
        <?php 
         }
        ?>
    </div>
    <script>
        

    </script>
    <?php
    include_once './../commun/footer.php';
    ?>
</body>

</html>
