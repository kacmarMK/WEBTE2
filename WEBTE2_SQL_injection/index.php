<?php

session_start();
date_default_timezone_set('Europe/Bratislava');
require_once("Database.php");
$conn = (new Database())->createConnection();

echo "<div class='pos'><a href='logout.php' id='log_out'>Odhlásenie</a></div>";


if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    echo "<h1>Vitajte na stránke " . $_SESSION['username'] . " !</h1>";
} else {
    header("location: login.php");
}
echo "<div class='pos'><a href='changePsw.php' id='changePSW'>Zmena hesla</a></div>";

?>

<!DOCTYPE html>
<html lang="sk">

<head>
   <meta charset="utf-8">
   <title>SQL Injection</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</head>

<body>

   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>