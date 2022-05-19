<?php
require("global.inc.php");

/**
* Bietet das Skript für die Anzeige der Übersichtsseite.
*/

// alle Klassen, die hier benötigt werden
require_once("./model/tour.model.php");

//wenn die erforderlichen Daten noch nicht eingegeben wurden, wird zur Startseite weitergeleitet
if(!istGesetztName() && !istGesetztAlter() && !istGesetztInteressen()) {
	header("location: index.php");
	exit;
}
//wenn die Anwendung schon beendet wurde, wird zur Urkundenseite weitergeleitet
else if(istGesetztUrkundeId()) {
	header("location: beenden.php");
	exit;
}

$uebersichtTemplate = new Template("templates/uebersicht.tpl");
$headerTemplate->set("header_titel", "Tour&uuml;bersicht");
$headerTemplate->set("header_symbol", "fas fa-map");

//wenn die Übersichtsseite zum ersten Mal besucht wird, wird ein Skript eingebunden, das das Hilfe-Modal anzeigt, und ein Cookie gesetzt, der den Besuch der Seite markiert
if(!istGesetztCookie("uebersichtBereitsBesucht")) {
	$ersterBesuchSkriptTemplate = new Template("templates/uebersicht/erster_besuch.tpl");
	$uebersichtTemplate->set("ersterBesuchSkript", $ersterBesuchSkriptTemplate->output());
	setzeCookie("uebersichtBereitsBesucht","1");
}
else $uebersichtTemplate->set("ersterBesuchSkript", "");

$hilfeTemplate = new Template("templates/header/hilfe.tpl");
$headerTemplate->set("header_hilfe", $hilfeTemplate->output());
$hilfeInhaltTemplate = new Template("templates/uebersicht/hilfe.tpl");
$uebersichtTemplate->set("hilfe", $hilfeInhaltTemplate->output());

$uebersichtTemplate->set("hinweis", "");

//zunächst wird probiert, Touren zu finden, die sowohl Alter als auch Interessen entsprechen
$result=Tour::getTouren(getAlter(), explode(",", getInteressen()));
if($result->num_rows == 0) {
	//wenn keine Touren gefunden wurden, wird versucht, welche nur passend zum Alter zu finden
	$result=Tour::getTouren(getAlter());
	if($result->num_rows > 0) {
		$hinweisTemplate = new Template("templates/uebersicht/hinweis.tpl");
		$hinweisTemplate->set("hinweis", "Leider haben wir keine Touren passend zu deinen Interessen gefunden.");
		$uebersichtTemplate->set("hinweis", $hinweisTemplate->output());
	}
	else {
		//wenn keine Touren gefunden wurden, wird versucht, welche nur passend zu den Interessen zu finden
		$result=Tour::getTouren(0, explode(",", getInteressen()));
		
		if($result->num_rows > 0) {
			$hinweisTemplate = new Template("templates/uebersicht/hinweis.tpl");
			$hinweisTemplate->set("hinweis", "Leider haben wir keine Touren passend f&uuml;r dein Alter gefunden.");
			$uebersichtTemplate->set("hinweis", $hinweisTemplate->output());
		}
		else {
			//wenn keine Touren gefunden wurden, werden alle vorhandenen Touren ausgegeben
			$result=Tour::getTouren(0, array());
			
			if($result->num_rows > 0) {
				$hinweisTemplate = new Template("templates/uebersicht/hinweis.tpl");
				$hinweisTemplate->set("hinweis", "Leider haben wir keine Touren passend f&uuml;r dein Alter und deine Interessen gefunden.");
				$uebersichtTemplate->set("hinweis", $hinweisTemplate->output());
			}
		}
	}
}
//wenn Touren gefunden wurden, werden diese ausgegeben
if($result->num_rows > 0) {
	$i = 1;
	while($tour = $result->fetch_object("Tour")) {
		$tourTemplate = new Template("templates/uebersicht/tour.tpl");
		$tourTemplate->set("tour_id", $tour->getId());
		$tourTemplate->set("tour_name", $tour->getName());
		if($tour->getMinAlter() == $tour->getMaxAlter()) $tour->set("altersgruppe", $tour->getMaxAlter());
		else $tourTemplate->set("altersgruppe", $tour->getMinAlter()." - ".$tour->getMaxAlter());
		if($i == 1) {
			$tourTemplate->set("farbe", "1");
			$i++;
		}
		else if($i == 2) {
			$tourTemplate->set("farbe", "2");
			$i--;
		}
		//passend zum Besuchsstatus der Tour wird ein Icon und die aktuelle Punktezahl ausgegeben
		if(istGesetztCookie("tour".$tour->getId()."abgeschlossen")) {
			$iconTemplate = new Template("templates/uebersicht/icon_abgeschlossen.tpl");
			$punkte = intval(getCookieInhalt("tour".$tour->getId()."abgeschlossen"));
			$punkteTemplate = new Template("templates/uebersicht/punkte.tpl");
			$punkteTemplate->set("punkte", $punkte);
			$tourTemplate->set("punkte", $punkteTemplate->output());
		}
		else if(istGesetztCookie("tour".$tour->getId()."_ordnungsnummer")) {
			$iconTemplate = new Template("templates/uebersicht/icon_unabgeschlossen.tpl");
			$iconTemplate->set("tour_id", $tour->getId());
			$punkte = getCookieInhalt("tour".$tour->getId()."_punkte");
			$punkteTemplate = new Template("templates/uebersicht/punkte.tpl");
			$punkteTemplate->set("punkte", $punkte);
			$tourTemplate->set("punkte", $punkteTemplate->output());
		}
		else {
			$iconTemplate = new Template("templates/uebersicht/icon_unangefangen.tpl");
			$iconTemplate->set("tour_id", $tour->getId());
			$tourTemplate->set("punkte", "");
		}
		$tourTemplate->set("icon", $iconTemplate->output());
		$tourenTemplates[] = $tourTemplate;
	}

	$tourenTemplate = Template::merge($tourenTemplates);
	$uebersichtTemplate->set("touren", $tourenTemplate);
}
//wurden keine Touren gefunden, wird stattdessen ein Hinweis ausgegeben
else {
	$uebersichtTemplate->set("touren", "");
	$hinweisTemplate = new Template("templates/uebersicht/hinweis.tpl");
	$hinweisTemplate->set("hinweis", "Leider sind aktuell keine Touren verf&uuml;gbar. Versuch es doch sp&auml;ter noch einmal.");
	$uebersichtTemplate->set("hinweis", $hinweisTemplate->output());
}

$headerTemplate->set("header_tipp", "");
$uebersichtTemplate->set("header", $headerTemplate->output());
$uebersichtTemplate->set("footer", $footerTemplate->output());
$uebersichtTemplate->set("vorname", getName());

echo $uebersichtTemplate->output();
?>