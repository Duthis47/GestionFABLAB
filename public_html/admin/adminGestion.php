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
        <link rel="stylesheet" href="/GestionFABLAB/public_html/CSS/style.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php
        session_start();
        if (isset($_SESSION["isAdmin"])){

            require_once './../commun/header.php';
            
        ?>
        <div class="container">
            <form method="POST" action="/GestionFABLAB/public_html/scriptAdmin/scriptGestion.php">
                <input type="submit" name="btnReset" value="Deconnexion" class="btn-reservation"/>
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
