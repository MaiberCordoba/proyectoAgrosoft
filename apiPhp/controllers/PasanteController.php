<?php
require_once("./config/dataBase.php");
require_once("./models/Pasante.php");

class PasanteController {
    private $db;
    private $pasante;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->pasante = new Pasante($this->db);
    }

    public function getAll() {
        $pasantes = $this->pasante->getAll();
        echo json_encode(["status" => 200, "data" => $pasantes]);
        http_response_code(200);
    }

    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $pasante = $this->pasante->getById($id);
            if ($pasante) {
                echo json_encode(["status" => 200, "data" => $pasante]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Pasante no encontrado"]);
                http_response_code(404);
            }
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['nombre'], $data['apellido'], $data['email'], $data['telefono'], $data['fecha_ingreso'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }
            if ($this->pasante->crearPasante($data['nombre'], $data['apellido'], $data['email'], $data['telefono'], $data['fecha_ingreso'])) {
                echo json_encode(["message" => "Pasante registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar pasante"]);
                http_response_code(500);
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['nombre'], $data['apellido'], $data['email'], $data['telefono'], $data['fecha_ingreso'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }
            if ($this->pasante->actualizarPasante($id, $data['nombre'], $data['apellido'], $data['email'], $data['telefono'], $data['fecha_ingreso'])) {
                echo json_encode(["message" => "Pasante actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar pasante"]);
                http_response_code(500);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->pasante->eliminarPasante($id)) {
                echo json_encode(["message" => "Pasante eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar pasante"]);
                http_response_code(500);
            }
        }
    }
}
