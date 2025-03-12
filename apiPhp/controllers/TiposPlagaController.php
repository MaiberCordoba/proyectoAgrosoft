<?php

require_once("./config/dataBase.php");
require_once("./models/TiposPlaga.php");

class TiposPlagaController {
    private $db;
    private $tiposPlaga;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->tiposPlaga = new TiposPlaga($this->db);
    }

    public function getAll() {
        $data = $this->tiposPlaga->getAll();
        echo json_encode(["status" => 200, "data" => $data]);
        http_response_code(200);
    }

    public function getById($id) {
        $data = $this->tiposPlaga->getById($id);
        if ($data) {
            echo json_encode(["status" => 200, "data" => $data]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Tipo de plaga no encontrado"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->tiposPlaga->crearTipoPlaga($data['nombre'], $data['descripcion'])) {
            echo json_encode(["message" => "Tipo de plaga registrado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar tipo de plaga"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->tiposPlaga->actualizarTipoPlaga($id, $data['nombre'], $data['descripcion'])) {
            echo json_encode(["message" => "Tipo de plaga actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar tipo de plaga"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->tiposPlaga->eliminarTipoPlaga($id)) {
            echo json_encode(["message" => "Tipo de plaga eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar tipo de plaga"]);
            http_response_code(500);
        }
    }
}