<?php

class Especie {
    private $connect;
    private $table = "especies";

    private $id;
    private $nombre;
    private $descripcion;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearEspecie($nombre, $descripcion) {
        $query = "INSERT INTO $this->table (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    public function actualizarEspecie($id, $nombre, $descripcion) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    public function eliminarEspecie($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
