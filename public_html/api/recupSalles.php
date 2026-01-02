<?php 

$id = $_GET['id'];
$type = $_GET['type'];
include_once __DIR__ . '/../classesDAO/ReservationDAO.php';
$lesSalles = ReservationDAO::getReservationsBySalle($id, $type);

//Retour sous format JSON pour le JS
header("Content-Type: application/json");
echo json_encode($lesSalles);