<?php

trait Database{
    private function connect ()
    {
        $string = "mysql:host=".DBHOST.";dbname=".DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        return $con;
    }

    public function query($query, $data = []){
        $con = $this->connect();
        $stm = $con->prepare($query);
        $check = $stm -> execute($data);
        if($check){
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if(is_array(($result)) && count($result)){
                return $result;
            }
        }else{
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

