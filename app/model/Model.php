<?php 

require_once __DIR__ . '/Database.php';

trait Model {
    use Database;
    public $errors = [];


    public function findAll(){
        $query = "select * from $this->table order by 1";
        return $this->query($query);
    }

    public function selectAll($data, $data_not=[]){

        $query = "select * from $this->table where ";
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && "; 
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " && "; 
        }

        $query = trim($query, " && ");
        $query .= ' order by 1'; 

        $data = array_merge($data, $data_not);

        return $this->query($query, $data);

    }

    public function select($data, $data_not=[]){

        $query = "select * from $this->table where ";
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && "; 
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " && "; 
        }

        $query = trim($query, " &");//supprime les ' ' et '&' en début et fin de chaine //$query = trim($query, " && ");
        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if($result) return $result[0];

        return false;
    }

    public function insert($data){
        $keys = array_keys($data);
        $query = "insert into $this->table (" . implode(", ",$keys) . ") values (:" . implode(", :",$keys) . ") ";
        return $this->query($query, $data);
    }

    public function update($idValue, $data, $idName){
        $query = "update $this->table set ";
        $keys = array_keys($data);
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " , "; 
        }
        $query = trim($query, " ,");
        $query .= " where $idName = :$idName";
        $data[$idName] = $idValue;
        return $this->query($query, $data);
    }

    public function delete($id, $idName){
        $data[$idName] = $id;
        $query = "delete from $this->table where $idName = :$idName";
        return $this->query($query, $data);
    } 
}
