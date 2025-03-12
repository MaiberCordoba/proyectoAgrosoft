<?php
require_once("./config/dataBase.php");
require_once("./models/Herramienta.php");

class HerramientaController {
    private $db;
    private $herramienta;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->herramienta = new Herramienta($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->herramienta->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $herramienta = $this->herramienta->getById($id);
        if ($herramienta) {
            echo json_encode(["status" => 200, "data" => $herramienta]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Herramienta no encontrada"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['cantidad'], $data['estado'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->herramienta->crearHerramienta($data['nombre'], $data['descripcion'], $data['cantidad'], $data['estado'])) {
            echo json_encode(["message" => "Herramienta registrada exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar herramienta"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['cantidad'], $data['estado'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->herramienta->actualizarHerramienta($id, $data['nombre'], $data['descripcion'], $data['cantidad'], $data['estado'])) {
            echo json_encode(["message" => "Herramienta actualizada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar herramienta"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->herramienta->eliminarHerramienta($id)) {
            echo json_encode(["message" => "Herramienta eliminada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar herramienta"]);
            http_response_code(500);
        }
    }
}

?>