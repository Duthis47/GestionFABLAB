<?php 

include_once './../classes/GestionConnexion.php';
class MaterielsDAO {
    public static function getAllMateriels(): array {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("SELECT Materiels.idR, Nom, Description, Tuto, Regle_securite, Materiels.idS, CapaAccueil, Nombre FROM Materiels JOIN Reservables ON Materiels.idR = Reservables.idR JOIN Salles ON Materiels.idS = Salles.idR");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouterMateriel($nom, $description, $statut): bool|int {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("INSERT INTO Reservables (Nom, Description, statut) VALUES (:Nom, :Description, :statut)");
        $stmt->bindParam(':Nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':Description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
        $stmt->execute();
        return $connexion->lastInsertId();
    }

    public static function modifierMateriel($idR, $nom, $description, $statut, $laConnexion): bool|int {
        $stmt = $laConnexion->prepare("UPDATE Reservables SET Nom=:Nom, Description=:Description, statut=:statut WHERE idR=:idR" );
        $stmt->bindParam(':Nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':Description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
        $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
        $stmt->execute();
        return $idR;
    }

    public static function getFormationAssocie($idMat){
        $connexion = GestionConnexion::getConnexion();
        $ordreSQL = "SELECT * FROM Formation NATURAL JOIN Necessiter WHERE idR_materiel = :idR";
        $req = $connexion->prepare($ordreSQL);
        $req->bindParam(":idR", $idMat, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }
}