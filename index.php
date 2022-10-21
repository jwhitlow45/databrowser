<?php

include('index.html');

class PokemonDB {
    function __construct($collection) {
        $this->collection = $collection;
    }

    function findNumber($num) {
        if ($num == null) {
            return $this;
        }
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if ($pokemon->num == $num) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findName($name) {
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if (str_contains(strtolower($pokemon->name), strtolower($name))) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findType($type) {
        if ($type == null) {
            return $this;
        }
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if (strtolower($pokemon->type1) == strtolower($type)) {
                array_push($newColl, $pokemon);
            } elseif (strtolower($pokemon->type2) == strtolower($type)) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findStat($stat, $min, $max) {
        if ($stat == null) {
            return $this;
        }
        if ($min == null) {
            $min = 0;
        }
        if ($max == null) {
            $max = INF;
        }
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            $statnum = $pokemon->$stat;
            if ($statnum >= $min && $statnum <= $max) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findGeneration($generation) {
        if ($generation == null) {
            return $this;
        }
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if($pokemon->generation == $generation) {
                array_push($newColl, $pokemon);
            }
        }
        return new PokemonDB($newColl);
    }

    function findLegendary($legendary) {
        if ($legendary == null) {
            return $this;
        }
        $newColl = [];
        foreach ($this->collection as $pokemon) {
            if (strtolower($pokemon->legendary) == strtolower($legendary)) {
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

    // get data from json db and store in pokemon db class to allow easy searching
    $json_str = file_get_contents("./data/pokemondb.json");
    $objlist = json_decode($json_str);
    $db = new PokemonDB($objlist);

    $number = $_POST["number"];
    $name = $_POST["name"];
    $type1 = $_POST["type1"];
    $type2 = $_POST["type2"];
    $hpmax = $_POST["hpmax"];
    $hpmin = $_POST["hpmin"];
    $attackmax = $_POST["attackmax"];
    $attackmin = $_POST["attackmin"];
    $defensemax = $_POST["defensemax"];
    $defensemin = $_POST["defensemin"];
    $spattmax = $_POST["spatkmax"];
    $spatkmin = $_POST["spatkmin"];
    $spdefmax = $_POST["spdefmax"];
    $spdefmin = $_POST["spdefmin"];
    $speedmax = $_POST["speedmax"];
    $speedmin = $_POST["speedmin"];
    $generation = $_POST["generation"];
    $legendary = $_POST["legendary"];

    $queryResult = $db->findNumber($number)
                        ->findName($name)
                        ->findType($type1)
                        ->findType($type2)
                        ->findStat("hp", $hpmin, $hpmax)
                        ->findStat("attack", $attackmin, $attackmax)
                        ->findStat("defense", $defensemin, $defensemax)
                        ->findStat("spatk", $spatkmin, $spattmax)
                        ->findStat("spdef", $spdefmin, $spdefmax)
                        ->findStat("speed", $speedmin, $speedmax)
                        ->findGeneration($generation)
                        ->findLegendary($legendary);

    foreach ($queryResult->collection as $result) {
        echo $result;
    }

}

handleUserQuery();
?>