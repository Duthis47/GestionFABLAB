<!DOCTYPE html>
<?php
    //On lance la session si elle n'existe pas
    if (!isset($_SESSION)) {
        session_start();
    }

    //On verifie que l'utilisateur est un administrateur
    if(!isset($_SESSION['isAdmin'])){
        header("Location: ./../index.php");
        exit();
    }

    require_once './../commun/header.php';
    include_once './../classesDAO/SalleDAO.php';
    include_once './../classesDAO/MaterielsDAO.php';

    $isSalleMode = !isset($_GET['estMateriel']);
    $tableauElement = [];
    if(!$isSalleMode){
        $titreF = "Choisissez le matériel à afficher";
        $tableauElement = MaterielsDAO::getAllMateriels();
    } else {
        $titreF = "Choisissez la salle à afficher";
        $tableauElement = SalleDAO::getAllSalles();
    }

    $tableauElementJson = json_encode($tableauElement);

?>

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

    <script src="./../fullcalendar/dist/index.global.min.js"></script>
    <script src="./../JS/calendrier.js"></script>
    <script src="./../JS/recupElement.js"></script>

<body>
    <div class="container">
        <div id="filtre">
            <!-- Ici mettre le filtre de salle ou de matériel -->
            <form>
                <div class="mb-3">
                    <label for="element" class="form-label"><?= $titreF ?></label>
                    <?php                         
                    ?>
                    <select class="form-select" id="element" name="element">
                       <?php
                       foreach ($tableauElement as $element) {
                           $id = $element['idR'];
                           $nom = $element['Nom'];
                           echo "<option value='" . $id . "' " . $selected . ">" . htmlspecialchars($nom) . "</option>";
                       }
                       ?>
                    </select>
                </div>
                <input type="hidden" id="tableauElement" name="tableauElement" value="<?= htmlspecialchars($tableauElementJson)?>"/>
            </form>
        </div>
        <main>
            <div id='calendrier'></div>
            <form id="popupAdmin" method="post" action="#">
                <div class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title">Information Réservation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="text" disabled="true" id="idResa" name="idResa"/>
                                <p>Modal body text goes here.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="Valider" class="btn btn-primary">Valider la reservation</button>
                                <button type="submit" name="Annuler" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>


    <script>
        // Fermer le popup au chargement de la page
        let popup = document.getElementById('popupAdmin');
        window.onload = (event) => {
            popup.style.display = "none"; 
        };

        //Recupere l'id de la salle ou du materiel selectionné
        const selectElement = document.getElementById('element');
        const tabElement = JSON.parse(document.getElementById('tableauElement').value);
        let idR = selectElement.value;

        //Ajoute un ecouteur d'evenement sur le select pour changer le calendrier affiché
        selectElement.addEventListener('change', (event) => {
            idR = event.target.value;
            capaSalle = tabElement[idR];

            if (!<?= $isSalleMode ?>) {
                console.log("Materiel");
                recupMateriels("admin", idR, capaSalle);
            } else {
                console.log("Salle");
                recupSalle("admin", idR, capaSalle);
            }
        });


        //Charge le calendrier de la salle ou du materiel selectionné au chargement de la page
        let capaSalle = tabElement[idR];
        if (!<?= $isSalleMode ?>) {
            recupMateriels("admin", idR, capaSalle);
        } else {
            recupSalle("admin", idR, capaSalle);
        }
    </script>
<?php include_once './../commun/footer.php'; ?>
</body>