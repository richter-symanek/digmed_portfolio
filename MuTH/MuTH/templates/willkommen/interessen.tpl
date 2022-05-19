<h1>Was sind deine Interessen?</h1>
<p><b>Tipp:</b> Wenn ihr zu mehreren seid, w&auml;hlt einfach alle Themen aus, die einen von euch interessieren oder einigt euch auf die Themen, die alle gut finden.</p>
<form action="./willkommen.php?action=interessen2" method="post" class="willkommen_form">
<select name="interessen[]" size="4" multiple required>
	$interessen
</select>
<br><input type="submit" value="Speichern">
</form>

<div class="willkommen_steps">
  <span class="step finish"></span>
  <span class="step finish"></span>
  <span class="step active"></span>
</div>