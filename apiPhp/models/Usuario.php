<?php

class Usuario {
    private $connect;
    private $table = "usuarios";

    private $identificacion;
    private $nombre;
    private $apellidos;
    private $fechaNacimiento;
    private $telefono;
    private $correoElectronico;
    private $passwordHash;
    private $admin;

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
        $stmt->bindParam(':identificacion', $identificacion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo usuario
    public function crearUsuario($identificacion, $nombre, $apellidos, $fechaNacimiento, $telefono, $correoElectronico, $passwordHash, $admin) {
        $query = "INSERT INTO $this->table (identificacion, nombre, apellidos, fechaNacimiento, telefono, correoElectronico, passwordHash, admin) 
                  VALUES (:identificacion, :nombre, :apellidos, :fechaNacimiento, :telefono, :correoElectronico, :passwordHash, :admin)";
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(':identificacion', $identificacion, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':fechaNacimiento', $fechaNacimiento, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':correoElectronico', $correoElectronico, PDO::PARAM_STR);
        $stmt->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':admin', $admin, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Actualizar un usuario
    public function actualizarUsuario($identificacion, $nombre, $apellidos, $fechaNacimiento, $telefono, $correoElectronico, $passwordHash, $admin) {
        $query = "UPDATE $this->table 
                  SET nombre = :nombre, apellidos = :apellidos, fechaNacimiento = :fechaNacimiento, telefono = :telefono, 
                      correoElectronico = :correoElectronico, passwordHash = :passwordHash, admin = :admin 
                  WHERE identificacion = :identificacion";

        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(':identificacion', $identificacion, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':fechaNacimiento', $fechaNacimiento, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':correoElectronico', $correoElectronico, PDO::PARAM_STR);
        $stmt->bindParam(':passwordHash', $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':admin', $admin, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar un usuario
    public function eliminarUsuario($identificacion) {
        $query = "DELETE FROM $this->table WHERE identificacion = :identificacion";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':identificacion', $identificacion, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
