<?php 

class Salle {
    private $idR;
    private $Nom;
    private $capaAccueil;
    private $reservations; // Tableau des réservations associées à la salle

    public function __construct($idR, $Nom, $capaAccueil, $Lesreservations = []) {
        $this->idR = $idR;
        $this->Nom = $Nom;
        $this->capaAccueil = $capaAccueil;
        $this->reservations = $Lesreservations;
    }

    public function getIdR() {
        return $this->idR;
    }

    public function getNom() {
        return $this->Nom;
    }

    public function getCapaAccueil() {
        return $this->capaAccueil;
    }

    public function getPlaceRestante()   {
        $a = 0;
        foreach ($this->reservations as $reservation) {
            $a += $reservation->getNbOccupant();
        }
        return $this->capaAccueil - $a;
    }
}