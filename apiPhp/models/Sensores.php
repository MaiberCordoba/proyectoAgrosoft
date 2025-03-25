<?php
class Sensores {
    private $conn;
    private $table = "sensores";

    public function __construct($db) {
        $this->conn = $db;
    }

    // GET ALL
    public function getAll(): mixed {
        try {
            $query = "SELECT s.id, s.nombre, s.fk_tipo_sensor, s.fk_lote, 
                      ts.nombre as tipo_sensor_nombre
                      FROM " . $this->table . " s
                      LEFT JOIN tipossensores ts ON s.fk_tipo_sensor = ts.id";
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
            $query = "SELECT s.id, s.nombre, s.fk_tipo_sensor, s.fk_lote, 
                      ts.nombre as tipo_sensor_nombre
                      FROM " . $this->table . " s
                      LEFT JOIN tipossensores ts ON s.fk_tipo_sensor = ts.id
                      WHERE s.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // CREATE
    public function create($nombre, $fk_tipo_sensor, $fk_lote): mixed {
        try {
            $query = "INSERT INTO " . $this->table . " 
                     (nombre, fk_tipo_sensor, fk_lote) 
                     VALUES (:nombre, :fk_tipo_sensor, :fk_lote)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":fk_tipo_sensor", $fk_tipo_sensor, PDO::PARAM_INT);
            $stmt->bindParam(":fk_lote", $fk_lote, PDO::PARAM_INT);
            $stmt->execute();
            return ["success" => "Sensor creado", "id" => $this->conn->lastInsertId()];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // UPDATE (Full)
    public function update($id, $nombre, $fk_tipo_sensor, $fk_lote): mixed {
        try {
            $query = "UPDATE " . $this->table . " 
                     SET nombre = :nombre, 
                         fk_tipo_sensor = :fk_tipo_sensor, 
                         fk_lote = :fk_lote 
                     WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":fk_tipo_sensor", $fk_tipo_sensor, PDO::PARAM_INT);
            $stmt->bindParam(":fk_lote", $fk_lote, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0 
                ? ["success" => "Sensor actualizado"] 
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
            
            if (isset($data['nombre'])) {
                $setParts[] = 'nombre = :nombre';
                $params[':nombre'] = $data['nombre'];
            }
            
            if (isset($data['fk_tipo_sensor'])) {
                $setParts[] = 'fk_tipo_sensor = :fk_tipo_sensor';
                $params[':fk_tipo_sensor'] = $data['fk_tipo_sensor'];
            }
            
            if (isset($data['fk_lote'])) {
                $setParts[] = 'fk_lote = :fk_lote';
                $params[':fk_lote'] = $data['fk_lote'];
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
                ? ["success" => "Sensor actualizado parcialmente"] 
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
                ? ["success" => "Sensor eliminado"] 
                : ["error" => "No se eliminó el registro (¿ID existe?)"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
?>