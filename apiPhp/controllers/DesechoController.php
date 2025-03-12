<?php
require_once("./config/dataBase.php");
require_once("./models/Desecho.php");

class DesechoController {
    private $db;
    private $desecho;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->desecho = new Desecho($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->desecho->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $desecho = $this->desecho->getById($id);
        if ($desecho) {
            echo json_encode(["status" => 200, "data" => $desecho]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Desecho no encontrado"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['tipo_desecho_id'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->desecho->crearDesecho($data['nombre'], $data['descripcion'], $data['tipo_desecho_id'])) {
            echo json_encode(["message" => "Desecho registrado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar desecho"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['tipo_desecho_id'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->desecho->actualizarDesecho($id, $data['nombre'], $data['descripcion'], $data['tipo_desecho_id'])) {
            echo json_encode(["message" => "Desecho actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar desecho"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->desecho->eliminarDesecho($id)) {
            echo json_encode(["message" => "Desecho eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar desecho"]);
            http_response_code(500);
        }
    }
}
?>
