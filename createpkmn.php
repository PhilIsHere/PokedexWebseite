<?php
session_start();
use App\Database;
use App\Pokedex;
include_once 'vendor/autoload.php';

/**ToDo:
 * Einlesen in display: flex
 * Unterschied zwischen display block, flex, inline, inline-block
 * Media Queries in CSS
 * Borderradius, rendern, Seite designen
 * Selektoren, Placeholder, Margin, padding, background-image
 */

/**Pokedexnummer
 * User soll eine eingabemaske sehen
 * In dieser soll er ein Pokemon anlegen können und folgende eigenschaften Anlegen können:
 *  , Name des Pokemon, Typ, Größe, Gewicht OPTIONAL: Ein Bild des Pokemon
 * Sollte der Name oder die Pokemonnummer bereits vergeben sein soll eine Fehlermeldung ausgegeben werden und das Pokemon soll stattdessen abgerufen werden können
 */

//$_GET = array('pkmnname' => 'Bisasam', 'pkmnnummer' => '1'); //DEBUG OPTION
$dbPokedex = new Pokedex('db','root','root','pokedex');//Todo: ERINNERN: PHP NUR INNERHALB VOM DOCKER CONTAINER AUSFÜHRBAR!
if (!empty($_GET)) {
    $jsonresult = array();
    if (isset($_GET['pkmnname']) || isset($_GET['pkmnnummer'])) {
        $result = $dbPokedex->getPkmnInfo($_GET['pkmnnummer'], $_GET['pkmnname']);
        if (is_array($result) && count($result) > 0) {
            $jsonresult = ['status' => 'err', 'msg' => $result['name'].' ist bereits im Pokedex aufgenommen!'];
        } else {
            $jsonresult = ['status' => 'ok', 'msg' => ''];
        }
//        var_dump($jsonresult);
    } else {
        $jsonresult = ['status' => 'err', 'msg' => 'missing fields'];
    }
    header('Content-Type: application/json');
    echo json_encode($jsonresult);
    exit();
}

$check = array();
if (array_key_exists('createpkmn', $_POST) && $_POST['createpkmn'] === '1'){
    $result = $dbPokedex->getPkmnInfo($_POST['pkmnnummer'], $_POST['pkmnname']);
    if (is_array($result)){
        $check['error'] = "pkmnexists";
        foreach ($result as $value){
            echo $value;
        }
    }else{
        $result = $dbPokedex->setPkmnInfo($_POST['pkmnnummer'], $_POST['pkmnname'], $_POST['pkmngroesse'], $_POST['pkmngewicht']);
        $check['done'] = "pkmncreated";
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="assets/sound/succsess.mp3">
    <style>
        body{
            background-image: url("https://cdn-icons-png.flaticon.com/512/188/188940.png");
        }
        .textbox_error{
            display: block;
            border: 2px solid red;
        }
        .flex-box {
            display: flex;
            flex-wrap: wrap;
            flex-direction:row;
        }
        .flex-items{
            display: inherit;
            flex-wrap: wrap;
            justify-content: space-around;
            flex-direction: column;
        }
        table, td, th {
            border: 1px solid black;
            text-align: center;
        }
        .DexColours{
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to bottom right,red, whitesmoke);
            background-size: cover;
            background-position: center center;
        }

    </style>
        <body>
    <?php if (!array_key_exists('createpkmn', $_POST) || $_POST['createpkmn'] === '2'): ?>
    <div id="error" class="error colour-error" style="display: none">

    </div>
    <form method="post">
    <div>
        <h1 style="text-align: center" class="DexColours">Willkommen im Pokedex-Log! Hier kannst du neu entdeckte Pokemon anlegen!</h1>
    </div>
        <div class="flex-box">
            <div class="flex-items">
            <div class="testklasse">
                <label for="pkmnnummer">Pokedex-Nummer:</label>
            </div>
            <div class="testklasse">
                <label for="pkmnname">Name des Pokemon:</label>
            </div>
            <div>
                <label for="pkmngroesse">Größe in cm:</label>

            </div>
            <div>
                <label for="pkmngewicht">Gewicht in kg:</label>
            </div>
            <div>
                <label for="pkmntyp">Typ:</label>
            </div>
            </div>
            <div class="flex-items">
                <div id="lookup">
                    <input type="number" id="pkmnnummer" class="inputfields" name="pkmnnummer" />
                </div>
                <div>
                    <input for="name" id="pkmnname" class="inputfields" name="pkmnname" />
                </div>
                <div>
                    <input type="number" id="pkmngroesse" name="pkmngroesse">
                </div>
                <div>
                    <input type="number" id="pkmngewicht" name="pkmngewicht">
                </div>
                <div>
                    <select id="pkmntyp" name="pkmntyp">
                        <option value="NULL"></option>
                        <option value="Normal" style="background-color: grey">Normal</option>
                        <option value="Feuer" style="background-color: red">Feuer</option>
                        <option value="Wasser" style="background-color: blue">Wasser</option>
                        <option value="Elektro" style="background-color: yellow">Elektro</option>
                        <option value="Pflanze" style="background-color: forestgreen">Pflanze</option>
                        <option value="Flug" style="background-color: lightblue">Flug</option>
                        <option value="Käfer" style="background-color: darkgreen">Käfer</option>
                        <option value="Gift" style="background-color: blueviolet">Gift</option>
                        <option value="Gestein" style="background-color: saddlebrown">Gestein</option>
                        <option value="Boden" style="background-color: sandybrown">Boden</option>
                        <option value="Kampf" style="background-color: firebrick">Kampf</option>
                        <option value="Eis" style="background-color: aliceblue">Eis</option>
                        <option value="Psycho" style="background-color: deeppink">Psycho</option>
                        <option value="Geist" style="background-color: darkviolet">Geist</option>
                        <option value="Drache" style="background-color: steelblue">Drache</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" name="createpkmn" value="1">
        <button type="submit" id="createButton" class="submitbutton">Im Pokedex eintragen</button>

    <?php elseif (array_key_exists('done', $check) && $check['done'] === "pkmncreated"): ?>
        <span>
            <div>
            <h1 style="color: dodgerblue">Das Pokemon wurde erfolgreich angelegt!</h1>
            </div>
            <h2>
                <table class="testklasse">
                    <thead>
                    <tr>
                        <th>Nummer:</th> <th>Name:</th> <th>Größe:</th> <th>Gewicht:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo '#'.$result['nummer']?></td> <td><?php echo $result['name']?></td><td><?php echo $result['groesse'].'cm' ?></td> <td><?php echo $result['gewicht'].'kg' ?></td>
                    </tr>
                    </tbody>
                </table>
            </h2>
            <h4>
                <form method="post" class="testklasse">
                    <input type="hidden" name="createpkmn" value="2">
                    <button type="submit">Möchtest du ein neues Pokémon anlegen?</button>
                </form>
            </h4>
        </span>
    <?php elseif (array_key_exists('createpkmn', $_POST) && array_key_exists('error', $check)): ?>
        <span>
            <div>
            <h1 style="color: cornflowerblue">Das Pokemon ist bereits vorhanden</h1>
            </div>
            <h2>
                <table>
                    <thead>
                    <tr>
                        <th>Nummer:</th> <th>Name:</th> <th>Größe:</th> <th>Gewicht:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
<!--                        Todo: Tabelle durch div ersetzen-->
                        <td><?php echo '#'.$result['nummer']?></td> <td><?php echo $result['name']?></td><td><?php echo $result['groesse'].'cm' ?></td> <td><?php echo $result['gewicht'].'kg' ?></td>
                    </tr>
                    </tbody>
                </table>
            </h2>
            <h4>
                <form method="post">
                    <input type="hidden" name="createpkmn" value="2">
                    <button type="submit">Möchtest du stattdessen ein neues Pokémon anlegen?</button>
                </form>
            </h4>
        </span>
    </form>
    <?php endif; ?>
    </body>
    <script type="text/javascript">
        try {
            const BASE_URL = '/createpkmn.php';

            let inputFields = document.querySelectorAll('.inputfields');
            console.log(inputFields);
            for (let i =0; i < inputFields.length; i++){
                inputFields[i].addEventListener('blur', function (lookUpPkmn){ //Todo: Anderen/Passenderen event finden, damit die Fehlermeldung bestehen bleibt
                    let pkmnnummer = document.getElementById('pkmnnummer')?.value;
                    let pkmname = document.querySelector('#pkmnname')?.value;
                    let httprequest = new XMLHttpRequest();
                    httprequest.onreadystatechange = function (){
                        console.log('readystate',this.readyState);
                        if (this.readyState === XMLHttpRequest.DONE && this.status === 200){
                            let response = JSON.parse(httprequest.response);
                            // console.log(httprequest.response);
                            if (response.status !== 'ok') {
                                // document.getElementById('lookup').innerHTML += JSON.parse(httprequest.response).msg;
                                let htmlElement = document.createElement('span');
                                let inputBoxElement = document.getElementsByClassName('inputfields');
                                // console.log(inputBoxElement);
                                // for (let i = 0; i < inputBoxElement.length; i++){
                                //     console.log(i,inputBoxElement[i]);
                                // }
                                inputBoxElement[i].classList.add('textbox_error');
                                // let htmlElementErrorCheck = document.querySelector('.textbox_error');
                                let htmlElementErrorCheck = document.querySelector('span.textbox_error');
                                if(!htmlElementErrorCheck) {
                                    htmlElement.innerHTML = response.msg; //Todo: Errormessage an die richtige Stelle (Sprich: Oberhalb des Buttons)
                                    htmlElement.style.color = 'red';
                                    htmlElement.classList.add('textbox_error');
                                    document.getElementById('lookup').appendChild(htmlElement);
                                }else {
                                    document.getElementById('lookup').removeChild(htmlElementErrorCheck);
                                }
                            }
                        }
                    };
                    // httprequest.open("GET", BASE_URL + '?pkmnname=' + pkmname + '&pkmnnummer=' + pkmnnummer );
                    httprequest.open("GET", `${BASE_URL}?pkmnname=${pkmname}&pkmnnummer=${pkmnnummer}` );
                    httprequest.send();
                });
            }

            // 1. Eingabefeld aus dem Dom (Documentobjectmodel, der HTML-Struktur) herausholen
            let submitButtonId = document.getElementById('createButton');
            // console.log('DOM', document);
            // let submitButtonIds = document.getElementsByClassName('submitbutton');
            // let singleQuery = document.querySelector('#pkmnname');
            // let allQuery = document.querySelectorAll('#form1 input');
            // 2. Auf ein Event warten
            submitButtonId.addEventListener('click', function (submitClickEvent){
                let returnValue = confirm('Bist du sicher, dass du das Pokémon anlegen möchtest?');
                if (returnValue === true){
                    alert('Das Formular wurde abgeschickt!');
                }else {
                    alert('Das Formular wurde NICHT abgeschickt!');
                    submitClickEvent.preventDefault();
                }
            });

            // submitButtonId.addEventListener('blur', function (ev) {
            //     // Hier rein kommt der Code auf das auslösen des Events ausgeführt werden soll.
            //     console.log(submitButtonIds.value);
            //     let returnValue = confirm('Das ist eine Testnachricht');
            //
            //     ev.preventDefault();
            // });
            //let pokemonName = document
            setTimeout(function () {
                let response = {'status': 'err', 'msg': 'missing fields'};
                if (response.status === 'err') {
                    let errorDiv =  document.querySelector('#error');
                    if (errorDiv) {
                        errorDiv.innerHTML = response.msg;
                        errorDiv.style.display = 'block';
                    } else {
                        throw 'Missing Element';
                    }
                }
            }, 10000);


        } catch (e) {
            console.error(e);
        }
    </script>
    </head>
</html>
