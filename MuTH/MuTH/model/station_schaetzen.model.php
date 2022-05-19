<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

// alle Klassen, die hier benötigt werden
require_once("./model/station.model.php");

/**
* Repräsentiert die Datenbanktabelle `station_schaetzen` und ihre Attribute, die die Datenbanktabelle `station` erweitert.
* @see Station
*/
class Station_Schaetzen extends Station {
	private $frage;
	private $antwort;
	private $min_antwort;
	private $max_antwort;
	private $min_range;
	private $max_range;
	
	/**
	* Erstellt ein Objekt der Klasse Station_Schaetzen.
	*
	* @param int $id
	* @param string $name
	* @param int $punkte
	* @param string $typ
	* @param string $tipp
	* @param int $hat_bild
	* @param int $antwort
	* @param int $min_antwort
	* @param int $max_antwort
	* @param int $min_range
	* @param int $max_range
	*/
	public function __construct (int $id = 0, string $name = "", int $punkte = 0, string $typ = "", string $tipp = "", int $hat_bild = 0, string $frage = "", int $antwort = 0, int $min_antwort = 0, int $max_antwort = 0, int $min_range = 0, int $max_range = 0) {
		if(!isset($this->id)) $this->id = $id;
		if(!isset($this->name)) $this->name = $name;
		if(!isset($this->punkte)) $this->punkte = $punkte;
		if(!isset($this->typ)) $this->typ = $typ;
		if(!isset($this->tipp)) $this->tipp = $tipp;
		if(!isset($this->hat_bild)) $this->hat_bild = $hat_bild;
		if(!isset($this->frage)) $this->frage = $frage;
		if(!isset($this->antwort)) $this->antwort = $antwort;
		if(!isset($this->min_antwort)) $this->min_antwort = $min_antwort;
		if(!isset($this->max_antwort)) $this->max_antwort = $max_antwort;
		if(!isset($this->min_range)) $this->min_range = $min_range;
		if(!isset($this->max_range)) $this->max_range = $max_range;
	}
	
	public function getFrage() {
		return $this->frage;
	}
	
	public function getAntwort() {
		return $this->antwort;
	}
	
	public function getMinAntwort() {
		return $this->min_antwort;
	}
	
	public function getMaxAntwort() {
		return $this->max_antwort;
	}
	
	public function getMinRange() {
		return $this->min_range;
	}
	
	public function getMaxRange() {
		return $this->max_range;
	}
	
	public function setFrage(string $frage) {
		$this->frage = $frage;
	}
	
	public function setAntwort(int $antwort) {
		$this->antwort = $antwort;
	}
	
	public function setMinAntwort(int $min_antwort) {
		$this->min_antwort = $min_antwort;
	}
	
	public function setMaxAntwort(int $max_antwort) {
		$this->max_antwort = $max_antwort;
	}
	
	public function setMinRange(int $min_range) {
		$this->min_range = $min_range;
	}
	
	public function setMaxRange(int $max_range) {
		$this->max_range = $max_range;
	}
	
	/**
	* Liefert die Station_Schaetzen mit der übergebenen StationsID.
	*
	* @static
	* @param int $station_id Die gesuchte StationsID.
	* @return mixed Bei Gelingen der Abfrage die gesuchte Station.
	*/
	public static function getSchaetzenStationByStationId(int $station_id) {
		global $db;
		$statement=$db->prepare("
			SELECT station.station_id AS id, station_name AS name, station_punkte AS punkte, station_tipp AS tipp, station_hat_bild AS hat_bild,
				station_frage AS frage, station_antwort AS antwort, station_min_antwort AS min_antwort, station_max_antwort AS max_antwort, station_min_range AS min_range, station_max_range AS max_range 
			FROM `station` 
			LEFT JOIN `station_schaetzen` USING(station_id) 
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