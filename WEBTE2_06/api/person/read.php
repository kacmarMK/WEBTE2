<?php
include_once "../../config/Database.php";
include_once "../../models/PersonRepository.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$conn = (new Database())->createConnection();

$personRep = new PersonRepository($conn);

if(isset($_GET['id'])) {
    $person = $personRep->getById($_GET['id']);
    
    echo json_encode($person);
}
else if(isset($_GET['day']) && isset($_GET['month']) && isset($_GET['country'])) {
    $persons = $personRep->getPersonsByDate($_GET['day'], $_GET['month'], $_GET['country']);
    
    echo json_encode($persons);
} 
else if(isset($_GET['name']) && isset($_GET['country'])) {
    $persons = $personRep->getDateByNameCountry($_GET['name'], $_GET['country']);

    echo json_encode($persons);
}    
else {
    $persons = $personRep->getAll();

    http_response_code(404);
    echo json_encode(array("message" => "Nenájdené."));
}

?>