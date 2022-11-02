<?php

include('./PokemonQuery.php');

function handleUserInsert() {
    $json_str = file_get_contents("./data/pokemondb.json");
    $objlist = json_decode($json_str);

    $request = new PokemonQuery();
    $request->populateFromPostData();





}

handleUserInsert();
?>