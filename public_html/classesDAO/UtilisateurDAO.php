<?php 


class UtilisateurDAO{
    public static function getUtilisateurByMail($mail): array|bool {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("SELECT * FROM Utilisateur WHERE mailU = :mail");
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function ajouterUtilisateur($nom, $prenom, $mail): bool|int {
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("INSERT INTO Utilisateur (nomU, prenomU, mailU) VALUES (:nom, :prenom, :mail)");
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        return $connexion->lastInsertId();
    }
}