<?php
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
   
      session_start();
      include_once("config/Database.php");
   
      $conn = (new Database())->createConnection();
   
      $sql = "SELECT visits FROM site_visit_counter WHERE site='location'";
      $stmt = $conn->query($sql);
      $number = $stmt->fetch(PDO::FETCH_ASSOC);
      $number["visits"]++;
      $q = "UPDATE site_visit_counter SET visits=? WHERE site='location'";
      $stm = $conn->prepare($q);
      $stm->execute([$number["visits"]]);
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <title>Zadanie 7 WEBTE2</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</head>

<body>
    <div class="container" id="lctn">
        <h4>IP adresa: </h4>
        <p id="ip">Vaša IP adresa: </p>
        <hr class="rounded">
        <h4>GPS súradnice: </h4>
        <p id="latitude">Zemepisná šírka: </p>
        <p id="longitude">Zemepisná dĺžka: </p>
        <p id="city">Mesto prislúchajúce súradniciam: </p>
        <p id="country">Štát prislúchajúci IP adrese: </p>
        <p id="capital">Hlavné mesto štátu: </p>
        <hr class="rounded">
        <a href="index.php" class="btn btn-warning" style="border: 2px solid #1d2124;">Hlavná stránka</a>
        <a href="statistics.php" class="btn btn-dark" style="float: right; border: 2px solid #1d2124;">Štatistika</a>
    </div>
    <script>
        window.onload = (event) => {
            $.get("https://ipinfo.io/json", function(response) {
            fetch("https://geo.ipify.org/api/v1?apiKey=at_ItqTwemoypa0xiCCQfljaopslJRGJ&ipAddress=" + response.ip)
                .then(
                    function(response) {
                        if (response.status !== 200) {
                            console.log('Looks like there was a problem. Status Code: ' +
                                response.status);
                            return;
                        }

                        response.json().then(function(data) {
                            document.getElementById("ip").innerHTML += data["ip"];
                            document.getElementById("latitude").innerHTML += data["location"]["lat"];
                            document.getElementById("longitude").innerHTML += data["location"]["lng"];
                            if(data["location"]["city"] == "") {
                                document.getElementById("city").innerHTML += "Mesto sa nedá lokalizovať alebo sa nachádzate na vidieku";
                            }
                            else {
                                document.getElementById("city").innerHTML += data["location"]["city"];
                            }
                            var countryCode = (data["location"]["country"]).toLowerCase();
                            fetch('https://restcountries.eu/rest/v2/alpha/' + countryCode)
                                .then(function(response) {
                                    if (response.status !== 200) {
                                        console.log('Looks like there was a problem. Status Code: ' +
                                            response.status);
                                        return;
                                    }

                                    response.json().then(function(data) {
                                        document.getElementById("country").innerHTML += data["altSpellings"][2];
                                        document.getElementById("capital").innerHTML += data["capital"];
                                        
                                    });
                                }).catch(function(err) {
                                    console.log('Fetch Error :-S', err);
                                });
                        });
                    }
                )
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
            }, "jsonp");
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>