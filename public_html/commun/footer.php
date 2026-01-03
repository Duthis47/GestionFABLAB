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

        //Ici, j'utilise le cookie généré par le script JS pour changer la couleur du footer
        $theme = isset($_COOKIE['user_theme']) ? $_COOKIE['user_theme'] : 'light';
        if ($theme == 'light'){
            $footerColor = 'bg-gray';
        }else {
            $footerColor = 'bg-secondary';
        }
        ?>
    
        
        <footer class="container-fluid font-weight-bold">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-auto mb-3 mb-md-0">
                    <a class="navbar-brand" href="https://www.univ-pau.fr/fr/index.html"> 
                        <img alt="Logo uppa" src="<?= BASE_URL ?>image/logo-uppa.png" class="img-fluid-logo-footer-uppa"/>
                    </a> 
                </div>

                <div class="col-12 col-md-auto mb-3 mb-md-0 fs-4">
                    <p>Suivez nous sur les réseaux sociaux!</p>
                    <ul class="list-unstyled">
                        <li> <a href="https://www.instagram.com/fablab.milieuxaquatiques/"><img alt="Logo insta" src="<?= BASE_URL ?>image/logo-insta.png"/></a> Instagram</li>
                        <li> <a href="https://www.linkedin.com/company/fablab-milieux-aquatiques-uppa/"><img alt="Logo linkedin" src="<?= BASE_URL ?>image/logo-linkedin.png"/></a> Linkedin</li>
                    </ul>
                    <p>Ou retrouvez toutes nos informations <a class="footer-underline-a" href="https://organisation.univ-pau.fr/fr/grands-projets/irekia/fablab-milieux-aquatiques.html">ici</a>!</p>
                </div>

                <div class="col-12 col-md-auto mb-3 mb-md-0 fs-4">
                    <p>Contactez-nous!</p>
                    <ul class="list-unstyled">
                        <li><img alt="Logo mail" src="<?= BASE_URL ?>image/logo-mail.png"><a class="footer-a" href="mailto:fablab.ma@univ-pau.fr">fablab.ma@univ-pau.fr</a></li>
                        <li><img alt="Logo pin" src="<?= BASE_URL ?>image/logo-pin.png">Sur place au : <a class="footer-a" href="https://www.google.fr/maps/place/Université+de+Pau+et+des+Pays+de+l'Adour/@43.4794501,-1.5085429,20.57z/data=!4m6!3m5!1s0xd51400f19c3049b:0x7417b36bb785049a!8m2!3d43.4793862!4d-1.5086889!16s%2Fg%2F11btmqzr9n?entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoASAFQAw%3D%3D">1 allée du parc Montaury,<br> 64600 Anglet - rdc du Bâtiment 1, salle 013</a></li>
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
                    <p style="font-size:10px;">Site réalisé par Charlotte ENCARNACAO, Mathis DUCROT et Honoré BLAISE<br> dans le cadre d’une SAÉ à ISANUM</p>
                </div>
                <div class="col-12 col-md-4 mb-3 mb-md-0 fs-4">
                    <p> <a class="footer-underline-a" href="#RGPD.php">RGPD</a></p>
                </div>
                <div class="col-12 col-md-4 mb-3 mb-md-0 fs-4">
                    <p> <a class="footer-underline-a" href="#mentionslegales.php">Mentions légales</a></p>
                </div>
            </div>
        </footer>
    </body>
</html>