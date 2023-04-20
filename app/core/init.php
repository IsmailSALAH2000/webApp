<?php

spl_autoload_register(function ($classname){
    require "../app/model/".ucfirst($classname).".php";
});
require "config.php";
require "functions.php";
require "../app/model/Database.php";
require "../app/model/Model.php";
require "../app/controllers/Controller.php";
require "App.php";
