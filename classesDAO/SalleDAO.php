<?php 

include_once './../classes/GestionConnexion.php';

class SalleDAO {
    public static function getAllSalles(PDO $connexion): array {
        $connexion = 
        $stmt = $connexion->prepare("SELECT id, nom, description FROM salles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}