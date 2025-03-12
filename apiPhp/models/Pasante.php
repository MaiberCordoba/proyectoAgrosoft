<?php

class Pasante {
    private $connect;
    private $table = "pasantes";

    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $telefono;
    private $fecha_ingreso;

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

    public function crearPasante($nombre, $apellido, $email, $telefono, $fecha_ingreso) {
        $query = "INSERT INTO $this->table (nombre, apellido, email, telefono, fecha_ingreso) VALUES (:nombre, :apellido, :email, :telefono, :fecha_ingreso)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
        return $stmt->execute();
    }

    public function actualizarPasante($id, $nombre, $apellido, $email, $telefono, $fecha_ingreso) {
        $query = "UPDATE $this->table SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, fecha_ingreso = :fecha_ingreso WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
        return $stmt->execute();
    }

    public function eliminarPasante($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}



