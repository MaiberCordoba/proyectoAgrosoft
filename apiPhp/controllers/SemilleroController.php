<?php

require_once("./config/dataBase.php");
require_once("./models/Semillero.php");

class SemilleroController {
    private $db;
    private $semillero;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->semillero = new Semillero($this->db);
    }

    public function getAll() {
        $semilleros = $this->semillero->getAll();
        echo json_encode(["status" => 200, "data" => $semilleros]);
        http_response_code(200);
    }

    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $semillero = $this->semillero->getById($id);
            if ($semillero) {
                echo json_encode(["status" => 200, "data" => $semillero]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Semillero no encontrado"]);
                http_response_code(404);
            }
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['fk_Cultivos'], $data['nombre'], $data['ubicacion'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->semillero->crearSemillero($data['fk_Cultivos'], $data['nombre'], $data['ubicacion'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Semillero registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar semillero"]);
                http_response_code(500);
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['fk_Cultivos'], $data['nombre'], $data['ubicacion'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->semillero->actualizarSemillero($id, $data['fk_Cultivos'], $data['nombre'], $data['ubicacion'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Semillero actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar semillero"]);
                http_response_code(500);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->semillero->eliminarSemillero($id)) {
                echo json_encode(["message" => "Semillero eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar semillero"]);
                http_response_code(500);
            }
        }
    }
}

