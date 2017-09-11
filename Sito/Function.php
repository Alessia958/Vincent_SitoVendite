<?php

    function pulisciInput($value){
        $value = trim($value);
        return $value;
    }

    function pulisciTesto($value){
        $value = htmlentities($value,ENT_QUOTES);
        $value = strip_tags($value);
        return $value;
    }