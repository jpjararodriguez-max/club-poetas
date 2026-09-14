<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once "../backend/conexion.php";

$token = trim($_POST["token"] ?? '');
$nueva_password = trim($_POST["nueva_password"] ?? '');
$exito = false;
$mensajeError = "No se pudo actualizar la contraseña. Es posible que el enlace haya expirado o ya fue utilizado.";

if (!empty($token) && !empty($nueva_password)) {

    // 1. Encriptación segura con algoritmo oficial de PHP
    $password_hash = password_hash($nueva_password, PASSWORD_DEFAULT);

    // 2. Consulta preparada para actualizar contraseña y anular el token 
    $stmt = $conn->prepare("
        UPDATE usuarios 
        SET password = ?, reset_token = NULL 
        WHERE reset_token = ? AND reset_token IS NOT NULL
    ");

    if ($stmt) {
        $stmt->bind_param("ss", $password_hash, $token);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $exito = true;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña Actualizada - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container reset-box">

    <?php if ($exito): ?>
        <h2>✅ Contraseña actualizada</h2>
        <p>Tu contraseña se cambió correctamente. Ya puedes iniciar sesión con tus nuevas credenciales.</p>
        <a href="login.html" class="btn-link">Ir al Inicio de Sesión</a>
    <?php else: ?>
        <h2>❌ Ocurrió un error</h2>
        <p><?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?></p>
        <a href="forgot_password.php" class="btn-link">Solicitar nuevo enlace</a>
    <?php endif; ?>

</div>

</body>
</html>