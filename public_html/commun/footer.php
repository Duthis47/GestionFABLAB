<!DOCTYPE html>
<html>
    <body> 
    <script>
            // Détecte si l'utilisateur préfère le mode sombre
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = prefersDark ? 'dark' : 'light';
            // Crée le cookie (valable 30 jours)
            document.cookie = "user_theme=" + theme + "; max-age=" + (30*24*60*60) + "; path=/";
    </script>
        <?php 
        //Empeche l'affichage des potentielles erreurs
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
        
        <nav class="navbar navbar-expand-md navbar-white <?php echo $navbarColor; ?> mt-5 "> 
            <div class="container-fluid"> 
                
                <a class="navbar-brand" href="#"> 
                    <img alt="Logo uppa" src="./../image/logo-uppa.png" class="img-fluid-logo-footer-uppa"/>
                </a> 
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> 
                    <span class="navbar-toggler-icon"></span> 
                </button> 
                <div class="collapse navbar-collapse" id="navbarCollapse"> <!-- Ajout de la div collapse pour le menu mobile -->
                    <div class ="container">
                    </div> 
                </div>
                <a class="navbar-brand" href="#"> 
                    <img alt="Logo fablab" src="./../image/logo-fablab.png" class="img-fluid-logo-footer-fablab"/>
                </a> 


            </div> 
        </nav>
        
        <!-- Un seul script Bootstrap Bundle (qui inclut Popper) à la fin -->
        <script src="./../bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>