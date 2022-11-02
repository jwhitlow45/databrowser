<?php

include('./PokemonForm.php');

function handleUserInsert() {
    $json_str = file_get_contents("./data/pokemondb.json");
    $objlist = json_decode($json_str);

    $request = new PokemonForm();
    $request->populateFromPostData();





}

handleUserInsert();
?>