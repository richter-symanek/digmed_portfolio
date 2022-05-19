/**
* Konfiguriert den gezeigten Cookie-Nutzungshinweis bez�glich Aussehen und Inhalt.
*
* @copyright 2015 Silktide Ltd
* @license The MIT License (MIT) (N�here Informationen unter: https://opensource.org/licenses/MIT)
*/
window.addEventListener("load", function(){
	window.cookieconsent.initialise({
	  "palette": {
		"popup": {
		  "background": "#009fe3",
		  "text": "#ffffff"
		},
		"button": {
		  "background": "#ff7e69",
		  "text": "#ffffff"
		}
	  },
	  "theme": "classic",
	  "content": {
		"message": "Damit der Tourguide funktioniert, nutzt er Cookies. Diese dienen nur der Funktionalit�t der Anwendung. Nach Abschluss der Tour werden die Cookies von deinem Ger�t gel�scht.",
		"dismiss": "Akzeptieren",
		"link": "Weitere Informationen",
		"href": "seite.php?page=datenschutz"
	  }
	})});