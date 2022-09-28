<!DOCTYPE html>
<html lang="sk">

<head>
   <meta charset="utf-8">
   <title>Zadanie 6 WEBTE2</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   <script>
      $(document).ready(function() {
         $("#getNamedayName").click(function(a) {
            a.preventDefault();
            $.ajax({
               url: "https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/read.php",
               type: "get",
               data: {
                  day: $("#day").val(),
                  month: $("#month").val(),
                  country: $("#country").val(),
               },
               success: function(data) {
                  document.getElementById("data").innerHTML = "";
                  for (i = 0; i < data.length; i++) {
                     document.getElementById("data").innerHTML += data[i]["value"] + "<br>";
                  }
               }
            })
         });
         $("#getNamedayDate").click(function(b) {
            b.preventDefault();
            $.ajax({
               url: "https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/read.php",
               type: "get",
               data: {
                  name: $("#name").val(),
                  country: $("#state").val(),
               },
               success: function(data) {
                  document.getElementById("data").innerHTML = "";
                  for (i = 0; i < data.length; i++) {
                     document.getElementById("data").innerHTML += data[i]["day"];
                     document.getElementById("data").innerHTML += ". ";
                     document.getElementById("data").innerHTML += data[i]["month"] + "." + "<br>";
                  }
               }
            })
         });
         $("#getHolidays").click(function(cd) {
            cd.preventDefault();
            $.ajax({
               url: "https://wt69.fei.stuba.sk/z6RESTapiXK/api/holiday/read.php",
               type: "get",
               data: {
                  code: $("#code").val(),
               },
               success: function(data) {
                  document.getElementById("data").innerHTML = "";
                  for (i = 0; i < data.length; i++) {
                     document.getElementById("data").innerHTML += data[i]["day"];
                     document.getElementById("data").innerHTML += ". ";
                     document.getElementById("data").innerHTML += data[i]["month"];
                     document.getElementById("data").innerHTML += ". ";
                     document.getElementById("data").innerHTML += data[i]["value"] + "<br>";
                  }
               }
            })
         });
         $("#getMemorialDays").click(function(e) {
            e.preventDefault();
            $.ajax({
               url: "https://wt69.fei.stuba.sk/z6RESTapiXK/api/memorial_day/read.php",
               type: "get",
               data: '',
               success: function(data) {
                  document.getElementById("data").innerHTML = "";
                  for (i = 0; i < data.length; i++) {
                     document.getElementById("data").innerHTML += data[i]["day"];
                     document.getElementById("data").innerHTML += ". ";
                     document.getElementById("data").innerHTML += data[i]["month"];
                     document.getElementById("data").innerHTML += ". ";
                     document.getElementById("data").innerHTML += data[i]["value"] + "<br>";
                  }
               }
            })
         });
         $("#postName").click(function(f) {
            f.preventDefault();
            $.ajax({
               url: "https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/create.php",
               type: "post",
               data: {
                  name: $("#meno").val(),
                  day: $("#den").val(),
                  month: $("#mesiac").val(),
               },
               success: function(data) {
                  document.getElementById("data").innerHTML = "";
                  document.getElementById("data").innerHTML += data["message"] + "<br>";
               }
            })
         });
      });
   </script>
</head>

<body>
   <div class="container">
      <h1>Kalendár - REST API</h1>
      <div class="row">
         <div class="col">
            <form action="#" method="get">
               <h2>Variant a)</h2>
               <h6>Zistí, kto má v daný deň meniny na základe dňa, mesiaca a krajiny.</h6>
               <div class="form-group">
                  <label for="day">Deň</label>
                  <input type="number" required id="day" name="day" min="1" max="31" class="form-control">
                  <label for="month">Mesiac</label>
                  <input type="number" required id="month" name="month" min="1" max="12" class="form-control">
                  <label for="country">Krajina</label>
                  <select name="country" id="country" class="form-control">
                     <option value="Maďarsko">Maďarsko</option>
                     <option value="Poľsko">Poľsko</option>
                     <option value="Rakúsko">Rakúsko</option>
                     <option value="Slovensko">Slovensko</option>
                     <option value="Česko">Česko</option>
                  </select>
               </div>

               <button id="getNamedayName" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odoslať požiadavku</button>
            </form>
         </div>

         <div class="col">
            <form action="#" method="get">
               <h2>Variant b)</h2>
               <h6>Zistí, kedy má osoba meniny na základe mena a štátu.</h6>
               <div class="form-group">
                  <label for="name">Meno</label>
                  <input type="text" required id="name" name="name" class="form-control">
                  <label for="state">Krajina</label>
                  <select name="country" id="state" class="form-control">
                     <option value="Maďarsko">Maďarsko</option>
                     <option value="Poľsko">Poľsko</option>
                     <option value="Rakúsko">Rakúsko</option>
                     <option value="Slovensko">Slovensko</option>
                     <option value="Česko">Česko</option>
                  </select>
               </div>

               <button id="getNamedayDate" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odoslať požiadavku</button>
            </form>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <form action="#" method="get">
               <h2>Variant c), d)</h2>
               <h6>Vráti zoznam všetkých sviatkov na Slovensku alebo v Česku.</h6>
               <div class="form-group">
                  <label for="code">Kód krajiny</label>
                  <select name="code" id="code" class="form-control">
                     <option value="SK">SK</option>
                     <option value="CZ">CZ</option>
                  </select>
               </div>

               <button id="getHolidays" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odoslať požiadavku</button>
            </form>
         </div>



         <div class="col">
            <form action="#" method="get">
               <h2>Variant e)</h2>
               <h6>Vráti zoznam všetkých pamätných dní na Slovensku.</h6>
               <button id="getMemorialDays" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odoslať požiadavku</button>
               <!---->
            </form>
         </div>

         <div class="col">
            <form action="#" method="post">
               <h2>Variant f)</h2>
               <h6>Pridá nové meniny do databázy Slovenských mien na základe mena, dňa a mesiaca.</h6>
               <div class="form-group">
                  <label for="meno">Meno</label>
                  <input type="text" required id="meno" name="name" class="form-control">
                  <label for="den">Deň</label>
                  <input type="number" required id="den" name="day" min="1" max="31" class="form-control">
                  <label for="mesiac">Mesiac</label>
                  <input type="number" required id="mesiac" name="month" min="1" max="12" class="form-control">
               </div>

               <button id="postName" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odoslať požiadavku</button>
            </form>
         </div>
      </div>
   </div>

   <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Výstup API:</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body text-center" id="data">

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvoriť</button>
            </div>
         </div>
      </div>
   </div>
   
   <br>
   <div class="container" id="documentation">
      <h2 style="background-color: white; color: black; font-weight: bold;">Dokumentácia REST API</h2>
      <p>Hlavička API je header('Access-Control-Allow-Origin: *');
         header('Content-Type: application/json');</p>
      <p>Pri správnom spracovaní GET požiadavky sa vráti http response code 200, pri správnom spracovaní POST požiadavky sa vráti http response code 201, ak je neúspešný, tak 503.</p>
      <p>Pomocou ajaxu sa posiela požiadavka, vrátené dáta sú naformátované vo formáte json, a tie sa ďalej spracujú a vložia do modalu.</p>
      <br><br>
      <p><b>Variant a)</b></p>
      <p>Metóda: GET, Príklad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/read.php?day=14&month=8&country=Rakúsko</p>
      <p>Návratený kód: 200, Navrátené dáta: [
         {
         "id": "2658",
         "value": "Maximilian"
         }
         ]</p>
         <p><b>Variant b)</b></p>
      <p>Metóda: GET, Príklad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/read.php?name=Balázs&country=Maďarsko</p>
      <p>Návratený kód: 200, Navrátené dáta: [
         {
         "id": "34",
         "day": "3",
         "month": "2"
         }
         ]</p>
         <p><b>Variant c) a d)</b></p>
      <p>Metóda: GET, Príklad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/holiday/read.php?code=SK</p>
      <p>Návratený kód: 200, Navrátené dáta: [
         {
         "id": "5",
         "day": "1",
         "month": "1",
         "value": "Deň vzniku Slovenskej republiky"
         },
         {
         "id": "1412",
         "day": "1",
         "month": "5",
         "value": "Sviatok práce"
         },
         {
         "id": "2860",
         "day": "1",
         "month": "9",
         "value": "Deň ústavy Slovenskej republiky"
         },
         {
         "id": "3591",
         "day": "1",
         "month": "11",
         "value": "Sviatok všetkých svätých"
         },
         {
         "id": "2206",
         "day": "5",
         "month": "7",
         "value": "Sviatok svätého Cyrila a Metoda"
         },
         {
         "id": "73",
         "day": "6",
         "month": "1",
         "value": "Zjavenie Pána (Traja králi a vianočný sviatok pravoslávnych kresťanov)"
         },
         {
         "id": "1501",
         "day": "8",
         "month": "5",
         "value": "Deň víťazstva nad fašizmom"
         },
         {
         "id": "3063",
         "day": "15",
         "month": "9",
         "value": "Sedembolestná Panna Mária"
         },
         {
         "id": "3756",
         "day": "17",
         "month": "11",
         "value": "Deň boja za slobodu a demokraciu"
         },
         {
         "id": "4156",
         "day": "24",
         "month": "12",
         "value": "Štedrý deň"
         },
         {
         "id": "4162",
         "day": "25",
         "month": "12",
         "value": "Prvý sviatok vianočný"
         },
         {
         "id": "4171",
         "day": "26",
         "month": "12",
         "value": "Druhý sviatok vianočný"
         },
         {
         "id": "2825",
         "day": "29",
         "month": "8",
         "value": "Výročie Slovenského národného povstania"
         }
         ]</p>
         <p><b>Variant e)</b></p>
      <p>Metóda: GET, Príklad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/memorial_day/read.php</p>
      <p>Návratený kód: 200, Navrátené dáta: [
         {
         "id": "999",
         "day": "25",
         "month": "3",
         "value": "Deň zápasu za ľudské práva"
         },
         {
         "id": "1208",
         "day": "13",
         "month": "4",
         "value": "Deň nespravodlivo stíhaných"
         },
         {
         "id": "1451",
         "day": "4",
         "month": "5",
         "value": "Výročie úmrtia M.R. Štefánika"
         },
         {
         "id": "1850",
         "day": "7",
         "month": "6",
         "value": "Výročie Memoranda národa slovenského"
         },
         {
         "id": "2208",
         "day": "5",
         "month": "7",
         "value": "Deň zahraničných Slovákov"
         },
         {
         "id": "2342",
         "day": "17",
         "month": "7",
         "value": "Výročie Deklarácie o zvrchovanosti Slovenskej republiky"
         },
         {
         "id": "2551",
         "day": "4",
         "month": "8",
         "value": "Deň Matice slovenskej"
         },
         {
         "id": "3102",
         "day": "19",
         "month": "9",
         "value": "Deň prvého verejného vystúpenia Slovenskej národnej rady"
         },
         {
         "id": "3291",
         "day": "6",
         "month": "10",
         "value": "Deň obetí Dukly"
         },
         {
         "id": "3529",
         "day": "27",
         "month": "10",
         "value": "Deň černovskej tragédie"
         },
         {
         "id": "3554",
         "day": "29",
         "month": "10",
         "value": "Deň narodenia Ľudovíta Štúra"
         },
         {
         "id": "3570",
         "day": "30",
         "month": "10",
         "value": "Výročie Deklarácie slovenského národa"
         },
         {
         "id": "3581",
         "day": "31",
         "month": "10",
         "value": "Deň reformácie"
         },
         {
         "id": "4213",
         "day": "30",
         "month": "12",
         "value": "Deň vyhlásenia Slovenska za samostatnú cirkevnú provinciu"
         }
         ]</p>
      <p><b>Variant f)</b></p>
      <p>Metóda: POST, Príklad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/create.php , Parametre v Body: name: Gargamel, day: 5, month: 11</p>
      <p>Návratený kód: 200, Navrátené dáta: Meno bolo pridané do databázy.</p>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>