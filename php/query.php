<?php
// error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './dbconnect.php';

$conn = db_connect();

function buildPokemonQuery() {
    $sql = 'SELECT * FROM pokemon WHERE 1';
    // get all variables sent by query form
    $number = $_POST["number"];
    $name = $_POST["name"];
    $type1 = $_POST["type1"];
    $type2 = $_POST["type2"];
    $hpmin = $_POST["hpmin"];
    $hpmax = $_POST["hpmax"];
    $attackmin = $_POST["attackmin"];
    $attackmax = $_POST["attackmax"];
    $defensemin = $_POST["defensemin"];
    $defensemax = $_POST["defensemax"];
    $spatkmin = $_POST["spatkmin"];
    $spatkmax = $_POST["spatkmax"];
    $spdefmin = $_POST["spdefmin"];
    $spdefmax = $_POST["spdefmax"];
    $speedmin = $_POST["speedmin"];
    $speedmax = $_POST["speedmax"];
    $generation = $_POST["generation"];
    $legendary = $_POST["legendary"];

    if (!empty($number)) {
        $sql .= ' AND number=' . $number;
    }
    if (!empty($name)) {
        $sql .= ' AND name LIKE "%' . $name . '%"';
    }
    if (!empty($type1) && !empty($type2)) { //both type1 and type 2 provided
        $sql .= ' AND ((type1="%s" AND type2="%s") OR (type1="%s" AND type2="%s"))';
        $sql = sprintf($sql, $type1, $type2, $type2, $type1);
    } else if (!empty($type1)) {    // only type 1 provided
        $sql .= ' AND (type1="%s" OR type2="%s")';
        $sql = sprintf($sql, $type1, $type1);
    } else if (!empty($type2)) {    // only type 2 provided
        $sql .= ' AND (type1="%s" OR type2="%s")';
        $sql = sprintf($sql, $type2, $type2);
    }
    if (!empty($hpmin)) {
        $sql .= ' AND hp>=' . $hpmin;
    }
    if (!empty($hpmax)) {
        $sql .= ' AND hp<=' . $hpmax;
    }
    if (!empty($attackmin)) {
        $sql .= ' AND attack>=' . $attackmin;
    }
    if (!empty($attackmax)) {
        $sql .= ' AND attack<=' . $attackmax;
    }
    if (!empty($defensemin)) {
        $sql .= ' AND defense>=' . $defensemin;
    }
    if (!empty($defensemax)) {
        $sql .= ' AND defense<=' . $defensemax;
    }
    if (!empty($spatkmin)) {
        $sql .= ' AND spatk>=' . $spatkmin;
    }
    if (!empty($spatkmax)) {
        $sql .= ' AND spatk<=' . $spatkmax;
    }
    if (!empty($spdefmin)) {
        $sql .= ' AND spdef>=' . $spdefmin;
    }
    if (!empty($spdefmax)) {
        $sql .= ' AND spdef<=' . $spdefmax;
    }
    if (!empty($speedmin)) {
        $sql .= ' AND speed>=' . $speedmin;
    }
    if (!empty($speedmax)) {
        $sql .= ' AND speed<=' . $speedmax;
    }
    if (!empty($generation)) {
        $sql .= ' AND generation=' . $generation;
    }
    if (!empty($legendary)) {
        $sql .= ' AND legendary=' . $legendary;
    }

    return $sql;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = buildPokemonQuery();
    $pokemon_arr = array();
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_row($result)) {
            array_push($pokemon_arr, [
                'number' => $row[0],	
                'name' => $row[1],	
                'type1' => $row[2],	
                'type2' => $row[3],	
                'hp' => $row[4],	
                'attack' => $row[5],	
                'defense' => $row[6],	
                'spatk' => $row[7],	
                'spdef' => $row[8],	
                'speed' => $row[9],	
                'generation' => $row[10],	
                'legendary' => $row[11]
            ]);
        }
    }
    mysqli_stmt_close($stmt);
    echo json_encode($pokemon_arr);
}
?>