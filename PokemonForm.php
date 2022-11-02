<?php
class PokemonForm {
    function __construct() {
        $this->attributes = [
            "number" => "",
            "name" => "",
            "type1" => "",
            "type2" => "",
            "hpmax" => "",
            "hpmin" => "",
            "attackmax" => "",
            "attackmin" => "",
            "defensemax" => "",
            "defensemin" => "",
            "spattmax" => "",
            "spatkmin" => "",
            "spdefmax" => "",
            "spdefmin" => "",
            "speedmax" => "",
            "speedmin" => "",
            "generation" => "",
            "legendary" => ""
        ];
    }

    function populateFromPostData() {
        foreach ($this->attributes as $key => $value) {
            $this->attributes[$key] = $_POST[$key];
        }
    }
}
?>