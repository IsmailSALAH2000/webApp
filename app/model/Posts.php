<?php

class User {
    use Model;
    protected $table = "posts";
    protected $allowedColums = [
        'email',
        'password',
    ];
}