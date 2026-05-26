<?php
require_once "../backend/proteger.php";
require_once "../backend/conexion.php";

$correo = $_SESSION["correo"];

$sql = "SELECT jugador_favorito FROM usuarios WHERE correo = '$correo'";
$resultado = $conn->query($sql);
$usuario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
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
                <input type="text" value="<?= $_SESSION['nombre'] ?>" disabled>
            </div>

            <div class="perfil-item">
                <label>Correo</label>
                <input type="email" value="<?= $_SESSION['correo'] ?>" disabled>
            </div>

            <div class="perfil-item">
                <label>Jugador Favorito</label>
                <input type="text" value="<?= isset($usuario['jugador_favorito']) ? $usuario['jugador_favorito'] : 'No definido' ?>" disabled>
            </div>

            <div class="perfil-item">
                <label>Perfil</label>
                <input type="text" value="<?= $_SESSION['perfil'] ?>" disabled>
            </div>

        </div>

    </div>

</main>

<script>
function activarEdicion() {
    document.querySelectorAll(".perfil-item input").forEach(input => {
        input.disabled = false;
    });

    document.getElementById("guardarBtn").style.display = "inline-block";
}

function guardarCambios() {
    alert("Luego conectamos esto con base de datos 🔥");
}
</script>
</body>
</html>