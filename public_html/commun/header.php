<!DOCTYPE html>
<html>
    <head>
        <script src="/GestionFABLAB/public_html/bootstrap/js/color-modes.js"></script>
        <link href="/GestionFABLAB/public_html/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <meta name="theme-color" content="#712cf9" />
        <link href="/GestionFABLAB/public_html/bootstrap/navbar/navbar-static.css" rel="stylesheet" />
        <link href="/GestionFABLAB/public_html/CSS/style.css" rel="stylesheet"/>
    </head>
    <body>
        <!-- SUPPRESSION des scripts JS ici (déplacés en bas) -->
        
        <?php 
        session_start();
            $sizeCol='4';
            $sizeFont = '4';
        ?>
        
        <nav class="navbar navbar-expand-md navbar-white bg-gray mb-5 "> 
            <div class="container-fluid"> 
                <a class="navbar-brand" href="#"> 
                    <img alt="Logo fablab" src="/GestionFABLAB/public_html/image/logo-fablab.png" class="img-fluid-logo"/>
                </a> 
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> 
                    <span class="navbar-toggler-icon"></span> 
                </button> 
                
                <div class="collapse navbar-collapse" id="navbarCollapse"> <!-- Ajout de la div collapse pour le menu mobile -->
                    <div class ="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-<?php echo $sizeCol;?> text-center fs-<?php echo $sizeFont;?>">
                                <a class="nav-link" aria-current="page" href="/GestionFABLAB/public_html/index.php">Accueil</a> 
                            </div>
                            <div class="col-<?php echo $sizeCol;?> text-center fs-<?php echo $sizeFont;?>">
                                <a href="/GestionFABLAB/public_html/reservation/reservationUser.php" class="btn btn-warning btn-lg active" role="button" aria-pressed="true">Reservation</a>  
                            </div>
                            <div class="col-<?php echo $sizeCol;?> text-center fs-<?php echo $sizeFont;?>">
                            <?php 
                            if (!isset($_SESSION['isAdmin'])){
                            ?>
                                <a class="nav-link" href="/GestionFABLAB/public_html/Connexion/formConnexAdmin.php">Administrateur</a>
                            
                            <?php 
                            } else {
                            ?>
                                <!-- DEBUT DU DROPDOWN CORRIGÉ -->
                                <div class="dropdown show">
                                    <!-- Correction: data-bs-toggle au lieu de data-toggle -->
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                        Admin Menu
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="#">Infos</a></li>
                                        <li><a class="dropdown-item" href="#">Gestion</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                                <!-- FIN DU DROPDOWN CORRIGÉ -->
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
        <script src="/GestionFABLAB/public_html/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>