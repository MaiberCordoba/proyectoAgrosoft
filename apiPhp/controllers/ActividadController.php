<?php 

require_once("./config/dataBase.php");
require_once("./models/Actividad.php");

class ActividadController {
    private $db;
    private $actividad;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->actividad = new Actividad($this->db);
    }

    // Obtener todas las actividades
    public function getAll() {
        $actividades = $this->actividad->getAll();
    
        echo json_encode([
            "status" => 200,
            "data" => $actividades
        ]);
        http_response_code(200);
    }

    // Obtener una actividad por ID
    public function getById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $actividad = $this->actividad->getById($id);
            if ($actividad) {
                echo json_encode([
                    "status" => 200,
                    "data" => $actividad
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Actividad no encontrada"]);
                http_response_code(404);
            }
        }
    }

    // Crear una actividad
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_Cultivos'], $data['fk_Usuarios'], $data['titulo'], $data['descripcion'], $data['fecha'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->actividad->crearActividad(
                $data['fk_Cultivos'], 
                $data['fk_Usuarios'], 
                $data['titulo'], 
                $data['descripcion'], 
                $data['fecha'], 
                $data['estado']
            )) {
                echo json_encode(["message" => "Actividad registrada exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar actividad"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar una actividad
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['fk_Cultivos'], $data['fk_Usuarios'], $data['titulo'], $data['descripcion'], $data['fecha'], $data['estado'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->actividad->actualizarActividad(
                $id, 
                $data['fk_Cultivos'], 
                $data['fk_Usuarios'], 
                $data['titulo'], 
                $data['descripcion'], 
                $data['fecha'], 
                $data['estado']
            )) {
                echo json_encode(["message" => "Actividad actualizada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar actividad"]);
                http_response_code(500);
            }
        }
    }

    public function patch($id): void {
        // Obtener datos del cuerpo de la petición
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validación básica del ID
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(["error" => "ID debe ser numérico"]);
            return;
        }
        
        // Validación básica de datos
        if (empty($data)) {
            http_response_code(400);
            echo json_encode(["error" => "Se requieren datos para actualizar"]);
            return;
        }
        
        // Llamar al modelo simplificado
        $result = $this->actividad->partialUpdate($id, $data);
        
        // Manejar la respuesta
        if (isset($result['error'])) {
            http_response_code(400);
            echo json_encode(["error" => $result['error']]);
            return;
        }
        
        // Respuesta exitosa
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => $result['success'],
            "updated_id" => $id
        ]);
    }

    // Eliminar una actividad
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->actividad->eliminarActividad($id)) {
                echo json_encode(["message" => "Actividad eliminada exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar actividad"]);
                http_response_code(500);
            }
        }
    }
}
