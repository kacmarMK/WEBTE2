<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once("config/Database.php");

$conn = (new Database())->createConnection();


if (isset($_POST["ip"]) && isset($_POST["city"]) && isset($_POST["country"]) && isset($_POST["date"]) && isset($_POST["time"]) && isset($_POST["lat"]) && isset($_POST["lng"])) {

   $sql = "SELECT visits FROM site_visit_counter WHERE site='index'";
   $stmt = $conn->query($sql);
   $number = $stmt->fetch(PDO::FETCH_ASSOC);
   $number["visits"]++;
   $q = "UPDATE site_visit_counter SET visits=? WHERE site='index'";
   $stm = $conn->prepare($q);
   $stm->execute([$number["visits"]]);


   $sql = "INSERT INTO logs (ip, country, city, date, time, latitude, longitude) VALUES (?,?,?,?,?,?,?)";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$_POST["ip"], $_POST["country"], $_POST["city"], $_POST["date"], $_POST["time"], $_POST["lat"], $_POST["lng"]]);
}

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
   <div class="modal" tabindex="-1" role="dialog" id="myModal">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Súhlas</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <p>Súhlasíte so spracovaním vašich lokalizačných údajov(IP adresa a GPS súradnice)?</p>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="localisation()">Áno</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="declined()">Nie</button>
            </div>
         </div>
      </div>
   </div>
   <div class="container" style="display:none" id="divko">
      <h2>Predpoveď počasia pre vašu lokáciu:</h2>
      <p id="status"></p>
      <p id="timezone"></p>
      <p id="temp"></p>
      <p id="clouds"></p>
      <hr class="rounded">
      <h2>Predpoveď počasia na zvyšok dňa:</h2>
      <table id="forecast">
         <tr>
            <th>Čas</th>
            <th>Teplota</th>
            <th>Počasie</th>
         </tr>
      </table>
      <hr class="rounded">
      <a href="location.php" class="btn btn-warning" style="border: 2px solid #1d2124;">Údaje o vašej lokácii</a>
      <a href="statistics.php" class="btn btn-dark" style="border: 2px solid #1d2124;float: right;">Štatistika</a>
   </div>

   <script>
      $(window).on('load', function() {
         $('#myModal').modal('show');
      });

      function declined() {
         alert("Obsah stránky bol z dôvodu zamietnutia prístupu k vašim dátam zablokovaný.")
      }
      function calcTime(offset) {
         // create Date object for current location
         var d = new Date();

         // convert to msec
         // subtract local time zone offset
         // get UTC time in msec
         var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

         // create new Date object for different city
         // using supplied offset
         var nd = new Date(utc + (3600000 * offset));

         // return time as a string
         return nd.toLocaleString();
      }

      function geoFindMe(lat, lng) {
         fetch("https://api.openweathermap.org/data/2.5/onecall?lat=" +
               lat + "&lon=" +
               lng + "&units=metric&lang=sk&exclude=minutely,daily&appid=66414c2fa9bb7b77b451359cea985eb4")
            .then(
               function(response) {
                  if (response.status !== 200) {
                     console.log('Looks like there was a problem. Status Code: ' +
                        response.status);
                     return;
                  }

                  response.json().then(function(data) {
                     console.log(data);
                     var tmz = document.getElementById("timezone");
                     var temp = document.getElementById("temp");
                     var clds = document.getElementById("clouds");

                     tmz.innerHTML = "Časová zóna: " + data["timezone"];
                     temp.innerHTML = "Teplota: " + Math.round(data["current"]["temp"]) + "°C";
                     clds.innerHTML = "Počasie: " + data["current"]["weather"][0]["description"];
                     var table = document.getElementById("forecast");
                     var date = new Date(new Date().getTime() + (data["timezone_offset"] * 1000));
                     var hours = date.getUTCHours();
                     // Hours part from the timestamp

                     for (i = 1; i < data["hourly"].length; i++) {
                        if (hours == 23) {
                           break;
                        }
                        hours = (hours + 1) % 24;
                        var tr = document.createElement('tr');

                        var td1 = document.createElement('td');
                        var td2 = document.createElement('td');
                        var td3 = document.createElement('td');



                        // Minutes part from the timestamp
                        var minutes = "0" + date.getUTCMinutes();
                        // Seconds part from the timestamp
                        var seconds = "0" + date.getUTCSeconds();

                        var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

                        var text1 = document.createTextNode(formattedTime);
                        var text2 = document.createTextNode(Math.round(data["hourly"][i]["temp"]) + "°C");
                        var text3 = document.createTextNode(data["hourly"][i]["weather"][0]["description"]);

                        td1.appendChild(text1);
                        td2.appendChild(text2);
                        td3.appendChild(text3);
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                        tr.appendChild(td3);
                        table.appendChild(tr);
                     }
                     document.getElementById("divko").style.display = "block";
                  });
               }
            )
            .catch(function(err) {
               console.log('Fetch Error :-S', err);
            });
      }

      function localisation() {
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
                        var ip = data["ip"];
                        var city = data["location"]["city"];
                        var country = data["location"]["country"];
                        var lat = data["location"]["lat"];
                        var lng = data["location"]["lng"];


                        let off = data["location"]["timezone"];
                        let offset = off.replace(":", ".");
                        let datetime = calcTime(offset);
                        let date = datetime.split(",")[0];
                        var time = datetime.split(", ")[1];
                        let y = date.split(". ")[2];
                        let m = date.split(". ")[1];
                        if (m.length == 1) {
                           m = "0" + m;
                        }
                        let d = date.split(". ")[0];
                        var finalDate = y + "-" + m + "-" + d;
                        $.ajax({
                           type: "POST",
                           url: "https://wt69.fei.stuba.sk/z7mashupMK/",
                           data: {
                              ip: ip,
                              city: city,
                              country: country,
                              date: finalDate,
                              time: time,
                              lat: lat,
                              lng: lng
                           }
                        });
                        geoFindMe(lat, lng);
                     });
                  }
               )
               .catch(function(err) {
                  console.log('Fetch Error :-S', err);
               });
         }, "jsonp");
      }
   </script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>