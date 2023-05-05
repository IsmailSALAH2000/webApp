<?php 

require_once __DIR__ . '/Database.php';

trait Model {
    use Database;
    
    //protected $limit=5;
    //protected $offset=0;
    //protected $order_type = "desc";
    //protected $order_column = "id";
    public $errors = [];


    public function findAll(){
        $query = "select * from $this->table"; //order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        return $this->query($query);
    }

    public function where($data, $data_not=[]){ //utile ?

        $query = "";

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

        $query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);

        return $this->query($query, $data);

    }

    public function select($data, $data_not=[]){ //ok
        //$query = "";

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

        //$query .= " limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if($result) return $result[0];

        return false;
    }

    public function insert($data){ //ok

        /*
        if (!empty($this-> allowedColums)){
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColums)){
                    unset($data[$key]); 
                }
            }
        }*/

        //$query = "";
        $keys = array_keys($data);
        $query = "insert into $this->table (" . implode(", ",$keys) . ") values (:" . implode(", :",$keys) . ") ";
        return $this->query($query, $data);
    }

    public function update($idValue, $data, $idName){ //ok
        /*
        //annuler les entrées non obligatoire -> tout ce qui n'est pas obligatoire sur un formulaire ne doit pas être envoyer dans le tableau $data
        if (!empty($this-> allowedColums)){
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColums)){
                    unset($data[$key]); 
                }
            }
        }

        $query = "";
*/
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
        //$query = "";
        $data[$idName] = $id;
        $query = "delete from $this->table where $idName = :$idName";
        return $this->query($query, $data);
    } 
}