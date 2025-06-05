<?php
require 'conexion.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start();
$mensaje = "";
$token = "";

// Si ya hay usuario logueado en sesión, tomarlo para mostrar saludo
$usuarioLogueado = $_SESSION['username'] ?? null;

// Lógica para registrar nuevo usuario
if (isset($_POST['registrar'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        $mensaje = "⚠️ El usuario ya existe. Iniciá sesión.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed]);
        $mensaje = "✅ Usuario registrado correctamente. Ahora podés iniciar sesión.";
    }
}

// Lógica para login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            $key = "mi_clave_secreta_super_segura";
            $payload = [
                "iat" => time(),
                "exp" => time() + 3600,
                "user_id" => $user['id'],
                "username" => $user['username']
            ];
            $token = JWT::encode($payload, $key, 'HS256');
            $mensaje = "🎉 Sesión iniciada correctamente.";

            // Guardar usuario en sesión para mostrar saludo
            $_SESSION['username'] = $user['username'];
            $usuarioLogueado = $user['username'];
        } else {
            $mensaje = "❌ Contraseña incorrecta.";
        }
    } else {
        $mensaje = "❌ El usuario no existe.";
    }
}

// Para cerrar sesión (opcional)
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Login JWT</title>
</head>
<body>

<div class="form-box">
    <h2>Inicio Sesion / Registrarse</h2>

    <?php if ($usuarioLogueado): ?>
        <h3>🎉 Bienvenido, <?= htmlspecialchars($usuarioLogueado) ?>!</h3>
        <a href="index.php?logout=1">Cerrar sesión</a>
    <?php else: ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="submit" name="login" value="Iniciar sesión">
            <input type="submit" name="registrar" value="Registrarse">
        </form>
    <?php endif; ?>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($token): ?>
        <h3>🔐 Token generado:</h3>
        <code><?= htmlspecialchars($token) ?></code>
    <?php endif; ?>
</div>

</body>
</html>