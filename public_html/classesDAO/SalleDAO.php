<?php 

include_once './../classes/GestionConnexion.php';
include_once './MaterielsDAO.php';

class SalleDAO {
    public static function getAllSalles(): array {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("SELECT idR, Nom, capaAccueil, Description FROM Salles NATURAL JOIN Reservables");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouterSalle($nom, $description, $statut, $capaAccueil): bool|int {

       $connexion = GestionConnexion::getConnexion();

       try{
        $connexion->beginTransaction();

        $stmt = $connexion->prepare("INSERT INTO Reservables (Nom, Description, statut) VALUES (:nom, :description, :statut)");
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':Description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
        $stmt->execute();
       
        $idR =  $connexion->lastInsertId();

        $stmt2 = $connexion->prepare("INSERT INTO Salles (idR, nomSalles, CapaAccueil) VALUES (:idR, :nomSalles, :CapaAccueil)");
        $stmt2->bindParam(':idR', $idR, PDO::PARAM_INT);
        $stmt2->bindParam(':nomSalles', $nom, PDO::PARAM_STR);
        $stmt2->bindParam(':CapaAccueil', $capaAccueil, PDO::PARAM_INT);
        $stmt2->execute();

        $connexion->commit();
        return $connexion->lastInsertId();
       }
       catch (Exception $erreur) {
            if ($connexion->inTransaction()) {
                $connexion->rollBack();
            }
            return false;
        }
    }
}