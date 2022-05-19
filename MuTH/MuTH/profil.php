<?php
require("global.inc.php");

/**
* Bietet das Skript für die Änderung der Nutzer_innendaten.
*/

// alle Klassen, die hier benötigt werden
require_once("./model/schlagwort.model.php");

// wenn die erforderlichen Daten noch nicht eingegeben wurden, wird zur Startseite weitergeleitet
if(!istGesetztName() && !istGesetztAlter() && !istGesetztInteressen()) {
	header("location: index.php");
	exit;
}
// wenn die Anwendung schon beendet wurde, wird zur Urkundenseite weitergeleitet
else if(istGesetztUrkundeId()) {
	header("location: beenden.php");
	exit;
}
// wenn das Formular abgesandt wurde, werden die Daten geändert und auf die Übersichtsseite weitergeleitet
else if(isset($_POST['send'])) {
	setName($_POST['vorname']);
	setAlter($_POST['alter']);
	$interessen = implode(",", $_POST['interessen']);
	setInteressen(addslashes($interessen));
	
	header("location: uebersicht.php");
	exit;
}

$profilTemplate = new Template("templates/profil.tpl");
$headerTemplate->set("header_titel", "Daten &auml;ndern");
$headerTemplate->set("header_symbol", "fas fa-user");

$hilfeTemplate = new Template("templates/header/hilfe.tpl");
$headerTemplate->set("header_hilfe", $hilfeTemplate->output());
$hilfeInhaltTemplate = new Template("templates/profil/hilfe.tpl");
$profilTemplate->set("hilfe", $hilfeInhaltTemplate->output());

$profilTemplate->set("vorname", getName());
$profilTemplate->set("alter", getAlter());
$interessen = explode(",", getInteressen());

// liest alle Schlagwörter für die Auswahl möglicher Interessen aus
$result=Schlagwort::getAlleSchlagworte();
while($schlagwort = $result->fetch_object("Schlagwort")) {
	$schlagwortTemplate = new Template("templates/profil/schlagwort.tpl");
	$schlagwortTemplate->set("schlagwort", $schlagwort->getSchlagwort());
	if(in_array($schlagwort->getSchlagwort(),$interessen)) $schlagwortTemplate->set("selected", " selected");
	else $schlagwortTemplate->set("selected", "");
	$schlagworteTemplates[] = $schlagwortTemplate;
}
$schlagworte = Template::merge($schlagworteTemplates);

$headerTemplate->set("header_tipp", "");
$profilTemplate->set("header", $headerTemplate->output());
$profilTemplate->set("footer", $footerTemplate->output());
$profilTemplate->set("interessen", $schlagworte);


echo $profilTemplate->output();
?>