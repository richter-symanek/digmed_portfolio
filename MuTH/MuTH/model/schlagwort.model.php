<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

/**
* Repräsentiert die Datenbanktabelle `schlagwort` und ihre Attribute.
*/
class Schlagwort {
	private $id;
	private $schlagwort;
	
	/**
	* Erstellt ein Objekt der Klasse Schlagwort.
	*
	* @param int $id
	* @param string $schlagwort
	*/
	public function __construct(int $id = 0, string $schlagwort = "") {
		if(!$this->id) $this->id = $id;
		if(!$this->schlagwort) $this->schlagwort = $schlagwort;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getSchlagwort() {
		return $this->schlagwort;
	}
	
	public function setId(string $id) {
		$this->id = $id;
	}
	
	public function setSchlagwort(string $schlagwort) {
		$this->schlagwort = $schlagwort;
	}
	
	/**
	* Liefert alle Schlagwörter in der Datenbanktabelle `schlagwort` einmal nach einzigartigem Wert in der Spalte `schlagwort`.
	*
	* @static
	* @return mixed Bei Gelingen der Abfrage alle Schlagwörter.
	*/
	public static function getAlleSchlagworte() {
		global $db;
		$result=$db->query("SELECT DISTINCT schlagwort FROM `schlagwort`");	
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else return $result;
	}
}
?>