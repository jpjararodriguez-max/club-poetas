<?php
require "../backend/conexion.php";

$token = $_POST["token"] ?? null;
$nueva_password = $_POST["nueva_password"] ?? null;

if (!$token || !$nueva_password) {
    die("Datos incompletos");
}

// Encriptar contraseña
$password_hash = password_hash($nueva_password, PASSWORD_DEFAULT);

// Actualizar contraseña usando el token
$stmt = $conn->prepare("
    UPDATE usuarios 
    SET password = ?, reset_token = NULL 
    WHERE reset_token = ?
");
$stmt->bind_param("ss", $password_hash, $token);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    die("Error al actualizar la contraseña");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contraseña actualizada</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container reset-box">

    <h2>✅ Contraseña actualizada</h2>

    <p>Tu contraseña se cambió correctamente.</p>

    <a href="login.html" class="btn-link">Ir al login</a>

</div>

</body>
</html>