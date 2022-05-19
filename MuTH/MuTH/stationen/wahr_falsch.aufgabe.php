<?php
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Bestimmt, was auf der Aufgabenseite von Wahr-Falsch-Fragen angezeigt wird, wie dort getätigte Anworten ausgewertet werden und gibt das Ergebnis an das Auswertungsseiten-Skript.
*/

$result = Station_Wahr_Falsch::getWahrFalschStationByStationId($station_id);
$station = $result->fetch_object("Station_Wahr_Falsch");

//wenn schon Daten gesendet (also die Aufgabe bearbeitet wurde), werden diese verarbeitet und dann auf die Auswertungsseite weitergeleitet
if(isset($_POST['send'])) {
	$user_antwort = intval($_POST['antwort']);
	$punkteSum = 0;
	//prüft, ob die Frage richtig beantwortet wurde und erhöht entsprechend die Tourpunkte
	if($user_antwort == $station->getAntwort()) {
		$korrekt_beantwortet = 1;
		$punkte = $station->getPunkte() + getAktuellePunkte($tour_id);
		setPunkte($tour_id, $punkte);
		$punkteSum += $station->getPunkte();
	}
	else $korrekt_beantwortet = 0;
	//die aktuelle Ordnungsnummer wird bereits erhöht, allerdings zunächst per GET-Parameter zu Auswertungsseite der aktuellen Ordnungsnummer weitergeleitet
	setOrdnungsnummer($tour_id, getAktuelleOrdnungsnummer($tour_id) + 1);
	//per GET-Parameter wird übergeben, ob die Frage richtig beantwortet und wie viele Punkte dabei erreicht wurden
	header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=auswertung&richtig=".$korrekt_beantwortet."&punkte=".$punkteSum);
	exit;
}
//ansonsten wird die Frageseite abgerufen und angezeigt
else {
	$tourTemplate = new Template("templates/tour/aufgabe.tpl");
	$tourTemplate->set("tour_id", $tour_id);
	$tourTemplate->set("ordnungsnummer", $ordnungsnummer);
	$inhaltTemplate = new Template("templates/tour/".$station_typ."/inhalt_aufgabe.tpl");
	
	if($station->getHatBild()){
		$bildTemplate = new Template("templates/tour/station_bild.tpl");
		$bildTemplate->set("url", $station->getBildURL());
		$inhaltTemplate->set("bild", $bildTemplate->output());
	}
	else $inhaltTemplate->set("bild", "");

	$inhaltTemplate->set("aussage", $station->getAussage());
	$tourTemplate->set("inhalt", $inhaltTemplate->output());
	$headerTemplate->set("header_titel", "Station ".$ordnungsnummer);
}
?>