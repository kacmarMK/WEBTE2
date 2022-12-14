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
      <h1>Kalend??r - REST API</h1>
      <div class="row">
         <div class="col">
            <form action="#" method="get">
               <h2>Variant a)</h2>
               <h6>Zist??, kto m?? v dan?? de?? meniny na z??klade d??a, mesiaca a krajiny.</h6>
               <div class="form-group">
                  <label for="day">De??</label>
                  <input type="number" required id="day" name="day" min="1" max="31" class="form-control">
                  <label for="month">Mesiac</label>
                  <input type="number" required id="month" name="month" min="1" max="12" class="form-control">
                  <label for="country">Krajina</label>
                  <select name="country" id="country" class="form-control">
                     <option value="Ma??arsko">Ma??arsko</option>
                     <option value="Po??sko">Po??sko</option>
                     <option value="Rak??sko">Rak??sko</option>
                     <option value="Slovensko">Slovensko</option>
                     <option value="??esko">??esko</option>
                  </select>
               </div>

               <button id="getNamedayName" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odosla?? po??iadavku</button>
            </form>
         </div>

         <div class="col">
            <form action="#" method="get">
               <h2>Variant b)</h2>
               <h6>Zist??, kedy m?? osoba meniny na z??klade mena a ??t??tu.</h6>
               <div class="form-group">
                  <label for="name">Meno</label>
                  <input type="text" required id="name" name="name" class="form-control">
                  <label for="state">Krajina</label>
                  <select name="country" id="state" class="form-control">
                     <option value="Ma??arsko">Ma??arsko</option>
                     <option value="Po??sko">Po??sko</option>
                     <option value="Rak??sko">Rak??sko</option>
                     <option value="Slovensko">Slovensko</option>
                     <option value="??esko">??esko</option>
                  </select>
               </div>

               <button id="getNamedayDate" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odosla?? po??iadavku</button>
            </form>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <form action="#" method="get">
               <h2>Variant c), d)</h2>
               <h6>Vr??ti zoznam v??etk??ch sviatkov na Slovensku alebo v ??esku.</h6>
               <div class="form-group">
                  <label for="code">K??d krajiny</label>
                  <select name="code" id="code" class="form-control">
                     <option value="SK">SK</option>
                     <option value="CZ">CZ</option>
                  </select>
               </div>

               <button id="getHolidays" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odosla?? po??iadavku</button>
            </form>
         </div>



         <div class="col">
            <form action="#" method="get">
               <h2>Variant e)</h2>
               <h6>Vr??ti zoznam v??etk??ch pam??tn??ch dn?? na Slovensku.</h6>
               <button id="getMemorialDays" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odosla?? po??iadavku</button>
               <!---->
            </form>
         </div>

         <div class="col">
            <form action="#" method="post">
               <h2>Variant f)</h2>
               <h6>Prid?? nov?? meniny do datab??zy Slovensk??ch mien na z??klade mena, d??a a mesiaca.</h6>
               <div class="form-group">
                  <label for="meno">Meno</label>
                  <input type="text" required id="meno" name="name" class="form-control">
                  <label for="den">De??</label>
                  <input type="number" required id="den" name="day" min="1" max="31" class="form-control">
                  <label for="mesiac">Mesiac</label>
                  <input type="number" required id="mesiac" name="month" min="1" max="12" class="form-control">
               </div>

               <button id="postName" class="btn btn-dark btn-block" data-toggle="modal" data-target="#exampleModal">Odosla?? po??iadavku</button>
            </form>
         </div>
      </div>
   </div>

   <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">V??stup API:</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body text-center" id="data">

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori??</button>
            </div>
         </div>
      </div>
   </div>
   
   <br>
   <div class="container" id="documentation">
      <h2 style="background-color: white; color: black; font-weight: bold;">Dokument??cia REST API</h2>
      <p>Hlavi??ka API je header('Access-Control-Allow-Origin: *');
         header('Content-Type: application/json');</p>
      <p>Pri spr??vnom spracovan?? GET po??iadavky sa vr??ti http response code 200, pri spr??vnom spracovan?? POST po??iadavky sa vr??ti http response code 201, ak je ne??spe??n??, tak 503.</p>
      <p>Pomocou ajaxu sa posiela po??iadavka, vr??ten?? d??ta s?? naform??tovan?? vo form??te json, a tie sa ??alej spracuj?? a vlo??ia do modalu.</p>
      <br><br>
      <p><b>Variant a)</b></p>
      <p>Met??da: GET, Pr??klad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/read.php?day=14&month=8&country=Rak??sko</p>
      <p>N??vraten?? k??d: 200, Navr??ten?? d??ta: [
         {
         "id": "2658",
         "value": "Maximilian"
         }
         ]</p>
         <p><b>Variant b)</b></p>
      <p>Met??da: GET, Pr??klad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/read.php?name=Bal??zs&country=Ma??arsko</p>
      <p>N??vraten?? k??d: 200, Navr??ten?? d??ta: [
         {
         "id": "34",
         "day": "3",
         "month": "2"
         }
         ]</p>
         <p><b>Variant c) a d)</b></p>
      <p>Met??da: GET, Pr??klad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/holiday/read.php?code=SK</p>
      <p>N??vraten?? k??d: 200, Navr??ten?? d??ta: [
         {
         "id": "5",
         "day": "1",
         "month": "1",
         "value": "De?? vzniku Slovenskej republiky"
         },
         {
         "id": "1412",
         "day": "1",
         "month": "5",
         "value": "Sviatok pr??ce"
         },
         {
         "id": "2860",
         "day": "1",
         "month": "9",
         "value": "De?? ??stavy Slovenskej republiky"
         },
         {
         "id": "3591",
         "day": "1",
         "month": "11",
         "value": "Sviatok v??etk??ch sv??t??ch"
         },
         {
         "id": "2206",
         "day": "5",
         "month": "7",
         "value": "Sviatok sv??t??ho Cyrila a Metoda"
         },
         {
         "id": "73",
         "day": "6",
         "month": "1",
         "value": "Zjavenie P??na (Traja kr??li a viano??n?? sviatok pravosl??vnych kres??anov)"
         },
         {
         "id": "1501",
         "day": "8",
         "month": "5",
         "value": "De?? v????azstva nad fa??izmom"
         },
         {
         "id": "3063",
         "day": "15",
         "month": "9",
         "value": "Sedembolestn?? Panna M??ria"
         },
         {
         "id": "3756",
         "day": "17",
         "month": "11",
         "value": "De?? boja za slobodu a demokraciu"
         },
         {
         "id": "4156",
         "day": "24",
         "month": "12",
         "value": "??tedr?? de??"
         },
         {
         "id": "4162",
         "day": "25",
         "month": "12",
         "value": "Prv?? sviatok viano??n??"
         },
         {
         "id": "4171",
         "day": "26",
         "month": "12",
         "value": "Druh?? sviatok viano??n??"
         },
         {
         "id": "2825",
         "day": "29",
         "month": "8",
         "value": "V??ro??ie Slovensk??ho n??rodn??ho povstania"
         }
         ]</p>
         <p><b>Variant e)</b></p>
      <p>Met??da: GET, Pr??klad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/memorial_day/read.php</p>
      <p>N??vraten?? k??d: 200, Navr??ten?? d??ta: [
         {
         "id": "999",
         "day": "25",
         "month": "3",
         "value": "De?? z??pasu za ??udsk?? pr??va"
         },
         {
         "id": "1208",
         "day": "13",
         "month": "4",
         "value": "De?? nespravodlivo st??han??ch"
         },
         {
         "id": "1451",
         "day": "4",
         "month": "5",
         "value": "V??ro??ie ??mrtia M.R. ??tef??nika"
         },
         {
         "id": "1850",
         "day": "7",
         "month": "6",
         "value": "V??ro??ie Memoranda n??roda slovensk??ho"
         },
         {
         "id": "2208",
         "day": "5",
         "month": "7",
         "value": "De?? zahrani??n??ch Slov??kov"
         },
         {
         "id": "2342",
         "day": "17",
         "month": "7",
         "value": "V??ro??ie Deklar??cie o zvrchovanosti Slovenskej republiky"
         },
         {
         "id": "2551",
         "day": "4",
         "month": "8",
         "value": "De?? Matice slovenskej"
         },
         {
         "id": "3102",
         "day": "19",
         "month": "9",
         "value": "De?? prv??ho verejn??ho vyst??penia Slovenskej n??rodnej rady"
         },
         {
         "id": "3291",
         "day": "6",
         "month": "10",
         "value": "De?? obet?? Dukly"
         },
         {
         "id": "3529",
         "day": "27",
         "month": "10",
         "value": "De?? ??ernovskej trag??die"
         },
         {
         "id": "3554",
         "day": "29",
         "month": "10",
         "value": "De?? narodenia ??udov??ta ??t??ra"
         },
         {
         "id": "3570",
         "day": "30",
         "month": "10",
         "value": "V??ro??ie Deklar??cie slovensk??ho n??roda"
         },
         {
         "id": "3581",
         "day": "31",
         "month": "10",
         "value": "De?? reform??cie"
         },
         {
         "id": "4213",
         "day": "30",
         "month": "12",
         "value": "De?? vyhl??senia Slovenska za samostatn?? cirkevn?? provinciu"
         }
         ]</p>
      <p><b>Variant f)</b></p>
      <p>Met??da: POST, Pr??klad: https://wt69.fei.stuba.sk/z6RESTapiXK/api/person/create.php , Parametre v Body: name: Gargamel, day: 5, month: 11</p>
      <p>N??vraten?? k??d: 200, Navr??ten?? d??ta: Meno bolo pridan?? do datab??zy.</p>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>