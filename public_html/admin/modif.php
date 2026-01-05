<?php if (!isset($_SESSION)) {
    session_start();
} 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Réservation - FABLAB</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />

    <link rel="stylesheet" href="./../CSS/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./../fullcalendar/packages/core/main.css">
    <link rel="stylesheet" href="./../fullcalendar/packages/daygrid/main.css">
    <script src="./../bootstrap/js/color-modes.js"></script>
    <meta name="theme-color" content="#712cf9" />
    
</head>
<body>

    <?php
    include_once './../commun/header.php';
    $isSalleMode = !isset($_GET["estMateriel"]);
    $capaSalle = 0;
    if ($isSalleMode){
        $titreR = "Réservation de Salle";
        $script = "./sReservationSalle.php";
    }else {
        $titreR = "Réservation de Matériel";
        $script = "./sReservationMateriel.php";
    }
    ?>
    <div class="container mb-5">
        <h1 class="text-wrapper-4">Modifier les réservables</h1>
        <br /><br />
        <div id="filtre">
            <form>
                <div class="mb-3">
                    <label class="form-label me-3">Choisir
                        <a href="modif.php" class="btn btn-sm <?= $isSalleMode ? 'btn-fablab-blue' : 'btn-outline-fablab-blue' ?>" >
                            Salle
                        </a>
                        <a href="modif.php?estMateriel=true" class="btn btn-sm <?= !$isSalleMode ? 'btn-fablab-blue' : 'btn-outline-fablab-blue' ?>" >
                            Matériel
                        </a>
                    </label>
                    <?php                         
                    $tableauElement = [];
                    if ($isSalleMode) { ?>
                        <select class="form-select" id="salle" name="salle">
                            <?php 
                                                    //Liste des salles
                                include_once './../classesDAO/SalleDAO.php';
                        
                                $listeSalle = SalleDAO::getAllSalles();
                                $i = 1;
                                foreach ($listeSalle as $salle) {
                                    $tableauElement[$salle["idR"]] = $salle['capaAccueil'];
                                    if($i==1){
                                       $capaSalle = $salle['capaAccueil'];
                                   }
                            ?>
                            <option value="<?php echo $salle['idR']; ?>" 
                            <?php if (isset($_GET["estSalle"]) && $_GET["estSalle"] == $salle['idR']) {
                                echo "selected";
                            } ?>>
                            Salle <?php echo $i . " - " . $salle['Nom'] . " (Capacité : " . $salle['capaAccueil'] . " personnes)"; ?></option>
                            <?php 
                            $i++;
                        }
                        } else { 
                        include_once './../classesDAO/MaterielsDAO.php';
                        $listeMateriel = MaterielsDAO::getAllMateriels();
                        ?>
                        <select class="form-select" id="materiel" name="materiel">
                                                    <?php 
                        
                        $i = 1;
                        foreach ($listeMateriel as $materiel) {
                            $tableauElement[$materiel['idR']] = $materiel['Nombre'];
                            if ($i==1){
                                $capaSalle = $materiel['Nombre'];
                            }
                            ?>
                            <option value="<?php echo $materiel['idR'];?>" data-salle="<?= $materiel["idS"]?>" data-maxPlaceSalle="<?= $materiel['CapaAccueil'] ?>"
                            <?php if (isset($_GET["estMateriel"]) && $_GET["estMateriel"] == $materiel['idR']) {
                                echo "selected";
                            } ?>>
                            Matériel <?php echo $i . " - " . $materiel['Nom']; ?></option>
                            <?php 
                            $i++;
                        }
                        }
                        $tableauElement = json_encode($tableauElement) ?>
                    </select>
                </div>
                <input type="hidden" name="tableauElement[]" id="tableauElement" value="<?= htmlspecialchars($tableauElement, ENT_QUOTES, 'UTF-8')?>"/>
            </form>
        </div>
    </div>

    <?php
    include_once './../commun/footer.php';
    ?>
</body>

</html>