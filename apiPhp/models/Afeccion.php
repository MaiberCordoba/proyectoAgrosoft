<?php

class Afeccion {
    private $connect;
    private $table = "afecciones";

    private $id;
    private $fk_Cultivos;
    private $nombre;
    private $descripcion;
    private $fecha;
    private $estado;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las afecciones
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una afección por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva afección
    public function crearAfeccion($fk_Cultivos, $nombre, $descripcion, $fecha, $estado) {
        $query = "INSERT INTO $this->table (fk_Cultivos, nombre, descripcion, fecha, estado) VALUES (:fk_Cultivos, :nombre, :descripcion, :fecha, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Actualizar una afección
    public function actualizarAfeccion($id, $fk_Cultivos, $nombre, $descripcion, $fecha, $estado) {
        $query = "UPDATE $this->table SET fk_Cultivos = :fk_Cultivos, nombre = :nombre, descripcion = :descripcion, fecha = :fecha, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Eliminar una afección
    public function eliminarAfeccion($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
