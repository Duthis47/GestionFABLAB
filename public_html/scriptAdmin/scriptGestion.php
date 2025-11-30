<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
session_start();
if (isset($_SESSION["isAdmin"])){
    switch($_POST["btnReset"]){
        case "Deconnexion" :
            session_destroy();
            header("Location: /GestionFABLAB/public_html/index.php");
            break;
    }
}