<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ANSI">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="./resources/fontawesome/css/all.css" rel="stylesheet" type="text/css">
		<link href="./resources/css/header.css" rel="stylesheet" type="text/css">
		<link href="./resources/css/general.css" rel="stylesheet" type="text/css">
		<link href="./resources/css/tour.css" rel="stylesheet" type="text/css">
		<script src="./resources/js/nav.js"></script>
		
		<script src="./resources/js/input_range.js"></script>
		<script src="./resources/js/wahr_falsch_toggle.js"></script>
		<script src="./resources/js/hilfe_info.js"></script>
		
		<link rel="stylesheet" type="text/css" href="./resources/css/cookieconsent.css">
		<script src="./resources/js/cookieconsent.js"></script>
		<script src="./resources/js/cookieconsent_config.js"></script>
		
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i&amp;subset=latin-ext" rel="stylesheet">
		
		<title>MuTH $header_titel</title>
	</head>
	<nav>
		<!-- https://www.w3schools.com/howto/howto_js_topnav_responsive.asp -->
		<div class="topnav" id="myTopnav">
			<span id="titel_group"><i class="$header_symbol symbol"></i> <span id="titel">$header_titel</span></span>
			$header_tourUebersicht_start
			$header_menueSeiten
			<a href="javascript:void(0);" class="icon icon1" onclick="mobileNavToggle()">
			<i class="fa fa-bars"></i>
			</a>
			$header_hilfe
			$header_tipp
		</div>
		<!-- w3schools END -->
	</nav>