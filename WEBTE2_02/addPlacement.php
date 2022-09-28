

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
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function getPerson($conn, $id)
{
    $sql = "SELECT * FROM athlete WHERE id=?";
    $stm = $conn->prepare($sql);
    $stm->bindValue(1, $id);
    $stm->execute();

    return $stm->fetch(PDO::FETCH_ASSOC);
}
function getOh($conn)
{
    $sql = "SELECT * FROM oh";
    $stm = $conn->query($sql);

    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['id']) &&
    (isset($_POST['oh_id'])) &&
     (isset($_POST['placing'])) &&
      (isset($_POST['discipline'])))
 {  
    //pridanie umiestnenia
    $sql = "INSERT INTO placement (person_id, oh_id, placing, discipline) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id'], $_POST['oh_id'], $_POST['placing'], $_POST['discipline']]);
    header('Location: ' . "addPlacement.php?id=" . $_POST['id']);
    exit;

    //$person = getPerson($conn, $id);
}
else if (isset($_GET['id'])) {
    $person = getPerson($conn, $_GET['id']);
    $o_hry = getOh($conn);
  } else {
    //header('Location: ' . "../404.html");
  }

?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Zadanie 2</title>
</head>

<body>
    <a href="index.php" class="back">Späť</a>
    <form action="addPlacement.php" method="POST">
        <div class="hide"><input type="hidden" id="id" name="id" value="<?php echo isset($person["id"]) ? $person["id"] : null; ?>"></div>
        <label for="oh_id">Olympijské hry:</label><br>
        <select name="oh_id" id="oh_id">
            <?php
                foreach($o_hry as $o_hra) {
                    echo '<option value="' . $o_hra['id'] . '">' . $o_hra['type'] . ", " . $o_hra['year'] . ", " . $o_hra['city'] . ", " . $o_hra['country'] . '</option>';
                }
            ?>
        </select><br>
        <label for="placing">Umiestnenie:</label><br>
        <input type="placing" id="placing" name="placing" value="" required><br>
        <label for="discipline">Disciplína:</label><br>
        <input type="discipline" id="discipline" name="discipline" value="" required><br>

        <input type="submit" value="Pridať umiestnenie">
    </form>
    
</body>

</html>