<?php

class User {
    private $connect;
    private $table = "users";

    private $id;
    private $nombre;
    private $email;
    private $created_at;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los usuarios
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        if ($stmt->execute()) {
            return $stmt;
        } else {
            $error = $stmt->errorInfo();
            die("Error en la consulta de la DB: " . $error[2]);
        }
    }

    // Obtener un usuario por ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stmt->errorInfo();
                die("Error en la consulta de la DB: " . $error[2]);
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al obtener usuario por ID: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo usuario
    public function crearUsuario($nombre, $email) {
        try {
            $query = "INSERT INTO $this->table (nombre, email, created_at) VALUES (:nombre, :email, NOW())";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al registrar un usuario: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un usuario
    public function actualizarUsuario($id, $nombre, $email) {
        try {
            $query = "UPDATE $this->table SET nombre = :nombre, email = :email WHERE id = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al actualizar un usuario: " . $e->getMessage());
            return false;
        }
    }

    public function patchUser($id, $data): array {
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $stmt = $this->connect->prepare("UPDATE $this->table SET $set WHERE id = :id");
        $stmt->execute(array_merge($data, ['id' => $id]));
        return ['success' => $stmt->rowCount() > 0];
    }

    // Eliminar un usuario
    public function eliminarUsuario($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id = :id";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            error_log("Error al eliminar un usuario: " . $e->getMessage());
            return false;
        }
    }
}
