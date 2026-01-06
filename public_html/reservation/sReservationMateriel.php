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
    $raison = $_POST["raison"];
    $isSalle = $_POST["chkSalle"];

    $success = ReservationDAO::ajouterReservationMateriel($idMateriel, $dateDebut, $dateFin, false, $nomUtilisateur, $prenomUtilisateur, $mailUtilisateur);
    if ($success) {
        if($isSalle == "true"){
            ajouterResaSalle();
        }else {
            $raisonMail = "Reserver";
            include_once './../scriptMail/envoiMail.php';
            header("Location: ./../reservation/reservationUser.php");
        }
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