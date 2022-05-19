<?php
require_once("global.inc.php");

/**
* Bietet das Skript für die Anzeige der statischen Seiten.
*/

$seiteTemplate = new Template("templates/seite.tpl");
$headerTemplate->set("header_symbol", "fas fa-file-alt");

if(isset($_GET['page'])) {
	$page = addslashes(trim($_GET['page']));
	$result = Seite::getSeiteByBezeichner($page);
	$seite=$result->fetch_object("Seite");
	
	if(isset($seite)) {
		$seiteTemplate->set("titel", $seite->getTitel());
		$seiteTemplate->set("inhalt", $seite->getInhalt());
		$headerTemplate->set("header_titel", $seite->getMenuetitel());
	}
	//wenn keine Seite mit dem Bezeichner gefunden wurde, wird auf eine Fehlerseite weitergeleitet
	else {
		$headerTemplate->set("header_titel", "Fehler");
		$seiteTemplate->set("titel", "Seite nicht gefunden");
		$seiteTemplate->set("inhalt", "Die Seite, die du aufrufen willst, existiert nicht. Zur&uuml;ck zur <a href=\"uebersicht.php\">&Uuml;bersicht</a>.");
	}
}
//wenn kein Seitenbezeichner angegeben wurde, wird auf eine Fehlerseite weitergeleitet
else {
	$headerTemplate->set("header_titel", "Fehler");
	$seiteTemplate->set("titel", "Seite nicht gefunden");
	$seiteTemplate->set("inhalt", "Die Seite, die du aufrufen willst, existiert nicht. Zur&uuml;ck zur <a href=\"uebersicht.php\">&Uuml;bersicht</a>.");
}

$headerTemplate->set("header_hilfe", "");
$headerTemplate->set("header_tipp", "");
$seiteTemplate->set("header", $headerTemplate->output());
$seiteTemplate->set("footer", $footerTemplate->output());

echo $seiteTemplate->output();
?>