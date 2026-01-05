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

include_once './../classesDAO/ReservationDAO.php';
include_once './../classesDAO/UtilisateurDAO.php';

// Récupération des données
$action = $_POST['action']; // 'bloquer' ou 'debloquer'
$isSalle = $_POST["isSalle"];

$successCount = 0;
$failCount = 0;

$isSalleBool = ($isSalle === "true" || $isSalle === true);

// --Ajout Blocages--
if ($action == 'bloquer') {
    $dateDebut = $_POST["dateDebut"];
    $dateFin = $_POST["dateFin"];
    $ids = isset($_POST["ids"]) ? $_POST["ids"] : [];

    if (empty($ids) || empty($dateDebut) || empty($dateFin)) {
        header("Location: ./../admin/adminGestionDispo.php?error=missing_data"); exit();
    }

    // Conversion de la date de début en timestamp (pour le décalage)
    $timestampDebut = strtotime($dateDebut);

    foreach ($ids as $index => $idR) {
        $dateDebutDecalee = date('Y-m-d H:i:s', $timestampDebut + $index); // +0s, +1s, +2s...

        if ($isSalleBool) {
            $res = ReservationDAO::ajouterReservationSalle($idR, $dateDebutDecalee, $dateFin, true);
        } else {
            $res = ReservationDAO::ajouterReservationMateriel($idR, $dateDebutDecalee, $dateFin, true);
        }
        ($res == 1) ? $successCount++ : $failCount++;
    }

// --Suppression Blocages--
} elseif ($action == 'debloquer') {
    $toDelete = isset($_POST["toDelete"]) ? $_POST["toDelete"] : [];
    
    // On récupère l'ID admin
    $admin = UtilisateurDAO::getUtilisateurByMail("admin@etud.univ-pau.fr");
    $idAdmin = $admin ? $admin["idU"] : null;

    if ($idAdmin && !empty($toDelete)) {
        foreach ($toDelete as $value) {
            // La value contient "ID_RESSOURCE|DATE_EXACTE" (ex: "4|2026-01-09 10:00:01")
            $parts = explode('|', $value);
            if (count($parts) == 2) {
                $idR = $parts[0];
                $dateExacte = $parts[1];
                
                $res = ReservationDAO::refuserReservation($isSalle, $idAdmin, $idR, $dateExacte);
                ($res == 1) ? $successCount++ : $failCount++;
            }
        }
    }
}


$redirectUrl = "./../admin/adminGestionDispo.php";

if ($isSalleBool) {
    // true
    $redirectUrl .= "?success=" . $successCount . "&fail=" . $failCount;
} else {
    // false
    $redirectUrl .= "?estMateriel=true&success=" . $successCount . "&fail=" . $failCount;
}

header("Location: " . $redirectUrl);
exit();
?>