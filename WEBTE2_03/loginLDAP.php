<?php
session_start();
date_default_timezone_set('Europe/Bratislava');

if ((isset($_POST['stubaUname']) && (isset($_POST['stubaPsw']) && (!empty($_POST['stubaUname']) && (!empty($_POST['stubaPsw'])))))) {
        $ldapuid = $_POST['stubaUname'];
        $ldappass = $_POST['stubaPsw'];
        $dn  = 'ou=People, DC=stuba, DC=sk';
        $ldaprdn  = "uid=$ldapuid, $dn";

        // connect to ldap server
        $ldapconn = ldap_connect("ldap.stuba.sk")
            or die("Could not connect to LDAP server.");

        if ($ldapconn) {
            $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            // binding to ldap server
            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

            // verify binding
            if ($ldapbind) {
                $_SESSION['username'] = $_POST['stubaUname'];
                $_SESSION['date'] = date("Y-m-d H:i:s");
                $_SESSION['type'] = "ldap";
                header("location: index.php");
            } else {
                echo "Prihlásenie nebolo úspešné";
            }
        }
        ldap_unbind($ldapconn);
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
    <form action="loginLDAP.php" method="post">
        <div class="container">
            <label for="stubaUname"><b>Prihlasovacie meno</b></label>
            <input type="text" placeholder="Vložte prihlasovacie meno" name="stubaUname" id="stubaUname" required>
            <br>
            <label for="stubaPsw"><b>Heslo</b></label>
            <input type="password" placeholder="Vložte heslo" name="stubaPsw" id="stubaPsw" required>
            <br>
            <button type="submit">Prihlásiť sa</button>
            <br>
        </div>

    </form>
    <p>ak nie ste zaregistrovaný, registrujte sa na odkaze: <a href="register.php" class="register">Registrácia</a></p>
    <div class="loginDIV">
        <a href="login.php" class="loginC" style="border-bottom: none;">Prihlásenie pomocou 2FA</a>
        <a href="loginOAuth.php" class="loginC" style="border-top: 3px solid black;">Prihlásenie pomocou OAuth</a>
    </div>
    
</body>

</html>