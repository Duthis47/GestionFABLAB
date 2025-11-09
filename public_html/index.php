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
  <link rel="stylesheet" href="fullcalendar/packages/core/main.css">
<link rel="stylesheet" href="fullcalendar/packages/daygrid/main.css">

</head>

<body>
    <!-- Fichiers JS à insérer avant </body> -->
    <script src="fullcalendar/packages/core/main.js"></script>
    <script src="fullcalendar/packages/daygrid/main.js"></script>

  
    <?php
        require_once './commun/header.php';
    ?>
    <div class="container">
        <div id="calendrier"></div>
             <script>
            window.onload = () => {
            // On va chercher la div dans le HTML
                let calendarEl = document.getElementById('calendrier');

            // On instancie le calendrier
                let calendar = new FullCalendar.Calendar(calendarEl, {
                // On charge le composant "dayGrid"
                    plugins: [ 'dayGrid' ],
                    locale: 'fr',
                    height: 1000
             });

            // On affiche le calendrier
            calendar.render();
        };
            </script>
    </div>
</body>
</html>
