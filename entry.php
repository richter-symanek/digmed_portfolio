<?php

/**
* Bietet das Skript für die Impressumsseite.
*/

require("header.php"); // Seitenheader einfügen

?>

<section id="entry">
    <?if (empty($_GET['entry_id']) || !is_numeric($_GET['entry_id'])):?><p><b>Fehler:</b> Kein Eintrag gefunden.</p>
        <p><a href="search.php">Zurück zur Suche</a></p>
    <? else :?>
    <h2>Eintrag</h2>
        <?
            $sql = "SELECT *, entries.entry_id AS entry_id, persons.firstname AS firstname, persons.lastname AS lastname, spouses.firstname AS spouse_firstname, spouses.lastname AS spouse_lastname 
                    FROM entries
                    LEFT JOIN persons ON(entries.person_id = persons.person_id)
                    LEFT JOIN places USING(place_id)
                    LEFT JOIN personal_information ON(entries.person_id = personal_information.person_id)
                    LEFT JOIN baptisms ON(entries.entry_id = baptisms.entry_id)
                    LEFT JOIN births ON(entries.entry_id = births.entry_id)
                    LEFT JOIN marriages ON(entries.entry_id = marriages.entry_id)
                    LEFT JOIN persons AS spouses ON(marriages.spouse_id = persons.person_id)
                    LEFT JOIN deaths ON(entries.entry_id = deaths.entry_id)
                    LEFT JOIN burials ON(entries.entry_id = burials.entry_id)
                    WHERE entries.entry_id = ?
                    LIMIT 1";
            
            if ($statement=$db->prepare($sql)) {
                $statement->bind_param("i",$_GET['entry_id']);
                $statement->execute();
                $entry = $statement->get_result()->fetch_assoc();
            } else {
                $error = $db->errno . ' ' . $db->error;
                echo $error;
            }

            if ($entry['entry_type'] === "Heirat") {
                $sql = "SELECT firstname, lastname 
                        FROM persons
                        WHERE person_id = ?
                        LIMIT 1";
                
                if ($statement=$db->prepare($sql)) {
                    $statement->bind_param("i",$entry['spouse_id']);
                    $statement->execute();
                    $spouse = $statement->get_result()->fetch_assoc();
                } else {
                    $error = $db->errno . ' ' . $db->error;
                    echo $error;
                }
            }
        ?>
        <h3><?=$entry['entry_type']?> von <?=$entry['firstname']." ".$entry['lastname']?></h3>
        <table class="single-entry" cellspacing=0>
            <tr><td class="entries-column-head">Ereignisdatum</td><td><?=formatDate($entry['date'])?></td></tr>
            <tr><td class="entries-column-head">Standesamt / Kirchspiel</td><td><?=$entry['place_type']." ".$entry['place_name']?></td></tr>
            <?if (!empty($entry['birth_date'])) :?><tr><td class="entries-column-head">Geburtsdatum</td><td><?=formatDate($entry['birth_date'])?></td></tr><? endif ?>
            <?if ($entry['entry_type'] === "Geburt" || $entry['entry_type'] === "Taufe") :?><tr><td class="entries-column-head">Legitimität</td><td><?if ($entry['legitimate']) :?> Ehelich<? else :?>Unehelich<? endif ?></td></tr><? endif ?>
            <?if (!empty($spouse['firstname'])) :?><tr><td class="entries-column-head">Ehepartner*in</td><td><?=$spouse['firstname']." ".$spouse['lastname']?></td></tr><? endif ?>
            <?if (!empty($entry['previous_relations'])) :?><tr><td class="entries-column-head">Früheres Verhältnis hinsichtlich der Ehe</td><td><?=$entry['previous_relations']?></td></tr><? endif ?>
            <?if (!empty($entry['death_date'])) :?><tr><td class="entries-column-head">Todesdatum</td><td><?=formatDate($entry['death_date'])?></td></tr><? endif ?>
            <?if (!empty($entry['burial_place'])) :?><tr><td class="entries-column-head">Begräbnisort</td><td><?=$entry['burial_place']?></td></tr><? endif ?>
            <?if (!empty($entry['cause'])) :?><tr><td class="entries-column-head">Todesursache</td><td><?=$entry['cause']?></td></tr><? endif ?>
            <?if (!empty($entry['age'])) :?><tr><td class="entries-column-head">Alter</td><td><?=$entry['age']?></td></tr><? endif ?>
            <?if (!empty($entry['religion'])) :?><tr><td class="entries-column-head">Religion</td><td><?=$entry['religion']?></td></tr><? endif ?>
            <?if (!empty($entry['profession'])) :?><tr><td class="entries-column-head">Beruf</td><td><?=$entry['profession']?></td></tr><? endif ?>
            <?if (!empty($entry['residence'])) :?><tr><td class="entries-column-head">Wohnort</td><td><?=$entry['residence']?></td></tr><? endif ?>
            <tr><td class="entries-column-head">Am Datum</td><td><?if ($entry['living']) :?>Lebend<?else :?>Verstorben<? endif ?></td></tr>
            <?if ($entry['digitalised']) :?><tr><td class="entries-column-head">Digitalisat</td><td><a href="documents/<?=$entry['entry_id']?>.jpg" title="Digitalisat" target="blank"><i class="icon-picture"></i> Aufzeichnung</a></td></tr><? endif ?>
        </table>
        <br>
        <?if (!empty($entry['notes'])) :?>
            <h3>Anmerkungen</h3>
            <p><?=$entry['notes']?></p>
            <br>
        <? endif ?>
        <?php
        $sql = "SELECT *, mentions.entry_id AS entry_id
                FROM mentions
                LEFT JOIN persons ON(mentions.person_id = persons.person_id)
                LEFT JOIN personal_information ON(mentions.person_id = personal_information.person_id and mentions.entry_id = personal_information.entry_id)
                WHERE mentions.entry_id = ?
                ORDER BY relation, firstname, lastname";
            
        if ($statement=$db->prepare($sql)) {
            $statement->bind_param("i",$_GET['entry_id']);
            $statement->execute();
            $mentions = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            $error = $db->errno . ' ' . $db->error;
            echo $error;
        }
        ?>
        <?php if ($mentions): ?>
            <?$rowcount = 1;?>
            <h3>Weitere Personen in der Aufzeichnung</h3>
            <table cellspacing=0>
                <tr class="entries-row-head">
                    <td>Name</td>
                    <td>Beziehung zur Hauptperson</td>
                    <td>Religion</td>
                    <td>Alter</td>
                    <td>Beruf</td>
                    <td>Wohnort</td>
                    <td>Am Datum</td>
                </tr>
                <?php foreach($mentions as $entry): ?>
                    <tr class="entries-row-<?=$rowcount?>">
                        <td class="entries-name"><?=$entry['firstname']." ".$entry['lastname']?></td>
                        <td><?=$entry['relation']?></td>
                        <td><?=$entry['religion']?></td>
                        <td><?=$entry['age']?><? if (!empty($entry['age'])) :?> Jahre<? endif ?></td>
                        <td><?=$entry['profession']?></td>
                        <td><?=$entry['residence']?></td>
                        <td class="entries-living"><?if ($entry['living']) :?>Lebend<?else :?>Verstorben<? endif ?></td>
                    </tr>
                    <?if ($rowcount === 1) $rowcount++;
                    else $rowcount--;?>
                <?php endforeach ?>
            </table>
        <?php endif ?>
    <? endif ?>
  
</section>

<?

require("footer.php"); // Seitenfooter einfügen

?>