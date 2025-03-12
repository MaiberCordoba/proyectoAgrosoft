<?php
require_once("./config/dataBase.php");
require_once("./models/TipoEspecie.php");

class TipoEspecieController {
    private $db;
    private $tipoEspecie;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->tipoEspecie = new TipoEspecie($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->tipoEspecie->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $tipoEspecie = $this->tipoEspecie->getById($id);
            if ($tipoEspecie) {
                echo json_encode(["status" => 200, "data" => $tipoEspecie]);
            } else {
                echo json_encode(["message" => "Tipo de especie no encontrado"]);
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
            if ($this->tipoEspecie->crearTipoEspecie($data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Tipo de especie registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar tipo de especie"]);
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
            if ($this->tipoEspecie->actualizarTipoEspecie($id, $data['nombre'], $data['descripcion'])) {
                echo json_encode(["message" => "Tipo de especie actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar tipo de especie"]);
                http_response_code(500);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->tipoEspecie->eliminarTipoEspecie($id)) {
                echo json_encode(["message" => "Tipo de especie eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar tipo de especie"]);
                http_response_code(500);
            }
        }
    }
}

