<?php


class Era {
    private $connect;
    private $table = "eras";

    private $id;
    private $nombre;
    private $descripcion;
    private $fk_Lotes;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las eras
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una era por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva era
    public function crearEra($nombre, $descripcion, $fk_Lotes) {
        $query = "INSERT INTO $this->table (nombre, descripcion, fk_Lotes) VALUES (:nombre, :descripcion, :fk_Lotes)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fk_Lotes', $fk_Lotes, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Actualizar una era
    public function actualizarEra($id, $nombre, $descripcion, $fk_Lotes) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion, fk_Lotes = :fk_Lotes WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fk_Lotes', $fk_Lotes, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar una era
    public function eliminarEra($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
