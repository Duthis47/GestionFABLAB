<?php if (!isset($_SESSION)) { session_start(); } ?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestion Administrateur - FABLAB</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./../CSS/style.css"/>
        <script src="./../bootstrap/js/color-modes.js"></script>
        <meta name="theme-color" content="#712cf9" />
    </head>
    <body>
        <?php
        if (isset($_SESSION["isAdmin"])){
            // Le header contient maintenant le bouton déconnexion
            require_once './../commun/header.php';
        ?>
        
        <div class="container">
            <h1>Gestion</h1>
            </div>

        <?php 
        } else {
            header("Location: ./../index.php");
            exit();
        }
        ?>
    </body>
</html>
