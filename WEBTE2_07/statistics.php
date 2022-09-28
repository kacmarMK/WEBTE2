<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once("config/Database.php");

$conn = (new Database())->createConnection();


$query = "SELECT DISTINCT country FROM logs";
$stmt = $conn->query($query);
$codes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <title>Zadanie 7 WEBTE2</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</head>

<body>
    <div class="container" id="sttstcs">
        <h4>Národnosť návštevníkov tohto portálu: </h4>
        <table id="countries">
            <tr>
                <th>Vlajka</th>
                <th>Kód krajiny</th>
                <th>Počet návštevníkov</th>
            </tr>
            <?php
            foreach ($codes as $code) {
                $q = "SELECT COUNT(*) as num FROM logs WHERE country=?";
                $stm = $conn->prepare($q);
                $stm->execute([$code["country"]]);
                $visits = $stm->fetch(PDO::FETCH_ASSOC);
                $num_of_visits = $visits["num"];
                $countryCODE = $code["country"];
                echo "<tr>
                    <td><img src='http://www.geonames.org/flags/x/" . strtolower($countryCODE) . ".gif' width='30' height='20' alt='vlajka'></td>
                    <td><a href='https://wt69.fei.stuba.sk/z7mashupMK/statistics.php?code=" . $countryCODE . "' class='cntry'>$countryCODE</a></td>
                    <td>$num_of_visits</td>
                </tr>";
            }
            ?>
        </table>
        <table>
            <?php
            if (isset($_GET["code"])) {
                echo "<tr><th>Mesto</th><th>Počet návštev</th></tr>";
                $code = $_GET["code"];
                $query = "SELECT DISTINCT city FROM logs WHERE country=?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$code]);
                $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($cities as $city) {
                    $q = "SELECT COUNT(*) as num FROM logs WHERE city=?";
                    $stm = $conn->prepare($q);
                    $stm->execute([$city["city"]]);
                    $visits = $stm->fetch(PDO::FETCH_ASSOC);
                    $num_of_visits = $visits["num"];
                    $ct = $city["city"];
                    if($ct == null) {
                        $ct = "Nelokalizované mestá a vidiek";
                    }
                    echo "<tr>
                            <td>$ct</td>
                            <td>$num_of_visits</td>
                        </tr>";
                }
            } else {
                $sql = "SELECT visits FROM site_visit_counter WHERE site='statistics'";
                $stmt = $conn->query($sql);
                $number = $stmt->fetch(PDO::FETCH_ASSOC);
                $number["visits"]++;
                $q = "UPDATE site_visit_counter SET visits=? WHERE site='statistics'";
                $stm = $conn->prepare($q);
                $stm->execute([$number["visits"]]);
            }
            ?>
        </table>
        <hr class="rounded">
        <h4>Návštevy v rôzne časové rozmedzia: </h4>
        <table>
            <tr>
                <th>6:00-15:00</th>
                <th>15:00-21:00</th>
                <th>21:00-24:00</th>
                <th>24:00-6:00</th>
            </tr>
            <?php
            $first = new DateTime("06:00:00");
            $first = $first->format("H:i:s");
            $second = new DateTime("14:59:59");
            $second = $second->format("H:i:s");
            $query = "SELECT COUNT(*) as num FROM logs WHERE time BETWEEN ? AND ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$first, $second]);
            $morning = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $first = new DateTime("15:00:00");
            $first = $first->format("H:i:s");
            $second = new DateTime("20:59:59");
            $second = $second->format("H:i:s");
            $query = "SELECT COUNT(*) as num FROM logs WHERE time BETWEEN ? AND ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$first, $second]);
            $afternoon = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $first = new DateTime("21:00:00");
            $first = $first->format("H:i:s");
            $second = new DateTime("23:59:59");
            $second = $second->format("H:i:s");
            $query = "SELECT COUNT(*) as num FROM logs WHERE time BETWEEN ? AND ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$first, $second]);
            $evening = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $first = new DateTime("00:00:00");
            $first = $first->format("H:i:s");
            $second = new DateTime("05:59:59");
            $second = $second->format("H:i:s");
            $query = "SELECT COUNT(*) as num FROM logs WHERE time BETWEEN ? AND ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$first, $second]);
            $night = $stmt->fetchAll(PDO::FETCH_ASSOC);


            echo
            "<tr>
                <td>" . $morning[0]["num"] . "</td>
                <td>" . $afternoon[0]["num"] . "</td>
                <td>" . $evening[0]["num"] . "</td>
                <td>" . $night[0]["num"] . "</td>
            </tr>";
            ?>
        </table>
        <hr class="rounded">
        <?php
        $sql = "SELECT * FROM site_visit_counter WHERE visits=(SELECT MAX(visits) FROM site_visit_counter) ";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<p>Najčastejšie navštevovaná stránka je stránka <b>" . $row["site"] . "</b> s počtom návštev <b>" . $row["visits"] . "</b></p>";
        ?>
        <hr class="rounded">
        <a href="index.php" class="btn btn-warning" style="border: 2px solid #1d2124;">Hlavná stránka</a>
        <a href="location.php" class="btn btn-dark" style="float: right;border: 2px solid #1d2124;">Údaje o vašej lokácii</a>
    </div>

    <h1>Mapa pôvodu všetkých návštevníkov stránky:</h1>
    <div id="mapid"></div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script>
        var mymap = L.map('mapid').setView([48.1516988, 17.1093063], 13);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 5,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoieGthY21hcm0iLCJhIjoiY2tueGF3cTNyMGtjcDJ2bXBybzIzbXhkZCJ9.B7n4E8lRxSUT1VU3j6WQRA'
        }).addTo(mymap);

        <?php
        $sql = "SELECT DISTINCT city, latitude, longitude FROM logs";
        $stmt = $conn->query($sql);
        $coords = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($coords as $coord) {
            $lat = $coord["latitude"];
            $lng = $coord["longitude"];

            echo 'var marker = L.marker([' . $lat . ', ' . $lng . ']).addTo(mymap);';
        }
        ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>