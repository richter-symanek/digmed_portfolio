<?php
require("global.inc.php");

/**
* Bietet das Skript für das Abschließen der Anwendung und die Generierung der Urkunde.
*/

// alle Klassen, die hier benötigt werden
require_once("./model/tour.model.php");
require_once("./model/urkunde.model.php");

// wenn die erforderlichen Daten noch nicht eingegeben wurden, wird zur Startseite weitergeleitet
if(!istGesetztName() && !istGesetztAlter() && !istGesetztInteressen()) {
	header("location: index.php");
	exit;
}

// wenn das Formular für die Erzeugung einer Urkunde abgesandt wurde, wird diese generiert, in der Datenbank gespeichert und die Seite neu geladen
if(isset($_POST['send'])) {
	$result = Tour::getAlleTourenIds();
	$touren = array();
	$i = 0;
	// überprüft für alle bestehenden Touren, ob sie angefangen/abgeschlossen wurden und Punkte vorliegen und speichert diese Daten in einem Array
	while($tour = $result->fetch_object("Tour")) {
		if(istGesetztCookie("tour".$tour->getId()."abgeschlossen")) {
			$touren[$i] = array($tour->getId(), getCookieInhalt("tour".$tour->getId()."abgeschlossen"));
			loescheCookie("tour".$tour->getId()."abgeschlossen");
			$i++;
		}
		else if(istGesetztCookie("tour".$tour->getId()."_punkte")) {
			$touren[$i] = array($tour->getId(), getCookieInhalt("tour".$tour->getId()."_punkte"));
			loescheCookie("tour".$tour->getId()."_punkte");
			$i++;
		}
	}
	$urkunde = new Urkunde(getName());
	$urkunde_id = $urkunde->speichern($touren);
	setUrkundeId($urkunde_id);
	header("location: beenden.php");
	exit;
}
// wenn das Formular für die Löschung aller Daten (mit oder ohne vorherige Urkunde) abgesandt wurde, werden alle Cookies gelöscht und zur Startseite weitergeleitet
else if(isset($_POST['send2'])) {
	loescheAlleCookies();
	header("location: index.php");
	exit;
}
// wenn eine Urkunde bereits generiert wurde, wird deren ID auf einer eigenen Seite angezeigt zusammen mit der Option, die Anwendung neuzustarten und so alle Cookies zu löschen
else if(istGesetztUrkundeId()) {
	$beendenTemplate = new Template("templates/beenden/urkunde.tpl");
	$beendenTemplate->set("urkunde_id", getUrkundeId());
}
// die Seite zur Auswahl von Urkundengenerierung oder Abschluss der Anwendung ohne
else {
	$beendenTemplate = new Template("templates/beenden.tpl");
	$beendenTemplate->set("vorname", getName());
}

$headerTemplate->set("header_tipp", "");
$headerTemplate->set("header_titel", "Besuch beenden");
$headerTemplate->set("header_symbol", "fas fa-flag-checkered");
$hilfeTemplate = new Template("templates/header/hilfe.tpl");
$headerTemplate->set("header_hilfe", $hilfeTemplate->output());
$hilfeInhaltTemplate = new Template("templates/beenden/hilfe.tpl");
$beendenTemplate->set("hilfe", $hilfeInhaltTemplate->output());
$beendenTemplate->set("header", $headerTemplate->output());
$beendenTemplate->set("footer", $footerTemplate->output());

echo $beendenTemplate->output();
?>