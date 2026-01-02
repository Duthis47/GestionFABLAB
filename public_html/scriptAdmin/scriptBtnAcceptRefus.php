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
$dateDebut = $_POST["DateTime_debut"];
$type = $_POST["type"];

if ($_POST["Action"] == "1"){
    $r = accepterReservation($type, $idU, $dateDebut);
    if ($r == 1){
        //reussite
        exit;
    }else {
        //echec
        exit;
    }
}else if ($_POST["Action"] == "0"){
    exit;
}else {
    header("Location: ./../admin/afficherCalendrierAdmin.php");
    exit;
}