<?php 

require_once("./config/dataBase.php");
require_once("./models/Afeccion.php");

class AfeccionController {
    private $db;
    private $afeccion;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->afeccion = new Afeccion($this->db);
    }

    // Obtener todas las afecciones
    public function getAll() {
        $afecciones = $this->afeccion->getAll();
    
        echo json_encode([
            "status" => 200,
            "data" => $afecciones
        ]);
        http_response_code(200);
    }

    // Obtener una afección por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $afeccion = $this->afeccion->getById($id);
            if ($afeccion) {
                echo json_encode([
                    "status" => 200,
                    "data" => $afeccion
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Afección no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una afección
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_Cultivos'], $data['nombre'], $data['descripcion'], $data['fecha'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->afeccion->crearAfeccion(
                $data['fk_Cultivos'], 
                $data['nombre'], 
                $data['descripcion'], 
                $data['fecha'], 
                $data['estado']
            )) {
                echo json_encode(["message" => "Afección registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar afección"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una afección
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_Cultivos'], $data['nombre'], $data['descripcion'], $data['fecha'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->afeccion->actualizarAfeccion(
                $id, 
                $data['fk_Cultivos'], 
                $data['nombre'], 
                $data['descripcion'], 
                $data['fecha'], 
                $data['estado']
            )) {
                echo json_encode(["message" => "Afección actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar afección"]);
                http_response_code(500);
            }
        }
    }

    // Eliminar una afección
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->afeccion->eliminarAfeccion($id)) {
                echo json_encode(["message" => "Afección eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar afección"]);
                http_response_code(500);
            }
        }
    }
}
