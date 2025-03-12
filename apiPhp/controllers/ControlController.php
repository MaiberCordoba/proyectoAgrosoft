<?php
require_once("./config/dataBase.php");
require_once("./models/Control.php");

class ControlController {
    private $db;
    private $control;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->control = new Control($this->db);
    }

    public function getAll() {
        $controles = $this->control->getAll();
        echo json_encode(["status" => 200, "data" => $controles]);
        http_response_code(200);
    }

    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $control = $this->control->getById($id);
            if ($control) {
                echo json_encode(["status" => 200, "data" => $control]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Control no encontrado"]);
                http_response_code(404);
            }
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_Cultivos'], $data['fk_Usuarios'], $data['tipo'], $data['descripcion'], $data['fecha'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->control->crearControl(
                $data['fk_Cultivos'], 
                $data['fk_Usuarios'], 
                $data['tipo'], 
                $data['descripcion'], 
                $data['fecha'], 
                $data['estado']
            )) {
                echo json_encode(["message" => "Control registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar control"]);
                http_response_code(500);
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_Cultivos'], $data['fk_Usuarios'], $data['tipo'], $data['descripcion'], $data['fecha'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->control->actualizarControl(
                $id, 
                $data['fk_Cultivos'], 
                $data['fk_Usuarios'], 
                $data['tipo'], 
                $data['descripcion'], 
                $data['fecha'], 
                $data['estado']
            )) {
                echo json_encode(["message" => "Control actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar control"]);
                http_response_code(500);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->control->eliminarControl($id)) {
                echo json_encode(["message" => "Control eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar control"]);
                http_response_code(500);
            }
        }
    }
}

