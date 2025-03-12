<?php
require_once("./config/dataBase.php");
require_once("./models/Era.php");

class EraController {
    private $db;
    private $era;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->era = new Era($this->db);
    }

    public function getAll() {
        $eras = $this->era->getAll();
        echo json_encode(["status" => 200, "data" => $eras]);
        http_response_code(200);
    }

    public function getById($id) {
        $era = $this->era->getById($id);
        if ($era) {
            echo json_encode(["status" => 200, "data" => $era]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Era no encontrada"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['fk_Lotes'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }

        if ($this->era->crearEra($data['nombre'], $data['descripcion'], $data['fk_Lotes'])) {
            echo json_encode(["message" => "Era registrada exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar era"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['fk_Lotes'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }

        if ($this->era->actualizarEra($id, $data['nombre'], $data['descripcion'], $data['fk_Lotes'])) {
            echo json_encode(["message" => "Era actualizada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar era"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->era->eliminarEra($id)) {
            echo json_encode(["message" => "Era eliminada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar era"]);
            http_response_code(500);
        }
    }
}

