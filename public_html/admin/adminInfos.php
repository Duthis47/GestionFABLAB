<?php 

if (!isset($_SESSION)) { session_start(); } 
if (!isset($_SESSION['isAdmin'])) {
    header("Location: ./../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil - FABLAB</title>
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
        <?php require_once './../commun/header.php'; ?>
        
        <div class="container">
            <main>
                <div class="d-flex gap-3 my-4">
                    <a href="./afficherCalendrierAdmin.php" class="btn btn-fablab-blue btn-lg">
                        Afficher les réservations — Salles
                    </a>
                    <a href="./afficherCalendrierAdmin.php?estMateriel=true" class="btn btn-fablab-blue btn-lg">
                        Afficher les réservations — Matériels
                    </a>
                </div>
            </main>
        </div>

        <?php require_once './../commun/footer.php'; ?>
    </body>
</html>
