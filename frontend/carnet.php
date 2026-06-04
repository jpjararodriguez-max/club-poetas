<?php
require_once "../backend/proteger.php";
require_once "../backend/conexion.php";

if (isset($_SESSION["usuario_id"])) {

    $stmt = $conn->prepare("
        UPDATE usuarios
        SET primer_ingreso = 0
        WHERE id = ?
    ");

    $stmt->bind_param("i", $_SESSION["usuario_id"]);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carnet del Club</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/carnet.css">
</head>

<body class="carnet-body">

    <div class="carnet-container">

        <!-- LOGO MINI PREMIUM -->
        <img src="img/logo.png" class="carnet-logo" alt="logo del club">

        <h2 class="carnet-titulo">CLUB DE LOS POETAS DEL FÚTBOL</h2>

        <div class="carnet-card">

         <h3 id="perfilTipo"><?= $_SESSION["perfil"] ?></h3>

          <p><strong>Nombre:</strong> <span id="nombreUsuario"><?= $_SESSION["nombre"] ?></span></p>
          <p><strong>Correo:</strong> <span id="correoUsuario"><?= $_SESSION["correo"] ?></span></p>
          <p><strong>Jugador Favorito:</strong> <span id="jugadorUsuario"><?= $_SESSION["jugador"] ?? '' ?></span></p>
            

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
