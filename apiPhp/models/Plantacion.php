<?php

class Plantacion {
    private $connect;
    private $table = "plantaciones";

    private $id;
    private $fk_Cultivos;
    private $nombre;
    private $fecha_siembra;
    private $estado;

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

    public function crearPlantacion($fk_Cultivos, $nombre, $fecha_siembra, $estado) {
        $query = "INSERT INTO $this->table (fk_Cultivos, nombre, fecha_siembra, estado) VALUES (:fk_Cultivos, :nombre, :fecha_siembra, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':fecha_siembra', $fecha_siembra);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function actualizarPlantacion($id, $fk_Cultivos, $nombre, $fecha_siembra, $estado) {
        $query = "UPDATE $this->table SET fk_Cultivos = :fk_Cultivos, nombre = :nombre, fecha_siembra = :fecha_siembra, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':fecha_siembra', $fecha_siembra);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function eliminarPlantacion($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

