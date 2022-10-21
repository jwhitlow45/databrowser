<?php

class PokemonDB {
    function __construct($collection) {
        $this->collection = $collection;
    }

    function findNumber($num) {
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if ($pokemon->Num == $num) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findName($name) {
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if (str_contains(strtolower($pokemon->Name), strtolower($name))) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findType($type) {
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if (strtolower($pokemon->Type1) == strtolower($type)) {
                array_push($newColl, $pokemon);
            } else if (strtolower($pokemon->Type2 )== strtolower($type)) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findStat($stat, $min, $max) {
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            $statnum = $pokemon->$stat;
            if ($statnum >= $min && $statnum <= $max) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findLegendary($legendary) {
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if (strtolower($pokemon->Legendary) == strtolower($legendary)) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }
}

function debugToConsole($msg) { 
    echo "<script>console.log(".json_encode($msg).")</script>";
}

function handleUserQuery() {

    $json_str = file_get_contents("./data/pokemondb.json");
    $objlist = json_decode($json_str);

    $db = new PokemonDB($objlist);

    debugToConsole($db->findName("char"));

    $number = $_GET["number"];
    $name = $_GET["name"];
    $type1 = $_GET["type1"];
    $type2 = $_GET["type2"];
    $hpmax = $_GET["hpmax"];
    $hpmin = $_GET["hpmin"];
    $attackmax = $_GET["attackmax"];
    $attackmin = $_GET["attackmin"];
    $defensemax = $_GET["defensemax"];
    $defensemin = $_GET["defensemin"];
    $spattmax = $_GET["spattmax"];
    $spattmin = $_GET["spattmin"];
    $spdefmax = $_GET["spdefmax"];
    $spdefmin = $_GET["spdefmin"];
    $speedmax = $_GET["speedmax"];
    $speedmin = $_GET["speedmin"];

}

handleUserQuery();
?>