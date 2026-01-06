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
$nomUtilisateur = $_POST["nom"];
$prenomUtilisateur = $_POST["prenom"];
$mailUtilisateur = $_POST["mail"];
$dateDebut = $_POST["dateDebut"];
$dateFin = $_POST["dateFin"];
$nbOccupants = $_POST["nbOccupants"];
$raison = $_POST["raison"];

//Prise en compte de la réservation
$success = ReservationDAO::ajouterReservationSalle($salleID, $dateDebut, $dateFin, false, $nomUtilisateur, $prenomUtilisateur, $mailUtilisateur, $nbOccupants);

if ($success) {
    $raisonMail = "Reserver";
    include_once './../scriptMail/envoiMail.php';
    if (isset($_SESSION["redirectedResa"])) {
        unset($_SESSION["redirectedResa"]);
        header("Location: ./reservationUser.php?reservation=success&estMateriel=true");
    }else {
        header("Location: ./reservationUser.php?reservation=success");
    }
} else {
    echo "Erreur lors de la réservation.";
}