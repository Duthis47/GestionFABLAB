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
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
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
<div class="container">
            <button type="submit"><a href = "ajout.php"><h3>Retour</h3></a></button>

            <form method="POST" action="" class="row g-3 needs-validation">
                <h1>Ajouter une formation</h1>
                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Ajouter un intitulé</label>
                    <input type="text" class="form-control" name="nomForm" id="validationNom" value="" required placeholder="Ex : Formation utilisation perceuse">
                    <div class="invalid-feedback">
                        Saisissez un intitulé.
                    </div>
                </div>
                <div class="col-md-6">
                    <input type="reset" name="btnCancel" value="Annuler" class="btn btn-outline-fablab-blue"/>
                    <input type="submit" name="btnValider" value="Valider" class="btn btn-fablab-yellow"/>
                </div>
            </form>
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

                            
                            $connexion->beginTransaction();

                            $stmt->bindParam(':lIntitule', $lIntitule, PDO::PARAM_STR);

                            if ($res) {
                                $_SESSION['flash_message'] = "<div>Matériel ajouté avec succès !</div>";
                                ob_end_clean();

                                header("Location: " . $_SERVER['REQUEST_URI']);
                                exit();
                            } else {
                                $leMsg = "<div>Erreur lors de l'ajout de matériel.</div>";
                            }
                            
                            echo $leMsg; 
                        }
                }
                ob_end_flush();
            ?>
            <br>
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
