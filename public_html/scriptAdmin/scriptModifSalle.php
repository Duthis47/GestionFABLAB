<?php

ini_set('session.cookie_httponly', 1);

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin'])) {
    header("Location: ./../index.php");
    exit();
}

require_once './../classesDAO/SalleDAO.php';
require_once './../classesDAO/MaterielsDAO.php';
require_once './../classes/GestionConnexion.php';

$urlRetourSalle = "./../admin/modif.php";
$urlRetourMateriel = "./../admin/modif.php?estMateriel=true";

if (isset($_POST["btnSupprimer"]) && $_POST["btnSupprimer"] == "Supprimer"){
    
    if(isset($_POST['idR']) && !empty($_POST['idR'])) {
        $idASuppr = $_POST['idR'];
        header('Location: ./scriptSupprSalle.php?idR=' . $idASuppr);
        exit();
    }
}
else{
    // --- CAS : MODIFICATION SALLE ---
    if (isset($_POST['nomRes'])){
        $lId = $_POST['idR'];
        $leNom = trim($_POST['nomRes']);
        $laCapa = $_POST['capaRes'];
        $laDesc = trim($_POST['descRes']);

        if (empty($leNom) || empty($laDesc) || !is_numeric($laCapa) || $laCapa < 1) {
            $_SESSION['flash_message'] = "<div class='alert alert-danger mt-3'>Erreur : Champs vides ou capacité invalide (min 1).</div>";
            header("Location: " . $urlRetourSalle);
            exit();
        }

        $res = SalleDAO::modifierSalle($lId, $leNom, $laDesc, "disponible", $laCapa);

        if ($res) {
            $_SESSION['flash_message'] = "<div class='alert alert-success mt-3'>Salle modifiée avec succès !</div>";
            header("Location: " . $urlRetourSalle);
            exit();
        } else {
            $_SESSION['flash_message'] = "<div class='alert alert-warning mt-3'>Erreur lors de la modification (BDD).</div>";
            header("Location: " . $urlRetourSalle);
            exit();
        }
    }

    else{
        try{
            $connexion = GestionConnexion::getConnexion();
            $connexion->beginTransaction();

            $lId = $_POST['idR'];
            $leNom = trim($_POST['nomMat']);
            $laDesc = trim($_POST['nomDesc']);
            $leTuto = trim($_POST['nomTuto']);
            $leNb = $_POST['nbMat'];
            $lesForm = isset($_POST['formMat']) ? $_POST['formMat'] : [];
            $laSalle = $_POST['salleMat'];
            $laSecu = trim($_POST['nomSecu']);

            if (empty($leNom) || empty($laDesc) || empty($leTuto) || empty($laSecu) || !is_numeric($leNb) || $leNb < 1) {
                $_SESSION['flash_message'] = "<div class='alert alert-danger mt-3'>Erreur : Tous les champs sont obligatoires et le nombre doit être positif.</div>";
                header("Location: " . $urlRetourMateriel);
                exit();
            }

            $res = MaterielsDAO::modifierMateriel($lId, $leNom, $laDesc, "disponible",$connexion);

            $stmt2 = $connexion->prepare("UPDATE Materiels SET Tuto=:Tuto, Regle_securite=:Regle_securite, Nombre=:Nombre, idS=:idS WHERE idR=:idR" );
            $stmt2->bindValue(':Tuto', $leTuto, PDO::PARAM_STR);
            $stmt2->bindValue(':Regle_securite', $laSecu, PDO::PARAM_STR);
            $stmt2->bindValue(':Nombre', $leNb, PDO::PARAM_INT);
            $stmt2->bindValue(':idS', $laSalle, PDO::PARAM_INT);
            $stmt2->bindValue(':idR', $lId, PDO::PARAM_INT);
            $stmt2->execute();

            $stmt3 = $connexion->prepare("DELETE FROM Necessiter WHERE idR_materiel=:idR_materiel");
            $stmt3->bindValue(':idR_materiel', $lId, PDO::PARAM_INT);
            $stmt3->execute();       

            if (!empty($lesForm)) {
                $stmt4 = $connexion->prepare("INSERT INTO Necessiter (idF, idR_materiel) VALUES (:idF, :idR)");
                foreach ($lesForm as $laForm) {
                    if ($laForm != 0) {
                        $stmt4->bindValue(':idF', $laForm, PDO::PARAM_INT);
                        $stmt4->bindValue(':idR', $lId, PDO::PARAM_INT);
                        $stmt4->execute();
                    }
                }
            }

            $connexion->commit();
            
            $_SESSION['flash_message'] = "<div class='alert alert-success mt-3'>Matériel modifié avec succès !</div>";
            header("Location: " . $urlRetourMateriel);
            exit();
       }
       catch (Exception $erreur) {
            if ($connexion->inTransaction()) {
                $connexion->rollBack();
            }
            $_SESSION['flash_message'] = "<div class='alert alert-danger mt-3'>Erreur SQL : " . $erreur->getMessage() . "</div>";
            header("Location: " . $urlRetourMateriel);
            exit();
        }
    }
}
?>