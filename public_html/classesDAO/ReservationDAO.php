<?php 
include_once './../classesDAO/UtilisateurDAO.php';
include_once './../classes/GestionConnexion.php';

class ReservationDAO {
    public static function getReservationsBySalle(int $salleId, string $type): array {
        $ajoutAttribut = "";
        $ajoutJoin ="";
        if($type === 'admin'){
            //SI ADMIN, ON RECUPERE AUSSI LES INFOS UTILISATEUR
            $ajoutAttribut = ", mailU, nomU, prenomU ";
            $ajoutJoin = " JOIN Utilisateur ON Utilisateur.idU = ReserverSalles.idU ";
        }
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("SELECT ReserverSalles.idU, idR_salle, DateTime_debut, DateTime_fin, Nb_occupant, AutorisationFinal". $ajoutAttribut ." FROM ReserverSalles" . $ajoutJoin." WHERE idR_salle = :salleId");
        $stmt->bindParam(':salleId', $salleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getReservationsByMateriel(int $materielId, string $type): array {
        $ajoutJoin ="";
        if($type === 'admin'){
            //SI ADMIN, ON RECUPERE AUSSI LES INFOS UTILISATEUR
            $ajoutJoin = " JOIN Utilisateur ON Utilisateur.idU = ReserverMateriels.idU ";
        }
        $connexion = GestionConnexion::getConnexion();
        $stmt = $connexion->prepare("SELECT * FROM ReserverMateriels JOIN Materiels ON Materiels.idR = idR_materiel JOIN Salles ON Materiels.idS = Salles.idR ".$ajoutJoin."WHERE idR_materiel = :materielId");
        $stmt->bindParam(':materielId', $materielId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouterReservationSalle($nomU, $prenomU, $mailUtilisateur, $salleId, $dateDebut, $dateFin, $nbOccupants) {
        $connexion = GestionConnexion::getConnexion();
        $user = UtilisateurDAO::getUtilisateurByMail($mailUtilisateur);
        if ($user){
            $utilisateurId = $user['idU'];
        }else {
            $utilisateurId = UtilisateurDAO::ajouterUtilisateur($nomU, $prenomU, $mailUtilisateur);
        }
        $stmt = $connexion->prepare("INSERT INTO ReserverSalles (idU, idR_salle, DateTime_debut, DateTime_fin, Nb_occupant, AutorisationFinal) VALUES (:utilisateurId, :salleId, :dateDebut, :dateFin, :nbOccupants, 0)");
        $stmt->bindParam(':utilisateurId', $utilisateurId, PDO::PARAM_INT);
        $stmt->bindParam(':salleId', $salleId, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $dateDebut);
        $stmt->bindParam(':dateFin', $dateFin);
        $stmt->bindParam(':nbOccupants', $nbOccupants, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function ajouterReservationMateriel($nomU, $prenomU, $mailUtilisateur, $materielId, $dateDebut, $dateFin) {
        $connexion = GestionConnexion::getConnexion();
        $user = UtilisateurDAO::getUtilisateurByMail($mailUtilisateur);
        if ($user){
            $utilisateurId = $user['idU'];
        }else {
            $utilisateurId = UtilisateurDAO::ajouterUtilisateur($nomU, $prenomU, $mailUtilisateur);
        }
        $stmt = $connexion->prepare("INSERT INTO ReserverMateriels (idU, idR_materiel, DateTime_debut, DateTime_fin) VALUES (:utilisateurId, :materielId, :dateDebut, :dateFin)");
        $stmt->bindParam(':utilisateurId', $utilisateurId, PDO::PARAM_INT);
        $stmt->bindParam(':materielId', $materielId, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $dateDebut);
        $stmt->bindParam(':dateFin', $dateFin);
        return $stmt->execute();
    }


    public static function accepterReservation($type, $idU, $idR, $dateDebut){
        try {
            $connexion = GestionConnexion::getConnexion();
            $table = "ReserverMateriels";
            $clause = "idR_materiel = :envoi ";
            $envoi = $idR;
            if ($type == "true"){
                $table="ReserverSalles";
                $clause = "idU = :envoi ";
                $envoi = $idU;
            }
            $ordreSQL = "UPDATE ".$table." SET AutorisationFinal = 1 WHERE ".$clause."AND DateTime_debut = :idD";
            $req = $connexion->prepare($ordreSQL);
            $req->bindValue("envoi", $envoi, PDO::PARAM_INT);
            $req->bindValue("idD", $dateDebut);
            return $req->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function refuserReservation($type, $idU, $idR, $dateDebut){
        $connexion = GestionConnexion::getConnexion();
        $table = "ReserverMateriels";
        $clause = "idR_materiel = :envoi ";
        $envoi = $idR;
        if ($type == "true"){
            $table="ReserverSalles";
            $clause = "idU = :envoi ";
            $envoi = $idU;
        }
        $ordreSQL = "DELETE FROM ".$table." WHERE ".$clause." AND DateTime_debut = :idD";
        $req = $connexion->prepare($ordreSQL);
        $req->bindValue("envoi", $envoi, PDO::PARAM_INT);
        $req->bindValue("idD", $dateDebut);
        return $req->execute();
    }
}