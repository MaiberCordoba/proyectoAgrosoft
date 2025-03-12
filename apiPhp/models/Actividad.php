<?php

class Actividad {
    private $connect;
    private $table = "actividades";

    private $id;
    private $fk_Cultivos;
    private $fk_Usuarios;
    private $titulo;
    private $descripcion;
    private $fecha;
    private $estado;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las actividades
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        
        // Devolver directamente los datos como array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una actividad por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva actividad
    public function crearActividad($fk_Cultivos, $fk_Usuarios, $titulo, $descripcion, $fecha, $estado) {
        $query = "INSERT INTO $this->table (fk_Cultivos, fk_Usuarios, titulo, descripcion, fecha, estado) VALUES (:fk_Cultivos, :fk_Usuarios, :titulo, :descripcion, :fecha, :estado)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Usuarios', $fk_Usuarios, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Actualizar una actividad
    public function actualizarActividad($id, $fk_Cultivos, $fk_Usuarios, $titulo, $descripcion, $fecha, $estado) {
        $query = "UPDATE $this->table SET fk_Cultivos = :fk_Cultivos, fk_Usuarios = :fk_Usuarios, titulo = :titulo, descripcion = :descripcion, fecha = :fecha, estado = :estado WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Cultivos', $fk_Cultivos, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Usuarios', $fk_Usuarios, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Eliminar una actividad
    public function eliminarActividad($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
