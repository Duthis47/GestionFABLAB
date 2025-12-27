<?php 

class GestionConnexion {
    private static $instance = null;
    private static $connexion;

    private function __construct() {
        $host = 'localhost';
        $db   = 'sae3';
        $user = 'adminer';
        $pass = 'Isanum64!';
        self::$connexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    }

    public static function getConnexion(): PDO {
        if (self::$instance === null) {
            self::$instance = new GestionConnexion();
        }
        return self::$connexion;
    }
}