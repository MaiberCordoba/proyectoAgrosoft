<?php

require_once __DIR__ . '/../config/dataBase.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

function generarJWT($correo) {
    $tiempoActual = time();
    $payload = [
        'iat' => $tiempoActual, // Tiempo de emisión
        'exp' => $tiempoActual + (60 * 60), // Expira en 1 hora
        'sub' => $correo  // correo del usuario
    ];

    return JWT::encode($payload, JWT_SECRET_KEY, JWT_ALGORITHM);
}


function validarJWT() {
    $headers = getallheaders();
    
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["error" => "No se proporcionó un token"]);
        exit;
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);

    try {
        $decoded = JWT::decode($token, new Key(JWT_SECRET_KEY, JWT_ALGORITHM));
        return (array) $decoded; // Retorna los datos del usuario autenticado
    } catch (ExpiredException $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token expirado"]);
        exit;
    } catch (SignatureInvalidException $e) {
        http_response_code(401);
        echo json_encode(["error" => "Firma inválida"]);
        exit;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido"]);
        exit;
    }
}
?>
