<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

// alle Klassen, die hier benötigt werden
require_once("./model/station.model.php");

/**
* Repräsentiert die Datenbanktabelle `station_wahr_falsch` und ihre Attribute, die die Datenbanktabelle `station` erweitert.
* @see Station
*/
class Station_Wahr_Falsch extends Station {
	private $aussage;
	private $antwort;
	
	/**
	* Erstellt ein Objekt der Klasse Station_Wahr_Falsch.
	*
	* @param int $id
	* @param string $name
	* @param int $punkte
	* @param string $typ
	* @param string $tipp
	* @param int $hat_bild
	* @param string $aussage
	* @param int $antwort
	*/
	public function __construct (int $id = 0, string $name = "", int $punkte = 0, string $typ = "", string $tipp = "", int $hat_bild = 0, string $aussage = "", int $antwort = 0) {
		if(!isset($this->id)) $this->id = $id;
		if(!isset($this->name)) $this->name = $name;
		if(!isset($this->punkte)) $this->punkte = $punkte;
		if(!isset($this->typ)) $this->typ = $typ;
		if(!isset($this->tipp)) $this->tipp = $tipp;
		if(!isset($this->hat_bild)) $this->hat_bild = $hat_bild;
		if(!isset($this->aussage)) $this->aussage = $aussage;
		if(!isset($this->antwort)) $this->antwort = $antwort;
	}
	
	public function getAussage() {
		return $this->aussage;
	}
	
	public function getAntwort() {
		return $this->antwort;
	}
	
	public function setAussage(string $aussage) {
		$this->aussage = $aussage;
	}
	
	public function setAntwort(int $antwort) {
		$this->antwort = $antwort;
	}
	
	/**
	* Liefert die Station_Wahr_Falsch mit der übergebenen StationsID.
	*
	* @static
	* @param int $station_id Die gesuchte StationsID.
	* @return mixed Bei Gelingen der Abfrage die gesuchte Station.
	*/
	public static function getWahrFalschStationByStationId(int $station_id) {
		global $db;
		$statement=$db->prepare("
			SELECT station.station_id AS id, station_name AS name, station_punkte AS punkte, station_tipp AS tipp, station_hat_bild AS hat_bild,
				station_aussage AS aussage, station_antwort AS antwort 
			FROM `station` 
			LEFT JOIN `station_wahr_falsch` USING(station_id) 
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