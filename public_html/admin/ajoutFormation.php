<?php
ob_start();

//Empeche l'affichage des potentiels erreurs
error_reporting(1);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION["isAdmin"])){
    require_once './../commun/header.php';
}
else {
    header("Location: ./../index.php");
}

require_once './../classesDAO/SalleDAO.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajout de matériel et de salles - FABLAB</title>
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
                <div class="col-md-8">
                    <div class="mb-4">
                        <a href="ajout.php" class="btn btn-outline-fablab-blue btn-sm d-inline-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                            </svg>
                            Retour au menu
                        </a>
                    </div>

                    <h2 class="mb-4 fw-bold">Ajouter une formation</h2>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">

                            <form method="POST" action="" class="row g-3 needs-validation" novalidate>
                                <div class="col-12">
                                    <label for="validationNom" class="form-label fw-semibold">Intitulé de la formation</label>
                                    <input type="text" class="form-control" name="nomForm" id="validationNom" value="" required placeholder="Ex : Formation utilisation perceuse">
                                    <div class="invalid-feedback">
                                        Saisissez un intitulé.
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                                    <a href="ajout.php" class="btn btn-outline-fablab-blue">Annuler</a>
                                    <input type="submit" name="btnValider" value="Valider" class="btn btn-fablab-yellow"/>
                                </div>
                            </form>
                        </div>
                    </div>

            <br>
            <?php
                $leMsg = "";

                if (isset($_SESSION['flash_message'])) {
                    $leMsg = $_SESSION['flash_message'];
                    unset($_SESSION['flash_message']);
                }

                if ((isset($_POST['btnValider']))) {

                    if (!empty($_POST['nomForm'])) {

                            $lIntitule = $_POST['nomForm'];

                            $rsql = "INSERT INTO Formation(Intitule) VALUES(:lIntitule)";

                            $connexion = GestionConnexion::getConnexion();

                            $stmt = $connexion->prepare($rsql);

                            $stmt->bindParam(':lIntitule', $lIntitule, PDO::PARAM_STR);
                            
                            $res = $stmt->execute();

                            if ($res) {
                                $_SESSION['flash_message'] = "<div class='alert alert-success mt-3'>Formation ajoutée avec succès !</div>";
                                ob_end_clean();

                                header("Location: " . $_SERVER['REQUEST_URI']);
                                exit();
                            } else {
                                $leMsg = "<div class='alert alert-danger mt-3'>Erreur lors de l'ajout de la formation.</div>";
                            }
                            
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
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
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
if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
</script>
</html>