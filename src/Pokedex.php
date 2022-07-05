<?php
namespace App;
include_once __DIR__ . '/../vendor/autoload.php';

class Pokedex extends \mysqli { //Backslashes nicht vergessen, damit man das root verzeichnis und nicht Namespace: APP verzeichnis nutzt.

    public function __construct(?string $hostname = null, ?string $username = null, ?string $password = null, ?string $database = null, ?int $port = null, ?string $socket = null)
    {
        parent::__construct($hostname, $username, $password, $database, $port, $socket);
    }

    public function getPkmnInfo(int $nummer, string $name) : ?array{
        $stmtGetPkmnInfo = $this->prepare("SELECT * FROM pokemon WHERE nummer=? OR name=?");
        $stmtGetPkmnInfo->bind_param("is", $nummer, $name);
        $stmtGetPkmnInfo->execute();
//        var_dump($stmtGetPkmnInfo->get_result()->fetch_assoc());
        return $stmtGetPkmnInfo->get_result()->fetch_assoc();
    }

    public function setPkmnInfo(int $nummer, string $name, int $groesse, int $gewicht) : ?array{
        $stmtSetPkmnInfo = $this->prepare("INSERT INTO pokedex.pokemon (nummer, name, groesse, gewicht) VALUES (?,?,?,?)");
        $stmtSetPkmnInfo->bind_param("isii",$nummer, $name, $groesse, $gewicht);
        $stmtSetPkmnInfo->execute();
        return $this->getPkmnInfo($nummer, $name);
    }
}