<?php
session_start();
require "conexion.php";

$perfil   = $_POST["perfil"] ?? null;
$nombre   = $_POST["nombreCompleto"] ?? null;
$correo   = $_POST["correo"] ?? null;
$password = $_POST["password"] ?? null;
$jugador  = $_POST["jugador"] ?? null;

if (!$perfil || !$nombre || !$correo || !$password || !$jugador) {
    http_response_code(400);
    die("Faltan datos");
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    INSERT INTO usuarios (perfil, nombre_completo, correo, password, jugador_favorito)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssss", $perfil, $nombre, $correo, $passwordHash, $jugador);

if ($stmt->execute()) {

    // ✅ CREAR SESIÓN AUTOMÁTICA AL REGISTRAR
    $_SESSION["nombre"] = $nombre;
    $_SESSION["perfil"] = $perfil;
    $_SESSION["correo"] = $correo;
    $_SESSION["jugador"] = $jugador;

    echo "OK";
} else {
    http_response_code(500);
    echo "Error al insertar";
}


