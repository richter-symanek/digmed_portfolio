<?php

/**
* Bietet das Skript für die erweiterte Such- und die Ergebnisseite.
*/

require("header.php"); // Seitenheader einfügen


// prepare suggestions for place_name search field from stored place names
$datalist = "";
$sql = "SELECT place_name FROM places";
if ($statement = $db->prepare($sql)) {
    $statement->execute();
    $places = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    if (!empty($places)) {
        foreach ($places AS $place) {
            $datalist .= "<option>".$place['place_name']."</option>";
        }
    }
} else {
    $error = $db->errno . ' ' . $db->error;
    echo $error;
}

?>

<section id="advanced-search-form">
    <h2>Erweiterte Suche</h2>
    <form name="advanced-search" method="GET" action="search.php">
        <div>
            <h3>Gesuchte Person</h3>
            <input name="firstname" type="text" placeholder="Vorname" value="<?=$_GET['firstname']?>">
            <input name="lastname" type="text" placeholder="Nachname" value="<?=$_GET['lastname']?>">
            <select name="accuracy">
                <option value="">Suchgenauigkeit</option>
                <option value="exact" <? if ($_GET['accuracy'] === "exact") :?>selected<? endif ?>>Exakte Suche</option>
                <option value="wide" <? if ($_GET['accuracy'] === "wide") :?>selected<? endif ?>>Weite Suche</option>
            </select>
        </div>
        <div>
            <h3>Aufzeichnung</h3>
            <select name="entry_type">
                <option value="all">Art der Aufzeichnung</option>
                <option value="Geburt" <? if ($_GET['entry_type'] === "Geburt") :?>selected<? endif ?>>Geburt</option>
                <option value="Taufe" <? if ($_GET['entry_type'] === "Taufe") :?>selected<? endif ?>>Taufe</option>
                <option value="Heirat" <? if ($_GET['entry_type'] === "Heirat") :?>selected<? endif ?>>Heirat</option>
                <option value="Todesfall" <? if ($_GET['entry_type'] === "Todesfall") :?>selected<? endif ?>>Todesfall</option>
                <option value="Beerdigung" <? if ($_GET['entry_type'] === "Beerdigung") :?>selected<? endif ?>>Beerdigung</option>
            </select>
            <datalist id="places">
                <?=$datalist?>
            </datalist>
            <input name="place_name" type="text" placeholder="Ort des Standesamts / Kirchspiels" value="<?=$_GET['place_name']?>" list="places">
            <div class="form-date-container">
            <span class="form-date-label">Jahr (Zeitraum)</span>
            <input name="start-year" type="number" class="form-date" placeholder="Jahr" minlength="4" maxlength="4" value="<?=$_GET['start-year']?>">
            <input name="end-year" type="number" class="form-date" placeholder="Jahr" minlength="4" maxlength="4" value="<?=$_GET['end-year']?>">
            </div>
        </div>
        <div>
            <h3>Suche eingrenzen</h3>
            <input id="search-parents" name="search-parents" type="checkbox" <? if ($_GET['search-parents'] === "on" || empty($_GET)) :?>checked<? endif ?>> <label for="search-parents">Unter Eltern in Aufzeichnungen suchen</label>
            <input id="search-related-persons" name="search-related-persons" type="checkbox" <? if ($_GET['search-related-persons'] === "on") :?>checked<? endif ?>> <label for="search-related-persons">Unter anderen erwähnten Personen suchen</label>
            <input id="search-only-digitalised" name="search-only-digitalised" type="checkbox" <? if ($_GET['search-only-digitalised'] === "on") :?>checked<? endif ?>> <label for="search-only-digitalised">Nur Aufzeichnungen mit Digitalisaten</label>
            <input type="submit" value="Suche starten">
        </div>
    </form>
    
</section>

<?
    if (!empty($_GET)) {
        unset($main_entries);
        unset($mentions);
        unset($conditions);
        unset($parameters);
        $number_of_entries = 0; //for results display, row numbers to be added to this throughout result processing

        $conditions = [];
        $parameters = [];
        //$joins = [];
        $digitalised = "";
        $limit = 100; //number of results queried
        $order_param = "date, lastname, firstname"; // parameters results or ordered by
        $order_direction = "ASC"; // direction results or ordered by

        if (!empty($_GET['firstname'])) {
            $conditions[] = "firstname LIKE ?";
            $parameters[] = "%".$_GET['firstname']."%";
        }

        if (!empty($_GET['lastname'])) {
            $conditions[] = "lastname LIKE ?";
            $parameters[] = "%".$_GET['lastname']."%";
        }

        if (!empty($_GET['entry_type'])) {
            if ( $_GET['entry_type'] != "all") {
                $conditions[] = "entry_type = ?";
                $parameters[] = $_GET['entry_type'];
            }
            /*
            if ($_GET['entry_type'] === "all" || $_GET['entry_type'] === "death") {
                $joins[] = "LEFT JOIN `deaths` USING(entry_id)";
            }
            
            if ($_GET['entry_type'] === "all" || $_GET['entry_type'] === "burial") {
                $joins[] = "LEFT JOIN `burials` USING(entry_id)";
            }
            */
        }

        if (!empty($_GET['place_name'])) {
            $conditions[] = "place_name LIKE ?";
            $parameters[] = "%".$_GET['place_name']."%";
        }

        if (!empty($_GET['start-year']) || !empty($_GET['end-year'])) {
            if (!empty($_GET['start-year']) && empty($_GET['end-year'])) {
                $_GET['end-year'] = $_GET['start-year'];
            } elseif (empty($_GET['start-year']) && !empty($_GET['end-year'])) {
                $_GET['start-year'] = $_GET['end-year'];
            }

            $conditions[] = "date between ? AND ?";
            $parameters[] = $_GET['start-year']."-01-01";
            $parameters[] = $_GET['end-year']."-12-31";
        }

        if ($_GET['search-only-digitalised'] === "on") {
            $digitalised = "digitalised = 1";
        }

        // main query
        $sql = "SELECT *
                FROM entries
                LEFT JOIN persons ON(entries.person_id = persons.person_id)
                LEFT JOIN places USING(place_id)";

        // add possible additional joins when searching for death and burial entries
        //if ($joins) $sql .= " ".implode(" ", $joins);

        // add conditions if there are any
        if ($conditions) {
            if ($_GET['accuracy'] === "wide") $accuracy = " OR ";
            else $accuracy = " AND ";
            $sql .= " WHERE (".implode($accuracy, $conditions).")";
        }

        // add mandatory condition for digitalised entries independent of search accuracy if selected
        if ($digitalised != "") {
            if ($conditions) $sql .= " AND ".$digitalised;
            else $sql.= " WHERE ".$digitalised;
        }

        // add ordering
        $sql .= " ORDER BY ".$order_param." ".$order_direction;

        // add result limit
        $sql .= " LIMIT ".$limit;
        
        if ($statement = $db->prepare($sql)) {
            if ($conditions) $statement->bind_param(str_repeat("s", count($parameters)), ...$parameters); // bind parameters to prevent sql injections, binding as strings suffices for all
            $statement->execute();
            $main_entries = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

            $number_of_entries += count($main_entries);

            // prepare data for displaying
            $births = [];
            $baptisms = [];
            $marriages = [];
            $deaths = [];
            $burials = [];

            foreach ($main_entries as $entry) {
                switch($entry['entry_type']) {
                    case "Geburt":
                        $births[] = $entry;
                        break;
                    case "Taufe":
                        $baptisms[] = $entry;
                        break;
                    case "Heirat":
                        $marriages[] = $entry;
                        break;
                    case "Todesfall":
                        $deaths[] = $entry;
                        break;
                    case "Beerdigung":
                        $burials[] = $entry;
                        break;
                }
            }

        } else {
            $error = $db->errno . ' ' . $db->error;
            echo $error;
        }

        if ($_GET['search-parents'] === "on" || $_GET['search-related-persons'] === "on") {
            $sql = "";
            $sql = "SELECT *, entries.entry_id AS entry_id
            FROM `mentions`
            LEFT JOIN `persons` ON(mentions.person_id = persons.person_id)
            LEFT JOIN `entries` ON(mentions.entry_id = entries.entry_id)
            LEFT JOIN `places` ON(entries.place_id = places.place_id)";

            // add conditions if there are any
            if ($conditions) {
                if ($_GET['accuracy'] === "wide") $accuracy = " OR ";
                else $accuracy = " AND ";
                $sql .= " WHERE (".implode($accuracy, $conditions).")";
            }
            
            $additional_conditions = [];
            // condition for parents to be included or excluded like selected
            if ($_GET['search-parents'] === "on" &&  empty($_GET['search-related-persons'])) {
                $additional_conditions[] = "relation = 'Elternteil'";
            } elseif (empty($_GET['search-parents']) &&  $_GET['search-related-persons'] === "on") {
                $additional_conditions[] = "relation != 'Elternteil'";
            }

            // add mandatory condition for digitalised entries independent of search accuracy if selected
            if ($digitalised != "") {
                $additional_conditions[] = $digitalised;
            }

            if ($additional_conditions) {
                if ($conditions) $sql .= " AND ".implode(" AND ", $additional_conditions);
                else $sql .= " WHERE ".implode(" AND ", $additional_conditions);
            }

            // add ordering
            $sql .= " GROUP BY firstname, lastname, entry_type, place_type, place_name, relation";

            // add ordering
            $sql .= " ORDER BY ".$order_param." ".$order_direction;

            // add result limit
            $sql .= " LIMIT ".$limit;
            
            if ($statement = $db->prepare($sql)) {
                if ($conditions) $statement->bind_param(str_repeat("s", count($parameters)), ...$parameters); // bind parameters to prevent sql injections, binding as strings suffices for all
                $statement->execute();
                $mentions = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
            
                $number_of_entries += count($mentions);
            } else {
                $error = $db->errno . ' ' . $db->error;
                echo $error;
            }
        }
?>
<section id="results">
    <h2>Ergebnisse</h2>
    <p id="entry-count">
        <?php if ($number_of_entries > 0): ?>
        <?=$number_of_entries?> Einträge gefunden 
            <?php if ($main_entries->num_rows === 100 || $mentions->num_rows === 100): ?>
                — Ggf. konnten nicht alle Einträge angezeigt werden. Grenze deine Suche weiter ein.
            <?php endif ?> 
        <?php endif ?>     
    </p>
    <?php if ($main_entries || $mentions): ?>
        <?php if (!empty($births)): ?>
            <?$rowcount = 1;?>
            <h3>Geburten</h3>
            <table cellspacing=0>
                <?php foreach($births as $entry): ?>
                    <tr class="entries-row-<?=$rowcount?>">
                        <td class="entries-year" title="<?=formatDate($entry['date'])?>"><?=substr($entry['date'],0,4)?></td>
                        <td class="entries-name"><?=$entry['firstname']." ".$entry['lastname']?></td>
                        <td><?=$entry['place_type']." ".$entry['place_name']?></td>
                        <td class="entries-digitalised"><? if ($entry['digitalised']): ?><a href="documents/<?=$entry['entry_id']?>.jpg" title="Digitalisat" target="blank"><i class="icon-picture"></i></a><? endif ?></td>
                        <td class="entries-link"><a href="entry.php?entry_id=<?=$entry['entry_id']?>#entry">Eintrag ❯</a></td>
                    </tr>
                    <?if ($rowcount === 1) $rowcount++;
                    else $rowcount--;?>
                <?php endforeach ?>
            </table>
            <br>
        <?php endif ?>
        <?php if (!empty($baptisms)): ?>
            <?$rowcount = 1;?>
            <h3>Taufen</h3>
            <table cellspacing=0>
                <?php foreach($baptisms as $entry): ?>
                    <tr class="entries-row-<?=$rowcount?>">
                        <td class="entries-year" title="<?=formatDate($entry['date'])?>"><?=substr($entry['date'],0,4)?></td>
                        <td class="entries-name"><?=$entry['firstname']." ".$entry['lastname']?></td>
                        <td><?=$entry['place_type']." ".$entry['place_name']?></td>
                        <td class="entries-digitalised"><? if ($entry['digitalised']): ?><a href="documents/<?=$entry['entry_id']?>.jpg" title="Digitalisat" target="blank"><i class="icon-picture"></i></a><? endif ?></td>
                        <td class="entries-link"><a href="entry.php?entry_id=<?=$entry['entry_id']?>#entry">Eintrag ❯</a></td>
                    </tr>
                    <?if ($rowcount === 1) $rowcount++;
                    else $rowcount--;?>
                <?php endforeach ?>
            </table>
            <br>
        <?php endif ?>
        <?php if (!empty($marriages)): ?>
            <?$rowcount = 1;?>
            <h3>Heiraten</h3>
            <table cellspacing=0>
                <?php foreach($marriages as $entry): ?>
                    <tr class="entries-row-<?=$rowcount?>">
                        <td class="entries-year" title="<?=formatDate($entry['date'])?>"><?=substr($entry['date'],0,4)?></td>
                        <td class="entries-name"><?=$entry['firstname']." ".$entry['lastname']?></td>
                        <td><?=$entry['place_type']." ".$entry['place_name']?></td>
                        <td class="entries-digitalised"><? if ($entry['digitalised']): ?><a href="documents/<?=$entry['entry_id']?>.jpg" title="Digitalisat" target="blank"><i class="icon-picture"></i></a><? endif ?></td>
                        <td class="entries-link"><a href="entry.php?entry_id=<?=$entry['entry_id']?>#entry">Eintrag ❯</a></td>
                    </tr>
                    <?if ($rowcount === 1) $rowcount++;
                    else $rowcount--;?>
                <?php endforeach ?>
            </table>
            <br>
        <?php endif ?>
        <?php if (!empty($deaths)): ?>
            <?$rowcount = 1;?>
            <h3>Todesfälle</h3>
            <table cellspacing=0>
                <?php foreach($deaths as $entry): ?>
                    <tr class="entries-row-<?=$rowcount?>">
                        <td class="entries-year" title="<?=formatDate($entry['date'])?>"><?=substr($entry['date'],0,4)?></td>
                        <td class="entries-name"><?=$entry['firstname']." ".$entry['lastname']?></td>
                        <td><?=$entry['place_type']." ".$entry['place_name']?></td>
                        <td class="entries-digitalised"><? if ($entry['digitalised']): ?><a href="documents/<?=$entry['entry_id']?>.jpg" title="Digitalisat" target="blank"><i class="icon-picture"></i></a><? endif ?></td>
                        <td class="entries-link"><a href="entry.php?entry_id=<?=$entry['entry_id']?>#entry">Eintrag ❯</a></td>
                    </tr>
                    <?if ($rowcount === 1) $rowcount++;
                    else $rowcount--;?>
                <?php endforeach ?>
            </table>
            <br>
        <?php endif ?>
        <?php if (!empty($burials)): ?>
            <?$rowcount = 1;?>
            <h3>Beerdigungen</h3>
            <table cellspacing=0>
                <?php foreach($burials as $entry): ?>
                    <tr class="entries-row-<?=$rowcount?>">
                        <td class="entries-year" title="<?=formatDate($entry['date'])?>"><?=substr($entry['date'],0,4)?></td>
                        <td class="entries-name"><?=$entry['firstname']." ".$entry['lastname']?></td>
                        <td><?=$entry['place_type']." ".$entry['place_name']?></td>
                        <td class="entries-digitalised"><? if ($entry['digitalised']): ?><a href="documents/<?=$entry['entry_id']?>.jpg" title="Digitalisat" target="blank"><i class="icon-picture"></i></a><? endif ?></td>
                        <td class="entries-link"><a href="entry.php?entry_id=<?=$entry['entry_id']?>#entry">Eintrag ❯</a></td>
                    </tr>
                    <?if ($rowcount === 1) $rowcount++;
                    else $rowcount--;?>
                <?php endforeach ?>
            </table>
            <br>
        <?php endif ?>
        <?php if ($mentions): ?>
            <?$rowcount = 1;?>
            <h3>Erwähnungen</h3>
            <table cellspacing=0>
                <?php foreach($mentions as $entry): ?>
                    <tr class="entries-row-<?=$rowcount?>">
                        <td class="entries-year" title="<?=formatDate($entry['date'])?>"><?=substr($entry['date'],0,4)?></td>
                        <td class="entries-name"><?=$entry['firstname']." ".$entry['lastname']?></td>
                        <td><?=$entry['entry_type']?></td>
                        <td><?=$entry['place_type']." ".$entry['place_name']?></td>
                        <td><?=$entry['relation']?></td>
                        <td class="entries-digitalised"><? if ($entry['digitalised']): ?><a href="documents/<?=$entry['entry_id']?>.jpg" title="Digitalisat" target="blank"><i class="icon-picture"></i></a><? endif ?></td>
                        <td class="entries-link"><a href="entry.php?entry_id=<?=$entry['entry_id']?>#entry">Eintrag ❯</a></td>
                    </tr>
                    <?if ($rowcount === 1) $rowcount++;
                    else $rowcount--;?>
                <?php endforeach ?>
            </table>
        <?php endif ?>
    <?php else: ?>
        <p id="no-entries-found">
            Keine Einträge gefunden
        </p>
    <?php endif ?>
    
</section>
<?
    } else {
        unset($main_entries);
        unset($mentions);
        $number_of_entries = 0; //for results display, row numbers to be added to this throughout result processing
    }

require("footer.php"); // Seitenfooter einfügen

?>