<?php

use App\User;
use App\Database;

include_once 'vendor/autoload.php';
session_start(); //Startet eine Session und setzt sie als Cookie
$error = array();
/**
 * 1.) Anhand der username Angebe im Formular holen wir uns den User aus der Datenbank
 *     - Keine User-Informationen in der Datenbank => Username falsch oder nicht existent
 *     - User gefunden
 * 2.) Prüfe ob das Passwort identisch ist
 *     - Neine => Fehlermeldung
 *     - Ja => erfoglreich verifiziert
 * 3.) Erstelle dir Anhand der Informationen in der Datenbank ein User-Objekt
 * 4.) Speichere das User-Objekt in der Session
 */

if (array_key_exists('eingegeben', $_POST) && $_POST['eingegeben'] === '1'){
//$username = $_POST['username'];
//Prepared Statements nutzt man um Sicherheit und Performance zu erhöhen.
//$username = "testname'; DELETE user WHERE 1=1;"; //Negativbeispiel, da mit den direkten Statements auch User direkt mit der DB kommunizieren können und Schaden anrichten  können.
    $dbPokedex = new mysqli('db','root','root','pokedex'); //Speichere die Datenbank als Variable.
    $stmtGetUserInfo = $dbPokedex->prepare("SELECT * FROM user WHERE name=?"); //Erstelle ein neues prepared Statement.
    $stmtGetUserInfo->bind_param("s", $_POST['inputUsername']);//Für jeden im prepare angegebenen Fragezeichen muss ich den Rückgabetyp und eine Variable festlegen in der ein Wert gespeichert ist
    $stmtGetUserInfo->execute(); //Führe den prepared Statement mit dem gebundenen Parameter aus.
    //var_dump($stmtGetUserInfo->get_result()->fetch_assoc());
    $resultSet = $stmtGetUserInfo->get_result(); //Speichere die ergebnisse in der Variable
    $result = $resultSet->fetch_assoc(); //Erstellt ein Array um jede Zeile zu speichern

    if (is_array($result) && $result['password'] === $_POST['inputPasswort']){//ToDo: Paramenter mit Datenbankabfragen anpassen
        $user = new User();
        $user->setUsername($_POST['inputUsername']);
        $user->setEmail($result['email']);

        $_SESSION['user'] = $user;
    } else {
        $error['falscheEingabe'] = 'Username oder Passwort falsch';
    }
} elseif (array_key_exists('loggingout', $_GET) && $_GET['loggingout'] === '1') {
    unset($_SESSION['user']);
}
?>

<head>
    <style>
        .error{
            border: 1px solid red;
        }
        /*.login{*/
        /*    font-family: sans-serif;*/
        /*    color: aqua;*/
        /*}*/
        /*
        In CSS werden genauere Eigenschaften priorisiert. Ein Element, was eine Klasse und eine ID zuweisung bezüglich Farben hat,
        wird die Farbe der ID bevorzugen, da die ID eindeutiger gegenüber der Klasse ist.
        */
        /*#labelInputUsername {*/
        /*    color: aqua;*/
        /*}*/
    </style>
    <title>Hallöchen!</title>

</head>
<body>
  <?php if(!array_key_exists('user', $_SESSION)): ?>
<!--  Ein Span ist ein Blanko HTML tag, der keine besonderen Eingenschaften mitbringt. Es ist nichts vordefiniert was eine hohe flexibilität ermöglicht.-->
    <h1>Bitte logge dich ein</h1>
<!--  Über php kann man mit Abfragen auch CSS-Klassen einbinden bzw. so lange auslagern, bis eine bestimmte Situation eintritt.-->
      <form method="post" class="<?= (!empty($error) && array_key_exists('falscheEingabe', $error)) ? 'error' : ''?>" action="login.php">
          <?php if (!empty($error) && array_key_exists('falscheEingabe', $error)): ?>
          <div>
              <?= $error['falscheEingabe'] ?>
          </div>
          <?php endif; ?>
      <div>
          <label for="inputUsername" class="register" id="labelInputUsername">Username:</label>
          <input type="text" id="inputUsername" name="inputUsername">
      </div> <?php //Divs entfernen packt alles auf eine Zeile. Aber wenn auch Passwort rot sein soll dann doppelter code?? ?>
      <div>
          <label for="inputPasswort" class="register">Passwort:</label>
          <input type="password" id="inputPasswort" name="inputPasswort">
<!--          Für unkritische Dinge kann man via CSS bestimmte Elemente verstecken. Hierfür kann via PHP eine Bedingung eingegeben werden.-->
      <div>
          <span>Passwort vergessen?</span>
      </div>
      </div>
          <input type="hidden" name="eingegeben" value="1">
          <button>Absenden</button>
      </form>
    <?php else: ?>
        <div>
            <p>
                Herzlich willkommen <?= $_SESSION['user']->getUsername() ?>
            </p>
            <div>
                Du kannst: <a href="createpkmn.php">Ein neues Pokemon anlegen</a>
            </div>
            <a href="/login.php?loggingout=1">Logout</a>
        </div>
    <?php endif; ?>
</body>
