<?php 

$id = $_GET['id'];
include_once __DIR__ . '/../classesDAO/ReservationDAO.php';
$lesSalles = ReservationDAO::getReservationsBySalle($id);

//Retour sous format JSON pour le JS
header("Content-Type: application/json");
echo json_encode($lesSalles);