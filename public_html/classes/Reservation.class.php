<?php 

class Reservation {
    private $idReservation;
    private $DateTime_debut;
    private $DateTime_fin;
    private $Nb_occupant;
    private $idSalle;
    private $idMateriel;
    private $idUtilisateur;

    public function __construct($idReservation, $DateTime_debut, $DateTime_fin, $Nb_occupant, $idSalle, $idMateriel, $idUtilisateur) {
        $this->idReservation = $idReservation;
        $this->DateTime_debut = $DateTime_debut;
        $this->DateTime_fin = $DateTime_fin;
        $this->Nb_occupant = $Nb_occupant;
        $this->idSalle = $idSalle;
        $this->idMateriel = $idMateriel;
        $this->idUtilisateur = $idUtilisateur;
    }

    public function getIdReservation() {
        return $this->idReservation;
    }

    public function getDateTimeDebut() {
        return $this->DateTime_debut;
    }

    public function getDateTimeFin() {
        return $this->DateTime_fin;
    }

    public function getNbOccupant() {
        return $this->Nb_occupant;
    }

    public function getIdSalle() {
        return $this->idSalle;
    }

    public function getIdMateriel() {
        return $this->idMateriel;
    }

    public function getIdUtilisateur() {
        return $this->idUtilisateur;
    }
}