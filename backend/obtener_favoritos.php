<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "conexion.php";

header('Content-Type: application/json; charset=utf-8');

$usuario_id = $_SESSION["usuario_id"] ?? null;

if (!$usuario_id) {
    echo json_encode([]);
    exit();
}

$stmt = $conn->prepare("SELECT jugador FROM favoritos WHERE usuario_id = ?");

if (!$stmt) {
    error_log("Error en prepare() de obtener_favoritos: " . $conn->error);
    echo json_encode([]);
    exit();
}

$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$result = $stmt->get_result();

$favoritos = [];

while ($row = $result->fetch_assoc()) {
    $favoritos[] = $row["jugador"];
}

$stmt->close();

echo json_encode($favoritos);
exit();
?>