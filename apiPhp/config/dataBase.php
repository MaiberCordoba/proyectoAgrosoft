<?php 

class DataBase {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "agrosoftnode";

    public $connect;

    public function getConection() {
        $this->connect = null;

        try{
            $this->connect = new PDO("mysql:host=". $this->host. ";dbname=". $this->dbname, $this->username, $this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect->exec("set names utf8");
        }catch(PDOException $e){
            echo "error en la conexion de la base de datos: ".$e->getMessage();
        }
        return $this->connect;
    }

}

define('JWT_SECRET_KEY', 'tutifruti'); 
define('JWT_ALGORITHM', 'HS256');

?>