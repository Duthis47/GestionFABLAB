<?php
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

$redirectUrl = "Location: ./../admin/modif.php";

if (isset($_POST["btnSupprimer"]) && $_POST["btnSupprimer"] == "Supprimer"){
    
    if(isset($_POST['idR']) && !empty($_POST['idR'])) {
        $idASuppr = $_POST['idR'];
        header('Location: ./scriptSupprSalle.php?idR=' . $idASuppr);
        exit();
    }
}
else{
    if (isset($_POST['nomRes']) && isset($_POST['capaRes']) && isset($_POST['descRes'])){
        $lId = $_POST['idR'];
        $leNom = $_POST['nomRes'];
        $laCapa = $_POST['capaRes'];
        $laDesc = $_POST['descRes'];

        $res = SalleDAO::modifierSalle($lId, $leNom, $laDesc, "disponible", $laCapa);

        if ($res) {
            $_SESSION['flash_message'] = "<div>Salle modifiée avec succès !</div>";

            header("Location: " . $redirectUrl);
            exit();
        } else {
            $leMsg = "<div class='alert alert-warning mt-3'>Veuillez remplir tous les champs.</div>";
        }
    }

    else{
        try{
        $connexion = GestionConnexion::getConnexion();
        $connexion->beginTransaction();

        $lId = $_POST['idR'];
        $leNom = $_POST['nomMat'];
        $laDesc = $_POST['nomDesc'];
        $leTuto = $_POST['nomTuto'];
        $leNb = $_POST['nbMat'];
        $lesForm = $_POST['formMat'];
        $laSalle = $_POST['salleMat'];
        $laSecu = $_POST['nomSecu'];
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
                    $stmt4->bindValue(':idF', $laForm, PDO::PARAM_INT);
                    $stmt4->bindValue(':idR', $lId, PDO::PARAM_INT);
                    $stmt4->execute();
                }
            }

        $connexion->commit();
        echo "$idR";

        header($redirectUrl);
        exit();
       }
       catch (Exception $erreur) {
            if ($connexion->inTransaction()) {
                $connexion->rollBack();
            }
            return false;
        }
    }
}

?>