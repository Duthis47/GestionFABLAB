<?php 
/*<input type="submit" name="btnSupprimer" value="Supprimer" class="btn btn-fablab-red"/>*/

if (isset($_POST['btnSupprimer']){
    $lId = ['idR']
    $rsql = "DELETE FROM Reservables WHERE idR == $lId ";
    
    $connexion = GestionConnexionPDO::getConnexion();
    $resReq = $connexion->query($rsql);
    $leRes = $resReq->fetch();
    if ($leRes==1){
        echo "<div class='alert alert-danger mt-3'>Salle ajoutée avec succès !</div>":
    }else{
        echo "<div class='alert alert-danger mt-3'>Erreur lors de la suppression</div>";
    }
}
?>