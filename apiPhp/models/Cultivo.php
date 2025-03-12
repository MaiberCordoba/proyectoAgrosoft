<?php

class Cultivo {
    private $connect;
    private $table = "cultivos";

    private $id;
    private $nombre;
    private $descripcion;
    private $fecha_siembra;
    private $estado;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los cultivos
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un cultivo por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo cultivo
    public function crearCultivo($nombre, $descripcion, $fecha_siembra, $estado) {
        $query = "INSERT INTO $this->table (nombre, descripcion, fecha_siembra, estado) VALUES (:nombre, :descripcion, :fecha_siembra, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_siembra', $fecha_siembra);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Actualizar un cultivo
    public function actualizarCultivo($id, $nombre, $descripcion, $fecha_siembra, $estado) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion, fecha_siembra = :fecha_siembra, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_siembra', $fecha_siembra);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Eliminar un cultivo
    public function eliminarCultivo($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
