function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2){
    return parts.pop().split(';').shift();
  }
}

function getColor(theme){
    const color = {
        "light": [],
        "dark": []
    };
}

function toDatetimeLocal(date) {
    //Conversion en format utilisable par FullCalendar
    const dateLocal = new Date(date);
    dateLocal.setMinutes(dateLocal.getMinutes() - dateLocal.getTimezoneOffset());
    return dateLocal.toISOString().slice(0, 16);
}

function toSqlDateTime(date) {
    const d = new Date(date);

    const year = d.getFullYear();
    // getMonth() commence à 0, donc on ajoute 1. padStart assure d'avoir 2 chiffres (01, 02...).
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');

    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    const seconds = String(d.getSeconds()).padStart(2, '0');

    // Résultat : 2026-01-02 10:00:00
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

function verifierDisponibilite(calendar, start, end) {
    let total = 0;
    let events = calendar.getEvents();

    events.forEach(ev => {
        // Si chevauchement
        if (ev.start < end && ev.end > start && ev.title !== 'Indisponible') {
            // On récupère le nombre d'occupants stocké dans extendedProps
            total += (ev.extendedProps.nbOccupant || 0);
        }
    });
    return total;
}

function verifierBlocage(calendar, start, end) {
    const events = calendar.getEvents();

    const estBloque = events.some(resa => {
        const cEstUnBlocage = (resa.extendedProps && resa.extendedProps.blocage == 1);
        const chevauche = (resa.start < end && resa.end > start);
        return cEstUnBlocage && chevauche;
    });

    // On retourne false si c'est bloqué, true sinon
    return !estBloque;
}

function afficherCalendrierSalle(type, toutesLesResa, placeTotalSalle) {
    //type peut etre 'etudiant' ou 'admin'
    //salle est l'id de la salle a afficher
    const theme = getCookie('user_theme');

    let allDay = type != 'etudiant';

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
        eventOrder: "duration",
        slotEventOverlap: false,
        selectable: true,
        slotMinTime: '08:00:00',
        slotMaxTime: '20:00:00',
        slotDuration: '00:30:00',
        slotLabelInterval: '01:00:00',
        height: "auto",
        aspectRatio: 1.5,
        expandRows: true,
        editable: false,
        allDayText: 'Toute la journée',
        dateClick: function (info) {
            //Script a effectuer lorsque je clic sur une date (info est relatif au jour du clic)

        },
        //On autorise la selection que si il reste de la place
        selectAllow: function (selectInfo) {
            if (!verifierBlocage(calendar, selectInfo.start, selectInfo.end)){
                return false;
            }
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
            else {
                let duration = info.end - info.start;
                const maxDuration = 60 * 60 * 1000; // 1 heure

                if (info.start < new Date()) {
                    alert("Vous ne pouvez pas modifier le passé.");
                    calendar.unselect();
                    return;
                }

                //On remplit : 
                document.getElementById('startBloc').ariaPlaceholder = toDatetimeLocal(info.start);
                document.getElementById('endBloc').ariaPlaceholder = toDatetimeLocal(info.end);
                document.getElementById('startBloc').value = toSqlDateTime(info.start);
                document.getElementById('endBloc').value = toSqlDateTime(info.end);
                document.getElementById("typeM").value = "Bloquer";
                document.getElementById("saveEventBtn").innerText = "Bloquer";
                document.getElementById("titlePopUp").innerText = "Bloquer un créneau";
                var monPopup = new bootstrap.Modal(document.getElementById('popupBlocage'));
                monPopup.show();
            }
        },

        eventClick: function (info) {
            if (type == 'admin') {
                if (info.event.extendedProps.blocage == 0){
                    // Afficher les détails de la réservation dans un formulaire ou une modale
                    document.getElementById('start').textContent = info.event.start.toLocaleString();
                    document.getElementById('end').textContent = info.event.start.toLocaleString();
                    document.getElementById('dateDebut').value = toSqlDateTime(info.event.start);
                    document.getElementById('nbOccupant').textContent = info.event.extendedProps.nbOccupant;
                    document.getElementById('reserverPar').textContent = info.event.extendedProps.reserverPar || 'Inconnu';
                    document.getElementById('idU').value = info.event.extendedProps.idU;
                    document.getElementById('idR').value = info.event.extendedProps.idR;
                    //A decommenter si on veut afficher la raison
                    //document.getElementById('raison').textContent = info.event.extendedProps.raison || 'Aucune raison fournie';  
                    if (info.event.extendedProps.AutorisationFinal == 1) {
                        document.getElementById("Valider").hidden = true;
                    } else {
                        document.getElementById("Valider").hidden = false;
                    }
                    var monPopup = new bootstrap.Modal(document.getElementById('popupAdmin'));
                    monPopup.show();
                }else {
                    document.getElementById('startBloc').ariaPlaceholder = toDatetimeLocal(info.event.start);
                    document.getElementById('endBloc').ariaPlaceholder = toDatetimeLocal(info.event.end);
                    document.getElementById('startBloc').value = toSqlDateTime(info.event.start);
                    document.getElementById('endBloc').value = toSqlDateTime(info.event.end);
                    document.getElementById('startBloc').readOnly = true;
                    document.getElementById('endBloc').readOnly = true;
                    document.getElementById("typeM").value = "Debloquer";
                    document.getElementById("saveEventBtn").innerText = "Debloquer";
                    document.getElementById("titlePopUp").innerText = "Debloquer un créneau";

                    var monPopup = new bootstrap.Modal(document.getElementById('popupBlocage'));
                    monPopup.show();
                }
            }
        },
        buttonText: {
            today: "Aujourd'hui",
            week: "Semaine",
            day: "Jour"
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

    var colorDisplay = "background";

    if (type == 'admin') {
        colorDisplay = "block";
    }


    toutesLesResa.forEach(function (resa) {
        var title = "Réservé (" + resa.Nb_occupant + "pers.)";

        var colorBack = "#ffa500";
        if (theme == "dark" && type == "etudiant"){
            colorBack = "#F8E71C";
        }
        let startISO = resa.DateTime_debut.replace(" ", "T");
        let endISO = resa.DateTime_fin.replace(" ", "T");
        if (type == 'admin' && resa.AutorisationFinal === 1) {
            colorBack = "#5CE65C";
        }
        if (resa.Blocage === 1){
            colorBack = "#333333";
            colorDisplay = "block";
            title = "Indisponible";
        }else if (type == "etudiant"){
            
            colorDisplay = "background"
        }

        let eventData = {
            title: title,

            start: startISO,
            end: endISO,

            backgroundColor: colorBack,
            borderColor: '#000000',
            textColor: '#ffffff',
            allDay: false,
            editable: false,
            display: colorDisplay,
            extendedProps: {
                nbOccupant: parseInt(resa.Nb_occupant),
                blocage: resa.Blocage || 0
            }
        }

        if (type == 'admin') {
            eventData.extendedProps.reserverPar = resa.nomU + ' ' + resa.prenomU;
            eventData.extendedProps.mailR = resa.mailU;
            eventData.extendedProps.raison = ""; // A remplir si besoin avec les raisons de la réservation
            eventData.extendedProps.idU = resa.idU;
            eventData.extendedProps.idR = resa.idR_salle;
            eventData.extendedProps.AutorisationFinal = resa.AutorisationFinal;
        }
        calendar.addEvent(eventData);
    });
    let startView = calendar.view.activeStart;
    let endView = calendar.view.activeEnd;
    if (type == "etudiant") {
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
    }
    calendar.setOption('locale', 'fr');
    calendar.render();
}


function afficherCalendrierMateriel(type, toutesLesResa, capaSalle = 100, nbExemplaireTotal) {
    console.log("B: "+nbExemplaireTotal);
    //type peut etre 'etudiant' ou 'admin'
    //salle est l'id de la salle a afficher
    const theme = getCookie('user_theme');
    console.log(theme);

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
        eventOrder: "duration",
        slotEventOverlap: false,
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
        selectAllow: function (selectInfo) {
            if (!verifierBlocage(calendar, selectInfo.start, selectInfo.end)){
                return false;
            }
            if (verifierDisponibilite(calendar, selectInfo.start, selectInfo.end) >= nbExemplaireTotal){
                return false;
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
                document.getElementById('nbOccupant').max = document.getElementById("materiel").selectedOptions[0].getAttribute('data-maxPlaceSalle');

                var monPopup = new bootstrap.Modal(document.getElementById('popupResa'));
                monPopup.show();

            }
            else {
                let duration = info.end - info.start;
                const maxDuration = 60 * 60 * 1000; // 1 heure

                if (info.start < new Date()) {
                    alert("Vous ne pouvez pas modifier le passé.");
                    calendar.unselect();
                    return;
                }

                //On remplit : 
                document.getElementById('startBloc').ariaPlaceholder = toDatetimeLocal(info.start);
                document.getElementById('endBloc').ariaPlaceholder = toDatetimeLocal(info.end);
                document.getElementById('startBloc').value = toSqlDateTime(info.start);
                document.getElementById('endBloc').value = toSqlDateTime(info.end);
                document.getElementById("typeM").value = "Bloquer";

                var monPopup = new bootstrap.Modal(document.getElementById('popupBlocage'));
                monPopup.show();
            }
        },
        eventClick: function (info) {
            if (type == 'admin') {
                const dateObjet = info.event.start;

                // Pour Affichage
                document.getElementById('start').textContent = dateObjet.toLocaleString();

                // Pour la BDD
                document.getElementById('dateDebut').value = toSqlDateTime(dateObjet);

                document.getElementById('nbOccupant').textContent = info.event.extendedProps.nbOccupant;
                document.getElementById('reserverPar').textContent = info.event.extendedProps.reserverPar || 'Inconnu';
                document.getElementById('idU').value = info.event.extendedProps.idU;
                document.getElementById('idR').value = info.event.extendedProps.idR;

                // Gestion du bouton Valider
                let btnValider = document.getElementById("Valider");
                if (info.event.extendedProps.AutorisationFinal == 1) {
                    btnValider.hidden = true;
                } else {
                    btnValider.hidden = false;
                }

                var monPopup = new bootstrap.Modal(document.getElementById('popupAdmin'));
                monPopup.show();
            }
        },
        headerToolbar: {
            left: 'prev,next,today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay',
        },
        buttonText: {
            today: "Aujourd'hui",
            week: "Semaine",
            day: "Jour"
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            meridiem: false
        },
        editable: true
    });
    var title = "Réservé";
    var colorDisplay = "background";
    if (type == 'admin') {
        colorDisplay = "block";
    }
    toutesLesResa.forEach(function (resa) {
        let currentTitle = "Réservé";
        let colorBack = (theme == "dark") ? "#F8E71C" : "#ffa500";
        
        // Par défaut pour l'admin, on affiche tout en 'block'
        let currentDisplay = "block"; 

        if (resa.Blocage === 1) {
            colorBack = "#333333";
            currentTitle = "Indisponible";
            currentDisplay = "block"; 
        } else {
            if (type === 'etudiant') {
                currentDisplay = 'none'; 
            } else {
                if (resa.AutorisationFinal == 1) colorBack = "#5CE65C";
                currentDisplay = "block";
            }
        }

        let startISO = resa.DateTime_debut.replace(" ", "T");
        let endISO = resa.DateTime_fin.replace(" ", "T");

        let eventData = {
            title: currentTitle,
            start: startISO,
            end: endISO,
            backgroundColor: colorBack,
            borderColor: '#000000',
            textColor: '#ffffff',
            display: currentDisplay, 
            extendedProps: {
                nbOccupant: 1,
                blocage: resa.Blocage || 0
            }
        };

        if (type == 'admin') {
            eventData.extendedProps.reserverPar = resa.nomU + ' ' + resa.prenomU;
            eventData.extendedProps.idR = resa.idR_materiel;
            eventData.extendedProps.AutorisationFinal = resa.AutorisationFinal;
        }
        calendar.addEvent(eventData);
    });

    let startView = calendar.view.activeStart;
    let endView = calendar.view.activeEnd;

    if (type == "etudiant") {
        for (let time = startView.getTime(); time < endView.getTime(); time += 1800 * 1000) {
            let dateCreneau = new Date(time);
            let dateFinCreneau = new Date(time + 1800 * 1000);

            let heure = dateCreneau.getHours();
            if (heure < 8 || heure >= 20) continue;

            let total = verifierDisponibilite(calendar, dateCreneau, dateFinCreneau);
            

            if (total >= nbExemplaireTotal) {
                calendar.addEvent({
                    title: 'Indisponible (Complet)',
                    start: dateCreneau,
                    end: dateFinCreneau,
                    display: 'block', 
                    backgroundColor: '#d9534f',
                    borderColor: '#d9534f',
                    textColor: '#ffffff',
                    editable: false,
                    extendedProps: { nbOccupant: 0 }
                });
            }
        }
    }
    calendar.setOption('locale', 'fr');
    calendar.render();
}