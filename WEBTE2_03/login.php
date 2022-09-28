<?php

session_start();
date_default_timezone_set('Europe/Bratislava');

require_once("Database.php");
require_once('PHPGangsta/GoogleAuthenticator.php');
$conn = (new Database())->createConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM user WHERE login=?";

    $stm = $conn->prepare($sql);
    $stm->execute([$_POST["uname"]]);

    $user = $stm->fetch(PDO::FETCH_ASSOC);

    if (password_verify($_POST["psw"], $user["password"])) {

        $secret = $user["secret"];

        if (isset($_POST['code'])) {
            $code = $_POST['code'];

            $ga = new PHPGangsta_GoogleAuthenticator();
            $result = $ga->verifyCode($secret, $code);

            if ($result == 1) {
                $_SESSION['username'] = $user['login'];
                $_SESSION['date'] = date("Y-m-d H:i:s");
                $_SESSION['type'] = "registered";
                header("location: index.php");
            } else {
                echo 'Nesprávny overovací kód.';
            }
        }
    }
    else {
        echo 'Nesprávne heslo.';
    }
}

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet"> 
    <title>Zadanie 3 WEBTE2</title>
</head>

<body>
    <form action="login.php" method="post">
        <div class="container">
            <label for="uname"><b>Prihlasovacie meno</b></label>
            <input type="text" id="uname" placeholder="Vložte prihlasovacie meno" name="uname" required>
            <br>
            <label for="psw"><b>Heslo</b></label>
            <input type="password" id="psw" placeholder="Vložte heslo" name="psw" required>
            <br>
            <label for="code"><b>Overovací kód</b></label>
            <input type="text" id="code" placeholder="Vložte kód" name="code" required>
            <br>
            <button type="submit">Prihlásiť sa</button>
            <br>
        </div>

    </form>
    <p>ak nie ste zaregistrovaný, registrujte sa na odkaze: <a href="register.php" class="register">Registrácia</a></p>
    <div class="loginDIV">
        <a href="loginLDAP.php" class="loginC" style="border-bottom: none;">Prihlásenie pomocou LDAP</a>
        <a href="loginOAuth.php" class="loginC" style="border-top: 3px solid black;">Prihlásenie pomocou OAuth</a>
    </div>
    
</body>

</html>