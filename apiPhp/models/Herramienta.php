<?php
class Herramienta {
    private $connect;
    private $table = "herramientas";

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

    public function crearHerramienta($nombre, $descripcion, $cantidad, $estado) {
        $query = "INSERT INTO $this->table (nombre, descripcion, cantidad, estado) VALUES (:nombre, :descripcion, :cantidad, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function actualizarHerramienta($id, $nombre, $descripcion, $cantidad, $estado) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion, cantidad = :cantidad, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    public function eliminarHerramienta($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
