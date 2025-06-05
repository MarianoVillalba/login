<?php
require 'conexion.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Datos del nuevo usuario
$username = 'admin';
$password = '123456';

// Verificar si el usuario ya existe
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
$stmt->execute([$username]);

if ($stmt->rowCount() > 0) {
    echo "⚠️ El usuario '$username' ya existe.";
    exit;
}

// Hashear la contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario
$insert = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
$insert->execute([$username, $hashedPassword]);

// Obtener ID del nuevo usuario
$user_id = $conn->lastInsertId();

// Generar token JWT
$key = "mi_clave_secreta_super_segura"; // ¡Usá una mejor para producción!
$payload = [
    "iss" => "localhost",
    "iat" => time(),
    "exp" => time() + (60 * 60), // 1 hora
    "user_id" => $user_id,
    "username" => $username
];

$jwt = JWT::encode($payload, $key, 'HS256');

// Mostrar el token
echo "<h3>✅ Usuario creado correctamente</h3>";
echo "<p><strong>Token JWT:</strong></p>";
echo "<code>$jwt</code>";
?>
