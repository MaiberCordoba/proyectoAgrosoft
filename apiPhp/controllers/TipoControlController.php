<?php

require_once("./config/dataBase.php");
require_once("./models/TipoControl.php");

class TipoControlController {
    private $db;
    private $tipoControl;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->tipoControl = new TipoControl($this->db);
    }

    public function getAll() {
        $tipos = $this->tipoControl->getAll();
        echo json_encode(["status" => 200, "data" => $tipos]);
        http_response_code(200);
    }

    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $tipo = $this->tipoControl->getById($id);
            if ($tipo) {
                echo json_encode(["status" => 200, "data" => $tipo]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Tipo de control no encontrado"]);
                http_response_code(404);
            }
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }
            if ($this->tipoControl->crearTipoControl($data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Tipo de control registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar tipo de control"]);
                http_response_code(500);
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }
            if ($this->tipoControl->actualizarTipoControl($id, $data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Tipo de control actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar tipo de control"]);
                http_response_code(500);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->tipoControl->eliminarTipoControl($id)) {
                echo json_encode(["message" => "Tipo de control eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar tipo de control"]);
                http_response_code(500);
            }
        }
    }
}

