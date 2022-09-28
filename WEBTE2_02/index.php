

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Zadanie 2</title>
</head>

<body>

    <?php
    include_once("../config.php");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=zadanie2", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    if(isset($_POST["athlete_placements"])) {
        header('Location: ' . "addPlacement.php?id=" . $_POST['athlete_placements']);
        exit;
    }

    $sql = "SELECT athlete.id, athlete.name, athlete.surname, oh.year, oh.city, oh.country, oh.type, placement.discipline FROM athlete, placement, oh WHERE placement.person_id = athlete.id AND placement.placing = 1 AND oh.id = placement.oh_id";

    $stm = $conn->query($sql);

    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    echo "<table class='sortable'> 
          <caption class='table_name'>Olympijskí víťazi</caption>
              <tr>
                  <th class='disabled'>Meno</th>
                  <th>Priezvisko</th>
                  <th>Rok</th>
                  <th class='disabled'>Mesto</th>
                  <th class='disabled'>Krajina</th>
                  <th>Typ OH</th>
                  <th class='disabled'>Disciplína</th>
                  <th class='disabled'></th>
              </tr>";

    foreach ($rows as $row) {
        echo "<tr>";
        echo "<td>" . '<a href="view.php?id=' . $row["id"] . '">' . $row["name"] ."</a></td>";
        echo "<td>" . '<a href="view.php?id=' . $row["id"] . '">' . $row["surname"] . "</a></td>";
        echo "<td>" . $row["year"] . "</td>";
        echo "<td>" . $row["city"] . "</td>";
        echo "<td>" . $row["country"] . "</td>";
        echo "<td>" . $row["type"] . "</td>";
        echo "<td>" . $row["discipline"] . "</td>";
        echo "<td>" . '<a href="edit.php?id=' . $row["id"] . '">' . "Upraviť" . "</a>" . 
                "<br>". '<a href="delete.php?id=' . $row["id"] . '">' . "Zmazať" . "</a>" . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    $sql = "SELECT athlete.id, athlete.name, athlete.surname, count(placement.person_id) as occurences FROM athlete, placement, oh 
          WHERE placement.person_id = athlete.id AND placement.placing = 1 AND oh.id = placement.oh_id 
          GROUP BY placement.person_id ORDER BY occurences DESC";

    $stm = $conn->query($sql);

    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    echo "<table> 
          <caption class='table_name'>TOP 10 najúspešnejších olympionikov</caption>
              <tr>
                  <th>Meno a Priezvisko</th>
                  <th>Počet zlatých medailí</th>
                  <th> </th>
              </tr>";

    $counter = 1;
    foreach ($rows as $row) {
        echo "<tr>";
        echo "<td>" . '<a href="view.php?id=' . $row["id"] . '">' . $row["name"] . " " . $row["surname"] . "</a>" . "</td>";
        echo "<td>" . $row["occurences"] . "</td>";
        echo "<td>" . '<a href="edit.php?id=' . $row["id"] . '">' . "Upraviť" . "</a>" . 
                "<br>". '<a href="delete.php?id=' . $row["id"] . '">' . "Zmazať" . "</a>" . "</td>";
        echo "</tr>";
        if ($counter == 10) {
            break;
        }
        $counter++;
    }
    echo "</table>";
    echo "<a href='edit.php' id='athleteAddition'>Pridanie nového športovca</a>";

    $sql = "SELECT id, name, surname FROM athlete";
    $stm = $conn->query($sql);
    $athletes = $stm->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <form action="index.php"  method="POST" id='placementForm'>
        <label for="athlete_placements">Zvoľte športovca:</label>

        <select name="athlete_placements" id="athlete_placements">
            <?php
                foreach($athletes as $athlete) {
                    echo '<option value="' . $athlete['id'] . '">' . $athlete['name'] . " " . $athlete['surname'] . '</option>';
                }
            ?>
        </select>
        <input type="submit" value="Pridať umiestnenie">
    </form>
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
</body>

</html>