<?php
include('./PokemonForm.php');

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

function handleUserQuery() {

    // get data from json db and store in pokemon db class to allow easy searching
    $json_str = file_get_contents("./data/pokemondb.json");
    $objlist = json_decode($json_str);
    $db = new PokemonDB($objlist);

    $request = new PokemonForm();
    $request->populateFromPostData();

    $queryResult = $db->findNumber($request->attributes["number"])
                        ->findName($request->attributes["name"])
                        ->findType($request->attributes["type1"])
                        ->findType($request->attributes["type2"])
                        ->findStat("hp", $request->attributes["hpmin"], $request->attributes["hpmax"])
                        ->findStat("attack", $request->attributes["attackmin"], $request->attributes["attackmax"])
                        ->findStat("defense", $request->attributes["defensemin"], $request->attributes["defensemax"])
                        ->findStat("spatk", $request->attributes["spatkmin"], $request->attributes["spattmax"])
                        ->findStat("spdef", $request->attributes["spdefmin"], $request->attributes["spdefmax"])
                        ->findStat("speed", $request->attributes["speedmin"], $request->attributes["speedmax"])
                        ->findGeneration($request->attributes["generation"])
                        ->findLegendary($request->attributes["legendary"]);

    echo json_encode($queryResult);
}

handleUserQuery();
?>