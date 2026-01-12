<?php 

ini_set('session.cookie_httponly', 1);

$id = (int)$_GET['id'];
$type = $_GET['type'];
include_once __DIR__ . '/../classesDAO/ReservationDAO.php';

if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true){
$lesMateriels = ReservationDAO::getReservationsByMateriel($id, $type);
header("Content-Type: application/json");
echo json_encode($lesMateriels);
}else {
    header("Location: ./../index.php");
}