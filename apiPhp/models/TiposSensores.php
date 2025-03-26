<?php
class TiposSensores {
    private $conn;
    private $table = "tipossensores";

    public function __construct($db) {
        $this->conn = $db;
    }

    // GET ALL
    public function getAll(): mixed {
        try {
            $query = "SELECT id, nombre FROM " . $this->table;
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
            return ["success" => "Tipo de sensor creado", "id" => $this->conn->lastInsertId()];
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
            return ["success" => "Tipo de sensor actualizado"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function patchTiposSensores($id, $data): array {
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $stmt = $this->conn->prepare("UPDATE $this->table SET $set WHERE id = :id");
        $stmt->execute(array_merge($data, ['id' => $id]));
        return ['success' => $stmt->rowCount() > 0];
    }

    // DELETE
    public function delete($id): mixed {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return ["success" => "Tipo de sensor eliminado"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }
}