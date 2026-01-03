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

    if (!isset($_GET["estMateriel"])) {
        $isSalleMode = true;
    }else {
        $isSalleMode = false;
    }
    $isSalleModeJson = json_encode($isSalleMode);
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
    <title>Page de Réservation - FABLAB <?= $isSalleMode ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../CSS/style.css" />
    <link rel="stylesheet" href="./../fullcalendar/packages/core/main.css">
    <link rel="stylesheet" href="./../fullcalendar/packages/daygrid/main.css">
    <script src="./../bootstrap/js/color-modes.js"></script>
    <meta name="theme-color" content="#712cf9" />

</head>

    <script src="./../fullcalendar/dist/index.global.min.js"></script>
    <script src="./../JS/calendrier.js"></script>
    <script src="./../JS/recupElement.js"></script>

<body>
    <div class="container">
        <div id="filtre">
            <!-- filtre de salle ou de matériel -->
            <form>
                <div class="mb-3">
                    <label for="element" class="form-label"><?= $titreF ?></label>
                    <?php                         
                    ?>
                    <select class="form-select" id="element" name="element">
                       <?php
                       $defaultId = 0;
                       $i = 1;
                       foreach ($tableauElement as $element) {
                            if ($i == 1){
                                $defaultId = $element['idR'];
                            }
                            $i++;
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
            <!-- Preparation du popup de validation admin -->
            <form method="post" action="./../scriptAdmin/scriptBtnAcceptRefus.php">
                <div id="popupAdmin" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="title">Information Réservation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    <strong>Début :</strong> <span id="start"></span><br>
                                    <strong>Fin :</strong> <span id="end"></span><br>
                                    <strong>Nombre d'occupants :</strong> <span id="nbOccupant"></span><br>
                                    <strong>Réservé par :</strong> <span id="reserverPar"></span><br>
                                    <strong>Raison :</strong> <span id="raison"></span><br>
                                </p>
                            </div>
                            <input type="hidden" id="idU" name="idU" value=""/>
                            <input type="hidden" id="idR" name="idR" value=""/>
                            <input type="hidden" id="dateDebut" name="dateDebut" value=""/>
                            <input type="hidden" name="type" value=<?= $isSalleModeJson ?> />
                            <div class="modal-footer">
                                <button type="submit" id="Valider" name="Action" value="1" class="btn btn-primary">Valider la reservation</button>
                                <button type="submit" id="Refuser" name="Action" value="0" class="btn btn-secondary" data-dismiss="modal">Refuser la reservation</button>
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

            if (!<?= $isSalleModeJson ?>) {
                recupMateriels("admin", idR, capaSalle);
            } else {
                recupSalle("admin", idR, capaSalle);
            }
        });

        const supprimerElement = document.getElementById("Refuser");
        var confirme = false;

        supprimerElement.addEventListener('click', function(event) {
            //Permet de securiser le clic sur le bouton (supprime que en cas de validation double)
            if (!confirme){
                event.preventDefault();
                this.textContent = "Êtes-vous sûr ?";
                this.classList.add('btn-danger'); 
                confirme = true;

                // On réinitialise si l'utilisateur n'a pas confirmé après 4s
                setTimeout(() => {
                    estPret = false;
                    this.textContent = "Valider la réservation";
                    this.classList.remove('btn-danger');
                }, 4000);
            }
        })

        //Charge le calendrier de la salle ou du materiel selectionné au chargement de la page
        let capaSalle = tabElement[idR];
        if (!<?= $isSalleModeJson ?>) {
            recupMateriels("admin", idR, capaSalle);
        } else {
            recupSalle("admin", idR, capaSalle);
        }
    </script>
<?php include_once './../commun/footer.php'; ?>
</body>