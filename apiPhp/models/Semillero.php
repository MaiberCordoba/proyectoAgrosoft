<?php

// MODELO: Semillero.php
class Semillero {
    private $connect;
    private $table = "semilleros";

    private $id;
    private $fk_Cultivos;
    private $nombre;
    private $ubicacion;
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

    public function crearSemillero($fk_Cultivos, $nombre, $ubicacion, $fecha_siembra, $estado) {
        $query = "INSERT INTO $this->table (fk_Cultivos, nombre, ubicacion, fecha_siembra, estado) VALUES (:fk_Cultivos, :nombre, :ubicacion, :fecha_siembra, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':fecha_siembra', $fecha_siembra);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function actualizarSemillero($id, $fk_Cultivos, $nombre, $ubicacion, $fecha_siembra, $estado) {
        $query = "UPDATE $this->table SET fk_Cultivos = :fk_Cultivos, nombre = :nombre, ubicacion = :ubicacion, fecha_siembra = :fecha_siembra, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':fecha_siembra', $fecha_siembra);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function eliminarSemillero($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
