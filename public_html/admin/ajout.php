<?php
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
<div class="container py-5 mb-5 pb-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-4">
                    
                    <h2 class="text-center mb-5 fw-bold">Gestion des Ajouts</h2>

                    <div class="d-flex flex-column">
                        
                        <div class="d-flex justify-content-between align-items-center py-4 border-bottom">
                            <h4 class="h5 mb-0">Salles</h4>
                            <a href="ajoutSalle.php" class="btn btn-fablab-blue">Ajouter</a>
                        </div>

                        <div class="d-flex justify-content-between align-items-center py-4 border-bottom">
                            <h4 class="h5 mb-0">Matériel</h4>
                            <a href="ajoutMateriel.php" class="btn btn-fablab-blue">Ajouter</a>
                        </div>

                        <div class="d-flex justify-content-between align-items-center py-4">
                            <h4 class="h5 mb-0">Formation</h4>
                            <a href="ajoutFormation.php" class="btn btn-fablab-yellow">Ajouter</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <?php include_once './../commun/footer.php'; ?>
    </body>
</html>
