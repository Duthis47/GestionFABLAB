<?php 


class GestionConnexion {
    private static $instance = null;
    private static $connexion;

    private function __construct() {
        $config = require './../../config.bdd.php';
        $host = 'db';
        $db   = $config["dsn"];
        $user = $config["username"];
        $pass = $config["passwd"];
        self::$connexion = new PDO("$db;charset=utf8", $user, $pass);
    }

    public static function getConnexion(): PDO {
        if (self::$instance === null) {
            self::$instance = new GestionConnexion();
        }
        return self::$connexion;
    }
}