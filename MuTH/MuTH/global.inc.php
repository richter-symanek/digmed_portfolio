<?php
header("Content-Type: text/html; charset=ANSI");

/**
* Bietet das Skript für globale Vorgänge, das auf allen regulären Seiten eingebunden wird.
*/

// bindet Dateien für Datenbank, Funktionen und Template Engine ein
require_once("./lib/db.inc.php");
require_once("./lib/functions.inc.php");
require_once("./lib/template.class.php");

// stelle Datenbankverbindung her
global $db;
$database = new DB();
$db = $database->connect();

// alle Klassen, die hier benötigt werden
require_once("./model/seite.model.php");

$headerTemplate = new Template("templates/header.tpl");
$footerTemplate = new Template("templates/footer.tpl");
$parse_url = parse_url($_SERVER['REQUEST_URI']);

// liest alle statischen Seiten aus, um diese im Menü anzuzeigen
$result = Seite::getAlleSeiten();
if($result->num_rows > 0) {
	while($seite = $result->fetch_object("Seite")) {
		if($seite->getBezeichner() != "" && $seite->getMenuetitel() != "" && empty(strstr($parse_url['query'],$seite->getBezeichner()))) {
			$menueSeite = new Template("templates/header/statische_seite.tpl");
			$menueSeite->set("seite_bezeichner", $seite->getBezeichner());
			$menueSeite->set("seite_menuetitel", $seite->getMenuetitel());
			$menueSeitenTemplates[] = $menueSeite;
		}
	}

	$menueSeitenTemplate = Template::merge($menueSeitenTemplates);
	$headerTemplate->set("header_menueSeiten", $menueSeitenTemplate);
}

// der Link zur Übersichtsseite/Startseite wird auf dieser selbst nicht angezeigt
if(empty(strstr($parse_url['path'],"uebersicht.php"))) {
	if(istGesetztName() && istGesetztAlter() && istGesetztInteressen()) {
		$uebersichtSeite = new Template("templates/header/uebersicht.tpl");
		$headerTemplate->set("header_tourUebersicht_start", $uebersichtSeite->output());
	}
	else if(empty(strstr($parse_url['path'],"index.php")) || empty(strstr($parse_url['path'],".php"))) {
		$startSeite = new Template("templates/header/startseite.tpl");
		$headerTemplate->set("header_tourUebersicht_start", $startSeite->output());
	}
	else $headerTemplate->set("header_tourUebersicht_start", "");
}
else $headerTemplate->set("header_tourUebersicht_start", "");
?>