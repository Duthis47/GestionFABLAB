<?php 

include_once './../classes/GestionConnexion.php';
class MaterielsDAO {
    public static function getAllMateriels(): array {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("SELECT Materiels.idR, Nom, Description, Tuto, Regle_securite, Materiels.idS, CapaAccueil, Nombre FROM Materiels JOIN Reservables ON Materiels.idR = Reservables.idR JOIN Salles ON Materiels.idS = Salles.idR");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}