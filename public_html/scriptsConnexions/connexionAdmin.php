<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$config = require "./../../config.admin.php";
$username = $_POST["username"];
$passwd = $_POST["password"];

if ($username === $config['username'] && password_verify($passwd, $config['passwd'])){
    session_start();
    $_SESSION["isAdmin"] = true;
    header("Location: ./../admin/adminInfos.php");
}
else {
    header("Location: ./../Connexion/formConnexAdmin.php?connex=echec");
}