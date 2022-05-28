<?php

/**
* Bietet das Skript für die Startseite.
*/

require("header.php"); // Seitenheader einfügen

?>

<section id="welcome">
    <h2>Willkommen!</h2>

    <p>
    Für die Familienforschung interessante Dokumente finden sich häufig verteilt auf viele verschiedene Seiten darunter die von Archiven, historischen Vereinen, anderen Kultureinrichtungen und privaten Forscher*innen. Gerade dort, wo große Datensätze gespeichert sind, wie bei den Staatsarchiven fehlt es an Personal und Geld, um die Inhalte adäquat zu erfassen und für Interessierte über die Suche zugänglich zu machen. Insbesondere die einzelnen Personeninformationen sind somit nur durch langwieriges Durchblättern ganzer Jahrgänge von z.B. Kirchenbüchern auffindbar.
    </p>

    <p>
    Zwar ist die geneaologische Forschung durch die Digitalisierung von Aufzeichnungen und zunehmende Bereitstellung von digitalen Quellenaufnahmen durch die Archive in den letzten Jahren bereits weit vorangekommen, allerdings baut ein großer Teil dieses Fortschritts aus benannten Gründen noch immer vor allem auf ehrenamtlicher Erfassung von Datensätzen auf. Durch die private Arbeit von Freiwilligen müssen Unterlagen nicht mehr von jeder Person selbst einzeln durchgesehen werden und mit der Erfassung in durchsuchbaren Datenbanken finden sich Informationen für die eigene Forschung, auf die man selbst durch eine fehlende Papierverbindung andernfalls nie gestoßen wäre. Die von mir entwickelte <b>Genealogische Datenbank</b> möchte hierzu einen Beitrag leisten, in dem ich Informationen meiner eigenen privaten Forschung anderen systematisch erfasst zur Verfügung stelle.
    </p>

    <h3>So funktioniert es</h3>

    <p>
    Erfasste Dokumente finden sich mit den systematisierbaren Informationen in der Datenbank und können über die Suchmaske durchsucht werden. Die Anwendung erlaubt die Suche nach Personeninfos wie Vorname, Name, Art der Aufzeichnung (Geburt, Taufe, Heirat, Todesfall, Beerdigung), Namen des Standesamtes oder Kirchspiels und Zeitraum der Aufzeichnung.
    </p>
    <p>
    Neben den Hauptakteur*innen einer erfassten Quelle können auch die darin erwähnten Personen (wie z.B. Eltern, Pat*innen, Trauzeug*innen oder bei der Behörde Anzeigende) durchsucht werden. Dadurch erlaubt die Seite den Zugriff auf Informationen, die in vielen anderen Erfassungsmethoden häufig sträflicherweise vernachlässigt werden und wichtige Hinweise auf Familie, Wohnorte und das weitere soziale Umfeld der gesuchten Personen liefern können.
    </p>
    <p>
    Die Suche lässt sich exakt (alle Kriterien müssen erfüllt sein) oder weit (nur eins der Kriterien muss erfüllt sein) fassen. Aktuell erlaubt sie noch nicht das Matching mit ähnlichen Personennamen, dies ist aber für die Zukunft geplant. Nach Namensbestandteilen kann dagegen gesucht und so weitere Einträge unter Namensvarianten gefunden werden. Aus welchen Orten in der Datenbank Aufzeichnungen erfasst sind, wird Ihnen bei der Sucheingabe als Vorschlag angezeigt.
    </p>

</section>

<?

require("footer.php"); // Seitenfooter einfügen

?>