
<?php

class TipoControl {
    private $connect;
    private $table = "tiposcontrol";

    private $id;
    private $nombre;
    private $descripcion;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los tipos de control
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un tipo de control por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo tipo de control
    public function crearTipoControl($nombre, $descripcion) {
        $query = "INSERT INTO $this->table (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    // Actualizar un tipo de control
    public function actualizarTipoControl($id, $nombre, $descripcion) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    // Eliminar un tipo de control
    public function eliminarTipoControl($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

