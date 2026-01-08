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

//on recupere le formulaire
$isSalle = $_POST["isSalle"];
$typeModif = $_POST["typeM"];
$dateDebut = $_POST["dateDebut"];
if ($typeModif == "Bloquer"){
    $dateFin = $_POST["dateFin"];
}else {
    $dateFin = "";
}

$idR = $_POST["idR"];

//on distingue les cas
$admin = UtilisateurDAO::getUtilisateurByMail("admin@etud.univ-pau.fr");
$idAdmin = $admin["idU"];

if ($typeModif == "Bloquer"){
    if($isSalle == "true"){
        $x = ReservationDAO::chevauchementResa("true", $idR, $dateDebut, $dateFin);
        if (!$x){
            $r = ReservationDAO::ajouterReservationSalle($idR, $dateDebut, $dateFin, true) ;
            if ($r== 1){
                //reussite
                header("Location: ./../admin/afficherCalendrierAdmin.php");
            }else {
                //echec
                header("Location: ./../admin/afficherCalendrierAdmin.php?echec=true");
            }
        }else {
            header("Location: ./../admin/afficherCalendrierAdmin.php?chevauchement=true");
        }
    }else {
        $x = ReservationDAO::chevauchementResa("true", $idR, $dateDebut, $dateFin);
        if (!$x){
            $r = ReservationDAO::ajouterReservationMateriel($idR, $dateDebut, $dateFin, true);
            if ($r== 1){
                //reussite
                header("Location: ./../admin/afficherCalendrierAdmin.php?estMateriel=true");
            }else {
                //echec
                header("Location: ./../admin/afficherCalendrierAdmin.php?estMateriel=true&echec=true");
            }
        }else {
            header("Location: ./../admin/afficherCalendrierAdmin.php?estMateriel=true&chevauchement=true");
        }
    }
}else if ($typeModif == "Debloquer"){
    if ($isSalle == "true"){
        $append = "";
    }else {
        $append = "?estMateriel=true&";
    }
    $r = ReservationDAO::refuserReservation($isSalle, $idAdmin, $idR, $dateDebut);
    if ($r== 1){
            //reussite
            header("Location: ./../admin/afficherCalendrierAdmin.php".$append);
        }else {
            //echec
            header("Location: ./../admin/afficherCalendrierAdmin.php".$append."echec=true");
        }
}else {

}