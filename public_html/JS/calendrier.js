function toDateTimeLocal(date) {
    const pad = (num) => String(num).padStart(2, '0');

    const year = date.getFullYear();
    const month = pad(date.getMonth() + 1);
    const day = pad(date.getDate());
    const hours = pad(date.getHours());
    const minutes = pad(date.getMinutes());

    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

function afficherCalendrier(type) {
    let allDay;
    if (type == 'etudiant') {
        allDay = false;
    }
    else {
        allDay = true;
    }

    debutsem = new Date();
    debutsem = debutsem.setUTCDate(debutsem.getUTCDate() - debutsem.getUTCDay() + 1);
    let x = new Date(debutsem)

    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendrier');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'local',
            initialView: 'timeGridWeek',
            locale: 'fr',
            weekends: false,
            allDaySlot: allDay,

            selectable: true,
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            slotDuration: '00:30:00',
            slotLabelInterval: '01:00:00',
            height: "auto",
            aspectRatio: 1.5,
            expandRows: true,
            dateClick: function (info) {
                //Script a effectuer lorsque je clic sur une date (info est relatif au jour du clic)

            },
            select: function (info) {
                if (type == 'etudiant') {
                    // Calcul de la durée en millisecondes
                    let duration = info.end - info.start;
                    const maxDuration = 60 * 60 * 1000; // 1 heure
                    
                    // Vérification si la date de début est dans le passé
                    if (info.start < new Date()) {
                        alert("Vous ne pouvez pas réserver dans le passé.");
                        calendar.unselect();
                        return;
                    }

                    // Remplissage du popup bootstrap
                    document.getElementById('startDisplay').innerText = info.start.toLocaleString();
                    document.getElementById('endDisplay').innerText = info.end.toLocaleString();
                    document.getElementById('startInput').value = info.start.toISOString();
                    document.getElementById('endInput').value = info.end.toISOString();
                    document.getElementById('eventTitle').value = ""; // Reset du champ


                    var monPopup = new bootstrap.Modal(document.getElementById('popupResa'));
                    monPopup.show();

                    // Gestion du bouton "Confirmer"
                    document.getElementById('saveEventBtn').onclick = function () {
                        let title = document.getElementById('eventTitle').value;

                        if (title) {
                            // Envoi vers le backend
                            fetch('api.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    title: title,
                                    start: info.start.toISOString(),
                                    end: info.end.toISOString()
                                })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        // Ajouter l'événement visuellement
                                        calendar.addEvent({
                                            title: title,
                                            start: info.start,
                                            end: info.end,
                                            backgroundColor: '#28a745', // Vert Bootstrap
                                            borderColor: '#28a745'
                                        });
                                        myModal.hide();
                                        calendar.unselect(); // Enlever la sélection grise
                                    } else {
                                        alert("Erreur lors de l'enregistrement");
                                    }
                                })
                                .catch(error => console.error('Erreur:', error));
                        } else {
                            alert("Veuillez entrer un motif.");
                        }
                    };
                }
            },

            headerToolbar: {
                left: 'prev,next,today',
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

    /*    
    calendar.addEvent({
                            title: 'Sélectionné',
                            start: info.start,
                            end: info.end,
                            backgroundColor: 'blue', // La couleur que vous vouliez
                            borderColor: 'blue',
                            id: 'selection_temporaire' // ID pour pouvoir le supprimer si besoin
                        });
                        */
}