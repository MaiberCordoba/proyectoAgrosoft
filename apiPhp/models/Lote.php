<?php

class Lote {
    private $connect;
    private $table = "lotes";

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los lotes
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un lote por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo lote
    public function crearLote($nombre, $descripcion, $tamX, $tamY, $estado, $posX, $posY) {
        $query = "INSERT INTO $this->table (nombre, descripcion, tamX, tamY, estado, posX, posY) 
                  VALUES (:nombre, :descripcion, :tamX, :tamY, :estado, :posX, :posY)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':tamX', $tamX, PDO::PARAM_INT);
        $stmt->bindParam(':tamY', $tamY, PDO::PARAM_INT);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL);
        $stmt->bindParam(':posX', $posX);
        $stmt->bindParam(':posY', $posY);
        return $stmt->execute();
    }

    // Actualizar un lote
    public function actualizarLote($id, $nombre, $descripcion, $tamX, $tamY, $estado, $posX, $posY) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion, tamX = :tamX, 
                  tamY = :tamY, estado = :estado, posX = :posX, posY = :posY WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':tamX', $tamX, PDO::PARAM_INT);
        $stmt->bindParam(':tamY', $tamY, PDO::PARAM_INT);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL);
        $stmt->bindParam(':posX', $posX);
        $stmt->bindParam(':posY', $posY);
        return $stmt->execute();
    }

    // Eliminar un lote
    public function eliminarLote($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
