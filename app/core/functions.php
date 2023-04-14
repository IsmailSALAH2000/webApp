<?php

function show($stuff)
    {
        echo '<pre>';
        print_r($stuff);
        echo '</pre>';
    }

function skip($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function redirect($path){
    header("Location: ".ROOT."/".$path);
    die;
}