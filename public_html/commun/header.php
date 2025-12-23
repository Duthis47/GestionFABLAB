<!-- Chemin absolu pour les ressources -->


<?php 
include_once __DIR__ . '/../../config.php';
//Empeche l'affichage des potentiels erreurs
//error_reporting(0);
//ini_set('display_errors', 0);

//Ici, j'utilise le cookie générer par le script JS pour changer la couleur du header
$theme = isset($_COOKIE['user_theme']) ? $_COOKIE['user_theme'] : 'light';
if ($theme == 'light'){
    $navbarColor = 'bg-gray';
}else {
    $navbarColor = 'bg-secondary';
}
?>
    <script>
            // Détecte si l'utilisateur préfère le mode sombre
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = prefersDark ? 'dark' : 'light';
            // Crée le cookie (valable 30 jours)
            document.cookie = "user_theme=" + theme + "; max-age=" + (30*24*60*60) + "; path=/";
    </script>
        
    <nav class="navbar navbar-expand-md navbar-white <?php echo $navbarColor; ?> mb-5 "> 
        <div class="container-fluid"> 
            <a class="navbar-brand" href="#"> 
                <img alt="Logo fablab" src="<?= BASE_URL ?>image/logo-fablab.png" class="img-fluid-logo-header"/>
            </a> 
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> 
                <span class="navbar-toggler-icon"></span> 
            </button> 
            
            <div class="collapse navbar-collapse" id="navbarCollapse"> <!-- Ajout de la div collapse pour le menu mobile -->
                <div class ="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-4 col-sm-12 mt-xs-3 mt-sm-3 text-center fs-4 ont-weight-bold">
                            <a class="nav-link" aria-current="page" href="<?= BASE_URL ?>index.php">Accueil</a> 
                        </div>
                        <div class="col-md-4 col-sm-12 mt-xs-3 mt-sm-3 text-center fs-4 font-weight-bold">
                            <a href="<?= BASE_URL ?>reservation/reservationUser.php" class="btn btn-warning btn-lg active" role="button" aria-pressed="true">Reservation</a>  
                        </div>
                        <div class="col-md-4 col-sm-12 mt-xs-3 mt-sm-3 text-center fs-4 font-weight-bold">
                        <?php 
                        if (!isset($_SESSION['isAdmin'])){
                        ?>
                            <a class="nav-link" href="<?= BASE_URL ?>Connexion/formConnexAdmin.php">Administrateur</a>
                        
                        <?php 
                        } else {
                        ?>
                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    Admin Menu
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Infos</a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/adminGestion.php">Gestion</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        <?php
                        } 
                        ?>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 
    </nav>
        
        <!-- Un seul script Bootstrap Bundle (qui inclut Popper) à la fin -->
        <script src="<?= BASE_URL ?>bootstrap/js/bootstrap.bundle.min.js"></script>
