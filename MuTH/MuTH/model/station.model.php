<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

/**
* Repräsentiert die Datenbanktabelle `station` und ihre Attribute.
* @abstract
*/
abstract class Station {
	protected $id;
	protected $name;
	protected $punkte;
	protected $typ;
	protected $tipp;
	protected $hat_bild;
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getPunkte() {
		return $this->punkte;
	}
	
	public function getTyp() {
		return $this->typ;
	}
	
	public function getTipp() {
		return $this->tipp;
	}
	
	public function getHatBild() {
		return $this->hat_bild;
	}
	
	public function setId(int $id) {
		$this->id = $id;
	}
	
	public function setName(string $name) {
		$this->name = $name;
	}
	
	public function setPunkte(int $punkte) {
		$this->punkte = $punkte;
	}
	
	public function setTyp(string $typ) {
		$this->typ = $typ;
	}
	
	public function setTipp(string $tipp) {
		$this->tipp = $tipp;
	}
	
	public function setHatBild(int $hat_bild) {
		$this->hat_bild = $hat_bild;
	}
	
	public function getBildURL() {
		if($this->hat_bild) return "resources/images/stationen/".$this->id.".png";
	}
	
	/**
	* Liefert den Typ der Station mit der übergebenen StationsID.
	*
	* @static
	* @param int $station_id Die gesuchte StationsID.
	* @return string Der Stationstyp der Station.
	*/
	public static function getTypByStationId(int $station_id) {
		global $db;
		$result = $db->query("
			SELECT station_typ AS typ 
			FROM `station` 
			WHERE station_id = ".$station_id."
		");	
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else {
			$station = $result->fetch_assoc();
			return $station['typ'];
		}
	}
}
?>