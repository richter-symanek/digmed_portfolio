/**
* Ändert das Label neben der Toggle-Checkbox von Wahr-Falsch-Fragen zu entweder "Wahr" oder "Falsch".
*/
function changeToggleLabel(x) {
 if(x) document.getElementById("wahr_falsch_label").innerHTML="Wahr";
 else document.getElementById("wahr_falsch_label").innerHTML="Falsch";
}