<?php
class DatosSensores {
    private $conn;
    private $table = "datossensores";

    public function __construct($db) {
        $this->conn = $db;
    }

    // GET ALL
    public function getAll(): mixed {
        try {
            $query = "SELECT ds.id, ds.valor, ds.fk_sensor, ds.fecha, ds.fk_unidad_medida,
                      s.nombre as sensor_nombre,
                      um.nombre as unidad_medida_nombre
                      FROM " . $this->table . " ds
                      LEFT JOIN sensores s ON ds.fk_sensor = s.id
                      LEFT JOIN unidadmedida um ON ds.fk_unidad_medida = um.id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // GET BY ID
    public function getId($id): mixed {
        try {
            $query = "SELECT ds.id, ds.valor, ds.fk_sensor, ds.fecha, ds.fk_unidad_medida,
                      s.nombre as sensor_nombre,
                      um.nombre as unidad_medida_nombre
                      FROM " . $this->table . " ds
                      LEFT JOIN sensores s ON ds.fk_sensor = s.id
                      LEFT JOIN unidadmedida um ON ds.fk_unidad_medida = um.id
                      WHERE ds.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // CREATE
    public function create($valor, $fk_sensor, $fecha, $fk_unidad_medida): mixed {
        try {
            $query = "INSERT INTO " . $this->table . " 
                     (valor, fk_sensor, fecha, fk_unidad_medida) 
                     VALUES (:valor, :fk_sensor, :fecha, :fk_unidad_medida)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
            $stmt->bindParam(":fk_sensor", $fk_sensor, PDO::PARAM_INT);
            $stmt->bindParam(":fecha", $fecha);
            $stmt->bindParam(":fk_unidad_medida", $fk_unidad_medida, PDO::PARAM_INT);
            $stmt->execute();
            return ["success" => "Dato de sensor creado", "id" => $this->conn->lastInsertId()];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // UPDATE (Full)
    public function update($id, $valor, $fk_sensor, $fecha, $fk_unidad_medida): mixed {
        try {
            $query = "UPDATE " . $this->table . " 
                     SET valor = :valor, 
                         fk_sensor = :fk_sensor, 
                         fecha = :fecha,
                         fk_unidad_medida = :fk_unidad_medida
                     WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
            $stmt->bindParam(":fk_sensor", $fk_sensor, PDO::PARAM_INT);
            $stmt->bindParam(":fecha", $fecha);
            $stmt->bindParam(":fk_unidad_medida", $fk_unidad_medida, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0 
                ? ["success" => "Dato de sensor actualizado"] 
                : ["error" => "No se realizaron cambios o el ID no existe"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // PATCH (Partial Update)
    public function partialUpdate($id, $data): mixed {
        try {
            if (empty($data)) {
                return ["error" => "No se proporcionaron campos para actualizar"];
            }

            $setParts = [];
            $params = [':id' => $id];
            
            $allowedFields = ['valor', 'fk_sensor', 'fecha', 'fk_unidad_medida'];
            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    $setParts[] = "$field = :$field";
                    $params[":$field"] = $data[$field];
                }
            }
            
            if (empty($setParts)) {
                return ["error" => "No se proporcionaron campos válidos para actualizar"];
            }
            
            $query = "UPDATE " . $this->table . " SET " . implode(', ', $setParts) . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            
            foreach ($params as $key => $value) {
                $paramType = (is_int($value)) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key, $value, $paramType);
            }
            
            $stmt->execute();
            
            return $stmt->rowCount() > 0 
                ? ["success" => "Dato de sensor actualizado parcialmente", "updatedFields" => array_keys($data)] 
                : ["error" => "No se realizaron cambios o el ID no existe"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // DELETE
    public function delete($id): mixed {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0 
                ? ["success" => "Dato de sensor eliminado"] 
                : ["error" => "No se eliminó el registro (¿ID existe?)"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // Método adicional para obtener datos por sensor
    public function getBySensor($sensorId, $limit = null): mixed {
        try {
            $query = "SELECT ds.id, ds.valor, ds.fecha, 
                      um.nombre as unidad_medida
                      FROM " . $this->table . " ds
                      LEFT JOIN unidadmedida um ON ds.fk_unidad_medida = um.id
                      WHERE ds.fk_sensor = :sensorId
                      ORDER BY ds.fecha DESC";
            
            if ($limit !== null) {
                $query .= " LIMIT :limit";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":sensorId", $sensorId, PDO::PARAM_INT);
            
            if ($limit !== null) {
                $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
?>