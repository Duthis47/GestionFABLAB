<?php 

include_once './../classes/GestionConnexion.php';

class SalleDAO {
    public static function getAllSalles(): array {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("SELECT idR, Nom, capaAccueil, Description FROM Salles NATURAL JOIN Reservables");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}