<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'CLAVE_SECRETA123';

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $jwt = $matches[1];
    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        echo json_encode(["mensaje" => "Token válido", "datos" => $decoded->data]);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["mensaje" => "Token inválido"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["mensaje" => "Token no enviado"]);
}
?>
