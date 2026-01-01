<?php 

//Script de reseravation de materiels

include_once './../classesDAO/ReservationDAO.php';

function ajouterResaMatos(){
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $idMateriel = $_POST['numMateriel'];
    $mailUtilisateur = $_POST['mail'];
    $nomUtilisateur = $_POST['nom'];
    $prenomUtilisateur = $_POST['prenom'];
    $success = ReservationDAO::ajouterReservationMateriel($nomUtilisateur, $prenomUtilisateur, $mailUtilisateur, $idMateriel, $dateDebut, $dateFin);
    if ($success) {
        ajouterResaSalle();
    } else {
        echo "Erreur lors de la réservation.";
    }
}


function ajouterResaSalle(){
    session_start();
    $_SESSION["redirectedResa"] = $_POST;
    header("Location: ./sReservationSalle.php");
}


ajouterResaMatos();