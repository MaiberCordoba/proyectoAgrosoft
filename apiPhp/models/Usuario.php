<?php

class Usuario {
    private $connect;
    private $table = "usuarios";

    private $identificacion;
    private $nombre;
    private $email;
    private $telefono;

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todos los usuarios
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un usuario por identificación
    public function getById($identificacion) {
        $query = "SELECT * FROM $this->table WHERE identificacion = :identificacion";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo usuario
    public function crearUsuario($identificacion, $nombre, $email, $telefono) {
        $query = "INSERT INTO $this->table (identificacion, nombre, email, telefono) VALUES (:identificacion, :nombre, :email, :telefono)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute();
    }

    // Actualizar un usuario
    public function actualizarUsuario($identificacion, $nombre, $email, $telefono) {
        $query = "UPDATE $this->table SET nombre = :nombre, email = :email, telefono = :telefono WHERE identificacion = :identificacion";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute();
    }

    // Eliminar un usuario
    public function eliminarUsuario($identificacion) {
        $query = "DELETE FROM $this->table WHERE identificacion = :identificacion";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':identificacion', $identificacion);
        return $stmt->execute();
    }
}