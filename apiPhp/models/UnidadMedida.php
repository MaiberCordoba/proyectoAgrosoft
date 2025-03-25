<?php
class UnidadMedida {
    private $conn;
    private $table = "unidadmedida";

    public function __construct($db) {
        $this->conn = $db;
    }

    // GET ALL
    public function getAll(): mixed {
        try {
            $query = "SELECT * FROM " . $this->table;
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
            $query = "SELECT id, nombre FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // CREATE
    public function create($nombre): mixed {
        try {
            $query = "INSERT INTO " . $this->table . " (nombre) VALUES (:nombre)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->execute();
            return ["success" => "Unidad de medida creada", "id" => $this->conn->lastInsertId()];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // UPDATE
    public function update($id, $nombre): mixed {
        try {
            $query = "UPDATE " . $this->table . " SET nombre = :nombre WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0 
                ? ["success" => "Unidad de medida actualizada"] 
                : ["error" => "No se realizaron cambios o el ID no existe"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // PATCH
    public function partialUpdate($id, $data): mixed {
        try {
            if (!isset($data['nombre'])) {
                return ["error" => "Debe proporcionar el campo 'nombre' para actualizar"];
            }
            return $this->update($id, $data['nombre']);
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // DELETE
    public function delete($id): mixed {
        try {
            // Verificar si la unidad está siendo usada en datossensores
            $checkQuery = "SELECT COUNT(*) as count FROM datossensores WHERE fk_unidad_medida = :id";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(":id", $id, PDO::PARAM_INT);
            $checkStmt->execute();
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                return ["error" => "No se puede eliminar, la unidad está siendo usada en datos de sensores"];
            }

            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0 
                ? ["success" => "Unidad de medida eliminada"] 
                : ["error" => "No se eliminó el registro (¿ID existe?)"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
?>