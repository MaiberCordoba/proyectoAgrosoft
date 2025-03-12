<?php

class Plaga {
    private $connect;
    private $table = "plagas";

    private $id;
    private $nombre;
    private $descripcion;
    private $fk_TiposPlaga;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las plagas
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una plaga por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva plaga
    public function crearPlaga($nombre, $descripcion, $fk_TiposPlaga) {
        $query = "INSERT INTO $this->table (nombre, descripcion, fk_TiposPlaga) VALUES (:nombre, :descripcion, :fk_TiposPlaga)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fk_TiposPlaga', $fk_TiposPlaga, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Actualizar una plaga
    public function actualizarPlaga($id, $nombre, $descripcion, $fk_TiposPlaga) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion, fk_TiposPlaga = :fk_TiposPlaga WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fk_TiposPlaga', $fk_TiposPlaga, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar una plaga
    public function eliminarPlaga($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}