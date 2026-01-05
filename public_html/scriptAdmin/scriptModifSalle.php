<?php

if (isset($_POST["btnSupprimer"]) && $_POST["btnSupprimer"] == "Supprimer"){
    
    if(isset($_POST['idR']) && !empty($_POST['idR'])) {
        $idASuppr = $_POST['idR'];
        header('Location: ./scriptSupprSalle.php?idR=' . $idASuppr);
        exit();
}
?>