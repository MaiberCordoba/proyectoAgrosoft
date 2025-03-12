<?php

require_once("./config/dataBase.php");
require_once("./models/Plaga.php");

class PlagaController {
    private $db;
    private $plaga;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->plaga = new Plaga($this->db);
    }

    // Obtener todas las plagas
    public function getAll() {
        $plagas = $this->plaga->getAll();
        echo json_encode(["status" => 200, "data" => $plagas]);
        http_response_code(200);
    }

    // Obtener una plaga por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $plaga = $this->plaga->getById($id);
            if ($plaga) {
                echo json_encode(["status" => 200, "data" => $plaga]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Plaga no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una plaga
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre'], $data['descripcion'], $data['fk_TiposPlaga'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->plaga->crearPlaga($data['nombre'], $data['descripcion'], $data['fk_TiposPlaga'])) {
                echo json_encode(["message" => "Plaga registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar plaga"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una plaga
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre'], $data['descripcion'], $data['fk_TiposPlaga'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->plaga->actualizarPlaga($id, $data['nombre'], $data['descripcion'], $data['fk_TiposPlaga'])) {
                echo json_encode(["message" => "Plaga actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar plaga"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una plaga
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->plaga->eliminarPlaga($id)) {
                echo json_encode(["message" => "Plaga eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar plaga"]);
                http_response_code(500);
            }
        }
    }
}