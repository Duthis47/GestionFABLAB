<?php 

ini_set('session.cookie_httponly', 1);

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin'])) {
    header("Location: ./../index.php");
    exit();
}
include_once './../classes/GestionConnexion.php';

$lId = $_GET['idR'];

try {
    $connexion = GestionConnexion::getConnexion();
    
    $sql = "DELETE FROM Reservables WHERE idR = :idR";
    $req = $connexion->prepare($sql);
    $req->bindValue(":idR",$lId, PDO::PARAM_INT);
    $req->execute();

    if ($req->rowCount() > 0) {
        header("Location: ./../admin/modif.php"); 
        exit();
    } else {
        echo "<div class='alert alert-warning mt-3'>Aucun élément supprimé (ID introuvable ou erreur).</div>";
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger mt-3'>Erreur SQL : " . $e->getMessage() . "</div>";
}
?>