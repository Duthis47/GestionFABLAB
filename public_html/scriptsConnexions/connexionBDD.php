<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
$config = require __DIR__ . './../../config.bdd.php';

$dsn = $config["dsn"];
$username= $config["username"];
$passwd = $config["passwd"];
ini_set('session.cookie_httponly', 1);

try {
    $laConnexion = new PDO($dsn, $username, $passwd);
    echo "Connexion BDD réussie";
}catch(Exception $e){
    echo "Erreur de chargement de la connexion BDD : ".$e->getMessage();
}