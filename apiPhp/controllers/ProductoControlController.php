<?php
require_once("./config/dataBase.php");
require_once("./models/ProductoControl.php");

class ProductoControlController {
    private $db;
    private $productoControl;

    public function __construct() {
        $database = new Database;
        $this->db = $database->getConection();
        $this->productoControl = new ProductoControl($this->db);
    }

    public function getAll() {
        echo json_encode([
            "status" => 200,
            "data" => $this->productoControl->getAll()
        ]);
        http_response_code(200);
    }

    public function getById($id) {
        $producto = $this->productoControl->getById($id);
        if ($producto) {
            echo json_encode(["status" => 200, "data" => $producto]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Producto no encontrado"]);
            http_response_code(404);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['tipo'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }

        if ($this->productoControl->crearProducto($data['nombre'], $data['descripcion'], $data['tipo'])) {
            echo json_encode(["message" => "Producto registrado exitosamente"]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error al registrar producto"]);
            http_response_code(500);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['nombre'], $data['descripcion'], $data['tipo'])) {
            echo json_encode(["message" => "Datos incompletos"]);
            http_response_code(400);
            return;
        }

        if ($this->productoControl->actualizarProducto($id, $data['nombre'], $data['descripcion'], $data['tipo'])) {
            echo json_encode(["message" => "Producto actualizado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al actualizar producto"]);
            http_response_code(500);
        }
    }

    public function delete($id) {
        if ($this->productoControl->eliminarProducto($id)) {
            echo json_encode(["message" => "Producto eliminado exitosamente"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Error al eliminar producto"]);
            http_response_code(500);
        }
    }
}

