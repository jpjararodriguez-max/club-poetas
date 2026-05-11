<?php
require_once "../backend/conexion.php";

$token = $_GET["token"] ?? null;

if (!$token) {
    echo "Token inválido";
    exit;
}

// Buscar usuario con ese token
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Token inválido o expirado";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva contraseña</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container reset-box">

    <h2>🔑 Nueva contraseña</h2>

    <p>Ingresa tu nueva contraseña para recuperar tu cuenta.</p>

    <form action="update_password.php" method="POST">

        <input type="hidden" name="token" value="<?php echo $token; ?>">

        <input type="password" name="nueva_password" placeholder="Nueva contraseña" required>

        <button type="submit">Cambiar contraseña</button>

    </form>

</div>

</body>
</html>