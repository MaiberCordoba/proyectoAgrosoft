<?php

class UsoHerramienta {
    private $connect;
    private $table = "usosherramientas";

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los usos de herramientas
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un uso de herramienta por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo uso de herramienta
    public function create($herramienta_id, $usuario_id, $fecha_uso, $cantidad) {
        $query = "INSERT INTO $this->table (herramienta_id, usuario_id, fecha_uso, cantidad) 
                  VALUES (:herramienta_id, :usuario_id, :fecha_uso, :cantidad)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':herramienta_id', $herramienta_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_uso', $fecha_uso);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Actualizar un uso de herramienta
    public function update($id, $herramienta_id, $usuario_id, $fecha_uso, $cantidad) {
        $query = "UPDATE $this->table SET herramienta_id = :herramienta_id, usuario_id = :usuario_id, 
                  fecha_uso = :fecha_uso, cantidad = :cantidad WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':herramienta_id', $herramienta_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_uso', $fecha_uso);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar un uso de herramienta
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>