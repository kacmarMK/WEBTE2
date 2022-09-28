<?php
require_once("Database.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = (new Database())->createConnection();

if (isset($_POST["num"])) {
    $sql = "INSERT INTO logs (x, parameter, f1, f2, f3) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (isset($_POST["function1"]) && isset($_POST["function2"]) && isset($_POST["function3"])) {
        $stmt->execute([$_POST["index"], $_POST["num"], $_POST["function1"], $_POST["function2"], $_POST["function3"]]);
    } else if (isset($_POST["function1"]) && isset($_POST["function2"])) {
        $stmt->execute([$_POST["index"], $_POST["num"], $_POST["function1"], $_POST["function2"], 0]);
    } else if (isset($_POST["function2"]) && isset($_POST["function3"])) {
        $stmt->execute([$_POST["index"], $_POST["num"], 0, $_POST["function2"], $_POST["function3"]]);
    } else if (isset($_POST["function1"]) && isset($_POST["function3"])) {
        $stmt->execute([$_POST["index"], $_POST["num"], $_POST["function1"], 0, $_POST["function3"]]);
    } else if (isset($_POST["function1"])) {
        $stmt->execute([$_POST["index"], $_POST["num"], $_POST["function1"], 0, 0]);
    } else if (isset($_POST["function2"])) {
        $stmt->execute([$_POST["index"], $_POST["num"], 0, $_POST["function2"], 0]);
    } else if (isset($_POST["function3"])) {
        $stmt->execute([$_POST["index"], $_POST["num"], 0, 0, $_POST["function3"]]);
    } else {
        $stmt->execute([$_POST["index"], $_POST["num"], 0, 0, 0]);
    }
}
$conn = null;
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Zadanie 5 WEBTE2</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div id="result" class="container"></div>
    <form action="index.php" method="POST" id='log_form'>
        <div class="form-group container">
            <label for="num">Upravte parameter meniaci výstup funkcii:</label>
            <input type="number" id="num" name="num" required><br>
            <h2 class="col-form-label">Zvoľte funkcie, ktorých výstup potrebujete:</h2>
            <label for="function1">y1 = sin^2(ax)</label>
            <input type="checkbox" id="function1" name="function1" value="1" checked><br>
            <label for="function2">y2 = cos^2(ax)</label>
            <input type="checkbox" id="function2" name="function2" value="1" checked><br>
            <label for="function3">y3 = sin(ax)*cos*(ax)</label>
            <input type="checkbox" id="function3" name="function3" value="1" checked><br>
            <input type="hidden" name="index" id="index">



            <script>
                var source = new EventSource("sse.php");
                source.addEventListener('evt', (e) => {
                    console.log(e);
                    document.getElementById("index").value = e.lastEventId;
                    var data = JSON.parse(e.data);
                    if (typeof data.sin == "undefined" && typeof data.cos == "undefined" && typeof data.sincos == "undefined") {
                        document.querySelector("#result").innerHTML = "";
                    } else if (typeof data.sin == "undefined" && typeof data.cos == "undefined") {
                        document.querySelector("#result").innerHTML = "sin(x)*cos(x): " + data.sincos;
                    } else if (typeof data.sin == "undefined" && typeof data.sincos == "undefined") {
                        document.querySelector("#result").innerHTML = "cos^2(x): " + data.cos;
                    } else if (typeof data.cos == "undefined" && typeof data.sincos == "undefined") {
                        document.querySelector("#result").innerHTML = "sin^2(x): " + data.sin;
                    } else if (typeof data.sin == "undefined") {
                        document.querySelector("#result").innerHTML = "cos^2(x): " + data.cos + "<br>";
                        document.querySelector("#result").innerHTML += "sin(x)*cos(x): " + data.sincos;
                    } else if (typeof data.cos == "undefined") {
                        document.querySelector("#result").innerHTML = "sin^2(x): " + data.sin + "<br>";
                        document.querySelector("#result").innerHTML += "sin(x)*cos(x): " + data.sincos;
                    } else if (typeof data.sincos == "undefined") {
                        document.querySelector("#result").innerHTML = "sin^2(x): " + data.sin + "<br>";
                        document.querySelector("#result").innerHTML += "cos^2(x): " + data.cos;
                    } else {
                        document.querySelector("#result").innerHTML = "sin^2(x): " + data.sin + "<br>";
                        document.querySelector("#result").innerHTML += "cos^2(x): " + data.cos + "<br>";
                        document.querySelector("#result").innerHTML += "sin(x)*cos(x): " + data.sincos;
                    }

                })
            </script>

            <div class="text-center" style="margin-top: 30px;">
                <button class="btn btn-dark" type="submit">Upraviť</button>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>