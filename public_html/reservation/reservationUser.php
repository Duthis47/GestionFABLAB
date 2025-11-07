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
                <div class="custom-select-wrapper selec-salle">
                    <img class="chevron-down" src="/GestionFABLAB/public_html/image/chevron-down"/>
                    <select name="selec-salle">
                        <option value="1">Test1</option>
                        <option value="2">Test2</option>
                    </select>
                </div>

                <div class="input-date">
                    <input type="date" name="dateFiltre"/>
                </div>

                <button class="bouton-filtrer" id="filtrer">
                    <span class="text-wrapper-5">Filtrer</span>
                </button>
            </div>               
            <div class="date-nav-bar">
                <div class="date-nav-today">Aujourd'hui</div>
                <div class="date-nav-controls">
                    <button class="nav-arrow" id="suivant" aria-label="Mois précédent">&lt;</button>
                    <span class="nav-month-year">Oct. – Nov. 2025</span>
                    <button class="nav-arrow" id="precedent" aria-label="Mois suivant">&gt;</button>
                </div>
            </div>
            
        </div>
        
        </div> 
<script>
    const buttonFiltre = document.getElementById("filtrer");
    const buttonMoisSuivant = document.getElementById("suivant");
    const buttonMoisPrecedent = document.getElementById("precedent");

    buttonFiltre.onclick = function(){
        buttonFiltre.innerHTML = "Ca fonctionne";
    };
    
</script>
</body>
</html>