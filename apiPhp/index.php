<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Encabezados
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
header("Content-Type: application/json; charset=UTF-8");

// Importar JWT para autenticación
require_once __DIR__ . "/token/jwt.php";

// Obtiene la URL de la solicitud
$request = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
$method = $_SERVER["REQUEST_METHOD"];
$table = ucfirst(strtolower($request[0])) . "Controller"; // Usar el primer elemento de la URL

// Endpoint específico para el login 
if ($request[0] == "login" && $method == "POST") {
    require_once("./controllers/LoginController.php");
    $login = new LoginController();
    $login->handleLogin();
    exit; // Evitar que el código continúe después de procesar el login
}

// Aplicar autenticación para todas las demás solicitudes
$authData = validarJWT(); // Si el token no es válido, la función responderá y terminará la ejecución

// ruta controlladores
$controllerFile = __DIR__ . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . $table . ".php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $tableController = new $table();

    switch ($method) {
        case 'GET':
            if (isset($request[1]) && !empty($request[1])) {
                $tableController->getById($request[1]);
            } else {
                $tableController->getAll();
            }
            break;

        case 'POST':
            $tableController->create();
            break;

        case 'PUT':
            $tableController->update($request[1]);
            break;

        case 'DELETE':
            $tableController->delete($request[1]);
            break;

        case 'PATCH':
            $tableController->patch($request[1]);
            break;

        default:
            echo json_encode(["message" => "Método no permitido"]);
            http_response_code(405);
            break;
    }
} else {
    echo json_encode(["message" => "Recurso no encontrado"]);
    http_response_code(404);
}
?>
