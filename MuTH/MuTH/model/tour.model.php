<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

// alle Klassen, die hier benötigt werden
require_once("schlagwort.model.php");

/**
* Repräsentiert die Datenbanktabelle `tour` und ihre Attribute.
*/
class Tour {
	private $id;
	private $name;
	private $min_alter;
	private $max_alter;
	private $starttext;
	private $hat_bild;
	
	/**
	* Erstellt ein Objekt der Klasse Tour.
	*
	* @param int $id
	* @param string $name
	* @param int $min_alter
	* @param int $max_alter
	* @param string $starttext
	*/
	public function __construct (int $id = 0, string $name = "", int $min_alter = 0, int $max_alter = 99, string $starttext = "") {
		if(!$this->id) $this->id = $id;
		if(!$this->name) $this->name = $name;
		if(!$this->min_alter) $this->min_alter = $min_alter;
		if(!$this->max_alter) $this->max_alter = $max_alter;
		if(!$this->starttext) $this->starttext = $starttext;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getMinAlter() {
		return $this->min_alter;
	}
	
	public function getMaxAlter() {
		return $this->max_alter;
	}
	
	public function getStarttext() {
		return $this->starttext;
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
	
	public function setMinAlter(int $min_alter) {
		$this->min_alter = $min_alter;
	}
	
	public function setMaxAlter(int $max_alter) {
		$this->max_alter = $max_alter;
	}
	
	public function setStarttext(string $starttext) {
		$this->starttext = $starttext;
	}
	
	public function setHatBild(int $hat_bild) {
		$this->hat_bild = $hat_bild;
	}
	
	public function getBildURL() {
		if($this->hat_bild) return "resources/images/touren/".$this->id.".png";
	}

	/**
	* Zählt die Stationen, die der Tour zugeordnet sind.
	*
	* @return int Die Stationsanzahl.
	*/
	public function getStationsanzahl() {
		global $db;
		$result = $db->query("
			SELECT tour_station_ordnungsnummer AS anzahl
			FROM `tour_station` 
			WHERE tour_id = ".$this->id."
			ORDER BY tour_station_ordnungsnummer DESC
			LIMIT 1
		");		
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else {
			$anzahl = $result->fetch_assoc();
			return $anzahl['anzahl'];
		}
	}
	
	/**
	* Liefert die StationsID, die mit der Tour und übergebenen Ordnungsnummer assoziiert ist.
	*
	* @param int $ordnungsnummer Die gesuchte Ordnungsnummer.
	* @return int Die StationsID.
	*/
	public function getStationIdByOrdnungsnummer(int $ordnungsnummer) {
		global $db;
		$statement=$db->prepare("
			SELECT station.station_id AS id
			FROM `station` 
			LEFT JOIN `tour_station` USING(station_id) 
			WHERE tour_id = ".$this->id." AND tour_station.tour_station_ordnungsnummer = ? 
			LIMIT 1
		");
		$statement->bind_param("i", $ordnungsnummer);
		$statement->execute();
		$result=$statement->get_result();
		$statement->close();		
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else {
			$station = $result->fetch_assoc();
			return $station['id'];
		}
	}
	
	/**
	* Liefert die IDs aller in der Datenbanktabelle `tour` vorhandenen Touren.
	*
	* @static
	* @return mixed Bei Gelingen der Abfrage die IDs aller Touren.
	*/
	public static function getAlleTourenIds() {
		global $db;
		$result = $db->query("
			SELECT tour_id AS id
			FROM `tour` 
			ORDER BY tour_id ASC
		");		
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else return $result;
	}
	
	/**
	* Liefert die Tour mit der übergebenen TourID.
	*
	* @static
	* @param int $id Die gesuchte TourID.
	* @return mixed Bei Gelingen der Abfrage die gesuchte Tour.
	*/
	public static function getTourById(int $id) {
		global $db;
		$statement=$db->prepare("SELECT tour_id AS id, tour_name AS name, tour_starttext AS starttext, tour_hat_bild as hat_bild FROM `tour` WHERE tour_id = ?");
		$statement->bind_param("i",$id);
		$statement->execute();
		$result=$statement->get_result();
		$statement->close();		
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else return $result;
	}
	
	/**
	* Liefert die den angebenem Alter und Interessen entsprechenden Touren.
	*
	* Prepared Statements für IN in WHERE CLAUSE basieren auf https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection#where-in-array
	*
	* @static
	* @param int $alter Das vorgebene Alter.
	* @param array $interessen Die vorgebenen Interessen.
	* @return mixed Bei Gelingen der Abfrage die passenden Touren.
	*/
	public static function getTouren(int $alter = 0, array $interessen = array()) {
		global $db;
		if($alter > 0 && !empty($interessen)) {
			$clause = implode(",", array_fill(0, count($interessen), "?"));
			$types = str_repeat("s", count($interessen));
			$statement=$db->prepare("
				SELECT tour.tour_id AS id, tour_name AS name, tour_min_alter AS min_alter, tour_max_alter as max_alter 
				FROM `tour`
				LEFT JOIN `tour_schlagwort` USING(tour_id)
				LEFT JOIN `schlagwort` USING(schlagwort_id) 
				WHERE tour_max_alter >= ? AND tour_min_alter <= ?
				AND schlagwort IN (".$clause.")
				GROUP BY tour_id
				ORDER BY tour_name ASC
			");
			$statement->bind_param("ii".$types, $alter, $alter, ...$interessen);
		}
		else if($alter > 0 && empty($interessen)) {
			$statement=$db->prepare("
				SELECT tour.tour_id AS id, tour_name AS name, tour_min_alter AS min_alter, tour_max_alter as max_alter 
				FROM `tour`
				WHERE tour_max_alter >= ? AND tour_min_alter <= ?
				ORDER BY tour_name ASC
			");
			$statement->bind_param("ii",$alter,$alter);
		}
		else if(!empty($interessen)) {
			$clause = implode(",", array_fill(0, count($interessen), "?"));
			$types = str_repeat("s", count($interessen));
			$statement=$db->prepare("
				SELECT tour.tour_id AS id, tour_name AS name, tour_min_alter AS min_alter, tour_max_alter as max_alter 
				FROM `tour`
				LEFT JOIN `tour_schlagwort` USING(tour_id)
				LEFT JOIN `schlagwort` USING(schlagwort_id) 
				WHERE schlagwort IN ($clause)
				GROUP BY tour_id
				ORDER BY tour_name ASC
			");
			$statement->bind_param($types, ...$interessen);
		}
		else {
			$statement=$db->prepare("
				SELECT tour.tour_id AS id, tour_name AS name, tour_min_alter AS min_alter, tour_max_alter as max_alter 
				FROM `tour`
				ORDER BY tour_name ASC
			");
		}
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