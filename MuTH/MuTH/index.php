<?php
require_once("global.inc.php");

/**
* Bietet das Skript für die Startseite.
*/

// wenn die Anwendung schon beendet wurde, wird zur Urkundenseite weitergeleitet
if(istGesetztUrkundeId()) {
	header("location: beenden.php");
	exit;
}
// wenn die Nutzer_innendaten schon gesetzt wurden, wird auf die Übersichtsseite weitergeleitet
else if(istGesetztName() && istGesetztAlter() && istGesetztInteressen()) {
	header("location: uebersicht.php");
	exit;
}
// wenn die Nutzer_innendaten nur teilweise gesetzt wurden, wird zum Willkommensskript weitergeleitet
else if(istGesetztName() || istGesetztAlter() || istGesetztInteressen()) {
	header("location: willkommen.php");
	exit;
}

$indexTemplate = new Template("templates/index.tpl");
$headerTemplate->set("header_titel", "Startseite");
$headerTemplate->set("header_symbol", "fas fa-home");

$headerTemplate->set("header_hilfe", "");
$headerTemplate->set("header_tipp", "");
$indexTemplate->set("header", $headerTemplate->output());
$indexTemplate->set("footer", $footerTemplate->output());

echo $indexTemplate->output();
?>