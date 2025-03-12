<?php

require_once("./config/dataBase.php");
require_once("./models/HorasMensuales.php");

class HorasMensualesController {
    private $db;
    private $horasMensuales;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->horasMensuales = new HorasMensuales($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->horasMensuales->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $horas = $this->horasMensuales->getById($id);
        if ($horas) {
            echo json_encode(["status" => 200, "data" => $horas]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Registro no encontrado"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_Pasantes'], $data['minutos'], $data['salario'], $data['mes'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->horasMensuales->create($data['fk_Pasantes'], $data['minutos'], $data['salario'], $data['mes'])) {
            echo json_encode(["message" => "Registro creado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al crear registro"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_Pasantes'], $data['minutos'], $data['salario'], $data['mes'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->horasMensuales->update($id, $data['fk_Pasantes'], $data['minutos'], $data['salario'], $data['mes'])) {
            echo json_encode(["message" => "Registro actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar registro"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->horasMensuales->delete($id)) {
            echo json_encode(["message" => "Registro eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar registro"]);
            http_response_code(500);
        }
    }
}
