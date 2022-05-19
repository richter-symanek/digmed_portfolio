/**
* Setzt und unsetzt die Klasse "responsive" für das Element mit der ID "myTopnav" und der Klasse "topnav" beim Klick auf das zugehörige Icon.
*
* @copyright Refsnes Data unter https://www.w3schools.com/howto/howto_js_topnav_responsive.asp
* @license "Fair Use" von Copyright unterliegenem Material in der Forschung (Nähere Informationen unter: https://www.w3schools.com/about/about_copyright.asp)
*/
function mobileNavToggle() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}