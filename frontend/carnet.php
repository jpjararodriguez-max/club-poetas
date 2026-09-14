<?php
require_once "../backend/proteger.php";
require_once "../backend/conexion.php";

if (isset($_SESSION["usuario_id"]) && !empty($_SESSION["usuario_id"])) {

    $stmt = $conn->prepare("
        UPDATE usuarios
        SET primer_ingreso = 0
        WHERE id = ?
    ");

    if ($stmt) {
        $stmt->bind_param("i", $_SESSION["usuario_id"]);
        $stmt->execute();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet del Club - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/carnet.css">
</head>

<body class="carnet-body">

    <div class="carnet-container">

        <!-- LOGO MINI PREMIUM -->
        <img src="img/logo.png" class="carnet-logo" alt="logo del club">

        <h2 class="carnet-titulo">CLUB DE LOS POETAS DEL FÚTBOL</h2>

        <div class="carnet-card">

            <h3 id="perfilTipo"><?= htmlspecialchars($_SESSION["perfil"] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>

            <p><strong>Nombre:</strong> <span id="nombreUsuario"><?= htmlspecialchars($_SESSION["nombre"] ?? '', ENT_QUOTES, 'UTF-8') ?></span></p>
            <p><strong>Correo:</strong> <span id="correoUsuario"><?= htmlspecialchars($_SESSION["correo"] ?? '', ENT_QUOTES, 'UTF-8') ?></span></p>
            <p><strong>Jugador Favorito:</strong> <span id="jugadorUsuario"><?= htmlspecialchars($_SESSION["jugador"] ?? '', ENT_QUOTES, 'UTF-8') ?></span></p>
            
            <!-- ICONO VERIFICADO -->
            <div class="verificado">
                <img src="img/verificado.png" alt="Verificado">
            </div>

        </div>

        <a href="dashboard.php" class="btn-volver">Entrar al Club</a>

    </div>

    <script src="js/carnet.js"></script>

</body>
</html>