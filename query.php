<?php
include('./PokemonQuery.php');

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

    $request = new PokemonQuery();
    $request->populateFromPostData();

    $queryResult = $db->findNumber($request->number)
                        ->findName($request->name)
                        ->findType($request->type1)
                        ->findType($request->type2)
                        ->findStat("hp", $request->hpmin, $request->hpmax)
                        ->findStat("attack", $request->attackmin, $request->attackmax)
                        ->findStat("defense", $request->defensemin, $request->defensemax)
                        ->findStat("spatk", $request->spatkmin, $request->spattmax)
                        ->findStat("spdef", $request->spdefmin, $request->spdefmax)
                        ->findStat("speed", $request->speedmin, $request->speedmax)
                        ->findGeneration($request->generation)
                        ->findLegendary($request->legendary);

    echo json_encode($queryResult);
}

handleUserQuery();
?>