<?php
/**
* Speichert für die Anwendung wichtige Funktionen, die keiner speziellen Klasse zuzuordnen sind.
*/
header('Content-Type: text/html; charset=utf-8');
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Formatiert ein im YYYY-MM-DD-Format übergebenes Datum $date in einen deutschsprachigen String.
*
* @param string $date
* @return string $date_str
*/
function formatDate(string $date) {
	$date_str = "";

	$date = explode("-", $date);

	$day = ltrim($date[2], "0");

	$month = "";
	switch($date[1]) {
		case "01":
			$month = "Januar";
			break;
		case "02":
			$month = "Februar";
			break;
		case "03":
			$month = "März";
			break;
		case "04":
			$month = "April";
			break;
		case "05":
			$month = "Mai";
			break;
		case "06":
			$month = "Juni";
			break;
		case "07":
			$month = "Juli";
			break;
		case "08":
			$month = "August";
			break;
		case "09":
			$month = "September";
			break;
		case "10":
			$month = "Oktober";
			break;
		case "11":
			$month = "November";
			break;
		case "12":
			$month = "Dezember";
			break;
	}

	$year = $date[0];

	$date_str = $day.". ".$month." ".$year;
	
	return $date_str;
}

/**
* Formatiert ein im YYYY-MM-DD-Format übergebenes Datum $date in das Format DD.MM.YYYY um.
*
* @param string $date
* @return string $date_str
*/
function formatDateDirection(string $date) {
	$date_str = "";

	$date = explode("-", $date);

	$date_str = $date[2].".".$date[1].".".$date[0];
	
	return $date_str;
}

?>