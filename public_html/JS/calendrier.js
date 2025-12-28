function toDatetimeLocal(date) {
    const dateLocal = new Date(date);
    dateLocal.setMinutes(dateLocal.getMinutes() - dateLocal.getTimezoneOffset());
    return dateLocal.toISOString().slice(0, 16);
}

function afficherCalendrierSalle(type, toutesLesResa) {
    //type peut etre 'etudiant' ou 'admin'
    //salle est l'id de la salle a afficher
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

                    // Remplissage du popup Bootstrap
                    document.getElementById('startInput').ariaPlaceholder = toDatetimeLocal(info.start);
                    document.getElementById('endInput').ariaPlaceholder = toDatetimeLocal(info.end);
                    document.getElementById('startInput').value = toDatetimeLocal(info.start);
                    document.getElementById('endInput').value = toDatetimeLocal(info.end);
                    document.getElementById('nom').value = ""; // Reset du champ
                    document.getElementById('prenom').value = ""; // Reset du champ
                    document.getElementById('mail').value = ""; // Reset du champ
                    document.getElementById('nbOccupant').value = ""; // Reset du champ


                    var monPopup = new bootstrap.Modal(document.getElementById('popupResa'));
                    monPopup.show();                                    
                         
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


function afficherCalendrierMateriel(type, toutesLesResa) {
    //type peut etre 'etudiant' ou 'admin'
    //salle est l'id de la salle a afficher
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

                    // Remplissage du popup Bootstrap
                    document.getElementById('startInput').ariaPlaceholder = toDatetimeLocal(info.start);
                    document.getElementById('endInput').ariaPlaceholder = toDatetimeLocal(info.end);
                    document.getElementById('startInput').value = toDatetimeLocal(info.start);
                    document.getElementById('endInput').value = toDatetimeLocal(info.end);
                    document.getElementById('nom').value = ""; // Reset du champ
                    document.getElementById('prenom').value = ""; // Reset du champ
                    document.getElementById('mail').value = ""; // Reset du champ
                    document.getElementById('nbOccupant').value = ""; // Reset du champ


                    var monPopup = new bootstrap.Modal(document.getElementById('popupResa'));
                    monPopup.show();                                    
                         
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