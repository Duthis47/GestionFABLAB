<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil - FABLAB</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="/GestionFABLAB/public_html/CSS/style.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">

    </head>

    <body>
        <?php
        require_once './commun/header.php';
        ?>
        <h1 class="display-3">Hello, world!</h1>
        <h1 class="fw-500 text-dark" style="font-family: 'Roboto Condensed'; font-size: 87.383px;">Bienvenue au FabLab Milieux Aquatiques</h1>
        <p class="fw-500 text-dark" style="font-family: 'Roboto Condensed'; font-size: 32px;">Bienvenue au FabLab Milieux Aquatiques</p>
        <button type="button" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold" style="border-radius: 15px; background: #B8E1FF; color: #000; font-family: 'Roboto Condensed'; font-size: 32px; font-style: normal; font-weight: 400; line-height: normal;">Découvrir les équipements</button> 

          <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg"> 
            <div class="col-lg-7 p-3 p-lg-5 pt-lg-3"> 
            <h1 class="display-4 fw-bold lh-1 text-body-emphasis">Bienvenue au FabLab Milieux Aquatiques</h1> 
            <p class="lead">Le FabLab Milieux Aquatiques met à disposition du matériel de prototypage, d'impression 3D, de découpe laser et bien plus encore. Accédez facilement aux outils via la plateforme de réservation.</p> 
            <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3"> 
                <button type="button" class="btn btn-lg px-4 me-md-2 fw-bold" style="border-radius: 15px; background: #B8E1FF; color: #000; font-family: 'Roboto Condensed'; font-size: 32px; font-style: normal; font-weight: 400; line-height: normal;">Primary</button> 
                <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button> 
            </div> 
            </div> 
            <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg"> 
            <img class="rounded-lg-3" src="bootstrap-docs.png" alt="" width="720"> 
            </div> 
        </div>

    </body>
</html>
