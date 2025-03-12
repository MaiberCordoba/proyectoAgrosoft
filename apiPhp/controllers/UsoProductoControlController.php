<?php
require_once("./config/dataBase.php");
require_once("./models/UsoProductoControl.php");

class UsoProductoControlController {
    private $db;
    private $usoProductoControl;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->usoProductoControl = new UsoProductoControl($this->db);
    }

    public function getAll() {
        $data = $this->usoProductoControl->getAll();
        echo json_encode(["status" => 200, "data" => $data]);
        http_response_code(200);
    }

    public function getById($id) {
        $data = $this->usoProductoControl->getById($id);
        if ($data) {
            echo json_encode(["status" => 200, "data" => $data]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Registro no encontrado"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_ProductoControl'], $data['fk_Cultivo'], $data['fecha'], $data['cantidad'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->usoProductoControl->crearUsoProductoControl($data['fk_ProductoControl'], $data['fk_Cultivo'], $data['fecha'], $data['cantidad'])) {
            echo json_encode(["message" => "Registro creado correctamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al crear el registro"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['fk_ProductoControl'], $data['fk_Cultivo'], $data['fecha'], $data['cantidad'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }
        if ($this->usoProductoControl->actualizarUsoProductoControl($id, $data['fk_ProductoControl'], $data['fk_Cultivo'], $data['fecha'], $data['cantidad'])) {
            echo json_encode(["message" => "Registro actualizado correctamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar el registro"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->usoProductoControl->eliminarUsoProductoControl($id)) {
            echo json_encode(["message" => "Registro eliminado correctamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar el registro"]);
            http_response_code(500);
        }
    }
}

