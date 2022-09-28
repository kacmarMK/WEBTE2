<?php
include_once "../../config/Database.php";
include_once "../../models/PersonRepository.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

$conn = (new Database())->createConnection();

$personRep = new PersonRepository($conn);

if(isset($_POST['name'])
    && isset($_POST['day'])
        && isset($_POST['month'])) {
    $personRep->insertPerson($_POST['name'], $_POST['day'], $_POST['month']);
    http_response_code(201);
    echo json_encode(array("message" => "Meno bolo pridané do databázy."));
}
else {
    http_response_code(503);
    echo json_encode(array("message" => "Meno nebolo pridané do databázy."));
}

?>