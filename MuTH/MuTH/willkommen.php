<?php
require_once("global.inc.php");

/**
* Bietet das Skript für die Eingabe der Nutzer_innendaten (Name, Alter, Interessen) zum Start der Anwendung.
*/

// alle Klassen, die hier benötigt werden
require_once("./model/schlagwort.model.php");

if(isset($_GET['action'])) $action = trim(addslashes($_GET['action']));

$willkommenTemplate = new Template("templates/willkommen.tpl");
$headerTemplate->set("header_titel", "Einf&uuml;hrung");
$headerTemplate->set("header_symbol", "fas fa-spinner");
switch($action) {
	case "name":
		$inhaltTemplate = new Template("templates/willkommen/name.tpl");
		$willkommenTemplate->set("inhalt", $inhaltTemplate->output());
	break;
	case "name2":
		if(isset($_POST['vorname'])) {
			setName($_POST['vorname']);
			header("location: willkommen.php?action=alter");
			exit;
		}
	break;
	
	case "alter":
		$inhaltTemplate = new Template("templates/willkommen/alter.tpl");
		$willkommenTemplate->set("inhalt", $inhaltTemplate->output());
	break;
	case "alter2":
		if(isset($_POST['alter'])) {
			setAlter($_POST['alter']);
			header("location: willkommen.php?action=interessen");
			exit;
		}
	break;
	
	case "interessen":
		$result=Schlagwort::getAlleSchlagworte();
		while($schlagwort = $result->fetch_object("Schlagwort")) {
			$schlagwortTemplate = new Template("templates/willkommen/interessen_schlagwort.tpl");
			$schlagwortTemplate->set("schlagwort", $schlagwort->getSchlagwort());
			$schlagworteTemplates[] = $schlagwortTemplate;
		}
		$schlagworte = Template::merge($schlagworteTemplates);

		$inhaltTemplate = new Template("templates/willkommen/interessen.tpl");
		$inhaltTemplate->set("interessen", $schlagworte);
		$willkommenTemplate->set("inhalt", $inhaltTemplate->output());
	break;
	case "interessen2":
		if(isset($_POST['interessen'])) {
			$interessen = implode(",", $_POST['interessen']);
			setInteressen($interessen);
			header("location: uebersicht.php");
			exit;
		}
	break;
	default:
		//wenn die Anwendung bereits beendet wurde, wird zur Urkundenseite weitergeleitet
		if(istGesetztUrkundeId()){
			header("location: beenden.php");
			exit;
		}
		//je nachdem, welche Daten schon gesetzt wurden, wird entweder zu einem Schritt des Willkommensskriptes weitergeleitet oder zur Übersichtsseite
		else if(istGesetztName()) {
			if(istGesetztAlter()) {
				if(istGesetztInteressen()) {
					header("location: uebersicht.php");
					exit;
				}
				else {
					header("location: willkommen.php?action=interessen");
					exit;
				}
			}
			else {
				header("location: willkommen.php?action=alter");
				exit;
			}
		}
		else {
			header("location: willkommen.php?action=name");
			exit;
		}
	break;
}

$headerTemplate->set("header_hilfe", "");
$headerTemplate->set("header_tipp", "");
$willkommenTemplate->set("header", $headerTemplate->output());
$willkommenTemplate->set("footer", $footerTemplate->output());
if(!isset($inhaltTemplate)) $willkommenTemplate->set("inhalt", "");

echo $willkommenTemplate->output();
?>