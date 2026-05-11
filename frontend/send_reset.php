<?php
require "../backend/conexion.php";

$correo = $_POST["correo"] ?? null;

if (!$correo) {
    die("Correo no válido");
}

// Buscar usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $mensaje = "❌ Correo no registrado";
} else {

    $usuario = $result->fetch_assoc();
    $user_id = $usuario["id"];

    // Generar token
    $token = bin2hex(random_bytes(50));

    // Guardarlo
    $stmt = $conn->prepare("UPDATE usuarios SET reset_token = ? WHERE id = ?");
    $stmt->bind_param("si", $token, $user_id);
    $stmt->execute();

    // Simulación link
    $mensaje = "✅ Enlace generado correctamente";
    $link = "reset_password.php?token=" . $token;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enlace enviado</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container forgot-box">

    <h2>📩 Recuperación</h2>

    <p><?php echo $mensaje; ?></p>

    <?php if (isset($link)) { ?>
        <a href="<?php echo $link; ?>" class="btn-link">Ir a cambiar contraseña</a>
    <?php } ?>

    <a href="login.html" class="back-link">← Volver al login</a>

</div>

</body>
</html>