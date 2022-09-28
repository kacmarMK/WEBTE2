
<?php

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

if ((isset($_POST['name']) && !empty($_POST['name'])) &&
    (isset($_POST['surname']) && !empty($_POST['surname']))
) {  
    $id = null;
    if (empty($_POST['id'])) {
        //pridanie usera
        $sql = "INSERT INTO athlete (name, surname, birth_day, birth_place, birth_country, death_day, death_place, death_country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute([$_POST['name'], $_POST['surname'], $_POST['birth_day'], $_POST['birth_place'], $_POST['birth_country'], $_POST['death_day'], $_POST['death_place'], $_POST['death_country']]);
        }
        catch (PDOException $e){
            if($e->errorInfo[0] == '23000' && $e->errorInfo[1] == '1062'){
                //
            } 
        }

        $id = $conn->lastInsertId();
    } else {
        //uprava usera
        $sql = "UPDATE athlete SET name=?, surname=?, birth_day=?, birth_place=?, birth_country=?, death_day=?, death_place=?, death_country=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_POST['name'], $_POST['surname'], $_POST['birth_day'], $_POST['birth_place'], $_POST['birth_country'], $_POST['death_day'], $_POST['death_place'], $_POST['death_country'], $_POST['id']]);
        
        $id = $_POST['id'];
    }
    $person = getPerson($conn, $id);

} else if (isset($_GET['id'])) {
    $person = getPerson($conn, $_GET['id']);
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
    <form action="edit.php" method="POST">
        <div class="hide"><input type="hidden" id="id" name="id" value="<?php echo isset($person["id"]) ? $person["id"] : null; ?>"></div>
        <label for="name">Meno:</label><br>
        <input type="text" id="name" name="name" value="<?php echo isset($person["name"]) ? $person["name"] : null; ?>" required><br>
        <label for="surname">Priezvisko:</label><br>
        <input type="text" id="surname" name="surname" value="<?php echo isset($person["surname"]) ? $person["surname"] : null; ?>" required><br>
        <label for="birth_day">Dátum narodenia:</label><br>
        <input type="text" id="birth_day" name="birth_day" value="<?php echo isset($person["birth_day"]) ? $person["birth_day"] : null; ?>"><br>
        <label for="birth_place">Miesto narodenia:</label><br>
        <input type="text" id="birth_place" name="birth_place" value="<?php echo isset($person["birth_place"]) ? $person["birth_place"] : null; ?>"><br>
        <label for="birth_country">Krajina pôvodu:</label><br>
        <input type="text" id="birth_country" name="birth_country" value="<?php echo isset($person["birth_country"]) ? $person["birth_country"] : null; ?>"><br>
        <label for="death_day">Dátum úmrtia:</label><br>
        <input type="text" id="death_day" name="death_day" value="<?php echo isset($person["death_day"]) ? $person["death_day"] : null; ?>"><br>
        <label for="death_place">Miesto úmrtia:</label><br>
        <input type="text" id="death_place" name="death_place" value="<?php echo isset($person["death_place"]) ? $person["death_place"] : null; ?>"><br>
        <label for="death_country">Krajina úmrtia:</label><br>
        <input type="text" id="death_country" name="death_country" value="<?php echo isset($person["death_country"]) ? $person["death_country"] : null; ?>"><br>
        <input type="submit" value="Upraviť">
    </form>
</body>

</html>