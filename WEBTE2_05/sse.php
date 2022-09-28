<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');



require_once("Database.php");
$con = (new Database())->createConnection();
$s = "SELECT * FROM logs WHERE logs.u_id = (SELECT MAX(logs.u_id) FROM logs)";
$result = $con->query($s);
$row = $result->fetch(PDO::FETCH_ASSOC);

if (empty($row)) {
    $index = 0;
    $f1 = 1;
    $f2 = 1;
    $f3 = 1;
    $parameter = 1;
} else {
    $index = $row['x'];
    $f1 = $row['f1'];
    $f2 = $row['f2'];
    $f3 = $row['f3'];
    $parameter = $row['parameter'];
}


while (true) {
    if ($f1 && $f2 && $f3) {
        $msg = json_encode([
            "sin" => sin($index * $parameter) * sin($index * $parameter),
            "cos" => cos($index * $parameter) * cos($index * $row['parameter']),
            "sincos" => sin($index * $parameter) * cos($index * $parameter)
        ]);
    } else if ($f1 && $f2) {
        $msg = json_encode([
            "sin" => sin($index * $parameter) * sin($index * $parameter),
            "cos" => cos($index * $parameter) * cos($index * $parameter)
        ]);
    } else if ($f1 && $f3) {
        $msg = json_encode([
            "sin" => sin($index * $parameter) * sin($index * $parameter),
            "sincos" => sin($index * $parameter) * cos($index * $parameter)
        ]);
    } else if ($f2 && $f3) {
        $msg = json_encode([
            "cos" => cos($index * $parameter) * cos($index * $parameter),
            "sincos" => sin($index * $parameter) * cos($index * $parameter)
        ]);
    } else if ($f1) {
        $msg = json_encode([
            "sin" => sin($index * $parameter) * sin($index * $parameter)
        ]);
    } else if ($f2) {
        $msg = json_encode([
            "cos" => cos($index * $parameter) * cos($index * $parameter)
        ]);
    } else if ($f3) {
        $msg = json_encode([
            "sincos" => sin($index * $parameter) * cos($index * $parameter)
        ]);
    } else {
        $msg = "";
    }
    sendSse($index++, $msg);
    sleep(1);
}

function sendSse($id, $msg)
{
    echo "id: $id\n";
    echo "event: evt\n";
    echo "data: $msg\n\n";
    ob_flush();
    flush();
}
