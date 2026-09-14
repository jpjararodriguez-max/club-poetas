<?php
// Configuración de errores para producción (Punto 8)
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once "../backend/conexion.php";

$token = trim($_GET["token"] ?? '');
$tokenValido = false;

if (!empty($token)) {
    // Buscar usuario con el token correspondiente (Inmune a SQL Injection)
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE reset_token = ? AND reset_token IS NOT NULL LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tokenValido = true;
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
    <title>Nueva Contraseña - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container reset-box">

    <h2>🔑 Nueva contraseña</h2>

    <?php if ($tokenValido): ?>
        <p>Ingresa tu nueva contraseña para recuperar tu cuenta.</p>

        <form action="update_password.php" method="POST" autocomplete="off">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">

            <input 
                type="password" 
                name="nueva_password" 
                placeholder="Nueva contraseña" 
                required 
                minlength="6"
            >

            <button type="submit">Cambiar contraseña</button>
        </form>
    <?php else: ?>
        <p style="color: #ff6b6b; font-weight: bold;">❌ El enlace de recuperación es inválido o ya ha caducado.</p>
        <a href="login.html" class="back-link">← Volver al inicio de sesión</a>
    <?php endif; ?>

</div>

</body>
</html>