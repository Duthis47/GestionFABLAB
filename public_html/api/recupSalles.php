<?php 

$id = $_GET['id'];
$type = $_GET['type'];
include_once __DIR__ . '/../classesDAO/ReservationDAO.php';

if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true){

$lesSalles = ReservationDAO::getReservationsBySalle($id, $type);

//Retour sous format JSON pour le JS
header("Content-Type: application/json");
echo json_encode($lesSalles);

}else {
    header("Location: ./../index.php");
}