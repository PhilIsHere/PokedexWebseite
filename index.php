<?php //Backend wird auf dem Server aufgeführt und dem User nie gezeigt.
use App\User;
use App\traits\ArrayTraits;

include_once 'vendor/autoload.php';
session_start();

if (array_key_exists('do',$_POST) && $_POST['do'] == 1) {
    //ToDo: If anweisungen für abgleich d. Mail und Passwort aus POST.
    $user = new \App\User();
    $dbPokedex = new mysqli('db','root','root','pokedex'); //Speichere die Datenbank als Variable.
    $stmtGetUserInfo = $dbPokedex->prepare("SELECT * FROM user WHERE name=? OR email=?"); //Erstelle ein neues prepared Statement.
    $stmtGetUserInfo->bind_param("ss", $_POST['username'], $_POST['email'][0]);
    $stmtGetUserInfo->execute();
    $resultSet = $stmtGetUserInfo->get_result();
    $dbResultAsAssoc = $resultSet->fetch_assoc();

    if ($dbResultAsAssoc){
        echo 'Benutzer bereits vorhanden! Bitte wähle einen anderen Benutzernamen!';
    }elseif (is_array($_POST['passwort']) && count($_POST['passwort']) ===  2 && $_POST['passwort'][0] === $_POST['passwort'][1]){
        //Todo: MySQL Befehle zum adden preparen
        $debugNewsletter = 0;
        $stmtSetUserInfo = $dbPokedex->prepare("INSERT INTO pokedex.user (name, password, email, newsletter) VALUES (?,?,?,?)"); //VALUES (".$_POST['username'].", ".$_POST['passwort'][0].', '.$_POST['email'][0].', 0;');
        $stmtSetUserInfo->bind_param('sssi',$_POST['username'],$_POST['passwort'][0],$_POST['email'][0],$debugNewsletter);
        $stmtSetUserInfo->execute();
        echo 'Benutzer erfolgreich angelegt!';
    }
    foreach ($_POST as $key => $value) {
        if  ($key === 'do'){
            continue;
        }
        $method = 'set' . ucfirst($key); // setVorname, setNachname usw.
        $user->$method(is_array($value) ? $value[0] : $value);//ruft die Methode des Users auf und übergibt "value" z.B. Philip, asd123 und weitere Werte die vom User eingegeben werden.
    }
    //echo 'Hallo '.$user->getVorname(). ' ';
}
$foo = 'bar';
$$foo = 'Tschüssi!';
// echo $foo . ' ' . $bar; //Doppel $-Zeichen nutzt den gespeicherten Wert als variablen namen, der weitergenutzt werden kann.

/**Todo Philip: Ein "Passwort wiederholen" Feld erstellen, welches den Inhalt gemeinsam mit dem Passwort-Feld als Array ans Backend übergibt und prüft ob sie übereinstimmen
 * Todo Philip: Loginseite erstellen, wenn Login erfolgreich ist, dann Session starten. Dazu ein User-Objekt fest vordefinieren.
 * Todo Philip: Sollte nebenbei noch Luft sein, dann lese dich gerne einmal on prepared Statments ein, falls diese noch kein Begriff sein sollten
*/
?>
<!--Frontend - wird im Browser des Users ausgeführt.-->
<html>
<head>
    <title>Registrierung Erforderlich!</title>
    <link rel="stylesheet" href="assets/app.css">
    <style>

    </style>
</head>
<body>
    <div id="index-wrapper"><!-- Div ist ein Container -->
        <?php if(!array_key_exists('do', $_POST)): ?>
            <form method="post">
                <h1 style="text-align: center">Bitte registriere dich jetzt!</h1>
                <h2 style="text-align: center"><a href="login.php">Oder logge dich ein!</a></h2>
                <div class="flex-box">
                    <div class="flex-items">
                        <div>
                            <label for="vorname">Vorname:</label>
                        </div>
                        <div>
                            <label for="nachname">Nachname:</label>
                        </div>
                        <div>
                            <label for="username">Gewünschter Benutzername:</label>
                        </div>
                        <div>
                            <label for="email">E-Mail Adresse:</label>
                        </div>
                        <div>
                            <label for="email_check">E-Mail Adresse wiederholen:</label>
                        </div>
                        <div>
                            <label for="passwort">Passwort<span style="color: darkred">*</span>:</label>
                        </div>
                        <div>
                            <label for="passwort_check">Passwort wiederholen:</label>
                        </div>
                    </div>
                    <div class="flex-items">
                        <div>
                            <input type="text" id="vorname" class="register" name="vorname" placeholder="Vorname"> <?php //IDs dürften pro Datei nur einmal vorkommen, Klassen beliebig oft, diese dienen dazu um angesteuert z.B. über style angesprochen zu werden ?>
                        </div>
                        <div>
                            <input type="text" id="nachname" class="register" name="nachname" placeholder="Nachname">
                        </div>
                        <div>
                            <input type="text" id="username" class="register" name="username" placeholder="Benutzername" required>
                        </div>
                        <div>
                            <input type="text" id="email" class="register" name="email[]" placeholder="E-Mail" required>
                        </div>
                        <div>
                            <input type="text" id="email_check" class="register" name="email[]" placeholder="E-Mail wiederholen" required>
                        </div>
                        <div>
                            <input type="password" id="passwort" class="register" name="passwort[]" placeholder="Passwort" required>
                        </div>
                        <div>
                            <input type="password" id="passwort_check" class="register" name="passwort[]" placeholder="Passwort wiederholen" required>
                        </div>
                    </div>
                    <div style="justify-content: center">
                        <input type="hidden" name="do" value="1">
                        <button type="submit">
                            Absenden
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <?php else: ?>
        <div>
            Das Formular wurde abgeschickt. Hallo <?= $_POST['vorname'] //<?= ist ein Shortcut der sofort den Wert der Varaible ausgibt ?>
        </div>
            <div>
                <a href="login.php">Du kannst dich nun einloggen.</a>
            </div>
    </div>
        <?php endif; ?>
<!--    <div style="background-color: red; width: 100px; height: 100px; padding-bottom: 10px; border-bottom: 5px solid black; margin-bottom: 10px;">-->
<!--        <div style="background-color: dodgerblue; width: 50px; height: 50px;"></div>-->
<!--    </div>-->
<!--<div style="background-color: darkcyan; width: 200px; height: 200px"></div>-->

</body>
</html>