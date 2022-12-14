

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../config.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=zadanie2", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

  if(isset($_GET['id'])) {
    $sql = "DELETE FROM athlete WHERE athlete.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_GET['id']]);
    header('Location: '. "index.php");
    exit;
  } else {
    header('Location: '. "../404.html");
  }
?> 