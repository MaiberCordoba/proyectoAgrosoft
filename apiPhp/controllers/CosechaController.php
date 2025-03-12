<?php
require_once("./config/dataBase.php");
require_once("./models/Cosecha.php");

class CosechaController {
    private $db;
    private $cosecha;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->cosecha = new Cosecha($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->cosecha->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $cosecha = $this->cosecha->getById($id);
        if ($cosecha) {
            echo json_encode(["status" => 200, "data" => $cosecha]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Cosecha no encontrada"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_Cultivo'], $data['fecha'], $data['cantidad'], $data['unidad'], $data['estado'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->cosecha->crearCosecha($data['fk_Cultivo'], $data['fecha'], $data['cantidad'], $data['unidad'], $data['estado'])) {
            echo json_encode(["message" => "Cosecha registrada exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar cosecha"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_Cultivo'], $data['fecha'], $data['cantidad'], $data['unidad'], $data['estado'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->cosecha->actualizarCosecha($id, $data['fk_Cultivo'], $data['fecha'], $data['cantidad'], $data['unidad'], $data['estado'])) {
            echo json_encode(["message" => "Cosecha actualizada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar cosecha"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->cosecha->eliminarCosecha($id)) {
            echo json_encode(["message" => "Cosecha eliminada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar cosecha"]);
            http_response_code(500);
        }
    }
}
?>