$header

<div class="back"><a href="uebersicht.php"><i class="fas fa-arrow-left"></i> Tour&uuml;bersicht</a></div>

<div class="content">
	<h1>Daten &auml;ndern</h1>
	<p>Wenn du magst, dann kannst du hier die Angaben, die du beim Start der Anwendung gemacht hast, bearbeiten.</p>
	<form action="profil.php" method="post" class="profil_form">
		<p><b>Vorname:</b> <input type="text" value="$vorname" name="vorname" pattern="[^\x27\x22]+" required></p>
		<p><b>Alter:</b> <input type="number" value="$alter" name="alter" max="99" min="1" step="1" required></p>
		<p><b>Interessen:</b> <select name="interessen[]" multiple required>$interessen</select></p>
		<p><input type="submit" value="Speichern" name="send"></p>
	</form>
</div>

$hilfe

$footer