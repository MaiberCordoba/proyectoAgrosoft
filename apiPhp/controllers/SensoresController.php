<?php
require_once("./config/dataBase.php");
require_once("./models/Sensores.php");

class SensoresController {
    private $db;
    private $sensores;

    public function __construct() {
        $database = new DataBase();
        $this->db = $database->getConection();
        $this->sensores = new Sensores($this->db);
    }

    // GET ALL
    public function getAll(): void {
        $result = $this->sensores->getAll();
        $this->sendResponse($result);
    }

    // GET BY ID
    public function getById($id): void {
        if (!$this->validateId($id)) return;
        $result = $this->sensores->getId($id);
        $this->sendResponse($result, 200, "data");
    }

    // CREATE
    public function create(): void {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $required = ['nombre', 'fk_tipo_sensor', 'fk_lote'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $this->sendError("El campo '$field' es requerido", 400);
                return;
            }
        }

        $result = $this->sensores->create(
            $data['nombre'],
            $data['fk_tipo_sensor'],
            $data['fk_lote']
        );
        $this->sendResponse($result, 201);
    }

    // UPDATE (PUT)
    public function update($id): void {
        if (!$this->validateId($id)) return;
        
        $data = json_decode(file_get_contents("php://input"), true);
        
        $required = ['nombre', 'fk_tipo_sensor', 'fk_lote'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $this->sendError("El campo '$field' es requerido", 400);
                return;
            }
        }

        $result = $this->sensores->update(
            $id,
            $data['nombre'],
            $data['fk_tipo_sensor'],
            $data['fk_lote']
        );
        $this->sendResponse($result);
    }

    // PATCH
    public function patch($id): void {
        if (!$this->validateId($id)) return;
        
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data)) {
            $this->sendError("Debe proporcionar al menos un campo para actualizar", 400);
            return;
        }

        $allowedFields = ['nombre', 'fk_tipo_sensor', 'fk_lote'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));

        if (empty($filteredData)) {
            $this->sendError("Solo se permiten actualizar los campos: nombre, fk_tipo_sensor, fk_lote", 400);
            return;
        }

        $result = $this->sensores->partialUpdate($id, $filteredData);
        $this->sendResponse($result);
    }

    // DELETE
    public function delete($id): void {
        if (!$this->validateId($id)) return;
        $result = $this->sensores->delete($id);
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
            $response["message"] = "Sensor creado exitosamente";
            $response["id"] = $result["id"];
        } elseif (isset($result['success'])) {
            $response["message"] = $result['success'];
            if (isset($result['updatedFields'])) {
                $response["updatedFields"] = $result['updatedFields'];
            }
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