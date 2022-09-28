<?php
session_start();
require_once("Database.php");
$conn = (new Database())->createConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $sql = "SELECT * FROM user WHERE login=?";

   $stm = $conn->prepare($sql);
   $stm->execute([$_POST["uname"]]);

   $user = $stm->fetch(PDO::FETCH_ASSOC);

   if (password_verify($_POST["psw"], $user["password"])) {

      $_SESSION['username'] = $user['login'];
      $_SESSION['password'] = $_POST["psw"];
      header("location: index.php");
   
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
   <title>CSRF</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

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

            <button type="submit">Prihlásiť sa</button>
            <br>
        </div>

    </form>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>