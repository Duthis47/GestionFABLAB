<?php
ob_start();

//Empeche l'affichage des potentiels erreurs
error_reporting(1);
ini_set('display_errors', 1);
ini_set('session.cookie_httponly', 1);
session_start();

if (isset($_SESSION["isAdmin"])){
    require_once './../commun/header.php';
}
else {
    header("Location: ./../index.php");
}

require_once './../classesDAO/MaterielsDAO.php';

require_once("./../classes/GestionConnexion.php");
$connexion = GestionConnexion::getConnexion();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajout de matériel - FABLAB</title>
        <link rel="preconnect" href="https://fonts.googleapis.com"/>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
        <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="./../CSS/style.css"/>
        <script src="./../bootstrap/js/color-modes.js"></script>
        <meta name="theme-color" content="#712cf9" />
    </head>
    
    <body>
        <div class="container py-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    
                    <div class="mb-4">
                        <a href="ajout.php" class="btn btn-outline-fablab-blue btn-sm d-inline-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                            </svg>
                            Retour au menu
                        </a>
                    </div>

                    <h2 class="mb-4 fw-bold">Ajouter un matériel</h2>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">

                            <form method="POST" action="" class="row g-3 needs-validation" novalidate>
                                
                                <div class="col-md-6">
                                    <label for="validationNom" class="form-label fw-semibold">Nom du matériel</label>
                                    <input type="textarea" class="form-control" name="nomMat" id="validationNom" required placeholder="Ex : Accélérateur de particules">
                                    <div class="invalid-feedback">Saisissez un nom.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationDesc" class="form-label fw-semibold">Description</label>
                                    <input type="textarea" class="form-control" name="nomDesc" id="validationDesc" required placeholder="Ex : 2 parties imbricables">
                                    <div class="invalid-feedback">Saisissez une description.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationTuto" class="form-label fw-semibold">Lien Tutoriel</label>
                                    <input type="textarea" class="form-control" name="nomTuto" id="validationTuto" required placeholder="Ex : Rincer avant usage">
                                    <div class="invalid-feedback">Saisissez un tutoriel.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationSecu" class="form-label fw-semibold">Règle de sécurité</label>
                                    <input type="textarea" class="form-control" name="nomSecu" id="validationSecu" required placeholder="Ex : Lunettes obligatoires">
                                    <div class="invalid-feedback">Saisissez des règles de sécurité.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationNombre" class="form-label fw-semibold">Ajouter un nombre d'exemplaires : </label>
                                    <input type="number" class="form-control" name="nbMat" id="validationNombre" value="" min="1" required placeholder="Ex : 2">
                                    <div class="invalid-feedback">
                                        Saisissez un nombre valide.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="validationFormMateriel" class="form-label fw-semibold">Formation obligatoire</label>
                                    <select class="form-select" aria-label="Default select example" name="formMat" id="validationFormMateriel" required>
                                        <option value='0' selected>Aucune formation</option>
                                        <?php
                                            $rsql = "SELECT * FROM Formation;";
                                            $resReq = $connexion->query($rsql);
                                            $leTuple = $resReq->fetch();
                                            while ($leTuple != NULL){
                                                echo '<option value="'.$leTuple['idF'].'">'.$leTuple['Intitule'].'</option>';
                                                $leTuple=$resReq->fetch();
                                            }
                                            ?>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="validationCustom02" class="form-label  fw-semibold">Ajouter une salle : </label>
                                    <select class="form-select" aria-label="Default select example" name="salleMat" id="validationFormMateriel" required>
                                        <?php
                                            $rsql2 = "SELECT * FROM Salles;";
                                            $resReq2 = $connexion->query($rsql2);
                                            $leTuple2 = $resReq2->fetch();
                                            while ($leTuple2 != NULL){
                                                echo '<option value="'.$leTuple2['idR'].'">'.$leTuple2['nomSalles'].'</option>';
                                                $leTuple2=$resReq2->fetch();
                                            }
                                        ?>
                                    </select>
                                </div>
                                <br>

                                <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                                    <input type="reset" name="btnCancel" value="Annuler" class="btn btn-outline-fablab-blue"/>
                                    <input type="submit" name="btnValider" value="Valider" class="btn btn-fablab-yellow"/>
                                </div>
                            </form>
                        </div>
                    </div>

                    <br>
                    <?php
                        $leMsg = "";

                        if ((isset($_POST['btnValider']))) {

                            if (!empty($_POST['nomMat']) && !empty($_POST['nomTuto']) && !empty($_POST['nomSecu']) && !empty($_POST['nomDesc'])) {

                                    $leNom = $_POST['nomMat'];
                                    $leTuto = $_POST['nomTuto'];
                                    $laSecu = $_POST['nomSecu'];
                                    $laDesc = $_POST['nomDesc'];
                                    $laFormation = $_POST['formMat'];
                                    $laSalle = $_POST['salleMat'];
                                    $leNombre = $_POST['nbMat'];

                                    $leStatut = "disponible";

                                    if ($laFormation == "0") {
                                        $laFormation = null; 
                                    }

                                    $res = MaterielsDAO::ajouterMateriel($leNom, $laDesc, $leStatut);




                                    if ($res!=NULL) {

                                        

                                $stmt2 = $connexion->prepare("INSERT INTO Materiels (idR, Tuto, Regle_securite, Nombre, idS) VALUES (:idR, :Tuto, :Regle_securite, :Nombre, :idS)");
                                $stmt2->bindParam(':idR', $res, PDO::PARAM_INT);
                                $stmt2->bindParam(':Tuto', $leTuto, PDO::PARAM_STR);
                                $stmt2->bindParam(':Regle_securite', $laSecu, PDO::PARAM_STR);
                                $stmt2->bindParam(':Nombre', $leNombre, PDO::PARAM_INT);
                                $stmt2->bindParam(':idS', $laSalle, PDO::PARAM_INT);

                                $res2 = $stmt2->execute();


                                        if ($res2){


                                            //$_SESSION['flash_message'] = "<div class='alert alert-success mt-3'>Matériel ajouté avec succès !</div>";
                                            ob_end_clean();
                                            header("Location: " . $_SERVER['REQUEST_URI']);
                                            exit();

                                        }else {
                                        $leMsg = "<div class='alert alert-danger mt-3'>Erreur lors de l'ajout de matériel.</div>";
                                        }   



                                        //$_SESSION['flash_message'] = "<div class='alert alert-success mt-3'>Matériel ajouté avec succès !</div>";
                                        ob_end_clean();
                                        header("Location: " . $_SERVER['REQUEST_URI']);
                                        exit();
                                    }else {
                                        $leMsg = "<div class='alert alert-danger mt-3'>Erreur lors de l'ajout de matériel.</div>";
                                    }
                                } else {
                                     $leMsg = "<div class='alert alert-warning mt-3'>Veuillez remplir tous les champs obligatoires.</div>";
                                }
                        }
                        echo $leMsg;
                        ob_end_flush();
                    ?>
                    <br>
                </div>   
            </div>
        </div>
        <?php include_once './../commun/footer.php'; ?>
    </body>

    <script>
    // Validation Bootstrap JavaScript
    (() => {
      'use strict'
      const forms = document.querySelectorAll('.needs-validation')
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
    
    // Empêcher la resoumission du formulaire au rafraîchissement
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
</html>