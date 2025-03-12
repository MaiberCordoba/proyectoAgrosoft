<?php
require_once("./config/dataBase.php");
require_once("./models/Venta.php");

class VentaController {
    private $db;
    private $venta;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->venta = new Venta($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->venta->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $venta = $this->venta->getById($id);
        if ($venta) {
            echo json_encode(["status" => 200, "data" => $venta]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Venta no encontrada"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_Usuario'], $data['fecha'], $data['total'], $data['estado'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->venta->crearVenta($data['fk_Usuario'], $data['fecha'], $data['total'], $data['estado'])) {
            echo json_encode(["message" => "Venta registrada exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar venta"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_Usuario'], $data['fecha'], $data['total'], $data['estado'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->venta->actualizarVenta($id, $data['fk_Usuario'], $data['fecha'], $data['total'], $data['estado'])) {
            echo json_encode(["message" => "Venta actualizada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar venta"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->venta->eliminarVenta($id)) {
            echo json_encode(["message" => "Venta eliminada exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar venta"]);
            http_response_code(500);
        }
    }
}

?>