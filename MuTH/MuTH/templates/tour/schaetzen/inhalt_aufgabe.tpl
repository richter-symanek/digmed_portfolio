<h2>$frage</h2>
<p>Gib eine Sch&auml;tzung ab.</p>
$bild
<p class="range">
<!-- Basierend auf https://www.bauer.uh.edu/parks/slider.htm/ -->
	<span id="slider_value" class="range_value_display">$initial_value</span>
	<br>
	<input type="button" class="range_button" id="range_button1" value="-" onClick="subtract_one_from_input_range_slider()"> 
	$min_range 
	<input type="range" id="antwort" name="antwort" value="$initial_value" min="$min_range" max="$max_range" step="1" onchange="show_value_of_input_range(this.value)"> 
	$max_range 
	<input type="button" class="range_button" id="range_button2" value="+" onClick="add_one_to_input_range_slider()">
	<!-- bauer.uh.edu END -->
</p>
<br>