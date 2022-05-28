<?php
require_once("global.inc.php");

?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>Genealogische Datenbank</title>

        <meta name="author" content="Yaël Richter-Symanek">       
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="img/favicon.png" type="image/x-icon">

        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Roboto+Slab:wght@400;500&display=swap" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">        
    </head>
    <body>
        <main>
            <header>
                <menu>
                    <ul>
                        <li><a href="index.php" id="main-page-link"><i class="icon-sitemap"></i>&nbsp; Genealogische Datenbank</a></li>
                        <li><a href="search.php" id="search-page-link"><i class="icon-search"></i>&nbsp; Suche</a></li>
                        <li><a href="about.php" id="about-page-link"><i class="icon-folder-open"></i>&nbsp; Über das Projekt</a></li>
                    </ul>
                </menu>
                <div id="search-form">
                    <h1>Genealogische Datenbank</h1>
                    <span>Standesamt- und Kirchenbucheinträge aus den historischen Regionen <b>Masuren, Westpreußen, Sachsen, Oberschlesien, Posen, Lodz</b> und <b>Wolhynien</b>.</span>
                    <form name="simple-search" method="GET" action="search.php">
                        <input name="firstname" type="text" placeholder="Vorname">
                        <input name="lastname" type="text" placeholder="Nachname">
                        <a href="search.php">Erweiterte Suche</a>
                        <input type="submit" value="Suche starten">
                    </form>
                </div>
            </header>

<?

?>