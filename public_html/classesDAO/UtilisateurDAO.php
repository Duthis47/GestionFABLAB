<?php 


class UtilisateurDAO{
    public static function getUtilisateurByMail($mail): array {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("SELECT * FROM Utilisateurs WHERE mailU = :mail");
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function ajouterUtilisateur($nom, $prenom, $mail): bool|int {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("INSERT INTO Utilisateurs (nomU, prenomU, mailU) VALUES (:nom, :prenom, :mail)");
        $stmt->bindParam(':nomU', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenomU', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':mailU', $mail, PDO::PARAM_STR);
        $stmt->execute();
        return $connexion->lastInsertId();
    }
}