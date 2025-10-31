<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$mdp = $_GET["mdp"];

$hash = password_hash($mdp, PASSWORD_BCRYPT);

echo $hash;