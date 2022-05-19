/**
* Zeigt den aktuellen Wert des Inputs, von dem sie aufgerufen wurde, und setzt diesen als Innenwert des Elements mit der ID "slider_value".
*
* @author Michael S. Parks <parks@uh.edu> unter https://www.bauer.uh.edu/parks/slider.htm
*
* @param string x Der aktuelle Wert des Inputs.
*/
function show_value_of_input_range(x) {
 document.getElementById("slider_value").innerHTML=x;
}

/**
* Erhöht den Wert des Inputs mit der ID "antwort" um 1 und aktualisiert des angezeigten Wert.
*
* @author Michael S. Parks <parks@uh.edu> unter https://www.bauer.uh.edu/parks/slider.htm
*/
function add_one_to_input_range_slider() {
  document.getElementById("antwort").value=parseInt(document.getElementById("antwort").value)+1;
  show_value_of_input_range(document.getElementById("antwort").value);
}

/**
* Erniedrigt den Wert des Inputs mit der ID "antwort" um 1 und aktualisiert des angezeigten Wert.
*
* @author Michael S. Parks <parks@uh.edu> unter https://www.bauer.uh.edu/parks/slider.htm
*/
function subtract_one_from_input_range_slider() {
  document.getElementById("antwort").value=parseInt(document.getElementById("antwort").value)-1;
  show_value_of_input_range(document.getElementById("antwort").value);
}