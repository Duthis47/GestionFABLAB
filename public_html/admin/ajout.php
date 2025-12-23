<?php if (!isset($_SESSION)) { session_start(); } ?>

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
        <link rel="stylesheet" href="./../CSS/style.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet"/>
        <script src="./../bootstrap/js/color-modes.js"></script>
        <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <meta name="theme-color" content="#712cf9" />
        <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />
    </head>
    <body>
        <?php
        session_start();
        if (isset($_SESSION["isAdmin"])){

            require_once './../commun/header.php';
            
        ?>
<div class="container">
            <form method="POST" action="#Ajout des réservables" class="row g-3 needs-validation" novalidate>

                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Ajouter un nom</label>
                    <input type="text" class="form-control" id="validationCustom01" value="" required placeholder="Exemple de nom">
                    <div class="valid-feedback">
                        Ca a l'air bon!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom02" class="form-label">Ajouter un tuto : </label>
                    <input type="text" class="form-control" id="validationCustom02" value="" required placeholder="Exemple de tuto">
                    <div class="valid-feedback">
                        Is ok
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustomUsername" class="form-label">Ajouter des règles de sécurité</label>
                    <div class="input-group has-validation">
                    <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required placeholder="Exemple de règle">
                    <div class="invalid-feedback">
                        C PAS DE LA SÉCU ÇA!!
                    </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationTextarea" class="form-label">Ajouter une description</label>
                    <textarea class="form-control" id="validationTextarea" placeholder="Lorem ipsum dolor" required></textarea>
                    <div class="invalid-feedback">
                    Please enter a message in the textarea.
                    </div>
                </div>
                



                <div class="spinner-container">
                                    <input type="number" class="form-control form-control-spinner" id="demo-simple" value="0" min="0" max="100">
                                </div>
                <div class="container">
        
            <input type="submit" name="btnValider" value="Valider" class="btn btn-primary"/>
            <input type="submit" name="btnCancel" value="Annuler" class="btn btn-primary"/>

            </form>
        </div>   
        </div>
        <?php 
            }
            else {
                header("Location: ./../index.php");
            }
        ?>
    </body>
</html>
