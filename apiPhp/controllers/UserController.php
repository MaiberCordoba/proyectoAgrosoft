<?php 

require_once("./config/dataBase.php");
require_once("./models/User.php");

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->user = new User($this->db);
    }

    // Obtener todos los usuarios
    public function getUser() {
        $stmt = $this->user->getAll();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => 200,
            "data" => $users
        ]);
        http_response_code(200);
    }

    // Obtener un usuario por ID
    public function getUserById($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $user = $this->user->getById($id);
            if ($user) {
                echo json_encode([
                    "status" => 200,
                    "data" => $user
                ]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Usuario no encontrado"]);
                http_response_code(404);
            }
        }
    }

    // Crear un usuario
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['email'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->user->crearUsuario($data['nombre'], $data['email'])) {
                echo json_encode(["message" => "Usuario registrado exitosamente"]);
                http_response_code(201);
            } else {
                echo json_encode(["message" => "Error al registrar usuario"]);
                http_response_code(500);
            }
        }
    }

    // Actualizar un usuario
    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['nombre']) || !isset($data['email'])) {
                echo json_encode(["message" => "Datos incompletos"]);
                http_response_code(400);
                return;
            }

            if ($this->user->actualizarUsuario($id, $data['nombre'], $data['email'])) {
                echo json_encode(["message" => "Usuario actualizado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al actualizar usuario"]);
                http_response_code(500);
            }
        }
    }

    public function patch($id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->user->patchUser($id, $data);
        echo json_encode($result);
    }
    // Eliminar un usuario
    public function eliminar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if ($this->user->eliminarUsuario($id)) {
                echo json_encode(["message" => "Usuario eliminado exitosamente"]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Error al eliminar usuario"]);
                http_response_code(500);
            }
        }
    }
}
