<?php

class Control {
    private $connect;
    private $table = "controles";

    private $id;
    private $fk_Cultivos;
    private $fk_Usuarios;
    private $tipo;
    private $descripcion;
    private $fecha;
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

    public function crearControl($fk_Cultivos, $fk_Usuarios, $tipo, $descripcion, $fecha, $estado) {
        $query = "INSERT INTO $this->table (fk_Cultivos, fk_Usuarios, tipo, descripcion, fecha, estado) VALUES (:fk_Cultivos, :fk_Usuarios, :tipo, :descripcion, :fecha, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Usuarios', $fk_Usuarios, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function actualizarControl($id, $fk_Cultivos, $fk_Usuarios, $tipo, $descripcion, $fecha, $estado) {
        $query = "UPDATE $this->table SET fk_Cultivos = :fk_Cultivos, fk_Usuarios = :fk_Usuarios, tipo = :tipo, descripcion = :descripcion, fecha = :fecha, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Usuarios', $fk_Usuarios, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function eliminarControl($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

