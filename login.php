<?php
require 'vendor/autoload.php';
require 'conexion.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'CLAVE_SECRETA123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"));
    $username = $input->username ?? '';
    $password = $input->password ?? '';

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $payload = [
            "iss" => "localhost",
            "aud" => "localhost",
            "iat" => time(),
            "exp" => time() + (60 * 60), // 1 hora
            "data" => [
                "id" => $user['id'],
                "username" => $user['username']
            ]
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        echo json_encode(["token" => $jwt]);
    } else {
        http_response_code(401);
        echo json_encode(["mensaje" => "Credenciales incorrectas"]);
    }
}
?>
