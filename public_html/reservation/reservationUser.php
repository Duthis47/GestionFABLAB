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
        <link rel="stylesheet" href="/GestionFABLAB/public_html/fullcalendar/packages/core/main.css">
        <link rel="stylesheet" href="/GestionFABLAB/public_html/fullcalendar/packages/daygrid/main.css">
        <link href="/GestionFABLAB/public_html/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
        
            <?php
            include_once './../commun/header.php';
            ?>
        <div class="container">
            <h1 class="text-wrapper-4">Réserver un créneau</h1>
            <br/><br/>
            <div id="calendrier"></div>
            <script>
                debutsem=new Date();
                debutsem=debutsem.setUTCDate(debutsem.getUTCDate()-debutsem.getUTCDay()+1);
                let x = new Date(debutsem)
                alert(x.getDate());
                if (debutsem )
                document.addEventListener('DOMContentLoaded', function () {
                    let calendarEl = document.getElementById('calendrier');

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        timeZone: 'UTC',
                        initialView: 'timeGridWeek',
                        locale: 'fr', 
                        weekends: false,
                        selectable: true,
                        slotMinTime : '08:00:00',
                        slotMaxTime : '20:00:00',
                        height : "auto",
                        expandRows : true,
                        dateClick: function(info) {
                            //Script a effectuer lorsque je clic sur une date (info est relatif au jour du clic)
                            info.dayEl.style.backgroundColor = 'red';
                        },
                        headerToolbar: {
                            left: 'prev,next',
                            center: 'title',
                            right: 'timeGridWeek,timeGridDay',
                        },
                        eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        meridiem: false
                      },
                        editable: true
                    });
                    calendar.setOption('locale', 'fr');
                    calendar.render();
                });

            </script>
        </div>
        <script id="filtrage">
            
        </script>
    </body>
</html>