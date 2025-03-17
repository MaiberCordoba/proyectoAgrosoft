<?php

require_once("./config/dataBase.php");
require_once("./models/TiposSensores.php");

class TiposSensoresController{
    private $db;
    private $tiposSensores;

    public function __construct() {
        $database = new DataBase;
        $this->db = $database->getConection();
        $this->tiposSensores = new TiposSensores(db: $this->db);
    }

    public function getAll():void {
        $TiposSensor = $this->tiposSensores->getAll();
        
        echo json_encode([
            "status" => 200,
            "data" => $TiposSensor
        ]);
        http_response_code(200);
    }
}