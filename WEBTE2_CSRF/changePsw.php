<?php

session_start();

require_once("Database.php");
$conn = (new Database())->createConnection();


$sql = "SELECT * FROM user WHERE login=?";

$stm = $conn->prepare($sql);
$stm->execute([$_SESSION['username']]);

$user = $stm->fetch(PDO::FETCH_ASSOC);

if((isset($_POST['old_psw']) && (isset($_POST['new_psw']))) && (strcmp($_POST['old_psw'], $_POST['new_psw']) == 0)) {
    $q = "UPDATE user SET password=? WHERE login=?";
    $s = $conn->prepare($q);
    $hash = password_hash($_POST['new_psw'], PASSWORD_BCRYPT);
    $s->execute([$hash, $user["login"]]);
}



echo "<div class='pos'><a href='index.php' id='back'>Späť</a></div>";

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <title>CSRF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</head>

<body>
    <form action="changePsw.php" method="post">
        <div class="container">
            <label for="old_psw"><b>Nové heslo</b></label>
            <input type="password" id="old_psw" placeholder="Vložte nové heslo" name="old_psw" required>
            <br>
            <label for="new_psw"><b>Nové heslo znovu</b></label>
            <input type="password" id="new_psw" placeholder="Vložte nové heslo znovu" name="new_psw" required>
            <br>

            <button type="submit">Zmeniť heslo</button>
            <br>
        </div>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>