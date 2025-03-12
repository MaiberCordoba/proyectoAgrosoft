<?php
require_once("./config/dataBase.php");
require_once("./models/TiposDesecho.php");

class TiposDesechoController {
    private $db;
    private $tiposDesecho;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->tiposDesecho = new TiposDesecho($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->tiposDesecho->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $tipoDesecho = $this->tiposDesecho->getById($id);
        if ($tipoDesecho) {
            echo json_encode(["status" => 200, "data" => $tipoDesecho]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Tipo de desecho no encontrado"]);
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
        if ($this->tiposDesecho->create($data['nombre'], $data['descripcion'])) {
            echo json_encode(["message" => "Tipo de desecho registrado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar tipo de desecho"]);
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
        if ($this->tiposDesecho->update($id, $data['nombre'], $data['descripcion'])) {
            echo json_encode(["message" => "Tipo de desecho actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar tipo de desecho"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->tiposDesecho->delete($id)) {
            echo json_encode(["message" => "Tipo de desecho eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar tipo de desecho"]);
            http_response_code(500);
        }
    }
}
