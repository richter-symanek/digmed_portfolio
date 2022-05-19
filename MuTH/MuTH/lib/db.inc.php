<?php
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Klasse f�r die Herstellung der Datenbankverbindung und Verwaltung der daf�r genutzen Daten.
*/
class DB {
	/**
	* Daten f�r die Verbindung mit der Datenbank. M�ssen entsprechend angepasst werden.
	*/
	private const DB_HOST = ""; // Host des Datenbankservers

	private const DB_USER = ""; // Datenbankbenutzername

	private const DB_PASSWORT = ""; // Datenbankpasswort

	private const DB_NAME = ""; // Datenbankname
	
	/**
	* Baut Verbindung mit DB �ber die angegebenen Daten auf
	*
	* @static
	* @return mysqli Bei Gelingen der Verbindung ein Objekt der Klasse mysqli.
	*/
	public static function connect() {
		$mysqli = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASSWORT, self::DB_NAME); //
		if ($mysqli->connect_errno) {
			die("Verbindungsfehler: ". $mysqli->connect_error);
		}
		else return $mysqli;
	}
}
?>