<?php

class Desecho {
    private $connect;
    private $table = "desechos";

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los desechos
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un desecho por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo desecho
    public function crearDesecho($nombre, $descripcion, $tipo_desecho_id) {
        $query = "INSERT INTO $this->table (nombre, descripcion, fk_TiposDesecho) 
                  VALUES (:nombre, :descripcion, :tipo_desecho_id)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':tipo_desecho_id', $tipo_desecho_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Actualizar un desecho
    public function actualizarDesecho($id, $nombre, $descripcion, $tipo_desecho_id) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion, 
                  fk_TiposDesecho = :tipo_desecho_id WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':tipo_desecho_id', $tipo_desecho_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar un desecho
    public function eliminarDesecho($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
