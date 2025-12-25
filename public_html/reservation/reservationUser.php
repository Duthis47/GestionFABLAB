<?php if (!isset($_SESSION)) { session_start(); } ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Réservation - FABLAB</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./../CSS/style.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./../fullcalendar/packages/core/main.css">
    <link rel="stylesheet" href="./../fullcalendar/packages/daygrid/main.css">
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <script src="./../bootstrap/js/color-modes.js"></script>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <meta name="theme-color" content="#712cf9" />
    <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>

    <?php
    include_once './../commun/header.php';
    ?>
    <div class="container">
        <h1 class="text-wrapper-4">Réserver un créneau</h1>
        <br /><br />
        <div id="calendrier"></div>
        <div class="modal fade" id="popupResa" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Réserver un créneau</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="bookingForm">
                            <div class="mb-3">
                                <label for="eventTitle" class="form-label">Motif du rendez-vous</label>
                                <input type="text" class="form-control" id="eventTitle" required>
                            </div>
                            <!-- Transformer ca en input pour modifier date et heure-->
                            <p>Début : <input type="datetime-local" id="startDisplay"/></p>
                            <p>Fin : <input type="datetime-local" id="endDisplay"/></p>
                            <input type="hidden" id="startInput">
                            <input type="hidden" id="endInput">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="saveEventBtn">Confirmer</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="./../JS/calendrier.js">
        </script>
        <script src="./../bootstrap/JS/bootstrap.bundle.min.js"></script>
        <script>
            afficherCalendrier('etudiant');
        </script>
    </div>
        <?php
    include_once './../commun/footer.php';
    ?>
</body>

</html>