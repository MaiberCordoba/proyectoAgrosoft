<?php
class Cosecha {
    private $connect;
    private $table = "cosechas";

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

    public function crearCosecha($fk_Cultivo, $fecha, $cantidad, $unidad, $estado) {
        $query = "INSERT INTO $this->table (fk_Cultivo, fecha, cantidad, unidad, estado) 
                  VALUES (:fk_Cultivo, :fecha, :cantidad, :unidad, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_Cultivo', $fk_Cultivo, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':unidad', $unidad);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function actualizarCosecha($id, $fk_Cultivo, $fecha, $cantidad, $unidad, $estado) {
        $query = "UPDATE $this->table SET fk_Cultivo = :fk_Cultivo, fecha = :fecha, cantidad = :cantidad, 
                  unidad = :unidad, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivo', $fk_Cultivo, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':unidad', $unidad);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function eliminarCosecha($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
