<?php 

class GestionConnexion {
    private static $instance = null;
    private $connexion;

    private function __construct() {
        $host = 'localhost';
        $db   = 'fablab_db';
        $user = 'fablab_user';
        $pass = 'fablab_password';
        self::$connexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    }

    public static function getConnexion(): PDO {
        if (self::$instance === null) {
            self::$instance = new GestionConnexion();
        }
        return self::$connexion;
    }
}