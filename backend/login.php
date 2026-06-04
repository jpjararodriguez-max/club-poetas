<?php
session_start();
require "conexion.php";

$correo = $_POST["correo"] ?? null;
$password = $_POST["password"] ?? null;

if (!$correo || !$password) {
    echo "Faltan datos";
    exit;
}

$stmt = $conn->prepare("
    SELECT id,
           perfil,
           nombre_completo,
           correo,
           jugador_favorito,
           password,
           primer_ingreso
    FROM usuarios
    WHERE correo = ?
");

$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Correo no registrado";
    exit;
}

$usuario = $resultado->fetch_assoc();

if (!password_verify($password, $usuario["password"])) {
    echo "Contraseña incorrecta";
    exit;
}

//  SESIÓN REAL
$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["perfil"] = $usuario["perfil"];
$_SESSION["nombre"] = $usuario["nombre_completo"];
$_SESSION["correo"] = $usuario["correo"];
$_SESSION["jugador"] = $usuario["jugador_favorito"];


if ($usuario["primer_ingreso"] == 1) {

    echo "CARNET";

} else {

    echo "OK";

 }