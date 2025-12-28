function toDatetimeLocal(date) {
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
            let nbActuel = verifierDisponibilite(calendar, selectInfo.start, selectInfo.end);
            return (nbActuel < placeTotalSalle);
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
    toutesLesResa.forEach(function (resa) {
    
    // 1. Correction du format de date (SQL -> ISO)
    // On remplace l'espace du milieu par un T pour être sûr que FullCalendar comprenne
    // Ex: "2025-12-30 09:00:00" devient "2025-12-30T09:00:00"
    let startISO = resa.DateTime_debut.replace(" ", "T");
    let endISO = resa.DateTime_fin.replace(" ", "T");

    calendar.addEvent({
        // On construit un titre dynamique car tu n'as pas de champ 'nom'
        title: 'Réservé (' + resa.Nb_occupant + ' pers.)', 
        
        start: startISO,
        end: endISO,
        
        backgroundColor: '#ffa500', // Rouge bootstrap
        borderColor: '#ffa500',
        textColor: '#ffffff',
        allDay: false, // Important pour forcer l'affichage en heures
        editable: false,
        display: "background",

        extendedProps: {
            nbOccupant: parseInt(resa.Nb_occupant)
        }
    });
});
// 1. On récupère le début et la fin de la vue actuelle (ex: Lundi matin au Vendredi soir)
    // Astuce : On prend large pour être sûr de couvrir la semaine affichée
    let startView = calendar.view.activeStart;
    let endView = calendar.view.activeEnd;
    
    // 2. On parcourt le temps par tranches de 30 minutes (1800000 ms)
    // On part du début de la semaine jusqu'à la fin
    for (let time = startView.getTime(); time < endView.getTime(); time += 1800 * 1000) {
        
        let dateCreneau = new Date(time); // 8h00, puis 8h30...
        let dateFinCreneau = new Date(time + 1800 * 1000); // 8h30, puis 9h00...

        // On vérifie qu'on est bien dans les heures d'ouverture (8h-20h) pour ne pas calculer la nuit pour rien
        let heure = dateCreneau.getHours();
        if (heure < 8 || heure >= 20) continue;

        // 3. On utilise ta fonction de comptage (qu'on a déjà faite !)
        // On demande : "Combien de gens entre 8h00 et 8h30 ?"
        let total = verifierDisponibilite(calendar, dateCreneau, dateFinCreneau);

        // 4. SI C'EST PLEIN -> On pose un petit pavé rouge
        if (total >= placeTotalSalle) {
            calendar.addEvent({
                title: 'COMPLET (' + total + ')',
                start: dateCreneau,
                end: dateFinCreneau,
                display: 'block',    // Bloc solide
                backgroundColor: '#d9534f', // Rouge
                borderColor: '#d9534f',
                editable: false,     // Touche pas à ça
                extendedProps: { nbOccupant: 0 }, // Pour pas fausser les comptes
                classNames: ['bloc-force-full'] 
            });
        }
    }
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
    toutesLesResa.forEach(function (resa) {
    
    // 1. Correction du format de date (SQL -> ISO)
    // On remplace l'espace du milieu par un T pour être sûr que FullCalendar comprenne
    // Ex: "2025-12-30 09:00:00" devient "2025-12-30T09:00:00"
    let startISO = resa.DateTime_debut.replace(" ", "T");
    let endISO = resa.DateTime_fin.replace(" ", "T");

    calendar.addEvent({
        // On construit un titre dynamique car tu n'as pas de champ 'nom'
        title: 'Réservé (' + resa.Nb_occupant + ' pers.)', 
        
        start: startISO,
        end: endISO,
        backgroundColor: '#d9534f',
        borderColor: '#d9534f',
        textColor: 'white',
        allDay: false // Important pour forcer l'affichage en heures
    });
});
    calendar.setOption('locale', 'fr');
    calendar.render();
}