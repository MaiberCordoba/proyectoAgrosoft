<?php
require_once("./config/dataBase.php");
require_once("./models/TiposSensores.php");

class TiposSensoresController {
    private $db;
    private $tiposSensores;

    public function __construct() {
        $database = new DataBase();
        $this->db = $database->getConection();
        $this->tiposSensores = new TiposSensores($this->db);
    }

    // GET ALL
    public function getAll(): void {
        $result = $this->tiposSensores->getAll();
        $this->sendResponse($result);
    }

    // GET BY ID
    public function getById($id): void {
        if (!$this->validateId($id)) return;
        $result = $this->tiposSensores->getId($id);
        $this->sendResponse($result, 200, "data");
    }

    // CREATE
    public function create(): void {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (empty($data['nombre'])) {
            $this->sendError("El campo 'nombre' es requerido", 400);
            return;
        }

        $result = $this->tiposSensores->create($data['nombre']);
        $this->sendResponse($result, 201);
    }

    // UPDATE (PUT)
    public function update($id): void {
        if (!$this->validateId($id)) return;
        
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (empty($data['nombre'])) {
            $this->sendError("El campo 'nombre' es requerido", 400);
            return;
        }

        $result = $this->tiposSensores->update($id, $data['nombre']);
        $this->sendResponse($result);
    }

    // PATCH
    public function patch($id): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $this->tiposSensores->patchTiposSensores($id, $data);
        echo json_encode($result);
    }

    // DELETE
    public function delete($id): void {
        if (!$this->validateId($id)) return;
        $result = $this->tiposSensores->delete($id);
        $this->sendResponse($result);
    }

    // Métodos auxiliares
    private function validateId($id): bool {
        if (!is_numeric($id)) {
            $this->sendError("ID debe ser un número", 400);
            return false;
        }
        return true;
    }

    private function sendResponse($result, $successCode = 200, $dataKey = "data") {
        if (isset($result['error'])) {
            $statusCode = strpos($result['error'], 'No se encontró') !== false ? 404 : 500;
            $this->sendError($result['error'], $statusCode);
            return;
        }

        $response = ["status" => $successCode];
        if ($successCode == 201) {
            $response["message"] = "Tipo de sensor creado exitosamente";
            $response["id"] = $result["id"];
        } elseif (isset($result['success'])) {
            $response["message"] = $result['success'];
        } else {
            $response[$dataKey] = $result;
        }

        echo json_encode($response);
        http_response_code($successCode);
    }

    private function sendError($message, $statusCode) {
        echo json_encode([
            "status" => $statusCode,
            "message" => $message
        ]);
        http_response_code($statusCode);
    }
}