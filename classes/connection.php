<?php


class CONNECTION_DB{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "bisuconnect_db";

    function connect(){
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        return $connection;
    }

    function read($query){
        $con = $this->connect();
        $result = mysqli_query($con, $query);

        if(!$result){
            return false;
        }
        else
        {
            $data = false;
            while($row = mysqli_fetch_assoc($result)){
                
                $data[]=  $row;
            }

            return $data;
        }
            
    }

    function save($query){
        $con = $this->connect();
        $result = mysqli_query($con, $query);

        if(!$result){
            return false;
        }else{
            return true;
        }
    }
}


//$DB = new CONNECTION_DB();



?>
