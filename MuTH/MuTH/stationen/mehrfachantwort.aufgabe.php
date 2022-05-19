<?php
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Bestimmt, was auf der Aufgabenseite von Mehrfachantwortfragen angezeigt wird, wie dort getätigte Anworten ausgewertet werden und gibt das Ergebnis an das Auswertungsseiten-Skript.
*/

$result = Station_Mehrfachantwort::getMehrfachantwortStationByStationId($station_id);
$station = $result->fetch_object("Station_Mehrfachantwort");

//wenn schon Daten gesendet (also die Aufgabe bearbeitet wurde), werden diese verarbeitet und dann auf die Auswertungsseite weitergeleitet
if(isset($_POST['send'])) {
	$result = $station->getAntwortmoeglichkeiten();
	$feedback = "";
	$punkteSum = 0;
	while($antwortmoeglichkeit = $result->fetch_object("Antwortmoeglichkeit")) {
		//Antwortmöglichkeiten, bei denen Nutzer_in richtig lag
		if($antwortmoeglichkeit->richtig == intval($_POST['antwort'.$antwortmoeglichkeit->getId()])) {
			$punkteSum += $station->getPunkte();
			//Antwort wurde richtigerweise als korrekt markiert --> werden grün markiert
			if($antwortmoeglichkeit->richtig) $feedback .= $antwortmoeglichkeit->getId()."xgreen_checked-";
			//Antwort wurde richtigerweise nicht markiert --> werden ausgegraut markiert
			else $feedback .= $antwortmoeglichkeit->getId()."xgrey_not-";
		}
		//Antwortmöglichkeiten, bei denen Nutzer_in falsch lag
		else if($antwortmoeglichkeit->richtig != intval($_POST['antwort'.$antwortmoeglichkeit->getID()])) {
			//Antwort wurde fälschlicherweise nicht markiert --> werden rot markiert
			if($antwortmoeglichkeit->richtig) $feedback .= $antwortmoeglichkeit->getId()."xred_not-";
			//Antwort wurde fälschlicherweise als korrekt markiert --> werden rot markiert
			else $feedback .= $antwortmoeglichkeit->getId()."xred_checked-";
		}
		else $feedback .= $antwortmoeglichkeit->getId()."xirgendwaslaueftfalsch_checked%";
	}
	$punkte = $punkteSum + getAktuellePunkte($tour_id);
	setPunkte($tour_id, $punkte);
	//die aktuelle Ordnungsnummer wird bereits erhöht, allerdings zunächst per GET-Parameter zu Auswertungsseite der aktuellen Ordnungsnummer weitergeleitet
	setOrdnungsnummer($tour_id, getAktuelleOrdnungsnummer($tour_id) + 1);
	//per GET-Parameter wird übergeben, ob die Frage richtig beantwortet und wie viele Punkte dabei erreicht wurden
	header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=auswertung&richtig=".$feedback."&punkte=".$punkteSum);
	exit;
}
//ansonsten wird die Frageseite abgerufen und angezeigt
else {
	$tourTemplate = new Template("templates/tour/aufgabe.tpl");
	$tourTemplate->set("tour_id", $tour_id);
	$tourTemplate->set("ordnungsnummer", $ordnungsnummer);
	$inhaltTemplate = new Template("templates/tour/".$station_typ."/inhalt_aufgabe.tpl");

	$inhaltTemplate->set("frage", $station->getFrage());
	if($station->getHatBild()){
		$bildTemplate = new Template("templates/tour/station_bild.tpl");
		$bildTemplate->set("url", $station->getBildURL());
		$inhaltTemplate->set("bild", $bildTemplate->output());
	}
	else $inhaltTemplate->set("bild", "");
	
	//die Antwortmöglichkeiten für die aktuelle Frage werden abgerufen und aufbereitet
	$result = $station->getAntwortmoeglichkeiten();
	while($antwortmoeglichkeit = $result->fetch_object("Antwortmoeglichkeit")) {
		$antwortTemplate = new Template("templates/tour/mehrfachantwort/antwort.tpl");
		$antwortTemplate->set("id", $antwortmoeglichkeit->getId());
		$antwortTemplate->set("antwort", $antwortmoeglichkeit->getAntwort());
		$antwortTemplates[] = $antwortTemplate;
	}
	$antwortTemplate2 = Template::merge($antwortTemplates);
	$inhaltTemplate->set("antworten", $antwortTemplate2);
	
	$tourTemplate->set("inhalt", $inhaltTemplate->output());
	$headerTemplate->set("header_titel", "Station ".$ordnungsnummer);
}
?>