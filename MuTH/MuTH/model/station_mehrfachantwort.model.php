<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

/**
* Repräsentiert die Datenbanktabelle `station_mehrfachantwort` und ihre Attribute, die die Datenbanktabelle `station` erweitert.
* @see Station
*/
class Station_Mehrfachantwort extends Station {
	private $frage;
	
	/**
	* Erstellt ein Objekt der Klasse Station_Mehrfachantwort.
	*
	* @param int $id
	* @param string $name
	* @param int $punkte
	* @param string $typ
	* @param string $tipp
	* @param int $hat_bild
	* @param string $frage
	*/
	public function __construct (int $id = 0, string $name = "", int $punkte = 0, string $typ = "", string $tipp = "", int $hat_bild = 0, string $frage = "") {
		if(!isset($this->id)) $this->id = $id;
		if(!isset($this->name)) $this->name = $name;
		if(!isset($this->punkte)) $this->punkte = $punkte;
		if(!isset($this->typ)) $this->typ = $typ;
		if(!isset($this->tipp)) $this->tipp = $tipp;
		if(!isset($this->hat_bild)) $this->hat_bild = $hat_bild;
		if(!isset($this->frage)) $this->frage = $frage;
	}
	
	public function getFrage() {
		return $this->frage;
	}
	
	public function setFrage(string $frage) {
		$this->frage = $frage;
	}
	
	/**
	* Liefert die Antwortmöglichkeiten, die mit der Station assoziiert sind.
	*
	* @return mixed Bei Gelingen der Abfrage die gesuchten Antwortmöglichkeiten.
	*/
	public function getAntwortmoeglichkeiten() {
		global $db;
		$result = $db->query("
			SELECT antwortmoeglichkeit.antwortmoeglichkeit_id AS id, antwortmoeglichkeit_antwort AS antwort, station_antwortmoeglichkeit_richtig AS richtig  
			FROM `station_mehrfachantwort_antwortmoeglichkeit`
			LEFT JOIN `antwortmoeglichkeit` USING(antwortmoeglichkeit_id) 
			WHERE station_id = ".$this->id."
		");	
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else {
			return $result;
		}
	}
	
	/**
	* Liefert die Station_Mehrfachantwort mit der übergebenen StationsID.
	*
	* @static
	* @param int $station_id Die gesuchte StationsID.
	* @return mixed Bei Gelingen der Abfrage die gesuchte Station.
	*/
	public static function getMehrfachantwortStationByStationId(int $station_id) {
		global $db;
		$statement=$db->prepare("
			SELECT station.station_id AS id, station_name AS name, station_punkte AS punkte, station_tipp AS tipp, station_hat_bild AS hat_bild,
				station_frage AS frage 
			FROM `station` 
			LEFT JOIN `station_mehrfachantwort` USING(station_id) 
			WHERE station.station_id = ? 
		");
		$statement->bind_param("i", $station_id);
		$statement->execute();
		$result=$statement->get_result();
		$statement->close();		
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else return $result;
	}
}
?>