<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin'])) {
    header("Location: ./../index.php");
    exit();
}

ini_set('session.cookie_httponly', 1);

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
        
        <?php if (isset($_SESSION['flash_message'])) { echo $_SESSION['flash_message']; unset($_SESSION['flash_message']); } ?>

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
                    $Elements = [];
                    if ($isSalleMode) { ?>
                        <select class="form-select" id="salle" name="salle">
                            <?php 
                                //Liste des salles
                                include_once './../classesDAO/SalleDAO.php';
                        
                                $listeSalle = SalleDAO::getAllSalles();
                                $i = 1;
                                foreach ($listeSalle as $salle) {
                                    $tableauElement[$salle["idR"]] = $salle;
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
                            $lesFormations = MaterielsDAO::getFormationAssocie($materiel['idR']);
                            $assocMatForm[$materiel['idR']] = $lesFormations;
                            $tableauElement[$materiel['idR']] = $materiel;
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
                        $assocMatFormTxt = json_encode($assocMatForm);
                        ?>
                    </select>
                </div>
                <input type="hidden" name="assocMatSalle[]" id="assocMatSalle" value="<?= htmlspecialchars($assocMatSalleTxt, ENT_QUOTES, 'UTF-8')?>"/>
                <input type="hidden" name="tableauElement[]" id="tableauElement" value="<?= htmlspecialchars($tableauElement, ENT_QUOTES, 'UTF-8')?>"/>
                <input type="hidden" name="assocMatForm[]" id="assocMatForm" value="<?= htmlspecialchars($assocMatFormTxt, ENT_QUOTES, 'UTF-8')?>"/>
            </form>
        </div>
        <?php 
         if ($isSalleMode == "true"){
         ?>
        <div id="formSalle">
            <form method="POST" action="./../scriptAdmin/scriptModifSalle.php" class="row g-3 needs-validation" novalidate>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="row g-3"> <div class="col-md-6">
                                <label for="validationNom" class="form-label fw-semibold">Nom de la salle</label>
                                <input type="text" class="form-control" name="nomRes" id="validationNom" value="" required placeholder=""> <div class="invalid-feedback">Saisissez un nom.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="validationCapaAccueil" class="form-label fw-semibold">Capacité d'accueil</label>
                                <input type="number" class="form-control" name="capaRes" id="validationCapaAccueil" required placeholder="" min="1">
                                <div class="invalid-feedback">Saisissez une capacité valide.</div>
                            </div>

                            <div class="col-md-12">
                                <label for="validationDesc" class="form-label fw-semibold">Ajouter une description de la salle</label>
                                <textarea class="form-control" name="descRes" id="validationDesc" required rows="3"></textarea> <div class="invalid-feedback">Saisissez une description de la salle.</div>
                            </div>

                            <input type="hidden" name="idR" id="hiddenIdSalle" value=""/>

                            <div class="col-12 d-flex mt-4">
    <!-- me-auto pousse tout ce qui suit vers la droite -->
    <input type="submit" name="btnSupprimer" value="Supprimer" class="btn btn-fablab-red me-auto" formnovalidate onclick="return confirm('Supprimer cette salle ?');"/>
    
    <div class="d-flex gap-2">
        <input type="reset" name="btnCancel" value="Annuler" class="btn btn-outline-fablab-blue"/>
        <input type="submit" name="btnValider" value="Valider" class="btn btn-fablab-yellow"/>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
            var laSalle = document.getElementById('salle');
            var inputHidden = document.getElementById("hiddenIdSalle"); 

            function updateSalle() {
                var lesElements = JSON.parse(document.getElementById('tableauElement').value);
                var salleVal = laSalle.value;
                
                inputHidden.value = salleVal;

                if (document.getElementById('capaSalle') && lesElements[salleVal]) {
                     document.getElementById('capaSalle').value = lesElements[salleVal].capaAccueil;
                }

                //Update des placeholder
                var nom = document.getElementById('validationNom').value = lesElements[salleVal].Nom;
                var capa = document.getElementById('validationCapaAccueil').value = lesElements[salleVal].capaAccueil;
                var desc = document.getElementById('validationDesc').value = lesElements[salleVal].Description;
            }

            if(laSalle) {
                laSalle.addEventListener('change', updateSalle);
                updateSalle();
            }
        </script>
        <?php 
         }else {
            ?>
        <div id="formMateriel">
            <form method="POST" action="./../scriptAdmin/scriptModifSalle.php" class="row g-3 needs-validation" novalidate>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <label for="validationNomMat" class="form-label fw-semibold">Nom du matériel</label>
                                <input type="text" class="form-control" name="nomMat" id="validationNomMat" required>
                            </div>

                            <div class="col-md-6">
                                <label for="validationNbMat" class="form-label fw-semibold">Nombre d'exemplaires</label>
                                <input type="number" class="form-control" name="nbMat" id="validationNbMat" required min="1">
                            </div>

                            <div class="col-md-12">
                                <label for="validationDescMat" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" name="nomDesc" id="validationDescMat" rows="2" required></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="validationTuto" class="form-label fw-semibold">Tutoriel</label>
                                <input type="text" class="form-control" name="nomTuto" id="validationTuto" required> <div class="invalid-feedback">Saisissez un tutoriel.</div> </div>

                            <div class="col-md-6">
                                <label for="validationSecu" class="form-label fw-semibold">Règle de sécurité</label>
                                <input type="text" class="form-control" name="nomSecu" id="validationSecu" required> <div class="invalid-feedback">Saisissez une règle de sécurité.</div> </div>

                            <div class="col-12">
                                <label for="formMat" class="form-label fw-semibold">Formation obligatoire (Ctrl+clic pour multiples)</label>
                                <select class="form-select" name="formMat[]" id="formMat" multiple size="4">
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
                                <label for="salleMat" class="form-label fw-semibold">Salle de stockage :</label>
                                <select class="form-select" name="salleMat" id="salleMat" required>
                                    <?php 
                                        include_once './../classesDAO/SalleDAO.php';
                                        $listeAllSalles = SalleDAO::getAllSalles();
                                        foreach ($listeAllSalles as $s) {
                                            echo "<option value='".$s['idR']."'>".$s['Nom']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <input type="hidden" name="idR" id="hiddenIdMateriel" value=""/>
                            
                            <div class="col-12 d-flex mt-4">
    <!-- me-auto pousse tout ce qui suit vers la droite -->
    <input type="submit" name="btnSupprimer" value="Supprimer" class="btn btn-fablab-red me-auto" formnovalidate onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce matériel ?');"/>
    
    <div class="d-flex gap-2">
        <input type="reset" value="Annuler" class="btn btn-outline-fablab-blue"/>
        <input type="submit" name="btnValider" value="Valider" class="btn btn-fablab-yellow"/>
    </div>
</div> </div> </div> </div></form>
                </div>
        <script>            
            let assocMatSalleData = JSON.parse(document.getElementById('assocMatSalle').value);
            let assocMatFormData = JSON.parse(document.getElementById('assocMatForm').value);
            let lesMateriels = JSON.parse(document.getElementById('tableauElement').value);
            let leMateriel = document.getElementById('materiel');
            
            let hiddenInputMat = document.getElementById('hiddenIdMateriel');

            // Fonction pour mettre à jour les champs
            function rafraichirFormulaire() {
                let materiel = leMateriel.value;
                
                hiddenInputMat.value = materiel;

                //Placeholder
                document.getElementById('validationNomMat').value = lesMateriels[materiel].Nom;
                document.getElementById('validationNbMat').value = lesMateriels[materiel].Nombre;
                document.getElementById('validationDescMat').value = lesMateriels[materiel].Description;
                document.getElementById('validationTuto').value = lesMateriels[materiel].Tuto;
                document.getElementById('validationSecu').value = lesMateriels[materiel].Regle_securite;

                if (assocMatSalleData[materiel]) {
                    let idSalleCible = assocMatSalleData[materiel];
                    document.getElementById('salleMat').value = idSalleCible;
                }

                if (assocMatFormData[materiel]) {
                    let idsCibles = assocMatFormData[materiel].map(f => f.idF.toString());
                    
                    if (idsCibles.length === 0) {
                        idsCibles.push("0");
                    }

                    Array.from(document.getElementById('formMat').options).forEach(option => {
                        option.selected = idsCibles.includes(option.value);
                    });
                }
            }

            if(leMateriel){
                leMateriel.addEventListener('change', rafraichirFormulaire);
                rafraichirFormulaire();
            }
        </script>
        <?php 
         }
        ?>
    </div>
    <?php
    include_once './../commun/footer.php';
    ?>

<script>
    (() => {
      'use strict'
      const forms = document.querySelectorAll('.needs-validation')

      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (event.submitter && event.submitter.hasAttribute('formnovalidate')) {
              return; 
          }

          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
    </script>
</body>
</html>