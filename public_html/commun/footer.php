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
        
        <footer class="container-fluid font-weight-bold">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-auto mb-3 mb-md-0">
                    <a class="navbar-brand" href="#"> 
                        <img alt="Logo uppa" src="<?= BASE_URL ?>image/logo-uppa.png" class="img-fluid-logo-footer-uppa"/>
                    </a> 
                </div>

                <div class="col-12 col-md-auto mb-3 mb-md-0 fs-4">
                    <p>Suivez nous sur les réseaux sociaux!</p>
                    <ul class="list-unstyled">
                        <li>Instagram</li>
                        <li>Linkedin</li>
                    </ul>
                    <p>Ou retrouvez toutes nos informations ici!</p>
                </div>

                <div class="col-12 col-md-auto mb-3 mb-md-0 fs-4">
                    <p>Contactez-nous!</p>
                    <ul class="list-unstyled">
                        <li>Mail</li>
                        <li>Chez nous</li>
                    </ul>
                </div>

                <div class="col-12 col-md-auto">
                    <a class="navbar-brand" href="#"> 
                        <img alt="Logo fablab" src="<?= BASE_URL ?>image/logo-fablab.png" class="img-fluid-logo-footer-fablab"/>
                    </a> 
                </div>
            </div>


            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-4 mb-3 mb-md-0 fs-4">
                    <p>Site réalisé par Charlotte ENCARNACAO, Mathis DUCROT et Honoré BLAISE dans le cadre d’une SAÉ à ISANUM</p>
                </div>
                <div class="col-12 col-md-4 mb-3 mb-md-0 fs-4">
                    <p>RGPD</p>
                </div>
                <div class="col-12 col-md-4 mb-3 mb-md-0 fs-4">
                    <p>Mentions légales</p>
                </div>
            </div>
        </footer>
    </body>
</html>