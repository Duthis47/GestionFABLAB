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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
    <div class="container">
        
        <?php 
        include_once './../commun/header.php';
        ?>

        <div class="reservation-page-content">
            
            <h1 class="text-wrapper-4">Réserver un créneau</h1>

            <div class="zone-de-filtre">
                <div class="custom-select-wrapper selec-salle">
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
            <div id='calendar'></div>
        </div>
        
        </div> 
    <script id="calendrier">
        // 3. S'assurer que la page est chargée avant d'exécuter le script
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            
            // Il est plus sûr et plus propre d'utiliser le préfixe FullCalendar
            const calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [
                    FullCalendar.interactionPlugin,
                    FullCalendar.dayGridPlugin,
                    FullCalendar.timeGridPlugin  // <<< 4. LE PLUGIN MANQUANT
                ],
                initialView: 'timeGridWeek',     // <-- Cette vue nécessite timeGridPlugin
                editable: true,
                events: [
                    { title: 'Meeting', start: new Date() }
                ]
            });
            
            calendar.render();
        });
    </script>
<script id="filtrage">
    var buttonFiltre = document.getElementById("filtrer");
    var buttonMoisSuivant = document.getElementById("suivant");
    var buttonMoisPrecedent = document.getElementById("precedent");

    buttonFiltre.onclick = function(){
        buttonFiltre.innerHTML = "Ca fonctionne";
    };
</script>
</body>
</html>