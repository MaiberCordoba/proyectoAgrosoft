<?php

class ProductoControl {
    private $connect;
    private $table = "productoscontrol";

    private $id;
    private $nombre;
    private $descripcion;
    private $tipo;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los productos de control
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un producto de control por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo producto de control
    public function crearProducto($nombre, $descripcion, $tipo) {
        $query = "INSERT INTO $this->table (nombre, descripcion, tipo) VALUES (:nombre, :descripcion, :tipo)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':tipo', $tipo);
        return $stmt->execute();
    }

    // Actualizar un producto de control
    public function actualizarProducto($id, $nombre, $descripcion, $tipo) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion, tipo = :tipo WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':tipo', $tipo);
        return $stmt->execute();
    }

    // Eliminar un producto de control
    public function eliminarProducto($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

