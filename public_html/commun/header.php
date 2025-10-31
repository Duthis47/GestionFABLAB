<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<?php 
    if (isset($_GET["pageTitle"])){
        $titre = $_GET["pageTitle"];
    }
    else {
        $titre = "Page d'accueil";
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $titre; ?></title>
        <link rel="stylesheet" href="./../CSS/style.css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">

    </head>
    <body>
        <header class="header">
      <div class="logo-container">
        <img 
          class="logo-image" 
          alt="Logo fablab" 
          src="./image/logo-fablab.png"
        />
        <div class="logo-subtitle">Milieux Aquatiques</div>
      </div>

      <nav class="nav-link">Accueil</nav>

      <button type="button" class="btn-reservation">
        <span>Réservation</span>
      </button>

      <a href="#" class="admin-link">Administrateur</a>
    </header>
    </body>
</html>
