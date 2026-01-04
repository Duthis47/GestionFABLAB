<?php 
include_once __DIR__ . '/../../config.php';

?>

<footer class="navbar-white navbar-custom text-dark py-4" style="font-size: 0.9rem;">
    
    <div class="container-fluid">
        
        <div class="row align-items-center justify-content-center text-center">
            
            <div class="col-12 col-md-auto mb-4 mb-md-0">
                <a class="navbar-brand" href="https://www.univ-pau.fr/fr/index.html"> 
                    <img alt="Logo uppa" src="<?= BASE_URL ?>image/logo-uppa.png" style="height: 70px; width: auto; background: white; padding: 5px; border-radius: 5px;"/>
                </a> 
            </div>

            <div class="col-12 col-md-auto mb-4 mb-md-0 mx-md-4">
                <p class="fw-bold mb-2">Suivez nous sur les réseaux sociaux!</p>
                <ul class="list-unstyled">
                    <li class="mb-1"> 
                        <a href="https://www.instagram.com/fablab.milieuxaquatiques/" class="text-dark text-decoration-none">
                            <img alt="Logo insta" src="<?= BASE_URL ?>image/logo-insta.png" style="width:20px; vertical-align: middle; margin-right: 5px;"/> Instagram
                        </a>
                    </li>
                    <li class="mb-1"> 
                        <a href="https://www.linkedin.com/company/fablab-milieux-aquatiques-uppa/" class="text-dark text-decoration-none">
                            <img alt="Logo linkedin" src="<?= BASE_URL ?>image/logo-linkedin.png" style="width:20px; vertical-align: middle; margin-right: 5px;"/> Linkedin
                        </a>
                    </li>
                </ul>
                <p class="mb-0">Ou retrouvez toutes nos informations <a class="text-info text-decoration-underline" href="https://organisation.univ-pau.fr/fr/grands-projets/irekia/fablab-milieux-aquatiques.html">ici</a>!</p>
            </div>

            <div class="col-12 col-md-auto mb-4 mb-md-0 mx-md-4">
                <p class="fw-bold mb-2">Contactez-nous!</p>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <img alt="Logo mail" src="<?= BASE_URL ?>image/logo-mail.png" style="width:20px; vertical-align: middle; margin-right: 5px;">
                        <a class="text-dark text-decoration-none" href="mailto:fablab.ma@univ-pau.fr">fablab.ma@univ-pau.fr</a>
                    </li>
                    <li>
                        <div class="d-flex justify-content-center justify-content-md-start">
                            <img alt="Logo pin" src="<?= BASE_URL ?>image/logo-pin.png" style="width:20px; height: 20px; vertical-align: top; margin-right: 5px;">
                            <span>
                                Sur place au : <a class="text-dark text-decoration-none" href="https://www.google.fr/maps/place/Université+de+Pau+et+des+Pays+de+l'Adour/@43.4794501,-1.5085429,20.57z/data=!4m6!3m5!1s0xd51400f19c3049b:0x7417b36bb785049a!8m2!3d43.4793862!4d-1.5086889!16s%2Fg%2F11btmqzr9n?entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoASAFQAw%3D%3D">1 allée du parc Montaury,<br> 64600 Anglet - rdc du Bâtiment 1, salle 013</a>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-auto">
                <a class="navbar-brand" href="#"> 
                    <img alt="Logo fablab" src="<?= BASE_URL ?>image/logo-fablab.png" style="height: 70px; width: auto;"/>
                </a> 
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center justify-content-center text-center small text-dark-50">
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <p class="mb-0">Site réalisé par Charlotte ENCARNACAO, Mathis DUCROT et Honoré BLAISE<br> dans le cadre d’une SAÉ à ISANUM</p>
            </div>
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <p class="mb-0"> <a class="text-dark-50 text-decoration-underline" href="#RGPD.php">RGPD</a></p>
            </div>
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <p class="mb-0"> <a class="text-dark-50 text-decoration-underline" href="#mentionslegales.php">Mentions légales</a></p>
            </div>
        </div>
    </div>
</footer>

<script>
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = prefersDark ? 'dark' : 'light';
    document.cookie = "user_theme=" + theme + "; max-age=" + (30*24*60*60) + "; path=/";
</script>