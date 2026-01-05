<?php

include_once './../classes/GestionConnexion.php';

class FormationDAO{
    public static function recupTout(){
        $rsql = "SELECT * FROM Formation;";
        $connexion = GestionConnexion::getConnexion();
        $resReq = $connexion->query($rsql);
        return $resReq->fetchAll(PDO::FETCH_ASSOC);    
    }
}