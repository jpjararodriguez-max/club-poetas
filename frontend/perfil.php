<?php
require_once "../backend/proteger.php";
require_once "../backend/conexion.php";

$correo = $_SESSION["correo"] ?? '';

if (!empty($correo)) {
    $stmt = $conn->prepare("SELECT jugador_favorito FROM usuarios WHERE correo = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($usuario = $resultado->fetch_assoc()) {
            $jugadorFavorito = $usuario['jugador_favorito'] ?? 'No definido';
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
    <title>Mi Perfil - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="dashboard-body">
<?php include "sidebar_ads.php"; ?>

<header class="dash-header-pro">
    <h1>👤 Mi Perfil</h1>
    <a href="dashboard.php" class="btn">⬅ Volver</a>
</header>

<main class="perfil-container">

    <div class="perfil-card">

        <!-- FOTO / ICONO -->
        <div class="perfil-avatar">
            ⚽
        </div>

        <!-- DATOS -->
        <div class="perfil-info">

            <div class="perfil-item">
                <label>Nombre</label>
                <input type="text" value="<?= htmlspecialchars($_SESSION['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" disabled>
            </div>

            <div class="perfil-item">
                <label>Correo</label>
                <input type="email" value="<?= htmlspecialchars($_SESSION['correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>" disabled>
            </div>

            <div class="perfil-item">
                <label>Jugador Favorito</label>
                <input type="text" value="<?= htmlspecialchars($jugadorFavorito, ENT_QUOTES, 'UTF-8') ?>" disabled>
            </div>

            <div class="perfil-item">
                <label>Perfil</label>
                <input type="text" value="<?= htmlspecialchars($_SESSION['perfil'] ?? '', ENT_QUOTES, 'UTF-8') ?>" disabled>
            </div>

        </div>

    </div>

</main>
</body>
<?php include "footer.php"; ?>
</html>