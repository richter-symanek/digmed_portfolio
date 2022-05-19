<?php
if(count(get_included_files()) ==1) exit("Direkter Zugriff nicht gestattet. <a href=\"../index.php\">Zur&uuml;ck zur Anwendung</a>");

/**
* Klasse für eine Template Engine, die Anwendungsinhalte für die Nutzer_innen aufbereitet.
* @author Nuno Freitas <nunofreitas@gmail.com>
* @link http://www.broculos.net/ Broculos.net Programming Tutorials
* @version 1.0
*/
class Template {
    protected $file;
    protected $values = array();
	
	/**
	* Erstellt ein Objekt der Klasse Template.
	*
	* @param string $file Der Dateipfad zu der Datei, die das Template bilden soll.
	*/
    public function __construct($file) {
        $this->file = $file;
    }
	
	/**
	* Weißt einem Schlüssel im Template einen Wert zu, den er annehmen soll.
	*
	* @param string $key Der Name des Schlüssels.
	* @param string $value Der Wert, den der Schlüssel annehmen soll.
	*/
	public function set($key, $value) {
		$this->values[$key] = $value;
	}
	  
	/**
	* Gibt den Inhalt der Template-Datei zurück und ersetzt dabei die festgelegten Schlüssel durch deren Werte.
	*/
	public function output() {
		if (!file_exists($this->file)) {
			return "Error loading template file ($this->file).";
		}
		$output = file_get_contents($this->file);
	  
		foreach ($this->values as $key => $value) {
			$tagToReplace = "$$key";
			$output = str_replace($tagToReplace, $value, $output);
		}
	  
		return $output;
	}
	
	/**
	* Fusioniert ein Array von Templates.
	*
	* Läuft durch alle übergebenen Templates und hängt diese aneinander separiert durch ein Trennzeichen.
	*
	* @static
	* @param array $templates Ein Array von Template-Objekten.
	* @param string $separator Das genutze Trennzeichen. Standard ist ein Zeilenumbruch.
	* @return string Die aneinander gehängten Templateinhalte.
	*/
	public static function merge($templates, $separator = "\n") {
		$output = "";
	 
		foreach ($templates as $template) {
			$content = (get_class($template) !== "Template")
				? "Error, incorrect type - expected Template."
				: $template->output();
			$output .= $content . $separator;
		}
	 
		return $output;
	}
}
?>