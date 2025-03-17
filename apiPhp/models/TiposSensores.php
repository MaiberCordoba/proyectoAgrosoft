<?php

class TiposSensores {
    private $connet;
    private $table = "tipossensores";

    private $id;
    private $nombre;
    private $unidadMedida;

    public function __construct($db){
        $this->connet = $db;
    }

    public function getAll(): mixed{
        try {
            $query = "SELECT * FROM $this->table";
            $stmt = $this->connet->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)){
                 return $result;
            }else{
                return ["error" => "No hay datos disponibles"];;
            }
        } catch (\Exception $e) {
            return ["error"=> $e->getMessage()];
        }
    }

    public function getId($id): mixed{
        try {
            $query = "SELECT * FROM $this->table WHERE id = :id";
            $stmt = $this->connet->prepare($query);
            $stmt->bindParam("", $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)){
                return $result["id"];
            }else{
                return ["error" => "no fue posible encontrar un tipo de sensor con esta id $id"];
            }
        } catch (\Exception $e) {
            return ["error"=> $e->getMessage()];
        }
    }
    
    public function create($nombre,$unidadMedida):mixed{
        try {
            $query = "INSERT INTO $this->table (nombre,unidadMedida) VALUES (:nombre,:unidadMedida)";
            $stmt = $this->connet->prepare($query);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam("unidadMedida", $unidadMedida, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)){
                return $result;
            }else{
                return ["error"=> "no fue posible crear nuevo tipo de sensor"];
            }
        }catch (\Exception $e) {
            return ["error"=> $e->getMessage()];
        }
    }
}