<?php

class UsoProductoControl {
    private $connect;
    private $table = "usoproductocontrol";

    private $id;
    private $fk_ProductoControl;
    private $fk_Cultivo;
    private $fecha;
    private $cantidad;

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

    public function crearUsoProductoControl($fk_ProductoControl, $fk_Cultivo, $fecha, $cantidad) {
        $query = "INSERT INTO $this->table (fk_ProductoControl, fk_Cultivo, fecha, cantidad) VALUES (:fk_ProductoControl, :fk_Cultivo, :fecha, :cantidad)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_ProductoControl', $fk_ProductoControl, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivo', $fk_Cultivo, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }

    public function actualizarUsoProductoControl($id, $fk_ProductoControl, $fk_Cultivo, $fecha, $cantidad) {
        $query = "UPDATE $this->table SET fk_ProductoControl = :fk_ProductoControl, fk_Cultivo = :fk_Cultivo, fecha = :fecha, cantidad = :cantidad WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_ProductoControl', $fk_ProductoControl, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivo', $fk_Cultivo, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute();
    }

    public function eliminarUsoProductoControl($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

