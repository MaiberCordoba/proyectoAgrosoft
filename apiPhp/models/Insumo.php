<?php

class Insumo {
    private $connect;
    private $table = "insumos";

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los insumos
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un insumo por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo insumo
    public function crearInsumo($nombre, $descripcion, $cantidad, $unidad_medida, $fecha_vencimiento) {
        $query = "INSERT INTO $this->table (nombre, descripcion, cantidad, unidad_medida, fecha_vencimiento) 
                  VALUES (:nombre, :descripcion, :cantidad, :unidad_medida, :fecha_vencimiento)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':unidad_medida', $unidad_medida);
        $stmt->bindParam(':fecha_vencimiento', $fecha_vencimiento);
        return $stmt->execute();
    }

    // Actualizar un insumo
    public function actualizarInsumo($id, $nombre, $descripcion, $cantidad, $unidad_medida, $fecha_vencimiento) {
        $query = "UPDATE $this->table SET nombre = :nombre, descripcion = :descripcion, cantidad = :cantidad, 
                  unidad_medida = :unidad_medida, fecha_vencimiento = :fecha_vencimiento WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':unidad_medida', $unidad_medida);
        $stmt->bindParam(':fecha_vencimiento', $fecha_vencimiento);
        return $stmt->execute();
    }

    // Eliminar un insumo
    public function eliminarInsumo($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
    