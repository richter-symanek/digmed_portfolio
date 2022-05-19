<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

/**
* Repräsentiert die Datenbanktabelle `station_erklaerung` und ihre Attribute.
*/
class Erklaerung {
	private $station_id;
	private $text;
	private $hat_bild;
	
	/**
	* Erstellt ein Objekt der Klasse Erklaerung.
	*
	* @param int $station_id
	* @param string $text
	* @param int $hat_bild
	*/
	public function __construct (int $station_id = 0, string $text = "", int $hat_bild = 0) {
		if(!isset($this->station_id)) $this->station_id = $station_id;
		if(!isset($this->text)) $this->text = $text;
		if(!isset($this->hat_bild)) $this->hat_bild = $hat_bild;
	}
	
	public function getStationId() {
		return $this->station_id;
	}
	
	public function getErklaerungText() {
		return $this->text;
	}
	
	public function getHatBild() {
		return $this->hat_bild;
	}
	
	public function setStationId(int $station_id) {
		$this->station_id = $station_id;
	}
	
	public function setText(string $text) {
		$this->text = $text;
	}
	
	public function setHatBild(int $hat_bild) {
		$this->hat_bild = $hat_bild;
	}
	
	/**
	* Liefert die BildURL für das Bild der Erklaerung, soweit diese über ein Bild verfügt.
	*
	* Liefert nur die korrekte BildURL, wenn das Bild auf dem Server im richtigen Ordner und entsprechend der Namenskonvention abgespeichert wurde.
	*
	* @param int $station_id Die assoziierte StationsID.
	* @return string Die BildURL, wenn die Erklaerung über ein Bild verfügt.
	*/
	public function getBildURL() {
		if($this->hat_bild) return "resources/images/stationen/erklaerungen/".$this->station_id.".png";
	}
	
	/**
	* Liefert die Erklaerung, die mit der übergebenen StationsID assoziiert ist.
	*
	* @static
	* @param int $station_id Die assoziierte StationsID.
	* @return mixed Bei Gelingen der Abfrage die gesuchte Erklaerung.
	*/
	public static function getErklaerungByStationId(int $station_id) {
		global $db;
		$result = $db->query("
			SELECT station_id, erklaerung_text AS text, erklaerung_hat_bild AS hat_bild 
			FROM `erklaerung` 
			WHERE station_id = ".$station_id);
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else return $result;
	}
}
?>