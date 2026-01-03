<?php 

include_once './../classesDAO/ReservationDAO.php';

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

$append = "";
if ($type == "false"){
    $append = "?estMateriel=true";
}

if ($_POST["Action"] == "1"){
    $r = ReservationDAO::accepterReservation($type, $idU, $idR, $dateDebut);
    if ($r == 1){
        header("Location: ./../admin/afficherCalendrierAdmin.php".$append);
        exit;
    }else {
        echo "Erreur de resa";
        exit;
    }
}else if ($_POST["Action"] == "0"){
    echo "mode suppression";
    exit;
}else {
    header("Location: ./../admin/afficherCalendrierAdmin.php".$append);
    exit;
}