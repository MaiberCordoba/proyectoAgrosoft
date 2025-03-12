<?php

require_once("./config/dataBase.php");
require_once("./models/Especie.php");

class EspecieController {
    private $db;
    private $especie;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->especie = new Especie($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->especie->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $especie = $this->especie->getById($id);
        if ($especie) {
            echo json_encode(["status" => 200, "data" => $especie]);
        } else {
            echo json_encode(["message" => "Especie no encontrada"]);
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
        if ($this->especie->crearEspecie($data['nombre'], $data['descripcion'])) {
            echo json_encode(["message" => "Especie registrada exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar especie"]);
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
        if ($this->especie->actualizarEspecie($id, $data['nombre'], $data['descripcion'])) {
            echo json_encode(["message" => "Especie actualizada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar especie"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->especie->eliminarEspecie($id)) {
            echo json_encode(["message" => "Especie eliminada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar especie"]);
            http_response_code(500);
        }
    }
}

