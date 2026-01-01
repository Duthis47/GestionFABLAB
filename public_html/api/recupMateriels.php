<?php 

$id = (int)$_GET['id'];

include_once __DIR__ . '/../classesDAO/ReservationDAO.php';
$lesMateriels = ReservationDAO::getReservationsByMateriel($id);
header("Content-Type: application/json");
echo json_encode($lesMateriels);