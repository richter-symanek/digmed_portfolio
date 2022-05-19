<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

/**
* Repräsentiert die Datenbanktabelle `station_mehrfachantwort_antwortmoeglichkeit` und ihre Attribute.
*/
class Antwortmoeglichkeit {
	private $id;
	private $antwort;
	
	/**
	* Erstellt ein Objekt der Klasse Schlagwort.
	*
	* @param int $id
	* @param string $antwort
	*/
	public function __construct (int $id = 0, string $antwort = "") {
		if(!isset($this->id)) $this->id = $id;
		if(!isset($this->antwort)) $this->antwort = $antwort;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getAntwort() {
		return $this->antwort;
	}
	
	public function setId(int $id) {
		$this->id = $id;
	}
	
	public function setAntwort(string $antwort) {
		$this->antwort = $antwort;
	}
}
?>