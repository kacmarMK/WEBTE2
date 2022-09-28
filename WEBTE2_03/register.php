<?php

require_once("Database.php");
require_once("PHPGangsta/GoogleAuthenticator.php");

$conn = (new Database())->createConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ((isset($_POST['login']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['psw']) && isset($_POST['psw-repeat'])) &&
        (!empty($_POST['login']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['psw']) && !empty($_POST['psw-repeat']))
    ) {
        if (strcmp($_POST['psw'], $_POST['psw-repeat']) == 0) {
            try {
                $stm = $conn->prepare("INSERT INTO user (login, email, name, surname, password, secret) VALUES (?, ?, ?, ?, ?, ?)");
                $hash = password_hash($_POST['psw'], PASSWORD_BCRYPT);
                

                //AUTENTIFIKACIA GENEROVANIE KODU
                $websiteTitle = 'Autentifikácia účtu';

                $ga = new PHPGangsta_GoogleAuthenticator();

                $secret = $ga->createSecret();

                $qrCodeUrl = $ga->getQRCodeGoogleUrl($websiteTitle, $secret);
                echo '<br><div class="qr"><img src="' . $qrCodeUrl . '" /></div>';

                echo '<br><p> Váš kľúč je: ' . $secret . '</p>';

                $stm->execute([$_POST['login'], $_POST['email'], $_POST['name'], $_POST['surname'], $hash, $secret]);

                $_SESSION['username'] = $_POST['login'];

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
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
    <form action="register.php" method="POST">
        <h2>Registrácia</h2>
        <div class="container">
            <h3>Prosím, vyplňte tento formulár na dokončenie registrácie.</h3>
            <br>
            <label for="login"><b>Prihlasovacie meno</b></label>
            <input type="text" placeholder="Vložte prihlasovacie meno" name="login" id="login" required>
            <br>
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Vložte email" name="email" id="email" required>
            <br>
            <label for="name"><b>Meno</b></label>
            <input type="text" placeholder="Vložte meno" name="name" id="name" required>
            <br>
            <label for="surname"><b>Priezvisko</b></label>
            <input type="text" placeholder="Vložte priezvisko" name="surname" id="surname" required>
            <br>
            <label for="psw"><b>Heslo</b></label>
            <input type="password" placeholder="Vložte heslo" name="psw" id="psw" required>
            <br>
            <label for="psw-repeat"><b>Heslo znova</b></label>
            <input type="password" placeholder="Vložte znova heslo" name="psw-repeat" id="psw-repeat" required>
            <br>

            <button type="submit" class="registerbtn" id="rgstr">Registrovať</button>
        </div>
    </form>
    <p>Máte už vytvorený účet? <a href="login.php" class="register">Prihlásenie</a></p>
    <script>
    var reg = document.getElementById('rgstr');
    reg.onclick = function() {
        var psw = document.getElementById('psw').innerHTML;
        var psw_rep = document.getElementById('psw-repeat').innerHTML;
        
        var n = psw.localeCompare(psw_rep);
        console.log("Velkost n je: "+ n);
        if(n != 0) {
            alert("Heslá sa nezhodujú, prosím zadajte zhodné heslá.");
        }
    }
    </script>
</body>

</html>