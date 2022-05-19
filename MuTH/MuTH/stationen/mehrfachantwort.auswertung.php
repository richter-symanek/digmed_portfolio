<?php
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Bestimmt, was auf der Auswertungsseite von Mehrfachantwortfragen angezeigt wird.
*/

$result = Station_Mehrfachantwort::getMehrfachantwortStationByStationId($station_id);
$station = $result->fetch_object("Station_Mehrfachantwort");

$inhaltTemplate->set("frage", $station->getFrage());
//wenn die Seite ohne die Angabe, ob die zugehörige Frage richtig beantwortet wurde, aufgerufen wird, wird zur nächsten Frage weitergeleitet
if(!isset($_GET['richtig'])) {
	header("location: tour.php?tour_id=".$tour_id."&ordnungsnummer=".$ordnungsnummer."&typ=aufgabe");
	exit;
}
else $richtig = addslashes($_GET['richtig']);

$antworten_array1 = explode("-", $richtig);
$i = 0;
$antworten_array2 = array();
//der als GET-Parameter übergebene String mit Informationen dazu, ob eine Antwort richtig markiert wurde, wird aufbereitet zur Auswertung
while($i < count($antworten_array1)) {
	$antwort_array = explode("x", $antworten_array1[$i]);
	$antworten_array2[$antwort_array[0]] = $antwort_array[1];
	$i++;
}
$result = $station->getAntwortmoeglichkeiten();
//für jede Antwortmöglichkeit der Frage wird bestimmt, ob diese richtig markiert wurde, und davon abhängig deren Anzeige auf der Auswertungsseite festgelegt
while($antwortmoeglichkeit = $result->fetch_object("Antwortmoeglichkeit")) {
		$antwortTemplate = new Template("templates/tour/mehrfachantwort/auswertung_antwort.tpl");
		$aktuelleAntwort = explode("_", $antworten_array2[$antwortmoeglichkeit->getId()]);
		$antwortTemplate->set("farbKlasse", $aktuelleAntwort[0]);
		if($aktuelleAntwort[1] == "checked") $antwortTemplate->set("check", " checked");
		else  $antwortTemplate->set("checked", "");
		$antwortTemplate->set("antwort", $antwortmoeglichkeit->getAntwort());
		$antwortTemplates[] = $antwortTemplate;
}
$antwortTemplate2 = Template::merge($antwortTemplates);
$inhaltTemplate->set("antworten", $antwortTemplate2);
?>