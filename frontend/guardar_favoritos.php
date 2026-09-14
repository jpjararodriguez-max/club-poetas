<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Incluir la protección de ruta unificada y la conexión
require_once "../backend/proteger.php";
require_once "../backend/conexion.php";

$usuario_id = $_SESSION["usuario_id"] ?? null;

if (!$usuario_id) {
    header("Location: login.html");
    exit();
}

$favoritos_json = $_POST["favoritos"] ?? null;

if (!$favoritos_json) {
    header("Location: favoritos.php");
    exit();
}

$favoritos = json_decode($favoritos_json, true);

if (!is_array($favoritos) || empty($favoritos)) {
    header("Location: favoritos.php");
    exit();
}

$favoritos = array_slice($favoritos, 0, 10);

// Borrar favoritos anteriores del usuario 
$stmtDelete = $conn->prepare("DELETE FROM favoritos WHERE usuario_id = ?");
if ($stmtDelete) {
    $stmtDelete->bind_param("i", $usuario_id);
    $stmtDelete->execute();
    $stmtDelete->close();
} else {
    error_log("Error en prepare DELETE favoritos: " . $conn->error);
}

$stmtInsert = $conn->prepare("INSERT INTO favoritos (usuario_id, jugador) VALUES (?, ?)");

if ($stmtInsert) {
    foreach ($favoritos as $jugador) {
        $jugadorLimpio = trim($jugador);
        if (!empty($jugadorLimpio)) {
            $stmtInsert->bind_param("is", $usuario_id, $jugadorLimpio);
            $stmtInsert->execute();
        }
    }
    $stmtInsert->close();
} else {
    error_log("Error en prepare INSERT favoritos: " . $conn->error);
}

// Redirigir de vuelta a favoritos notificando que se guardó
header("Location: favoritos.php?guardado=1");
exit();
?>