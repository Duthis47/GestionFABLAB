<?php if (!isset($_SESSION)) { session_start(); } ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil - FABLAB</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="./CSS/style.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
        <script src="./bootstrap/js/color-modes.js"></script>
        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <meta name="theme-color" content="#712cf9" />
        <link href="./bootstrap/navbar/navbar-static.css" rel="stylesheet" />
    </head>

    <body >
        <?php
        require_once './commun/header.php';
        ?>

        <main class="container py-5">
            
            <div class="mb-5">
                <h1 class="fw-bold text-dark display-4 mb-3" style="font-weight: 700;">
                    Bienvenue au FabLab<br>Milieux Aquatiques
                </h1>
                <p class="fw-bold fs-5 mb-4 text-dark">
                    Espace d’innovation et de prototypage pour les étudiants et chercheurs
                </p>
                <a href="reservation/reservationUser.php" class="btn btn-lg px-4 py-2 fw-normal" 
                        style="background-color: #B8E1FF; color: #000; border-radius: 10px; font-size: 1.25rem; border: none;">
                    Découvrir les équipements
                </a> 
            </div>

            <div class="p-4 p-md-5 rounded-4 shadow-sm" style="background-color: #f6f6f6;"> 
                
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5"> 
                        <p class="fs-5" >
                            Le FabLab Milieux Aquatiques est un espace collaboratif dédié à l'innovation pédagogique. Il rassemble étudiants, chercheurs et partenaires locaux pour <strong>concevoir, expérimenter et fabriquer</strong> des solutions concrètes répondant aux enjeux environnementaux de notre territoire.                        </p> 
                    </div> 
                    <div class="col-lg-6"> 
                        <div class="overflow-hidden rounded-3 shadow-sm">
                            <img src="./image/image1.png" alt="Intérieur Fablab" class="img-fluid w-100" style="object-fit: cover;"> 
                        </div>
                    </div> 
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0 order-2 order-lg-1"> 
                        <div class="overflow-hidden rounded-3 shadow-sm">
                            <img src="./image/image2.png" alt="Atelier outils" class="img-fluid w-100" style="object-fit: cover;"> 
                        </div>
                    </div> 
                    <div class="col-lg-6 order-1 order-lg-2 ps-lg-5"> 
                        <p class="mb-4 fs-6">
                            <strong>Campus UPPA de Montaury, à Anglet,</strong><br>
                            Situé au rez-de-chaussée du bâtiment 1 « Collège Sciences et Technologies pour l'Energie et l'Environnement ».
                        </p>
                        <p class="fw-bold">
                            Ouvert du lundi au vendredi de 8h à 17h
                        </p>
                    </div> 
                </div>

            </div>

            <div class="text-center mt-5 mb-4">
                <a href="reservation/reservationUser.php" class="btn btn-lg px-5 py-2 fw-bold" 
                        style="background-color: #F4C430; color: #000; border-radius: 10px; border: none; font-size: 1.2rem;">
                    Voir les créneaux disponibles
                </a>
            </div>

        </main>

        <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

    <?php
    require_once './commun/footer.php';
    ?>
    </body>
</html>