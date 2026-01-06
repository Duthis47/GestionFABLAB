<?php 

include_once './../classesDAO/ReservationDAO.php';
include_once './../classesDAO/UtilisateurDAO.php';

if (!isset($_SESSION)) {
    session_start();
}

//On verifie que l'utilisateur est un administrateur
if(!isset($_SESSION['isAdmin'])){
    header("Location: ./../index.php");
    exit();
}

$idU = $_POST["idU"];
$idR = $_POST["idR"];
$dateDebut = $_POST["dateDebut"];
$type = $_POST["type"];
$utilisateur = UtilisateurDAO::getUtilisateurById($idU);
$mailUtilisateur = $utilisateur["mailU"];
$prenomUtilisateur = $utilisateur["prenomU"];
$nomUtilisateur = $utilisateur["nomU"];

$append = "";
if ($type == "false"){
    $append = "?estMateriel=true";
}

if ($_POST["Action"] == "1"){
    $r = ReservationDAO::accepterReservation($type, $idU, $idR, $dateDebut);
    if ($r == 1){
        $raisonMail = "Accepter";
        include_once './../scriptMail/envoiMail.php';
        header("Location: ./../admin/afficherCalendrierAdmin.php".$append);
        exit;
    }else {
        echo "Erreur de validation, veuillez retourner en arrière";
        exit;
    }
}else if ($_POST["Action"] == "0"){
    $r = ReservationDAO::refuserReservation($type, $idU, $idR, $dateDebut);
    if ($r == 1){
        $raisonMail = "Refuser";
        include_once './../scriptMail/envoiMail.php';
        header("Location: ./../admin/afficherCalendrierAdmin.php".$append);
        exit;
    }else {
        echo "Erreur de suppression, veuillez retourner en arrière";
        exit;
    }
    exit;
}else {
    header("Location: ./../admin/afficherCalendrierAdmin.php".$append);
    exit;
}