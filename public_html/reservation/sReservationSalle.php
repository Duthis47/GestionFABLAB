<?php 

//Script de reservation de salles

include_once './../classesDAO/SalleDAO.php';
include_once './../classesDAO/ReservationDAO.php';
include_once './../classesDAO/UtilisateurDAO.php';

session_start();

if (isset($_SESSION["redirectedResa"])){
    $_POST = $_SESSION["redirectedResa"];
}

//Recupération des données du formulaire
$salleID = $_POST["numSalle"];
$nomU = $_POST["nom"];
$prenomU = $_POST["prenom"];
$mailU = $_POST["mail"];
$dateDebut = $_POST["dateDebut"];
$dateFin = $_POST["dateFin"];
$nbOccupants = $_POST["nbOccupants"];

//Prise en compte de la réservation
$success = ReservationDAO::ajouterReservationSalle($salleID, $dateDebut, $dateFin, false, $nomU, $prenomU, $mailU, $nbOccupants);

if ($success) {
    if (isset($_SESSION["redirectedResa"])) {
        unset($_SESSION["redirectedResa"]);
        header("Location: ./reservationUser.php?reservation=success&estMateriel=true");
    }else {
        header("Location: ./reservationUser.php?reservation=success");
    }
} else {
    echo "Erreur lors de la réservation.";
}