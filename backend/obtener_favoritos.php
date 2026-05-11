<?php
session_start();
require "conexion.php";

$usuario_id = $_SESSION["usuario_id"] ?? null;

if (!$usuario_id) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT jugador FROM favoritos WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$result = $stmt->get_result();

$favoritos = [];

while ($row = $result->fetch_assoc()) {
    $favoritos[] = $row["jugador"];
}

echo json_encode($favoritos);