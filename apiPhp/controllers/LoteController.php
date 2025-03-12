<?php
require_once("./config/dataBase.php");
require_once("./models/Lote.php");

class LoteController {
    private $db;
    private $lote;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->lote = new Lote($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->lote->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $lote = $this->lote->getById($id);
        if ($lote) {
            echo json_encode(["status" => 200, "data" => $lote]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Lote no encontrado"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['tamX'], $data['tamY'], $data['estado'], $data['posX'], $data['posY'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->lote->crearLote($data['nombre'], $data['descripcion'], $data['tamX'], $data['tamY'], $data['estado'], $data['posX'], $data['posY'])) {
            echo json_encode(["message" => "Lote registrado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar lote"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['tamX'], $data['tamY'], $data['estado'], $data['posX'], $data['posY'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->lote->actualizarLote($id, $data['nombre'], $data['descripcion'], $data['tamX'], $data['tamY'], $data['estado'], $data['posX'], $data['posY'])) {
            echo json_encode(["message" => "Lote actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar lote"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->lote->eliminarLote($id)) {
            echo json_encode(["message" => "Lote eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar lote"]);
            http_response_code(500);
        }
    }
}
