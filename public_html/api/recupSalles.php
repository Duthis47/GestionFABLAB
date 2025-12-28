<?php 

$id = $_GET['id'];
include_once __DIR__ . '/../classesDAO/ReservationDAO.php';
$lesSalles = ReservationDAO::getReservationsBySalle($id);
header("Content-Type: application/json");
echo json_encode($lesSalles);