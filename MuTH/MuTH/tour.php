<?php
require("global.inc.php");

/**
* Bietet das Skript für die Anzeige der einzelnen Touren.
*/

// alle Klassen, die hier benötigt werden
require_once("./model/tour.model.php");
require_once("./model/station.model.php");
require_once("./model/station_wahr_falsch.model.php");
require_once("./model/station_schaetzen.model.php");
require_once("./model/station_mehrfachantwort.model.php");
require_once("./model/erklaerung.model.php");
require_once("./model/antwortmoeglichkeit.model.php");

//wenn die erforderlichen Daten noch nicht eingegeben wurden, wird zur Startseite weitergeleitet
if(!istGesetztName() || !istGesetztAlter() || !istGesetztInteressen()) {
	header("location: willkommen.php");
	exit;
}
//wenn die Anwendung schon beendet wurde, wird zur Urkundenseite weitergeleitet
else if(istGesetztUrkundeId()) {
	header("location: beenden.php");
	exit;
}

$headerTemplate->set("header_symbol", "fas fa-globe-asia");
$headerTemplate->set("header_hilfe", "");
$headerTemplate->set("header_tipp", "");

//wenn keine TourID übergeben wurde -> Weiterleitung auf Fehlerseite
if(isset($_GET['tour_id'])) {
	$tour_id = intval($_GET['tour_id']);
	$tour_cookie_ordnungsnummer = "tour".$tour_id."_ordnungsnummer";
	$tour_cookie_punkte = "tour".$tour_id."_punkte";
	$result = Tour::getTourById($tour_id);
	
	//wenn nichts mit der DB-Abfrage schief gegangen ist
	if($result->num_rows > 0) {
	$tour = $result->fetch_object("Tour");
		//wenn Tour bereits abgeschlossen wurde, ist spezielles Cookie mit finalen Punkten gesetzt
		//es wird auf Abschlussseite geleitet, die wieder zur Übersicht verlinkt
		if(istAbgeschlossen($tour_id)) {
			$tourTemplate = new Template("templates/tour/ende.tpl");
			$tourTemplate->set("tour_id", $tour_id);
			$tourTemplate->set("titel", $tour->getName());
			$headerTemplate->set("header_titel", "Tourende");
			$tourTemplate->set("punkte", getFinalePunkte($tour_id));
		}
		//wenn Tour noch nicht abgeschlossen wurde
		else {
			//wenn noch gar kein Cookie für die Tour gesetzt wurde
			if(!istGesetztCookie($tour_cookie_ordnungsnummer)) {
				//$_GET['start'] wird nur im "Tour starten"-Link auf der Startseite der Tour übergeben
				//wenn das gesetzt wurde, dann wird die Tour gestartet, in dem der Tour-Cookie gesetzt und auf die erste Aufgabe weitergeleitet wird
				if(isset($_GET['start'])) {
					setzeCookie($tour_cookie_ordnungsnummer, "1");
					setzeCookie($tour_cookie_punkte, "0");
					header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=1&typ=aufgabe");
					exit;
				}
				//wenn $_GET['start'] nicht gesetzt wurde, ist es die Tour noch nicht begonnen worden
				//es wird eine Tourstartseite mit Einleitungstext angezeigt -> diese wird immer angezeigt, wenn eine unbegonnene Tour aufgerufen wird
				$tourTemplate = new Template("templates/tour.tpl");
				$tourTemplate->set("tour_id", $tour_id);
				$tourTemplate->set("titel", $tour->getName());
				$headerTemplate->set("header_titel", "Tourstart");
				$tourTemplate->set("starttext", $tour->getStarttext());
				if($tour->getHatBild()){
					$bildTemplate = new Template("templates/tour/bild.tpl");
					$bildTemplate->set("url", $tour->getBildURL());
					$tourTemplate->set("bild", $bildTemplate->output());
				}
				else $tourTemplate->set("bild", "");
			}
			//wenn Cookie für die Tour gesetzt und diese ergo schon begonnen wurde
			else {
				$ordnungsnummer = getAktuelleOrdnungsnummer($tour_id);
				//wenn die aktuelle Ordnungszahl größer als die Anzahl der Stationen in der Tour ist, dann ist das Ende erreicht
				//Abschluss-Cookie wird gesetzt und die Seite neu aufgerufen, so dass die Abschlussseite angezeigt wird
				if($ordnungsnummer > $tour->getStationsanzahl() && $_GET['typ'] == "aufgabe") {
					tourAbschliessen($tour_id);
					header("location: tour.php?tour_id=".$tour_id);
					exit;
				}
				
				//abhängig von der Seitenart, die aufgerufen werden soll, werden verschiedene Skriptteile ausgeführt
				switch($_GET['typ']) {
					case "erklaerung":
						if($ordnungsnummer == intval($_GET['ordnungsnummer']) + 1 || !isset($_GET['ordnungsnummer'])) {
							$aktuelleOrdnungsnummer = $ordnungsnummer - 1;
							$station_id = $tour->getStationIdByOrdnungsnummer($aktuelleOrdnungsnummer);
							$result = Erklaerung::getErklaerungByStationId($station_id);
							//wenn eine Erklärung in der DB gefunden wurde, dann wird diese auf einer eigenen Seite angezeigt
							if($result->num_rows > 0) {
								$erklaerung=$result->fetch_object("Erklaerung");
								$tourTemplate = new Template("templates/tour/erklaerung.tpl");
								$tourTemplate->set("tour_id", $tour_id);
								$tourTemplate->set("titel", "Erkl&auml;rung");
								$headerTemplate->set("header_titel", "Station ".$aktuelleOrdnungsnummer);
								$tourTemplate->set("text", $erklaerung->getErklaerungText());
								if($erklaerung->getHatBild()){
									$bildTemplate = new Template("templates/tour/erklaerung_bild.tpl");
									$bildTemplate->set("url", $erklaerung->getBildURL());
									$tourTemplate->set("bild", $bildTemplate->output());
								}
								else $tourTemplate->set("bild", "");
								$tourTemplate->set("ordnungsnummer", $ordnungsnummer);
							}
							//wenn keine Erklärung gefunden wurde, wird einfach auf die nächste Aufgabe weitergeleitet
							else {
								header("location: tour.php?tour_id=".$tour_id."&typ=aufgabe");
								exit;
							}
						}
						//wenn versucht wurde, eine andere als die aktuell relevante Erklärung aufzurufen oder keine Ordnungsnummer übergeben wurde, wird zur nächsten Aufgabe weitergeleitet
						else {
							header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=aufgabe");
							exit;
						}
					break;
					case "aufgabe":
						if($ordnungsnummer == intval($_GET['ordnungsnummer']) || !isset($_GET['ordnungsnummer'])) {
							$station_id = $tour->getStationIdByOrdnungsnummer($ordnungsnummer);
							$station_typ = Station::getTypByStationId($station_id);
							
							//das zum Stationstypen gehörige Aufgabenseitenskript wird aufgerufen
							include("./stationen/".$station_typ.".aufgabe.php");
							$hilfeTemplate = new Template("templates/header/hilfe.tpl");
							$headerTemplate->set("header_hilfe", $hilfeTemplate->output());
							$hilfeInhaltTemplate = new Template("templates/tour/".$station_typ."/hilfe.tpl");
							$tourTemplate->set("hilfe", $hilfeInhaltTemplate->output());
							if($station->getTipp() != "") {
								$tippTemplate = new Template("templates/header/tipp.tpl");
								$headerTemplate->set("header_tipp", $tippTemplate->output());
								$tippInhaltTemplate = new Template("templates/tour/tipp.tpl");
								$tippInhaltTemplate->set("tipp", $station->getTipp());
								$tourTemplate->set("tipp", $tippInhaltTemplate->output());
							}
							else {
								$tourTemplate->set("tipp", $hilfeInhaltTemplate->output());
							}
						}
						//wenn versucht wurde, eine andere als die aktuelle Aufgabe aufzurufen oder keine Ordnungsnummer übergeben wurde, wird zur nächsten Aufgabe weitergeleitet
						else {
							header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=aufgabe");
							exit;
						}
					break;
					case "auswertung":
						if($ordnungsnummer == intval($_GET['ordnungsnummer']) + 1 || !isset($_GET['ordnungsnummer'])) {
							$aktuelleOrdnungsnummer = $ordnungsnummer - 1;
							$station_id = $tour->getStationIdByOrdnungsnummer($aktuelleOrdnungsnummer);
							$station_typ = Station::getTypByStationId($station_id);
							
							$tourTemplate = new Template("templates/tour/auswertung.tpl");
							$tourTemplate->set("tour_id", $tour_id);
							$tourTemplate->set("ordnungsnummer", $aktuelleOrdnungsnummer);
							$inhaltTemplate = new Template("templates/tour/".$station_typ."/inhalt_auswertung.tpl");
							
							//das zum Stationstypen gehörige Auswertungsseitenskript wird aufgerufen
							include("./stationen/".$station_typ.".auswertung.php");
							$tourTemplate->set("inhalt", $inhaltTemplate->output());
							$tourTemplate->set("punkte", intval($_GET['punkte']));
							$headerTemplate->set("header_titel", "Station ".$aktuelleOrdnungsnummer);
						}
						//wenn versucht wurde, eine andere als die aktuell relevante Auswertung aufzurufen oder keine Ordnungsnummer übergeben wurde, wird zur nächsten Aufgabe weitergeleitet
						else {
							header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=aufgabe");
							exit;
						}
					break;
					default:
						if(isset($_GET['ordnungsnummer'])) header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".intval($_GET['ordnungsnummer'])."&typ=aufgabe");
						else header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=aufgabe");
						exit;
					break;
				}
			}
		}
	}
	//wenn Tourobjekt nicht richtig erzeugt werden konnte -> Weiterleitung auf Fehlerseite
	else {
		$tourTemplate = new Template("templates/tour/fehler.tpl");
		$headerTemplate->set("header_titel", "Fehler");
		$tourTemplate->set("titel", "Tour nicht gefunden");
		$tourTemplate->set("inhalt", "Die Tour, die du aufrufen willst, existiert nicht. Zur&uuml;ck zur <a href=\"uebersicht.php\">&Uuml;bersicht</a>.");
	}
}
//wenn keine TourID angegeben wurde
else {
	$tourTemplate = new Template("templates/tour/fehler.tpl");
	$headerTemplate->set("header_titel", "Fehler");
	$tourTemplate->set("titel", "Tour nicht gefunden");
	$tourTemplate->set("inhalt", "Die Tour, die du aufrufen willst, existiert nicht. Zur&uuml;ck zur <a href=\"uebersicht.php\">&Uuml;bersicht</a>.");
}

$tourTemplate->set("header", $headerTemplate->output());
$tourTemplate->set("footer", $footerTemplate->output());

echo $tourTemplate->output();
?>