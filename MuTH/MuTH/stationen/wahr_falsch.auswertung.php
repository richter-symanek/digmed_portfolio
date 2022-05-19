<?php
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Bestimmt, was auf der Auswertungsseite von Wahr-Falsch-Fragen angezeigt wird.
*/

$result = Station_Wahr_Falsch::getWahrFalschStationByStationId($station_id);
$station = $result->fetch_object("Station_Wahr_Falsch");

$inhaltTemplate->set("aussage", $station->getAussage());
//wenn die Seite ohne die Angabe, ob die zugehörige Frage richtig beantwortet wurde, aufgerufen wird, wird zur nächsten Frage weitergeleitet
if(!isset($_GET['richtig'])) {
	header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=aufgabe");
	exit;
}
else $richtig = intval($_GET['richtig']);
if($richtig) $feedbackTemplate = new Template("templates/tour/wahr_falsch/antwort_richtig.tpl");
else $feedbackTemplate = new Template("templates/tour/wahr_falsch/antwort_falsch.tpl");

if($station->getAntwort()) $feedbackTemplate->set("aussage_feedback", "Die Behauptung stimmt.");
else $feedbackTemplate->set("aussage_feedback", "Die Behauptung stimmt nicht.");
	
$inhaltTemplate->set("feedback", $feedbackTemplate->output());
?>