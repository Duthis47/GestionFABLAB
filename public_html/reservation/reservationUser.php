<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Réservation - FABLAB</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/GestionFABLAB/public_html/CSS/style.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        
        <?php 
        include_once './../commun/header.php';
        ?>

        <div class="reservation-page-content">
            
            <h1 class="text-wrapper-4">Réserver un créneau</h1>

            <div class="zone-de-filtre">
                <div class="selec-salle">
                    <select class="text-wrapper-5" name="selecType">
                    <img class="chevron-down" src="https://c.animaapp.com/mbPf7It7/img/chevron-down-1@2x.png" />
                    </select>
                </div>
                <div class="selec-date">
                    <div class="text-wrapper-5">Date</div>
                    <img class="chevron-down" src="https://c.animaapp.com/mbPf7It7/img/chevron-down-1@2x.png" />
                </div>
                <div class="bouton-filtrer">
                    <div class="text-wrapper-5">Filtrer</div>
                </div>
            </div>

            <div class="date-nav-bar">
                <div class="date-nav-today">Aujourd'hui</div>
                <div class="date-nav-controls">
                    <button class="nav-arrow" aria-label="Mois précédent">&lt;</button>
                    <span class="nav-month-year">Oct. – Nov. 2025</span>
                    <button class="nav-arrow" aria-label="Mois suivant">&gt;</button>
                </div>
            </div>
            
        </div>
        
        </div> 
</body>
</html>