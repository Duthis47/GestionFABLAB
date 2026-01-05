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
<div class="container">
                <h1>Ajouter une salle</h1>
                <button type="submit"><a href = "ajoutSalle.php">Ajouter Salle</a> </button>

                <h1>Ajouter un matériel</h1>
                <button type="submit"><a href = "ajoutMateriel.php">Ajouter Matériel</a> </button>

                <h1>Ajouter une formation</h1>
                <button type="submit"><a href = "ajoutFormation.php">Ajouter Formation</a> </button>

            <br>
            <br>
        </div>   
        </div>
        <?php include_once './../commun/footer.php'; ?>
    </body>
</html>
