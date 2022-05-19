<?php
/**
* Speichert für die Anwendung wichtige Funktionen, die keiner speziellen Klasse zuzuordnen sind.
*/
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Erstellt einen Cookie mit gegebenem Namen und Inhalt und 1 Tag Beständigkeit.
*
* @param string $name
* @param string $inhalt
*/
function setzeCookie(string $name, string $inhalt) {
	setcookie($name, trim(addslashes($inhalt)), time()+(3600*24));
}

/**
* Löscht den Cookie mit dem gegebenen Namen.
*
* @param string $name
*/
function loescheCookie(string $name) {
	setcookie($name, "", time() - 3600);
}

/**
* Löscht alle unter der Seite der Anwendung gespeicherten Cookies.
*
* @author Unbekannte_r Nutzer_in unter http://php.net/manual/en/function.setcookie.php#73484
* @license Creative Commons Attribution 3.0 (Nähere Informationen unter: http://php.net/manual/en/cc.license.php)
*/
function loescheAlleCookies() {
	if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, '', time()-1000);
			setcookie($name, '', time()-1000, '/');
		}
	}
}

/**
* Überprüft, ob ein Cookie mit dem gegebenen Namen existiert.
*
* @param string $name
* @return bool
*/
function istGesetztCookie(string $name) {
	return isset($_COOKIE[$name]);
}

/**
* Liefert den Inhalt des Cookies mit dem gegebenen Namen.
*
* @param string $name
* @return string
*/
function getCookieInhalt(string $name) {
	if(istGesetztCookie($name)) {
		$cookie = addslashes($_COOKIE[$name]);
		return $cookie;
	}
}

/**
* Liefert den als Cookie gespeicherten Namen.
*
* @return string
*/
function getName() {
	return (string)getCookieInhalt("vorname");
}

/**
* Liefert das als Cookie gespeicherte Alter.
*
* @return string
*/
function getAlter() {
	return (int)intval(getCookieInhalt("alter"));
}

/**
* Liefert die als Cookie gespeicherten Interessen.
*
* @return string
*/
function getInteressen() {
	return (string)getCookieInhalt("interessen");
}

/**
* Liefert die als Cookie gespeicherte UrkundenID.
*
* @return string
*/
function getUrkundeId() {
	return (int)intval(getCookieInhalt("urkunde_id"));
}

/**
* Setzt einen Cookie, der den gegebenen Namen speichert.
*
* @param string $name
*/
function setName(string $name) {
	setzeCookie("vorname", $name);
}

/**
* Setzt einen Cookie, der das gegebene Alter speichert.
*
* @param string $alter
*/
function setAlter(int $alter) {
	setzeCookie("alter", intval($alter));
}

/**
* Setzt einen Cookie, der die gegebenen Interessen speichert.
*
* @param string $interessen
*/
function setInteressen(string $interessen) {
	setzeCookie("interessen", $interessen);
}

/**
* Setzt einen Cookie, der die gegebene UrkundenID speichert.
*
* @param string $name
*/
function setUrkundeId(int $urkunde_id) {
	setzeCookie("urkunde_id", intval($urkunde_id));
}

/**
* Überprüft, ob der Cookie für den Namen existiert.
*
* @return bool
*/
function istGesetztName() {
	return isset($_COOKIE['vorname']);
}

/**
* Überprüft, ob der Cookie für das Alter existiert.
*
* @return bool
*/
function istGesetztAlter() {
	return isset($_COOKIE['alter']);
}

/**
* Überprüft, ob der Cookie für die Interessen existiert.
*
* @return bool
*/
function istGesetztInteressen() {
	return isset($_COOKIE['interessen']);
}

/**
* Überprüft, ob der Cookie für die UrkundenID existiert.
*
* @return bool
*/
function istGesetztUrkundeId() {
	return isset($_COOKIE['urkunde_id']);
}

/**
* Schließt die Tour mit gegebenen TourID ab. Setzt dafür eine finale Punktzahl und löscht die "Tourstand"-Cookies.
*
* @param int $tour_id
*/
function tourAbschliessen(int $tour_id) {
	setzeCookie("tour".$tour_id."abgeschlossen", getAktuellePunkte($tour_id));
	loescheCookie("tour".$tour_id."_ordnungsnummer");
	loescheCookie("tour".$tour_id."_punkte");
}

/**
* Überprüft, ob die Tour mit der gegebenen TourID abgeschlossen wurde.
*
* @param int $tour_id
* @return bool
*/
function istAbgeschlossen(int $tour_id) {
	return istGesetztCookie("tour".$tour_id."abgeschlossen");
}

/**
* Liefert die finale Punktzahl, die bei der Tour mit der gegebenen TourID erreicht wurde.
*
* @param int $tour_id
* @return string
*/
function getFinalePunkte(int $tour_id) {
	return getCookieInhalt("tour".$tour_id."abgeschlossen");
}

/**
* Liefert die aktuelle Ordnungsnummer der Nutzer_in bei der Tour mit der gegebenen TourID.
*
* @param int $tour_id
* @return string
*/
function getAktuelleOrdnungsnummer(int $tour_id) {
	return getCookieInhalt("tour".$tour_id."_ordnungsnummer");
}

/**
* Liefert die aktuelle Punktzahl der Nutzer_in bei der Tour mit der gegebenen TourID.
*
* @param int $tour_id
* @return string
*/
function getAktuellePunkte(int $tour_id) {
	return getCookieInhalt("tour".$tour_id."_punkte");
}

/**
* Setzt einen Cookie, der die gegebene Ordnungsnummer für die gegebene TourID als aktuelle Ordnungsnummer speichert.
*
* @param int $tour_id
* @param int $ordnungsnummer
*/
function setOrdnungsnummer(int $tour_id, int $ordnungsnummer) {
	setzeCookie("tour".$tour_id."_ordnungsnummer", $ordnungsnummer);
}

/**
* Setzt einen Cookie, der die gegebene Punktzahl für die gegebene TourID als aktuelle Punktzahl speichert.
*
* @param int $tour_id
* @param int $punkte
*/
function setPunkte(int $tour_id, int $punkte) {
	setzeCookie("tour".$tour_id."_punkte", $punkte);
}
?>