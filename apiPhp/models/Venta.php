
<?php
class Venta {
    private $connect;
    private $table = "ventas";

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

    public function crearVenta($fk_Usuario, $fecha, $total, $estado) {
        $query = "INSERT INTO $this->table (fk_Usuario, fecha, total, estado) VALUES (:fk_Usuario, :fecha, :total, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_Usuario', $fk_Usuario, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':total', $total, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function actualizarVenta($id, $fk_Usuario, $fecha, $total, $estado) {
        $query = "UPDATE $this->table SET fk_Usuario = :fk_Usuario, fecha = :fecha, total = :total, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Usuario', $fk_Usuario, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':total', $total, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function eliminarVenta($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
