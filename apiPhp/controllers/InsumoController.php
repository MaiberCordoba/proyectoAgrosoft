<?php
require_once("./config/dataBase.php");
require_once("./models/Insumo.php");

class InsumoController {
    private $db;
    private $insumo;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->insumo = new Insumo($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->insumo->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $insumo = $this->insumo->getById($id);
        if ($insumo) {
            echo json_encode(["status" => 200, "data" => $insumo]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Insumo no encontrado"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['cantidad'], $data['unidad_medida'], $data['fecha_vencimiento'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->insumo->crearInsumo($data['nombre'], $data['descripcion'], $data['cantidad'], $data['unidad_medida'], $data['fecha_vencimiento'])) {
            echo json_encode(["message" => "Insumo registrado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar insumo"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['cantidad'], $data['unidad_medida'], $data['fecha_vencimiento'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->insumo->actualizarInsumo($id, $data['nombre'], $data['descripcion'], $data['cantidad'], $data['unidad_medida'], $data['fecha_vencimiento'])) {
            echo json_encode(["message" => "Insumo actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar insumo"]);
            http_response_code(500);
        }
    }

    public function patch($id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->insumo->patchInsumo($id, $data);
        echo json_encode($result);
    }

    public function delete($id) {
        if ($this->insumo->eliminarInsumo($id)) {
            echo json_encode(["message" => "Insumo eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar insumo"]);
            http_response_code(500);
        }
    }
}

?>
