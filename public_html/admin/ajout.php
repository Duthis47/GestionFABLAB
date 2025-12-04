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
        <link rel="stylesheet" href="/GestionFABLAB/public_html/CSS/style.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet"/>
    </head>
    <body>
        <?php
        session_start();
        if (isset($_SESSION["isAdmin"])){

            require_once './../commun/header.php';
            
        ?>

            <form method="POST" action="/GestionFABLAB/public_html/scriptAdmin/scriptGestion.php">


                <div class="spinner-container">
                                    <input type="number" class="form-control form-control-spinner" id="demo-simple" value="0" min="0" max="100">
                                    <div class="spinner-controls">
                                        <button type="button" class="spinner-btn up" tabindex="-1"><i class="fas fa-chevron-up"></i></button>
                                        <button type="button" class="spinner-btn down" tabindex="-1"><i class="fas fa-chevron-down"></i></button>
                                    </div>
                                </div>
                <div class="container">

            <input type="submit" name="btnValider" value="Valider" class="btn-reservation"/>
            <input type="submit" name="btnCancel" value="Annuler" class="btn-reservation"/>

            </form>
        </div>
        <?php 
            }
            else {
                header("Location: /GestionFABLAB/public_html/index.php");
            }
        ?>
    </body>
</html>
