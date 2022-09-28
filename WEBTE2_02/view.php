
<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <title>Zadanie 2</title>
</head>

<body>

  <?php

function getPerson($conn, $id)
{
    $sql = "SELECT * FROM athlete WHERE id=?";
    $stm = $conn->prepare($sql);
    $stm->bindValue(1, $id);
    $stm->execute();

    return $stm->fetch(PDO::FETCH_ASSOC);
}

function getPlacement($conn, $id)
{
    $sql = "SELECT * FROM placement, oh WHERE placement.person_id = ? AND oh.id = placement.oh_id";
    $stm = $conn->prepare($sql);
    $stm->bindValue(1, $id);
    $stm->execute();

    return $stm->fetchAll(PDO::FETCH_ASSOC);
}


  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include_once("../config.php");

  try {
    $conn = new PDO("mysql:host=$servername;dbname=zadanie2", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

  if (isset($_GET['id'])) {
    $person = getPerson($conn, $_GET['id']);
  } else {
    header('Location: ' . "../404.html");
  }

  ?>
  <a href="index.php" class="back">Späť</a>
  <?php
    echo '<a href="edit.php?id=' . $_GET['id'] . '" class="back">Editácia</a>';
  ?>
  <form action="#"">
    <div class="hide"><input type="hidden" id="id" name="id" value=""></div>
    <label for="name">Meno:</label><br>
    <input type="text" id="name" name="name" value="<?php echo isset($person["name"]) ? $person["name"] : null; ?>" readonly><br>
    <label for="surname">Priezvisko:</label><br>
    <input type="text" id="surname" name="surname" value="<?php echo isset($person["surname"]) ? $person["surname"] : null; ?>" readonly><br>
    <label for="birth_day">Dátum narodenia:</label><br>
    <input type="text" id="birth_day" name="birth_day" value="<?php echo isset($person["birth_day"]) ? $person["birth_day"] : null; ?>" readonly><br>
    <label for="birth_place">Miesto narodenia:</label><br>
    <input type="text" id="birth_place" name="birth_place" value="<?php echo isset($person["birth_place"]) ? $person["birth_place"] : null; ?>" readonly><br>
    <label for="birth_country">Krajina pôvodu:</label><br>
    <input type="text" id="birth_country" name="birth_country" value="<?php echo isset($person["birth_country"]) ? $person["birth_country"] : null; ?>" readonly><br>
    <label for="death_day">Dátum úmrtia:</label><br>
    <input type="text" id="death_day" name="death_day" value="<?php echo isset($person["death_day"]) ? $person["death_day"] : null; ?>" readonly><br>
    <label for="death_place">Miesto úmrtia:</label><br>
    <input type="text" id="death_place" name="death_place" value="<?php echo isset($person["death_place"]) ? $person["death_place"] : null; ?>" readonly><br>
    <label for="death_country">Krajina úmrtia:</label><br>
    <input type="text" id="death_country" name="death_country" value="<?php echo isset($person["death_country"]) ? $person["death_country"] : null; ?>" readonly><br>
  </form>

  <?php
      $placements = getPlacement($conn, $_GET['id']);
      foreach($placements as $placement) {
  ?>
  
  <form action="#" class="placements">
    <label for="placement">Umiestnenie:</label><br>
    <input type="text" id="placement" name="placement" value="<?php echo isset($placement["placing"]) ? $placement["placing"] : null; ?>" readonly><br>
    <label for="discipline">Disciplína:</label><br>
    <input type="text" id="discipline" name="discipline" value="<?php echo isset($placement["discipline"]) ? $placement["discipline"] : null; ?>" readonly><br>
    <label for="type">Typ OH:</label><br>
    <input type="text" id="type" name="type" value="<?php echo isset($placement["type"]) ? $placement["type"] : null; ?>" readonly><br>
    <label for="year">Rok:</label><br>
    <input type="text" id="year" name="year" value="<?php echo isset($placement["year"]) ? $placement["year"] : null; ?>" readonly><br>
    <label for="country">Mesto a Krajina:</label><br>
    <input type="text" id="country" name="country" value="<?php echo isset($placement["city"]) ? $placement["city"] : null; ?> <?php echo isset($placement["country"]) ? $placement["country"] : null; ?>" readonly><br>
  </form>
  <?php
      }
  ?>
</body>

</html>