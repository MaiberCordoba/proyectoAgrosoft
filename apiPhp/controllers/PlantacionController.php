<?php
require_once("./config/dataBase.php");
require_once("./models/Plantacion.php");

class PlantacionController {
    private $db;
    private $plantacion;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->plantacion = new Plantacion($this->db);
    }

    public function getAll() {
        $plantaciones = $this->plantacion->getAll();
        echo json_encode(["status" => 200, "data" => $plantaciones]);
        http_response_code(200);
    }

    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $plantacion = $this->plantacion->getById($id);
            if ($plantacion) {
                echo json_encode(["status" => 200, "data" => $plantacion]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Plantación no encontrada"]);
                http_response_code(404);
            }
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['fk_Cultivos'], $data['nombre'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }
            if ($this->plantacion->crearPlantacion($data['fk_Cultivos'], $data['nombre'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Plantación registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar plantación"]);
                http_response_code(500);
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['fk_Cultivos'], $data['nombre'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }
            if ($this->plantacion->actualizarPlantacion($id, $data['fk_Cultivos'], $data['nombre'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Plantación actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar plantación"]);
                http_response_code(500);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->plantacion->eliminarPlantacion($id)) {
                echo json_encode(["message" => "Plantación eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar plantación"]);
                http_response_code(500);
            }
        }
    }
}

