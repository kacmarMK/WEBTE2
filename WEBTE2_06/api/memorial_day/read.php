
<?php
include_once "../../config/Database.php";
include_once "../../models/MemorialDayRepository.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$conn = (new Database())->createConnection();

$memorial = new MemorialDayRepository($conn);

$memorialDays = $memorial->getAll();

echo json_encode($memorialDays);
?>