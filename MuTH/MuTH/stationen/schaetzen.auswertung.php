<?php
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Bestimmt, was auf der Auswertungsseite von Schätzfragen angezeigt wird.
*/

$result = Station_Schaetzen::getSchaetzenStationByStationId($station_id);
$station = $result->fetch_object("Station_Schaetzen");

$inhaltTemplate->set("frage", $station->getFrage());
//wenn die Seite ohne die Angabe, ob die zugehörige Frage richtig beantwortet wurde, aufgerufen wird, wird zur nächsten Frage weitergeleitet
if(!isset($_GET['richtig'])) {
	header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=aufgabe");
	exit;
}
else $richtig = intval($_GET['richtig']);
if($richtig) $feedbackTemplate = new Template("templates/tour/schaetzen/antwort_richtig.tpl");
else $feedbackTemplate = new Template("templates/tour/schaetzen/antwort_falsch.tpl");

$inhaltTemplate->set("antwort", "Die ganz exakte Antwort auf die Sch&auml;tzfrage lautet <b>".$station->getAntwort()."</b>.");
	
$inhaltTemplate->set("feedback", $feedbackTemplate->output());
?>