<?php
session_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require "../backend/conexion.php";

$usuario_id = $_SESSION["usuario_id"] ?? null;

if (!$usuario_id) {
    echo "No autorizado";
    exit;
}

//  Recibir JSON
$favoritos_json = $_POST["favoritos"] ?? null;

if (!$favoritos_json) {
    echo "No seleccionaste jugadores";
    exit;
}

$favoritos = json_decode($favoritos_json, true);

//  Borrar favoritos anteriores
$stmt = $conn->prepare("DELETE FROM favoritos WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

//  Insertar nuevos favoritos
$stmt = $conn->prepare("INSERT INTO favoritos (usuario_id, jugador) VALUES (?, ?)");

foreach ($favoritos as $jugador) {
    $stmt->bind_param("is", $usuario_id, $jugador);
    $stmt->execute();
}

header("Location: favoritos.php?guardado=1");
exit;