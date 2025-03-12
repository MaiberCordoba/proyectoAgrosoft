<?php

class HorasMensuales {
    private $connect;
    private $table = "horasmensuales";

    public function __construct($db) {
        $this->connect = $db;
    }

    // Obtener todas las horas mensuales
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener horas mensuales por ID
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo registro de horas mensuales
    public function create($fk_Pasantes, $minutos, $salario, $mes) {
        $query = "INSERT INTO $this->table (fk_Pasantes, minutos, salario, mes) 
                  VALUES (:fk_Pasantes, :minutos, :salario, :mes)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':fk_Pasantes', $fk_Pasantes, PDO::PARAM_INT);
        $stmt->bindParam(':minutos', $minutos, PDO::PARAM_INT);
        $stmt->bindParam(':salario', $salario, PDO::PARAM_INT);
        $stmt->bindParam(':mes', $mes);
        return $stmt->execute();
    }

    // Actualizar un registro de horas mensuales
    public function update($id, $fk_Pasantes, $minutos, $salario, $mes) {
        $query = "UPDATE $this->table SET fk_Pasantes = :fk_Pasantes, minutos = :minutos, 
                  salario = :salario, mes = :mes WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_Pasantes', $fk_Pasantes, PDO::PARAM_INT);
        $stmt->bindParam(':minutos', $minutos, PDO::PARAM_INT);
        $stmt->bindParam(':salario', $salario, PDO::PARAM_INT);
        $stmt->bindParam(':mes', $mes);
        return $stmt->execute();
    }

    // Eliminar un registro de horas mensuales
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}