<?php
class PokemonQuery {
    function __construct() {
        $this->number = "";
        $this->name = "";
        $this->type1 = "";
        $this->type2 = "";
        $this->hpmax = "";
        $this->hpmin = "";
        $this->attackmax = "";
        $this->attackmin = "";
        $this->defensemax = "";
        $this->defensemin = "";
        $this->spattmax = "";
        $this->spatkmin = "";
        $this->spdefmax = "";
        $this->spdefmin = "";
        $this->speedmax = "";
        $this->speedmin = "";
        $this->generation = "";
        $this->legendary = "";
    }

    function populateFromPostData() {
        foreach ($this as $key => $value) {
            $this->{$key} = $_POST[$key];
        }
    }
}
?>