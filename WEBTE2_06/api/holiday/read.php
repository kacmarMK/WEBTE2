
<?php
include_once "../../config/Database.php";
include_once "../../models/HolidayRepository.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$conn = (new Database())->createConnection();

$holidayRep = new HolidayRepository($conn);

if (isset($_GET['code'])) {
    $holidays = $holidayRep->getAll($_GET['code']);

    echo json_encode($holidays);
} else {
    http_response_code(404);
}

?>