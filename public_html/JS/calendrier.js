function toDatetimeLocal(date) {
    //Conversion en format utilisable par FullCalendar
    const dateLocal = new Date(date);
    dateLocal.setMinutes(dateLocal.getMinutes() - dateLocal.getTimezoneOffset());
    return dateLocal.toISOString().slice(0, 16);
}

function verifierDisponibilite(calendar, start, end, eventIgnoredId = null) {
    let total = 0;
    let events = calendar.getEvents();

    events.forEach(ev => {
        // Si chevauchement
        if (ev.start < end && ev.end > start) {
            // On récupère le nombre d'occupants stocké dans extendedProps
            total += (ev.extendedProps.nbOccupant || 0);
        }
    });
    return total;
}

function afficherCalendrierSalle(type, toutesLesResa, placeTotalSalle) {
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
        editable: false,
        dateClick: function (info) {
            //Script a effectuer lorsque je clic sur une date (info est relatif au jour du clic)

        },
        //On autorise la selection que si il reste de la place
        selectAllow: function(selectInfo) {
            if (type == 'etudiant') {
                let nbActuel = verifierDisponibilite(calendar, selectInfo.start, selectInfo.end);
                return (nbActuel < placeTotalSalle);
            }
            return true;
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
                document.getElementById('nbOccupant').max = placeTotalSalle - verifierDisponibilite(calendar, info.start, info.end); // Reset du champ


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
    toutesLesResa.forEach(function (resa) {
    
    let startISO = resa.DateTime_debut.replace(" ", "T");
    let endISO = resa.DateTime_fin.replace(" ", "T");

    calendar.addEvent({
        title: 'Réservé (' + resa.Nb_occupant + ' pers.)', 
        
        start: startISO,
        end: endISO,
        
        backgroundColor: '#ffa500',
        borderColor: '#000000',
        textColor: '#ffffff',
        allDay: false, 
        editable: false,
        display: "background",
        extendedProps: {
            nbOccupant: parseInt(resa.Nb_occupant)
        }
    });
});
    let startView = calendar.view.activeStart;
    let endView = calendar.view.activeEnd;
    
    for (let time = startView.getTime(); time < endView.getTime(); time += 1800 * 1000) {
        
        let dateCreneau = new Date(time); 
        let dateFinCreneau = new Date(time + 1800 * 1000);

        let heure = dateCreneau.getHours();
        if (heure < 8 || heure >= 20) continue;

        let total = verifierDisponibilite(calendar, dateCreneau, dateFinCreneau);

        if (total >= placeTotalSalle) {
            calendar.addEvent({
                title: 'COMPLET (' + total + ')',
                start: dateCreneau,
                end: dateFinCreneau,
                display: 'block',    
                backgroundColor: '#d9534f', 
                borderColor: '#d9534f',
                editable: false,     
                extendedProps: { nbOccupant: 0 },
                classNames: ['bloc-force-full'] 
            });
        }
    }
    calendar.setOption('locale', 'fr');
    calendar.render();
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
}