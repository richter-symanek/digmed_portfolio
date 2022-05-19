<?php
header("Content-Type: text/html; charset=ANSI");
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");
require_once("./lib/db.inc.php");

/**
* Repräsentiert die Datenbanktabelle `seite` und ihre Attribute.
*/
class Seite {
	private $bezeichner;
	private $menuetitel;
	private $titel;
	private $inhalt;
	private $ordnungsnummer;
	
	/**
	* Erstellt ein Objekt der Klasse Seite.
	*
	* @param string $bezeichner
	* @param string $menuetitel
	* @param string $titel
	* @param string $inhalt
	* @param int $ordnungsnummer
	*/
	public function __construct (string $bezeichner = "", string $menuetitel = "", string $titel = "", string $inhalt = "", int $ordnungsnummer = 0) {
		if(!$this->bezeichner) $this->bezeichner = $bezeichner;
		if(!$this->menuetitel) $this->menuetitel = $menuetitel;
		if(!$this->titel) $this->titel = $titel;
		if(!$this->inhalt) $this->inhalt = $inhalt;
		if(!$this->ordnungsnummer) $this->ordnungsnummer = $ordnungsnummer;
	}
	
	public function getBezeichner() {
		return $this->bezeichner;
	}
	
	public function getMenuetitel() {
		return $this->menuetitel;
	}
	
	public function getTitel() {
		return $this->titel;
	}
	
	public function getInhalt() {
		return $this->inhalt;
	}
	
	public function getOrdnungsnummer() {
		return $this->ordnungsnummer;
	}
	
	public function setBezeichner(string $bezeichner) {
		$this->bezeichner = $bezeichner;
	}
	
	public function setMenuetitel(string $menuetitel) {
		$this->menuetitel = $menuetitel;
	}
	
	public function setTitel(string $titel) {
		$this->titel = $titel;
	}
	
	public function setInhalt(string $inhalt) {
		$this->inhalt = $inhalt;
	}
	
	public function setOrdnungsnummer(int $ordnungsnummer) {
		$this->ordnungsnummer = $ordnungsnummer;
	}
	
	/**
	* Liefert die Seite mit dem übergebenen Bezeichner.
	*
	* @static
	* @param int $page Der übergebene Bezeichner.
	* @return mixed Bei Gelingen der Abfrage die gesuchte Seite.
	*/
	public static function getSeiteByBezeichner(string $page) {
		global $db;
		$statement=$db->prepare("SELECT seite_titel AS titel, seite_menuetitel AS menuetitel, seite_inhalt AS inhalt FROM `seite` WHERE seite_bezeichner = ?");
		$statement->bind_param("s",$page);
		$statement->execute();
		$result=$statement->get_result();
		$statement->close();		
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else return $result;
	}
	
	/**
	* Liefert alle Seiten in der Datenbanktabelle `seite`.
	*
	* @static
	* @return mixed Bei Gelingen der Abfrage alle Seiten.
	*/
	public static function getAlleSeiten() {
		global $db;
		$result=$db->query("SELECT seite_bezeichner AS bezeichner, seite_menuetitel AS menuetitel FROM `seite` ORDER BY seite_ordnungsnummer ASC");	
		if(!$result) {
			die("Database Error [{$db->errno}] {$db->error}");
		}
		else return $result;
	}
}
?>