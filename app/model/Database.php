<?php

require_once __DIR__ . '/../core/config.php';

trait Database{
    private function connect ()
    {
        $string = "mysql:host=".DBHOST.";dbname=".DBNAME;
        $database = new PDO($string, DBUSER, DBPASS);
        return $database;
    }

    public function query(string $query, $data = []){
        $database = $this->connect();
        $preparedQuery = $database->prepare($query);
        $check = $preparedQuery->execute($data);
        if($check){
            return $preparedQuery->fetchAll();
            /*
            $result = $preparedQuery->fetchAll();
            if($result){
                return $result;
            }
            else return false;
            */
        }else{ //échec de la requête
            return false;
        }     
    }

    //get one row
    public function get_row ($query, $data = []){
        $con = $this->connect();
        $stm = $con->prepare($query);
        $check = $stm -> execute($data);
        if($check){
            $result = $stm->fetch(PDO::FETCH_OBJ);
            if(is_object(($result))){
                return $result[0];
            }
        }else{
            return false;
        }
    }
}


