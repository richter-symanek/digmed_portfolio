-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: dd21626
-- Erstellungszeit: 22. Aug 2018 um 13:16
-- Server Version: 5.7.21-nmm1-log
-- PHP-Version: 5.5.38-nmm3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `d02b407e`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `antwortmoeglichkeit`
--

CREATE TABLE IF NOT EXISTS `antwortmoeglichkeit` (
  `antwortmoeglichkeit_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `antwortmoeglichkeit_antwort` varchar(150) NOT NULL,
  PRIMARY KEY (`antwortmoeglichkeit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Daten für Tabelle `antwortmoeglichkeit`
--

INSERT INTO `antwortmoeglichkeit` (`antwortmoeglichkeit_id`, `antwortmoeglichkeit_antwort`) VALUES
(1, 'Eine Gummipumpe'),
(2, 'Zimmermannswerkzeug'),
(3, 'Ein sehr langer Nagel'),
(4, 'Eine Schatztruhe'),
(5, 'Äxte'),
(6, 'Scheren'),
(7, 'Dechsel'),
(8, 'Hammer'),
(9, 'Mörser'),
(10, 'Baumwolle'),
(11, 'Hanf'),
(12, 'Seide'),
(13, 'Ein Rentiergeweih'),
(14, 'Bambus aus China'),
(15, 'Wetzsteine aus Norwegen'),
(16, 'Bronzene Kochtöpfe aus England'),
(17, 'Schwefel aus Island'),
(18, 'Wein aus Italien'),
(19, 'blau'),
(20, 'rot-orange'),
(21, 'gelb-grün'),
(22, 'Ein diplomatisches Bündnis zwischen europäischen Staaten'),
(23, 'Ein Zusammenschluss von Kaufleuten'),
(24, 'Eine Gemeinschaft von Städten'),
(25, 'Eine Geschäftskette'),
(26, 'Straßen- und Ortsschilder'),
(27, 'Küstenlinien mit Hügeln und Gebäuden'),
(28, 'Fackeln entlang der Strecke'),
(29, 'Küstliche Markierungen, auch Seezeichen genannt'),
(30, 'Segelbücher mit Anweisungen für bestimmte Schiffsrouten');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `erklaerung`
--

CREATE TABLE IF NOT EXISTS `erklaerung` (
  `station_id` int(11) unsigned NOT NULL,
  `erklaerung_text` text NOT NULL,
  `erklaerung_hat_bild` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`station_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `erklaerung`
--

INSERT INTO `erklaerung` (`station_id`, `erklaerung_text`, `erklaerung_hat_bild`) VALUES
(1, 'Tatsächlich ist die Kogge ein mittelalterliches Handelsschiff. Datiert wurde sie, indem Wissenschaftler die Jahresringe des verwendeten Holzes untersuchten.', 0),
(4, 'Die durchschnittliche Ladekapazitäten von Schiffen wie der Kogge lag bei etwa 80-84 Tonnen. Zum Vergleich: Die größten Containerschiffe heute können teils 225.000 Tonnen und mehr laden.', 1),
(6, 'Einer der verwendeten Helme kann in der Ausstellung angesehen werden. Er hat vier Fenster zum Gucken - eins oben, links, rechts und vorne in der Mitte. Inzwischen taucht man nur noch zum verrichten schwerer Arbeiten mit Helm und auch dann sind die heute benutzten Helme wohl deutlich bequemer als die massiven Metallhelme aus der Zeit der Koggenausgrabung.', 0),
(7, 'Bei der Darßer Kogge handelt es sich um ein Schiffswrack ähnlich der Bremer Kogge. Es wurde in der Ostsee vor Mecklenburg-Vorpommern gefunden. Die Funde an Bord zeigen, dass sich Handelsbeziehungen damals schon über den gesamten Ost- und Nordseeraum erstreckten. Die vielfältige Herkunft der Waren ist dabei erstaunlich.', 0),
(8, 'Ab dem 15. Jahrhundert begann von Norddeutschland aus ein ausgiebiger Handel mit den nordatlantischen Inseln wie Island, Shetland und den Färöern. Besonders interessant für europäische Händler war das in Island abgebaute Schwefel. Das wurde in ganz Europa zur Herstellung von Schießpulver verwendet. Aber auch Stockfisch wurde von dor nach Europa gebracht. Dieser Handelt prägte ab da für etwa 200 Jahre stark die isländische Kultur.', 0),
(10, 'Die Hanse bezeichnete einen Zusammenschluss von Kaufleuten und gleichzeitige Gemeinschaft von Städten. Ziel war, Kaufleuten Schutz bei Handelsreisen zu bringen und gleichzeitig den Händlern innerhalb der Gemeinschaft Vorteile durch die Zusammenarbeit zu schaffen. Noch heute tragen Städte wie Bremen und Hamburg die Hanse in ihrem Namen. Deswegen ist das Autokennzeichen von Bremen zum Beispiel "HB" für "Hansestadt Bremen".\nDie Hanse verlor schließlich im Verlauf des Spätmittelalters beziehungsweise der frühen Neuzeit an Bedeutung.', 0),
(11, 'Die Entfernungen von zwei Orten wurden früher von Seeleuten in Stunden und Tagen angegeben. Das hatte den Grund, dass noch keine Technologien zur Verfügung standen, um längere Strecken auszumessen. Man konnte aber sagen, wie lange die Reise von einem Punkt zum anderen in etwa dauerte.', 0),
(12, 'Ohne moderne Technologien zur Orientierung, fuhren Schiffe häufig entlang der Küsten, um Kurs zu halten. Natürliche Marker wie Berge oder Buchten konnten helfen zu identifizieren, wo sich das Schiff befindet. Aber auch künstliche Markierungen – sogenannte Seezeichen – wurden verwendet. Zusätzlich gab es für manche Strecken Segelbücher mit genauen Anweisungen für eine bestimmte Route zwischen zwei Orten.', 1),
(13, 'Die Kogge ist nicht nur 8m breit sondern auch 20m lang. Ganz schön klein, im Vergleich zu heutigen Frachtschiffen!', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schlagwort`
--

CREATE TABLE IF NOT EXISTS `schlagwort` (
  `schlagwort_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `schlagwort` varchar(100) NOT NULL,
  PRIMARY KEY (`schlagwort_id`),
  UNIQUE KEY `schlagwort` (`schlagwort`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `schlagwort`
--

INSERT INTO `schlagwort` (`schlagwort_id`, `schlagwort`) VALUES
(2, 'Ausgrabungen'),
(5, 'Die Hanse'),
(4, 'Handel'),
(1, 'Kogge'),
(7, 'Mittelalter'),
(6, 'Navigieren auf See'),
(3, 'Schiffsbau');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `seite`
--

CREATE TABLE IF NOT EXISTS `seite` (
  `seite_bezeichner` varchar(75) NOT NULL,
  `seite_menuetitel` varchar(75) NOT NULL,
  `seite_titel` varchar(150) NOT NULL,
  `seite_inhalt` text NOT NULL,
  `seite_ordnungsnummer` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`seite_bezeichner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `seite`
--

INSERT INTO `seite` (`seite_bezeichner`, `seite_menuetitel`, `seite_titel`, `seite_inhalt`, `seite_ordnungsnummer`) VALUES
('datenschutz', 'Datenschutzerklärung', 'Datenschutzerklärung', '<h3 id="dsg-general-intro"></h3><p>Diese Datenschutzerklärung klärt Sie über die Art, den Umfang und Zweck der Verarbeitung von personenbezogenen Daten (nachfolgend kurz „Daten“) im Rahmen der Erbringung unserer Leistungen sowie innerhalb unseres Onlineangebotes und der mit ihm verbundenen Webseiten, Funktionen und Inhalte sowie externen Onlinepräsenzen, wie z.B. unser Social Media Profile auf (nachfolgend gemeinsam bezeichnet als „Onlineangebot“). Im Hinblick auf die verwendeten Begrifflichkeiten, wie z.B. „Verarbeitung“ oder „Verantwortlicher“ verweisen wir auf die Definitionen im Art. 4 der Datenschutzgrundverordnung (DSGVO). <br>\n<br>\n</p><h3 id="dsg-general-controller">Verantwortlicher</h3><p><span class="tsmcontroller">Yaël Richter-Symanek<br>\nBismarckstraße 347<br>\n28205 Bremen<br>\nDeutschland<br>\n<br>\n<img src="resources/images/impressum_datenschutz_email.png"></span></p><h3 id="dsg-general-datatype">Arten der verarbeiteten Daten</h3><p>-	Bestandsdaten (z.B., Personen-Stammdaten, Namen oder Adressen).<br>\n-	Kontaktdaten (z.B., E-Mail, Telefonnummern).<br>\n-	Inhaltsdaten (z.B., Texteingaben, Fotografien, Videos).<br>\n-	Nutzungsdaten (z.B., besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten).<br>\n-	Meta-/Kommunikationsdaten (z.B., Geräte-Informationen, IP-Adressen).</p><h3 id="dsg-general-datasubjects">Kategorien betroffener Personen</h3><p>Besucher und Nutzer des Onlineangebotes (Nachfolgend bezeichnen wir die betroffenen Personen zusammenfassend auch als „Nutzer“).<br>\n</p><h3 id="dsg-general-purpose">Zweck der Verarbeitung</h3><p>-	Zurverfügungstellung des Onlineangebotes, seiner Funktionen und  Inhalte.<br>\n-	Beantwortung von Kontaktanfragen und Kommunikation mit Nutzern.<br>\n-	Sicherheitsmaßnahmen.<br>\n-	Reichweitenmessung/Marketing<br>\n<span class="tsmcom"></span></p><h3 id="dsg-general-terms">Verwendete Begrifflichkeiten </h3><p>„Personenbezogene Daten“ sind alle Informationen, die sich auf eine identifizierte oder identifizierbare natürliche Person (im Folgenden „betroffene Person“) beziehen; als identifizierbar wird eine natürliche Person angesehen, die direkt oder indirekt, insbesondere mittels Zuordnung zu einer Kennung wie einem Namen, zu einer Kennnummer, zu Standortdaten, zu einer Online-Kennung (z.B. Cookie) oder zu einem oder mehreren besonderen Merkmalen identifiziert werden kann, die Ausdruck der physischen, physiologischen, genetischen, psychischen, wirtschaftlichen, kulturellen oder sozialen Identität dieser natürlichen Person sind.<br>\n<br>\n„Verarbeitung“ ist jeder mit oder ohne Hilfe automatisierter Verfahren ausgeführte Vorgang oder jede solche Vorgangsreihe im Zusammenhang mit personenbezogenen Daten. Der Begriff reicht weit und umfasst praktisch jeden Umgang mit Daten.<br>\n<br>\n„Pseudonymisierung“ die Verarbeitung personenbezogener Daten in einer Weise, dass die personenbezogenen Daten ohne Hinzuziehung zusätzlicher Informationen nicht mehr einer spezifischen betroffenen Person zugeordnet werden können, sofern diese zusätzlichen Informationen gesondert aufbewahrt werden und technischen und organisatorischen Maßnahmen unterliegen, die gewährleisten, dass die personenbezogenen Daten nicht einer identifizierten oder identifizierbaren natürlichen Person zugewiesen werden.<br>\n<br>\n„Profiling“ jede Art der automatisierten Verarbeitung personenbezogener Daten, die darin besteht, dass diese personenbezogenen Daten verwendet werden, um bestimmte persönliche Aspekte, die sich auf eine natürliche Person beziehen, zu bewerten, insbesondere um Aspekte bezüglich Arbeitsleistung, wirtschaftliche Lage, Gesundheit, persönliche Vorlieben, Interessen, Zuverlässigkeit, Verhalten, Aufenthaltsort oder Ortswechsel dieser natürlichen Person zu analysieren oder vorherzusagen.<br>\n<br>\nAls „Verantwortlicher“ wird die natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten entscheidet, bezeichnet.<br>\n<br>\n„Auftragsverarbeiter“ eine natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die personenbezogene Daten im Auftrag des Verantwortlichen verarbeitet.<br>\n</p><h3 id="dsg-general-legalbasis">Maßgebliche Rechtsgrundlagen</h3><p>Nach Maßgabe des Art. 13 DSGVO teilen wir Ihnen die Rechtsgrundlagen unserer Datenverarbeitungen mit.  Für Nutzer aus dem Geltungsbereich der Datenschutzgrundverordnung (DSGVO), d.h. der EU und des EWG gilt, sofern die Rechtsgrundlage in der Datenschutzerklärung nicht genannt wird, Folgendes: <br>\nDie Rechtsgrundlage für die Einholung von Einwilligungen ist Art. 6 Abs. 1 lit. a und Art. 7 DSGVO;<br>\nDie Rechtsgrundlage für die Verarbeitung zur Erfüllung unserer Leistungen und Durchführung vertraglicher Maßnahmen sowie Beantwortung von Anfragen ist Art. 6 Abs. 1 lit. b DSGVO;<br>\nDie Rechtsgrundlage für die Verarbeitung zur Erfüllung unserer rechtlichen Verpflichtungen ist Art. 6 Abs. 1 lit. c DSGVO;<br>\nFür den Fall, dass lebenswichtige Interessen der betroffenen Person oder einer anderen natürlichen Person eine Verarbeitung personenbezogener Daten erforderlich machen, dient Art. 6 Abs. 1 lit. d DSGVO als Rechtsgrundlage.<br>\nDie Rechtsgrundlage für die erforderliche Verarbeitung zur Wahrnehmung einer Aufgabe, die im öffentlichen Interesse liegt oder in Ausübung öffentlicher Gewalt erfolgt, die dem Verantwortlichen übertragen wurde ist Art. 6 Abs. 1 lit. e DSGVO. <br>\nDie Rechtsgrundlage für die Verarbeitung zur Wahrung unserer berechtigten Interessen ist Art. 6 Abs. 1 lit. f DSGVO. <br>\nDie Verarbeitung von Daten zu anderen Zwecken als denen, zu denen sie ehoben wurden, bestimmt sich nach den Vorgaben des Art 6 Abs. 4 DSGVO. <br>\nDie Verarbeitung von besonderen Kategorien von Daten (entsprechend Art. 9 Abs. 1 DSGVO) bestimmt sich nach den Vorgaben des Art. 9 Abs. 2 DSGVO. <br>\n</p><h3 id="dsg-general-securitymeasures">Sicherheitsmaßnahmen</h3><p>Wir treffen nach Maßgabe der gesetzlichen Vorgabenunter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der unterschiedlichen Eintrittswahrscheinlichkeit und Schwere des Risikos für die Rechte und Freiheiten natürlicher Personen, geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten.<br>\n<br>\nZu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von Daten durch Kontrolle des physischen Zugangs zu den Daten, als auch des sie betreffenden Zugriffs, der Eingabe, Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, Löschung von Daten und Reaktion auf Gefährdung der Daten gewährleisten. Ferner berücksichtigen wir den Schutz personenbezogener Daten bereits bei der Entwicklung, bzw. Auswahl von Hardware, Software sowie Verfahren, entsprechend dem Prinzip des Datenschutzes durch Technikgestaltung und durch datenschutzfreundliche Voreinstellungen.<br>\n</p><h3 id="dsg-general-coprocessing">Zusammenarbeit mit Auftragsverarbeitern, gemeinsam Verantwortlichen und Dritten</h3><p>Sofern wir im Rahmen unserer Verarbeitung Daten gegenüber anderen Personen und Unternehmen (Auftragsverarbeitern, gemeinsam Verantwortlichen oder Dritten) offenbaren, sie an diese übermitteln oder ihnen sonst Zugriff auf die Daten gewähren, erfolgt dies nur auf Grundlage einer gesetzlichen Erlaubnis (z.B. wenn eine Übermittlung der Daten an Dritte, wie an Zahlungsdienstleister, zur Vertragserfüllung erforderlich ist), Nutzer eingewilligt haben, eine rechtliche Verpflichtung dies vorsieht oder auf Grundlage unserer berechtigten Interessen (z.B. beim Einsatz von Beauftragten, Webhostern, etc.). <br>\n<br>\nSofern wir Daten anderen Unternehmen unserer Unternehmensgruppe offenbaren, übermitteln oder ihnen sonst den Zugriff gewähren, erfolgt dies insbesondere zu administrativen Zwecken als berechtigtes Interesse und darüberhinausgehend auf einer den gesetzlichen Vorgaben entsprechenden Grundlage. <br>\n</p><h3 id="dsg-general-thirdparty">Übermittlungen in Drittländer</h3><p>Sofern wir Daten in einem Drittland (d.h. außerhalb der Europäischen Union (EU), des Europäischen Wirtschaftsraums (EWR) oder der Schweizer Eidgenossenschaft) verarbeiten oder dies im Rahmen der Inanspruchnahme von Diensten Dritter oder Offenlegung, bzw. Übermittlung von Daten an andere Personen oder Unternehmen geschieht, erfolgt dies nur, wenn es zur Erfüllung unserer (vor)vertraglichen Pflichten, auf Grundlage Ihrer Einwilligung, aufgrund einer rechtlichen Verpflichtung oder auf Grundlage unserer berechtigten Interessen geschieht. Vorbehaltlich gesetzlicher oder vertraglicher Erlaubnisse, verarbeiten oder lassen wir die Daten in einem Drittland nur beim Vorliegen der gesetzlichen Voraussetzungen. D.h. die Verarbeitung erfolgt z.B. auf Grundlage besonderer Garantien, wie der offiziell anerkannten Feststellung eines der EU entsprechenden Datenschutzniveaus (z.B. für die USA durch das „Privacy Shield“) oder Beachtung offiziell anerkannter spezieller vertraglicher Verpflichtungen.</p><h3 id="dsg-general-rightssubject">Rechte der betroffenen Personen</h3><p>Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob betreffende Daten verarbeitet werden und auf Auskunft über diese Daten sowie auf weitere Informationen und Kopie der Daten entsprechend den gesetzlichen Vorgaben.<br>\n<br>\nSie haben entsprechend. den gesetzlichen Vorgaben das Recht, die Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen Daten zu verlangen.<br>\n<br>\nSie haben nach Maßgabe der gesetzlichen Vorgaben das Recht zu verlangen, dass betreffende Daten unverzüglich gelöscht werden, bzw. alternativ nach Maßgabe der gesetzlichen Vorgaben eine Einschränkung der Verarbeitung der Daten zu verlangen.<br>\n<br>\nSie haben das Recht zu verlangen, dass die Sie betreffenden Daten, die Sie uns bereitgestellt haben nach Maßgabe der gesetzlichen Vorgaben zu erhalten und deren Übermittlung an andere Verantwortliche zu fordern. <br>\n<br>\nSie haben ferner nach Maßgabe der gesetzlichen Vorgaben das Recht, eine Beschwerde bei der zuständigen Aufsichtsbehörde einzureichen.<br>\n</p><h3 id="dsg-general-revokeconsent">Widerrufsrecht</h3><p>Sie haben das Recht, erteilte Einwilligungen mit Wirkung für die Zukunft zu widerrufen.</p><h3 id="dsg-general-object">Widerspruchsrecht</h3><p><strong>Sie können der künftigen Verarbeitung der Sie betreffenden Daten nach Maßgabe der gesetzlichen Vorgaben jederzeit widersprechen. Der Widerspruch kann insbesondere gegen die Verarbeitung für Zwecke der Direktwerbung erfolgen.</strong></p><h3 id="dsg-general-cookies">Cookies und Widerspruchsrecht bei Direktwerbung</h3><p>Als „Cookies“ werden kleine Dateien bezeichnet, die auf Rechnern der Nutzer gespeichert werden. Innerhalb der Cookies können unterschiedliche Angaben gespeichert werden. Ein Cookie dient primär dazu, die Angaben zu einem Nutzer (bzw. dem Gerät auf dem das Cookie gespeichert ist) während oder auch nach seinem Besuch innerhalb eines Onlineangebotes zu speichern. Als temporäre Cookies, bzw. „Session-Cookies“ oder „transiente Cookies“, werden Cookies bezeichnet, die gelöscht werden, nachdem ein Nutzer ein Onlineangebot verlässt und seinen Browser schließt. In einem solchen Cookie kann z.B. der Inhalt eines Warenkorbs in einem Onlineshop oder ein Login-Status gespeichert werden. Als „permanent“ oder „persistent“ werden Cookies bezeichnet, die auch nach dem Schließen des Browsers gespeichert bleiben. So kann z.B. der Login-Status gespeichert werden, wenn die Nutzer diese nach mehreren Tagen aufsuchen. Ebenso können in einem solchen Cookie die Interessen der Nutzer gespeichert werden, die für Reichweitenmessung oder Marketingzwecke verwendet werden. Als „Third-Party-Cookie“ werden Cookies bezeichnet, die von anderen Anbietern als dem Verantwortlichen, der das Onlineangebot betreibt, angeboten werden (andernfalls, wenn es nur dessen Cookies sind spricht man von „First-Party Cookies“).<br>\n<br>\nWir können temporäre und permanente Cookies einsetzen und klären hierüber im Rahmen unserer Datenschutzerklärung auf.<br>\n<br>\nFalls die Nutzer nicht möchten, dass Cookies auf ihrem Rechner gespeichert werden, werden sie gebeten die entsprechende Option in den Systemeinstellungen ihres Browsers zu deaktivieren. Gespeicherte Cookies können in den Systemeinstellungen des Browsers gelöscht werden. Der Ausschluss von Cookies kann zu Funktionseinschränkungen dieses Onlineangebotes führen.<br>\n<br>\nEin genereller Widerspruch gegen den Einsatz der zu Zwecken des Onlinemarketing eingesetzten Cookies kann bei einer Vielzahl der Dienste, vor allem im Fall des Trackings, über die US-amerikanische Seite <a href="http://www.aboutads.info/choices/">http://www.aboutads.info/choices/</a> oder die EU-Seite <a href="http://www.youronlinechoices.com/">http://www.youronlinechoices.com/</a> erklärt werden. Des Weiteren kann die Speicherung von Cookies mittels deren Abschaltung in den Einstellungen des Browsers erreicht werden. Bitte beachten Sie, dass dann gegebenenfalls nicht alle Funktionen dieses Onlineangebotes genutzt werden können.</p><h3 id="dsg-general-erasure">Löschung von Daten</h3><p>Die von uns verarbeiteten Daten werden nach Maßgabe der gesetzlichen Vorgaben gelöscht oder in ihrer Verarbeitung eingeschränkt. Sofern nicht im Rahmen dieser Datenschutzerklärung ausdrücklich angegeben, werden die bei uns gespeicherten Daten gelöscht, sobald sie für ihre Zweckbestimmung nicht mehr erforderlich sind und der Löschung keine gesetzlichen Aufbewahrungspflichten entgegenstehen. <br>\n<br>\nSofern die Daten nicht gelöscht werden, weil sie für andere und gesetzlich zulässige Zwecke erforderlich sind, wird deren Verarbeitung eingeschränkt. D.h. die Daten werden gesperrt und nicht für andere Zwecke verarbeitet. Das gilt z.B. für Daten, die aus handels- oder steuerrechtlichen Gründen aufbewahrt werden müssen.</p><h3 id="dsg-general-changes">Änderungen und Aktualisierungen der Datenschutzerklärung</h3><p>Wir bitten Sie sich regelmäßig über den Inhalt unserer Datenschutzerklärung zu informieren. Wir passen die Datenschutzerklärung an, sobald die Änderungen der von uns durchgeführten Datenverarbeitungen dies erforderlich machen. Wir informieren Sie, sobald durch die Änderungen eine Mitwirkungshandlung Ihrerseits (z.B. Einwilligung) oder eine sonstige individuelle Benachrichtigung erforderlich wird.</p><p></p><h3 id="dsg-hostingprovider">Hosting und E-Mail-Versand</h3><p></p><p><span class="ts-muster-content">Die von uns in Anspruch genommenen Hosting-Leistungen dienen der Zurverfügungstellung der folgenden Leistungen: Infrastruktur- und Plattformdienstleistungen, Rechenkapazität, Speicherplatz und Datenbankdienste, E-Mail-Versand, Sicherheitsleistungen sowie technische Wartungsleistungen, die wir zum Zwecke des Betriebs dieses Onlineangebotes einsetzen. <br>\n<br>\nHierbei verarbeiten wir, bzw. unser Hostinganbieter Bestandsdaten, Kontaktdaten, Inhaltsdaten, Vertragsdaten, Nutzungsdaten, Meta- und Kommunikationsdaten von Kunden, Interessenten und Besuchern dieses Onlineangebotes auf Grundlage unserer berechtigten Interessen an einer effizienten und sicheren Zurverfügungstellung dieses Onlineangebotes gem. Art. 6 Abs. 1 lit. f DSGVO i.V.m. Art. 28 DSGVO (Abschluss Auftragsverarbeitungsvertrag).</span></p><p></p><h3 id="dsg-logfiles">Erhebung von Zugriffsdaten und Logfiles</h3><p></p><p><span class="ts-muster-content">Wir, bzw. unser Hostinganbieter, erhebt auf Grundlage unserer berechtigten Interessen im Sinne des Art. 6 Abs. 1 lit. f. DSGVO Daten über jeden Zugriff auf den Server, auf dem sich dieser Dienst befindet (sogenannte Serverlogfiles). Zu den Zugriffsdaten gehören Name der abgerufenen Webseite, Datei, Datum und Uhrzeit des Abrufs, übertragene Datenmenge, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite), IP-Adresse und der anfragende Provider.<br>\n<br>\nLogfile-Informationen werden aus Sicherheitsgründen (z.B. zur Aufklärung von Missbrauchs- oder Betrugshandlungen) für die Dauer von maximal 7 Tagen gespeichert und danach gelöscht. Daten, deren weitere Aufbewahrung zu Beweiszwecken erforderlich ist, sind bis zur endgültigen Klärung des jeweiligen Vorfalls von der Löschung ausgenommen.</span></p><p></p><h3 id="dsg-thirdparty-googlefonts">Google Fonts</h3><p></p><p><span class="ts-muster-content">Wir binden die Schriftarten ("Google Fonts") des Anbieters Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA, ein. Datenschutzerklärung: <a target="_blank" href="https://www.google.com/policies/privacy/">https://www.google.com/policies/privacy/</a>, Opt-Out: <a target="_blank" href="https://adssettings.google.com/authenticated">https://adssettings.google.com/authenticated</a>.</span></p><a href="https://datenschutz-generator.de" class="dsg1-6" rel="nofollow" target="_blank">Erstellt mit Datenschutz-Generator.de von RA Dr. Thomas Schwenke</a>', 2),
('elterninfo', 'Elterninformationen', 'Informationen für Eltern', '<p>Als Eltern oder Betreuer_innen haben Sie ein berechtigtes Interesse daran, was für Anwendungen Ihr Kind nutzt. Bei MuTH - dem Kindertourguide des Deutschen Schiffahrtsmuseums - handelt es sich um eine interaktive Spieleanwendung, die Ihrem Kind die Ausstellungsinhalte in altersentsprechender Form nahe bringen soll. Ausgelegt ist die Software auf Kinder im Alter von 9 bis 12 Jahren, kann aber auch von jüngeren Kindern mit digitaler Vorerfahrung und ausgeprägten Lesefähigkeiten oder interessierten älteren Kindern verwendet werden.</p>\n\n<p>Für die Funktionen der Anwendung müssen wir einige Daten ihres Kindes, die zum Anfang abgefragt werden, zwischenspeichern. Das sind der angegebene Vorname, das Alter und die ausgewählten Interessen sowie natürlich etwaige Punkte, die während der Benutzung gesammelt werden. Diese Daten speichern wir zunächst nur in Form von Cookies auf dem mobilen Gerät Ihres Kindes. Mit Abschließen der Anwendung wird gefragt, ob eine Urkunde über die erzielten Erfolge mitgenommen werden soll. Diese Urkunde kann dann am Empfang ausgedruckt werden. Im Falle einer solchen Urkundengenerierung werden der Name und die absolvierten Touren und dabei gewonnenen Punkte für die Dauer bis Sie die Urkunde abholen in unserer Datenbank gespeichert. Nach Abholung der Urkunde und ansonsten spätestens nach Öffnungsschluss werden diese Daten gelöscht. Die Cookies, die für das Spiel auf dem Smartphone oder Tablet gespeichert werden, werden mit Beenden und bei Generierung einer Urkunde mit Neustart der Anwendung gelöscht. Ansonsten verfallen sie nach 24 Stunden. Keine bei uns gespeicherten Daten wie der Name oder das Alter werden weitergegeben oder zu anderen Zwecken verwendet als den hier aufgeführten.</p>', 3),
('impressum', 'Impressum', 'Impressum', '<h2>Angaben gem&auml;&szlig; &sect; 5 TMG</h2>\n<p>Ya&euml;l Richter-Symanek<br />\nBismarckstra&szlig;e 347<br />\n28205 Bremen</p>\n\n<h2>Kontakt</h2>\n<img src="resources/images/impressum_datenschutz_email.png"></p>\n\n<h3>Haftung f&uuml;r Inhalte</h3> <p>Als Diensteanbieter sind wir gem&auml;&szlig; &sect; 7 Abs.1 TMG f&uuml;r eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach &sect;&sect; 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, &uuml;bermittelte oder gespeicherte fremde Informationen zu &uuml;berwachen oder nach Umst&auml;nden zu forschen, die auf eine rechtswidrige T&auml;tigkeit hinweisen.</p> <p>Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unber&uuml;hrt. Eine diesbez&uuml;gliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung m&ouml;glich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.</p> <h3>Haftung f&uuml;r Links</h3> <p>Unser Angebot enth&auml;lt Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb k&ouml;nnen wir f&uuml;r diese fremden Inhalte auch keine Gew&auml;hr &uuml;bernehmen. F&uuml;r die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf m&ouml;gliche Rechtsverst&ouml;&szlig;e &uuml;berpr&uuml;ft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.</p> <p>Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.</p> <h3>Urheberrecht</h3> <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielf&auml;ltigung, Bearbeitung, Verbreitung und jede Art der Verwertung au&szlig;erhalb der Grenzen des Urheberrechtes bed&uuml;rfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur f&uuml;r den privaten, nicht kommerziellen Gebrauch gestattet.</p> <p>Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.</p>\n\n<p>Quelle: <a href="https://www.e-recht24.de">eRecht24</a></p>\n\n<h2>Verwendetes Bildmaterial</h2>\n<div>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>\n<div>Icons made by <a href="https://www.flaticon.com/authors/roundicons" title="Roundicons">Roundicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>\n<div>Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>\n<div>Icons made by <a href="https://www.flaticon.com/authors/pixel-buddha" title="Pixel Buddha">Pixel Buddha</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>\n<div>Icons made by <a href="https://www.flaticon.com/authors/pause08" title="Pause08">Pause08</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `station`
--

CREATE TABLE IF NOT EXISTS `station` (
  `station_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `station_name` varchar(150) NOT NULL,
  `station_punkte` int(11) unsigned NOT NULL DEFAULT '0',
  `station_typ` varchar(150) NOT NULL,
  `station_tipp` varchar(300) NOT NULL,
  `station_hat_bild` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`station_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `station`
--

INSERT INTO `station` (`station_id`, `station_name`, `station_punkte`, `station_typ`, `station_tipp`, `station_hat_bild`) VALUES
(1, 'Die Kogge', 10, 'wahr_falsch', '', 0),
(2, 'Weitere Funde', 5, 'mehrfachantwort', 'Du findest die Funde alle in einer Vitrine ausgestellt.', 0),
(3, 'Werkzeuge', 5, 'mehrfachantwort', 'Wähle alle Werkzeuge aus, die du in der Ausstellung um die Kogge finden kannst.', 1),
(4, 'Ladekapazität', 10, 'schaetzen', 'Such doch mal nach einer richtigen Tonne in der Ausstellung. Und übrigens – eine Tonne sind 1000kg. Ein afrikanischer Elefant wiegt also zum Beispiel 6 Tonnen.', 0),
(5, 'Taumaterial', 10, 'mehrfachantwort', 'Probier an der Station doch einmal selber aus, wie man Taue dreht und finde die Antwort dabei heraus.', 0),
(6, 'Taucherhelm', 10, 'schaetzen', 'Bei den Informationen zur Ausgrabung der Kogge findest du bestimmt einen Hinweis.', 1),
(7, 'Die Darßer Kogge', 5, 'mehrfachantwort', 'In diesem Teil der Ausstellung findest du mehrere Karten auf großen Tischen. Auf einem siehst du bereits von weitem eine der hier genannten Antwortmöglichkeiten. Dort gibt es auch weitere Informationen.', 1),
(8, 'Nordatlantische Inseln', 10, 'wahr_falsch', '', 1),
(9, 'Die Farbe von Schwefel', 10, 'mehrfachantwort', 'Bei Schwefel handelt es sich auch um einen der Rohstoffe, die damals gehandelt wurden. Wenn du nach Informationen suchst, halte doch einmal nach einem Falken Ausschau.', 0),
(10, 'Die Hanse', 5, 'mehrfachantwort', 'Bremen ist auch heute noch eine Hansestadt.', 0),
(11, 'Entfernungen auf See', 10, 'wahr_falsch', 'Überleg einmal, was für Technologien damals zur Verfügung standen, um Strecken auszumessen, oder guck nach dem Thema "Navigation".', 1),
(12, 'Navigationshilfen', 10, 'mehrfachantwort', '', 1),
(13, 'Breite der Kogge', 15, 'schaetzen', 'Lauf doch einmal die ganze Breite der Kogge (also ihre kurze Seite) in langen Schritten ab. Wie viele brauchst du?', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `station_mehrfachantwort`
--

CREATE TABLE IF NOT EXISTS `station_mehrfachantwort` (
  `station_id` int(11) unsigned NOT NULL,
  `station_frage` varchar(250) NOT NULL,
  PRIMARY KEY (`station_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `station_mehrfachantwort`
--

INSERT INTO `station_mehrfachantwort` (`station_id`, `station_frage`) VALUES
(2, 'Was für Gegenstande wurden bei der Kogge gefunden?'),
(3, 'Welche Werkzeuge wurden beim Bau der Kogge verwendet?'),
(5, 'Aus welchem Rohstoff wurden Taue hergestellt?'),
(7, 'Was transportierte die "Darßer Kogge"?'),
(9, 'Welche Farbe hat Schwefel?'),
(10, 'Bei der "Hanse" handelt es sich um...?'),
(12, 'Was wurde im Mittelalter als Hilfe beim Navigieren eingesetzt?');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `station_mehrfachantwort_antwortmoeglichkeit`
--

CREATE TABLE IF NOT EXISTS `station_mehrfachantwort_antwortmoeglichkeit` (
  `station_id` int(11) unsigned NOT NULL,
  `antwortmoeglichkeit_id` int(11) unsigned NOT NULL,
  `station_antwortmoeglichkeit_richtig` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`station_id`,`antwortmoeglichkeit_id`),
  KEY `antwortmoeglichkeit_id` (`antwortmoeglichkeit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `station_mehrfachantwort_antwortmoeglichkeit`
--

INSERT INTO `station_mehrfachantwort_antwortmoeglichkeit` (`station_id`, `antwortmoeglichkeit_id`, `station_antwortmoeglichkeit_richtig`) VALUES
(2, 1, 0),
(2, 2, 1),
(2, 3, 1),
(2, 4, 0),
(3, 5, 1),
(3, 6, 0),
(3, 7, 1),
(3, 8, 1),
(3, 9, 0),
(5, 10, 0),
(5, 11, 1),
(5, 12, 0),
(7, 13, 1),
(7, 14, 0),
(7, 15, 1),
(7, 16, 1),
(7, 17, 1),
(7, 18, 0),
(9, 19, 0),
(9, 20, 0),
(9, 21, 1),
(10, 22, 0),
(10, 23, 1),
(10, 24, 1),
(10, 25, 0),
(12, 26, 0),
(12, 27, 1),
(12, 28, 0),
(12, 29, 1),
(12, 30, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `station_schaetzen`
--

CREATE TABLE IF NOT EXISTS `station_schaetzen` (
  `station_id` int(11) unsigned NOT NULL,
  `station_frage` varchar(250) NOT NULL,
  `station_antwort` int(11) NOT NULL,
  `station_min_antwort` int(11) NOT NULL,
  `station_max_antwort` int(11) NOT NULL,
  `station_min_range` int(11) NOT NULL DEFAULT '0',
  `station_max_range` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`station_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `station_schaetzen`
--

INSERT INTO `station_schaetzen` (`station_id`, `station_frage`, `station_antwort`, `station_min_antwort`, `station_max_antwort`, `station_min_range`, `station_max_range`) VALUES
(4, 'Wie viel konnte ein typisches mittelalterliches Schiff wie die Kogge an Ladung aufnehmen? (in Tonnen)', 82, 70, 90, 1, 100),
(6, 'Wie viele Fenster hatte der von den Tauchern für die Bergung der Kogge verwendete Taucherhelm?', 4, 4, 4, 0, 7),
(13, 'Wie breit ist die Kogge in Metern?', 8, 6, 10, 1, 20);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `station_wahr_falsch`
--

CREATE TABLE IF NOT EXISTS `station_wahr_falsch` (
  `station_id` int(11) unsigned NOT NULL,
  `station_aussage` varchar(250) NOT NULL,
  `station_antwort` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`station_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `station_wahr_falsch`
--

INSERT INTO `station_wahr_falsch` (`station_id`, `station_aussage`, `station_antwort`) VALUES
(1, 'Die Bremer Kogge stammt aus der Antike.', 0),
(8, 'Ab dem 15. Jahrhundert handelten norddeutsche Kaufleute bis nach Island.', 1),
(11, 'Schiffsleute gaben früher Entfernungen im Stunden und Tagen an.', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tour`
--

CREATE TABLE IF NOT EXISTS `tour` (
  `tour_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tour_name` varchar(100) NOT NULL,
  `tour_min_alter` int(2) unsigned NOT NULL DEFAULT '0',
  `tour_max_alter` int(2) unsigned NOT NULL DEFAULT '99',
  `tour_starttext` text NOT NULL,
  `tour_hat_bild` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tour_id`),
  UNIQUE KEY `tourname` (`tour_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tour`
--

INSERT INTO `tour` (`tour_id`, `tour_name`, `tour_min_alter`, `tour_max_alter`, `tour_starttext`, `tour_hat_bild`) VALUES
(1, 'Besonderer Schatz im Bremer Hafenbecken', 9, 10, 'Die Kogge wurde vor fast 60 Jahren gefunden. Seitdem hat sie viele Fragen zur damaligen Schifffahrt aufgeworfen. Wie war es damals, auf einem solchen Schiff zu reisen und darauf Waren zu transportieren? Und was ist eigentlich die Hanse, die in Bremen und Umland überall auftaucht?', 1),
(2, 'Die Lieferdienste des Mittelalters', 11, 12, 'Oder auch wie die Waren nach Norddeutschland kamen. Ob auf Amazon günstige Handys aus Asien, im Supermarkt Früchte und Gemüse aus Spanien oder bei IKEA Möbel aus Schweden – das, was wir heute kaufen können, kommt zu uns aus der ganzen Welt und das schnell. Doch wie war das eigentlich im Mittelalter?', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tour_schlagwort`
--

CREATE TABLE IF NOT EXISTS `tour_schlagwort` (
  `tour_id` int(11) unsigned NOT NULL,
  `schlagwort_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`tour_id`,`schlagwort_id`),
  KEY `schlagwort_id` (`schlagwort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tour_schlagwort`
--

INSERT INTO `tour_schlagwort` (`tour_id`, `schlagwort_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(2, 6),
(1, 7),
(2, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tour_station`
--

CREATE TABLE IF NOT EXISTS `tour_station` (
  `tour_id` int(11) unsigned NOT NULL,
  `station_id` int(11) unsigned NOT NULL,
  `tour_station_ordnungsnummer` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tour_id`,`station_id`),
  KEY `station_id` (`station_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tour_station`
--

INSERT INTO `tour_station` (`tour_id`, `station_id`, `tour_station_ordnungsnummer`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 5),
(1, 6, 7),
(1, 13, 6),
(2, 7, 1),
(2, 8, 2),
(2, 9, 3),
(2, 10, 4),
(2, 11, 5),
(2, 12, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `urkunde`
--

CREATE TABLE IF NOT EXISTS `urkunde` (
  `urkunde_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `urkunde_besitzer` varchar(100) NOT NULL,
  PRIMARY KEY (`urkunde_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `urkunde_tour`
--

CREATE TABLE IF NOT EXISTS `urkunde_tour` (
  `urkunde_id` int(11) unsigned NOT NULL,
  `tour_id` int(11) unsigned NOT NULL,
  `urkunde_tour_punkte` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`urkunde_id`,`tour_id`),
  KEY `tour_id` (`tour_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `erklaerung`
--
ALTER TABLE `erklaerung`
  ADD CONSTRAINT `erklaerung_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `station` (`station_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `station_mehrfachantwort`
--
ALTER TABLE `station_mehrfachantwort`
  ADD CONSTRAINT `station_mehrfachantwort_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `station` (`station_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `station_mehrfachantwort_antwortmoeglichkeit`
--
ALTER TABLE `station_mehrfachantwort_antwortmoeglichkeit`
  ADD CONSTRAINT `station_mehrfachantwort_antwortmoeglichkeit_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `station` (`station_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `station_mehrfachantwort_antwortmoeglichkeit_ibfk_2` FOREIGN KEY (`antwortmoeglichkeit_id`) REFERENCES `antwortmoeglichkeit` (`antwortmoeglichkeit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `station_schaetzen`
--
ALTER TABLE `station_schaetzen`
  ADD CONSTRAINT `station_schaetzen_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `station` (`station_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `station_wahr_falsch`
--
ALTER TABLE `station_wahr_falsch`
  ADD CONSTRAINT `station_wahr_falsch_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `station` (`station_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tour_schlagwort`
--
ALTER TABLE `tour_schlagwort`
  ADD CONSTRAINT `tour_schlagwort_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_schlagwort_ibfk_2` FOREIGN KEY (`schlagwort_id`) REFERENCES `schlagwort` (`schlagwort_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tour_station`
--
ALTER TABLE `tour_station`
  ADD CONSTRAINT `tour_station_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_station_ibfk_2` FOREIGN KEY (`station_id`) REFERENCES `station` (`station_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `urkunde_tour`
--
ALTER TABLE `urkunde_tour`
  ADD CONSTRAINT `urkunde_tour_ibfk_1` FOREIGN KEY (`urkunde_id`) REFERENCES `urkunde` (`urkunde_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `urkunde_tour_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
