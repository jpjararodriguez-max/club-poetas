<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require "../backend/conexion.php";

$correo = trim($_POST["correo"] ?? '');
$mensaje = "Si el correo ingresado está registrado en la plataforma, se generara un enlace de recuperación.";
$link = null;

if (!empty($correo) && filter_var($correo, FILTER_VALIDATE_EMAIL)) {

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            $user_id = $usuario["id"];

            // Generar token criptográficamente seguro
            $token = bin2hex(random_bytes(32));

            // Guardar el token en la base de datos
            $stmtUpdate = $conn->prepare("UPDATE usuarios SET reset_token = ? WHERE id = ?");
            if ($stmtUpdate) {
                $stmtUpdate->bind_param("si", $token, $user_id);
                $stmtUpdate->execute();
                $stmtUpdate->close();

                // Simulación de enlace para entorno local/desarrollo
                $link = "reset_password.php?token=" . $token;
            }
        }
        $stmt->close();
    }
} else {
    $mensaje = "Por favor, ingresa un correo electrónico válido.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enlace enviado - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container forgot-box">

    <h2>📩 Recuperación</h2>

    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>

    <?php if ($link): ?>
        <a href="<?= htmlspecialchars($link, ENT_QUOTES, 'UTF-8') ?>" class="btn-link">Ir a cambiar contraseña</a>
    <?php endif; ?>

    <br><br>
    <a href="login.html" class="back-link">← Volver al login</a>

</div>

</body>
</html>