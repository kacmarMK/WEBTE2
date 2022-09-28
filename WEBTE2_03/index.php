<?php

require_once("Database.php");

session_start();

if (isset($_SESSION['logout'])) {
    echo "<div class='pos'><a href='logoutOAuth.php' id='log_out'>Odhlásenie</a></div>";
} else {
    echo "<div class='pos'><a href='logout.php' id='log_out'>Odhlásenie</a></div>";
}

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    echo "<h1>Vitajte na stránke " . $_SESSION['username'] . " !</h1>";
} else {
    header("location: login.php");
}

if (isset($_SESSION['type']) && !empty($_SESSION['type'])) {
    $conn = (new Database())->createConnection();
    //registrovany user
    if (($_SESSION['type'] == "registered") && (!empty($_SESSION['date']) && !empty($_SESSION['type']))) {
        $stm = $conn->prepare("INSERT INTO loginlog (username, logdate, type) VALUES (?, ?, ?)");

        $stm->execute([$_SESSION['username'], $_SESSION['date'], $_SESSION['type']]);
    }
    //ldap prihlasenie
    else if (($_SESSION['type'] == "ldap") && (!empty($_SESSION['date']) && !empty($_SESSION['type']))) {
        $stm = $conn->prepare("INSERT INTO loginlog (username, logdate, type) VALUES (?, ?, ?)");

        $stm->execute([$_SESSION['username'], $_SESSION['date'], $_SESSION['type']]);
    }
    //google prihlasenie
    else if (($_SESSION['type'] == "oAuth") && (!empty($_SESSION['date']) && !empty($_SESSION['type']))) {
        $stm = $conn->prepare("INSERT INTO loginlog (username, logdate, type) VALUES (?, ?, ?)");

        $stm->execute([$_SESSION['username'], $_SESSION['date'], $_SESSION['type']]);
    } else {
        header("location: login.php");
    }
} else {
    header("location: login.php");
}

$ldapNumQ = "SELECT COUNT(*) as ldapNUM FROM loginlog WHERE type='ldap'";
$oAuthNumQ = "SELECT COUNT(*) as oAuthNUM FROM loginlog WHERE type='oAuth'";
$registeredNumQ = "SELECT COUNT(*) as registeredNUM FROM loginlog WHERE type='registered'";

$stm = $conn->query($ldapNumQ);
$ldapConns = $stm->fetch(PDO::FETCH_ASSOC);

$stm = $conn->query($oAuthNumQ);
$oAuthConns = $stm->fetch(PDO::FETCH_ASSOC);

$stm = $conn->query($registeredNumQ);
$registeredConns = $stm->fetch(PDO::FETCH_ASSOC);

$allConns = $ldapConns['ldapNUM'] + $oAuthConns['oAuthNUM'] + $registeredConns['registeredNUM'];

$dataPoints = array(
    array("label" => "LDAP", "y" => ($ldapConns['ldapNUM'] / $allConns) * 100),
    array("label" => "Google", "y" => ($oAuthConns['oAuthNUM'] / $allConns) * 100),
    array("label" => "Registrácia", "y" => ($registeredConns['registeredNUM'] / $allConns) * 100),
);

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet"> 
    <title>Zadanie 3 WEBTE2</title>
</head>

<body>
    <?php
    echo '<button type="button" id="logins" value="0">Minulé prihlásenia</button>';
    ?>
    <script>
        var logins = document.getElementById('logins');
        logins.onclick = function() {
            if (logins.value == 0) {
                <?php
                $sql = "SELECT logdate FROM loginlog WHERE username=?";
                $stm = $conn->prepare($sql);
                $stm->bindValue(1, $_SESSION['username']);
                $stm->execute();

                $dates = $stm->fetchAll(PDO::FETCH_ASSOC);
                ?>
                var table = document.createElement("table");
                var caption = document.createElement("caption");
                var tr = document.createElement("tr");
                var th = document.createElement("th");
                caption.innerHTML = "Tabuľka minulých prihlásení";
                th.innerHTML = "Dátum a čas";
                table.id = "logs";

                table.appendChild(caption);
                tr.appendChild(th);
                table.appendChild(tr);


                <?php
                $numDates = count($dates);
                $counter = 0;
                foreach ($dates as $date) {
                    if ($counter == ($numDates - 1)) {
                        break;
                    } ?>
                    var row = document.createElement("tr");
                    var td = document.createElement("td");
                    td.innerHTML = "<?php echo $date["logdate"]; ?>";
                    row.appendChild(td);
                    table.appendChild(row);
                <?php
                    $counter++;
                }
                ?>
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    title: {
                        text: "Štatistika prihlásení do aplikácie"
                    },
                    subtitles: [{
                        text: "Marec/Apríl 2021"
                    }],
                    data: [{
                        type: "pie",
                        yValueFormatString: "#,##0.00\"%\"",
                        indexLabel: "{label} ({y})",
                        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();
                var newEl = document.getElementById("loginsTable");
                newEl.appendChild(table);
                logins.value = 1;
                var chart = document.getElementById("chartContainer");
                chart.style.visibility = "visible";
            }
            else {
                logins.value = 0;
                var tab = document.getElementById("logs");
                tab.remove();
                var chart = document.getElementById("chartContainer");
                chart.style.visibility = "hidden";
            }
        }
    </script>
    <div id="loginsTable"></div>
    <div id="chartContainer"></div>


    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>