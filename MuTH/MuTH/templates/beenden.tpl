$header

<div class="back"><a href="uebersicht.php"><i class="fas fa-arrow-left"></i> Tour&uuml;bersicht</a></div>

<div class="content">

	<h1>Abschluss</h1>
	<p>Wenn du deinen Besuch beenden m&ouml;chtest, dann kannst du dich hier entscheiden, ob du eine Urkunde &uuml;ber deine erreichten Punkte nachhause mitnehmen willst. 
	Die Urkunde kannst du dir dann am Ausgang ausdrucken lassen.</p>

	<h2>Urkunde erstellen?</h2>
	<p>Um eine Urkunde zu erstellen, m&uuml;ssen wir einige Daten f&uuml;r bei uns zwischenspeichern.
	Diese Daten werden nach dem Drucken gel&ouml;scht oder sp&auml;testens nach 24 Stunden.
	Bevor du weiterklickst und eine Urkunde erstellst, frag bitte deine Eltern um Erlaubnis.</p>
	<p>Wenn du auf <i>Keine Urkunde erstellen</i> klickst, werden einfach alle Daten, die wir &uuml;ber deine Touren auf deinem Ger&auml;t gespeichert haben, gel&ouml;scht.</p>

	<form action="beenden.php" method="post">
		<p><input type="submit" value="Urkunde erstellen" name="send"> 
		<input type="submit" value="Keine Urkunde erstellen" name="send2" onclick="return confirm('M&ouml;chtest du wirklich alle Tourdaten l&ouml;schen? \nDu wirst danach zur Startseite weitergeleitet.');"></p>
	</form>

	<p>N&auml;here Informationen zur Datenverarbeitung finden sich unter <a href="seite.php?page=datenschutz">Datenschutzverordnung</a>.
</div>

$hilfe

$footer