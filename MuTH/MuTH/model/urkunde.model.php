<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

/**
* Repräsentiert die Datenbanktabelle `urkunde` und ihre Attribute.
*/
class Urkunde {
	private $id;
	private $besitzer;
	
	/**
	* Erstellt ein Objekt der Klasse Urkunde.
	*
	* @param string $besitzer
	* @param int $id
	*/
	public function __construct (string $besitzer = "", int $id = 0) {
		if(!isset($this->id)) $this->id = $id;
		if(!isset($this->besitzer)) $this->besitzer = $besitzer;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getBesitzer() {
		return $this->besitzer;
	}
	
	public function setId(string $id) {
		$this->id = $id;
	}
	
	public function setBesitzer(string $besitzer) {
		$this->besitzer = $besitzer;
	}
	
	/**
	* Fügt das Objekt der Datenbank hinzu. Speichert zudem die TourIDs und zugehörigen Punktzahlen mit der UrkundenID in der Tabelle `urkunde_tour`.
	*
	* @param array $touren Die Touren mit den dazugehörigen, erreichten Punkten.
	* @return int Bei Gelingen der Abfrage die UrkundenID, unter der die Urkunde gespeichert wurde.
	*/
	public function speichern(array $touren) {
		global $db;
		if($statement = $db->prepare("INSERT INTO `urkunde` (urkunde_besitzer) VALUES (?)")) {
			$statement->bind_param("s", $this->besitzer);
			$statement->execute();
			$statement->close();
			$urkunde_id = $db->insert_id;
			for($i = 0; $i < count($touren); $i++) {
				$statement = $db->prepare("INSERT INTO `urkunde_tour` (urkunde_id, tour_id, urkunde_tour_punkte) VALUES (?, ?, ?)");
				$statement->bind_param("iii", $urkunde_id, $touren[$i][0], $touren[$i][1]);
				$statement->execute();
				$statement->close();
			}
			return $urkunde_id;
		}
		else {
			$error = $mysqli->errno ." ". $mysqli->error;
			die($error);
		}
	}
}
?>