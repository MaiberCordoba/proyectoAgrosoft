<?php

require_once __DIR__ . '/../token/jwt.php';
require_once __DIR__ . '/../config/dataBase.php';
require_once __DIR__ . '/../models/Usuario.php';

class LoginController {
    public function handleLogin() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['correo']) || !isset($data['password'])) {
            echo json_encode(['error' => 'asegurese de estar enviando (correo y password)']);
            return;
        }

        $correoIngresado = $data['correo'];
        $passwordIngresado = $data['password'];

        $db = new Database();
        $usuarioModel = new Usuario($db->getConection());
        $usuarioData = $usuarioModel->getByCorreo($correoIngresado);

        if ($usuarioData && password_verify($passwordIngresado, $usuarioData['passwordHash'])) {
            $token = generarJWT($usuarioData['correoElectronico']);
            echo json_encode(['token' => $token]);
        } else {
            echo json_encode(['error' => 'Credenciales incorrectas']);
        }
    }
}
?>
