<?php
require_once("./config/dataBase.php");
require_once("./models/DatosSensores.php");

class DatosSensoresController {
    private $db;
    private $datosSensores;

    public function __construct() {
        $database = new DataBase();
        $this->db = $database->getConection();
        $this->datosSensores = new DatosSensores($this->db);
    }

    // GET ALL
    public function getAll(): void {
        $result = $this->datosSensores->getAll();
        $this->sendResponse($result);
    }

    // GET BY ID
    public function getById($id): void {
        if (!$this->validateId($id)) return;
        $result = $this->datosSensores->getId($id);
        $this->sendResponse($result, 200, "data");
    }

    // GET BY SENSOR
    public function getBySensor($sensorId, $limit = null): void {
        if (!$this->validateId($sensorId)) return;
        
        $result = $this->datosSensores->getBySensor($sensorId, $limit);
        $this->sendResponse($result);
    }

    // CREATE
    public function create(): void {
        $data = json_decode(file_get_contents("php://input"), true);
        
        $required = ['valor', 'fk_sensor', 'fk_unidad_medida'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $this->sendError("El campo '$field' es requerido", 400);
                return;
            }
        }

        // Si no se proporciona fecha, usar la actual
        $fecha = $data['fecha'] ?? date('Y-m-d H:i:s');

        $result = $this->datosSensores->create(
            $data['valor'],
            $data['fk_sensor'],
            $fecha,
            $data['fk_unidad_medida']
        );
        $this->sendResponse($result, 201);
    }

    // UPDATE (PUT)
    public function update($id): void {
        if (!$this->validateId($id)) return;
        
        $data = json_decode(file_get_contents("php://input"), true);
        
        $required = ['valor', 'fk_sensor', 'fk_unidad_medida'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $this->sendError("El campo '$field' es requerido", 400);
                return;
            }
        }

        // Si no se proporciona fecha, mantener la existente
        $fecha = $data['fecha'] ?? null;

        $result = $this->datosSensores->update(
            $id,
            $data['valor'],
            $data['fk_sensor'],
            $fecha,
            $data['fk_unidad_medida']
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

        $allowedFields = ['valor', 'fk_sensor', 'fecha', 'fk_unidad_medida'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));

        if (empty($filteredData)) {
            $this->sendError("Solo se permiten actualizar los campos: valor, fk_sensor, fecha, fk_unidad_medida", 400);
            return;
        }

        $result = $this->datosSensores->partialUpdate($id, $filteredData);
        $this->sendResponse($result);
    }

    // DELETE
    public function delete($id): void {
        if (!$this->validateId($id)) return;
        $result = $this->datosSensores->delete($id);
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
            $response["message"] = "Dato de sensor creado exitosamente";
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