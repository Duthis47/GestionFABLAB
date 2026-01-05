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
        $stmt = $connexion->prepare("SELECT ReserverSalles.idU, idR_salle, DateTime_debut, DateTime_fin, Nb_occupant, AutorisationFinal, Blocage". $ajoutAttribut ." FROM ReserverSalles" . $ajoutJoin." WHERE idR_salle = :salleId");
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

    public static function getBlocagesFuturs($isSalle) {
        $connexion = GestionConnexion::getConnexion();
        $mailAdmin = "admin@etud.univ-pau.fr"; 

        if ($isSalle) {
            $sql = "SELECT r.idR_salle as idR, r.DateTime_debut as dateDebut, r.DateTime_fin as dateFin, s.nomSalles as nomElement
                    FROM ReserverSalles r
                    JOIN Salles s ON r.idR_salle = s.idR
                    JOIN Utilisateur u ON r.idU = u.idU
                    WHERE u.mailU = :mail 
                    AND r.DateTime_fin > NOW()
                    ORDER BY r.DateTime_debut ASC";
        } else {
            $sql = "SELECT rm.idR_materiel as idR, rm.DateTime_debut as dateDebut, rm.DateTime_fin as dateFin, r.Nom as nomElement
                    FROM ReserverMateriels rm
                    JOIN Materiels m ON rm.idR_materiel = m.idR
                    JOIN Utilisateur u ON rm.idU = u.idU
                    JOIN Reservables r ON r.idR = rm.idR_materiel
                    WHERE u.mailU = :mail 
                    AND rm.DateTime_fin > NOW()
                    ORDER BY rm.DateTime_debut ASC";
        }

        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':mail', $mailAdmin);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouterReservationSalle($salleId, $dateDebut, $dateFin, $blocage=false, $nomU="admin", $prenomU="admin", $mailUtilisateur="admin@etud.univ-pau.fr", $nbOccupants=0) {
        $connexion = GestionConnexion::getConnexion();
        $user = UtilisateurDAO::getUtilisateurByMail($mailUtilisateur);
        if ($user){
            $utilisateurId = $user['idU'];
        }else {
            $utilisateurId = UtilisateurDAO::ajouterUtilisateur($nomU, $prenomU, $mailUtilisateur);
        }
        $ordreSQL = "INSERT INTO ReserverSalles (idU, idR_salle, DateTime_debut, DateTime_fin, Nb_occupant, AutorisationFinal) VALUES (:utilisateurId, :salleId, :dateDebut, :dateFin, :nbOccupants, 0)";
        if ($blocage){
            $ordreSQL = "INSERT INTO ReserverSalles (idU, idR_salle, DateTime_debut, DateTime_fin, Nb_occupant, AutorisationFinal, Blocage) VALUES (:utilisateurId, :salleId, :dateDebut, :dateFin, :nbOccupants, 0, 1)";
        }
        $stmt = $connexion->prepare($ordreSQL);
        $stmt->bindParam(':utilisateurId', $utilisateurId, PDO::PARAM_INT);
        $stmt->bindParam(':salleId', $salleId, PDO::PARAM_INT);
        $stmt->bindParam(':dateDebut', $dateDebut);
        $stmt->bindParam(':dateFin', $dateFin);
        $stmt->bindParam(':nbOccupants', $nbOccupants, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function ajouterReservationMateriel($materielId, $dateDebut, $dateFin, $blocage=false, $nomU="admin", $prenomU="admin", $mailUtilisateur="admin@etud.univ-pau.fr") {
        $connexion = GestionConnexion::getConnexion();
        $user = UtilisateurDAO::getUtilisateurByMail($mailUtilisateur);
        if ($user){
            $utilisateurId = $user['idU'];
        }else {
            $utilisateurId = UtilisateurDAO::ajouterUtilisateur($nomU, $prenomU, $mailUtilisateur);
        }

        $ordreSQL = "INSERT INTO ReserverMateriels (idU, idR_materiel, DateTime_debut, DateTime_fin) VALUES (:utilisateurId, :materielId, :dateDebut, :dateFin)";
        if ($blocage){
            $ordreSQL = "INSERT INTO ReserverMateriels (idU, idR_materiel, DateTime_debut, DateTime_fin, Blocage) VALUES (:utilisateurId, :materielId, :dateDebut, :dateFin, 1)";
        }
        $stmt = $connexion->prepare($ordreSQL);
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