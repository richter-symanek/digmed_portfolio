<?php
header('Content-Type: text/html; charset=utf-8');

/**
* Bietet das Skript für globale Vorgänge, das auf allen regulären Seiten eingebunden wird.
*/

// bindet Dateien für Datenbank und Funktionen ein
require_once("./lib/db.inc.php");
require_once("./lib/functions.inc.php");

// stelle Datenbankverbindung her
global $db;
$database = new DB();
$db = $database->connect();



?>