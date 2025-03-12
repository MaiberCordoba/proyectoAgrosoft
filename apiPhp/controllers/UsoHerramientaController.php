<?php

require_once("./config/dataBase.php");
require_once("./models/UsoHerramienta.php");

class UsoHerramientaController {
    private $db;
    private $usoHerramienta;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->usoHerramienta = new UsoHerramienta($this->db);
    }

    public function getAll() {
        echo json_encode(["status" => 200, "data" => $this->usoHerramienta->getAll()]);
        http_response_code(200);
    }

    public function getById($id) {
        $usoHerramienta = $this->usoHerramienta->getById($id);
        if ($usoHerramienta) {
            echo json_encode(["status" => 200, "data" => $usoHerramienta]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Uso de herramienta no encontrado"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_Herramienta'], $data['fk_Usuario'], $data['fechaUso'], $data['cantidad'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->usoHerramienta->crearUsoHerramienta($data['fk_Herramienta'], $data['fk_Usuario'], $data['fechaUso'], $data['cantidad'])) {
            echo json_encode(["message" => "Uso de herramienta registrado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar uso de herramienta"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_Herramienta'], $data['fk_Usuario'], $data['fechaUso'], $data['cantidad'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->usoHerramienta->actualizarUsoHerramienta($id, $data['fk_Herramienta'], $data['fk_Usuario'], $data['fechaUso'], $data['cantidad'])) {
            echo json_encode(["message" => "Uso de herramienta actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar uso de herramienta"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->usoHerramienta->eliminarUsoHerramienta($id)) {
            echo json_encode(["message" => "Uso de herramienta eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar uso de herramienta"]);
            http_response_code(500);
        }
    }
}

?>
