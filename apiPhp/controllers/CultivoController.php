<?php 

require_once("./config/dataBase.php");
require_once("./models/Cultivo.php");

class CultivoController {
    private $db;
    private $cultivo;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->cultivo = new Cultivo($this->db);
    }

    // Obtener todos los cultivos
    public function getAll() {
        $cultivos = $this->cultivo->getAll();
        echo json_encode(["status" => 200, "data" => $cultivos]);
        http_response_code(200);
    }

    // Obtener un cultivo por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $cultivo = $this->cultivo->getById($id);
            if ($cultivo) {
                echo json_encode(["status" => 200, "data" => $cultivo]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Cultivo no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un cultivo
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['nombre'], $data['descripcion'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->cultivo->crearCultivo(
                $data['nombre'], 
                $data['descripcion'], 
                $data['fecha_siembra'], 
                $data['estado']
            )) {
                echo json_encode(["message" => "Cultivo registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar cultivo"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un cultivo
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['nombre'], $data['descripcion'], $data['fecha_siembra'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->cultivo->actualizarCultivo(
                $id, 
                $data['nombre'], 
                $data['descripcion'], 
                $data['fecha_siembra'], 
                $data['estado']
            )) {
                echo json_encode(["message" => "Cultivo actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar cultivo"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar un cultivo
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->cultivo->eliminarCultivo($id)) {
                echo json_encode(["message" => "Cultivo eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar cultivo"]);
                http_response_code(500);
            }
        }
    }
}
