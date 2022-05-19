$header
$ersterBesuchSkript

<div class="content">
	<h1>Tour&uuml;bersicht</h1>
	<p>Hallo, $vorname!</p>
	<p>Hier kannst du dir eine Tour aussuchen, auf deren Spuren du dich begeben m&ouml;chtest.</p>
</div>

$hinweis

<div class="uebersicht_optionen">
	<a href="profil.php">Daten &auml;ndern</a>
	<a href="beenden.php">Besuch beenden</a>
</div>
	
<table class="uebersicht_table">
	<tr>
		<th>Tourname</th>
		<th>Altersgruppe</th>
		<th class="uebersicht_punkte_container"></th>
		<th></th>
	</tr>
	$touren
</table>

$hilfe

$footer