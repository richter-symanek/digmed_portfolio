/**
* Zeigt das Modal mit der ID "hilfe_content".
*
* @author Jon Henshaw unter https://raventools.com/blog/create-a-modal-dialog-using-css-and-javascript/
*/
function show_hilfe() {
	el = document.getElementById("hilfe_content");
	el.style.display = (el.style.display == "block") ? "none" : "block";
	$("hilfe_content").css("position", "fixed");
}

/**
* Zeigt das Modal mit der ID "tipp_content".
*
* @author Jon Henshaw unter https://raventools.com/blog/create-a-modal-dialog-using-css-and-javascript/
*/
function show_tipp() {
	el = document.getElementById("tipp_content");
	el.style.display = (el.style.display == "block") ? "none" : "block";
	$("tipp_content").css("position", "fixed");
}