/**
* Konfiguriert den gezeigten Cookie-Nutzungshinweis bezüglich Aussehen und Inhalt.
*
* @copyright 2015 Silktide Ltd
* @license The MIT License (MIT) (Nähere Informationen unter: https://opensource.org/licenses/MIT)
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
		"message": "Damit der Tourguide funktioniert, nutzt er Cookies. Diese dienen nur der Funktionalität der Anwendung. Nach Abschluss der Tour werden die Cookies von deinem Gerät gelöscht.",
		"dismiss": "Akzeptieren",
		"link": "Weitere Informationen",
		"href": "seite.php?page=datenschutz"
	  }
	})});