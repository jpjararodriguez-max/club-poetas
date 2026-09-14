<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_start();
require "conexion.php";

// Limpieza básica de espacios
$perfil   = trim($_POST["perfil"] ?? '');
$nombre   = trim($_POST["nombreCompleto"] ?? '');
$correo   = trim($_POST["correo"] ?? '');
$password = $_POST["password"] ?? '';
$jugador  = trim($_POST["jugador"] ?? '');

//  Validar que no falten datos obligatorios
if (empty($perfil) || empty($nombre) || empty($correo) || empty($password) || empty($jugador)) {
    http_response_code(400);
    echo "Faltan datos";
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Correo no válido";
    exit;
}

// Verificacion del correo si  ya existia  en la BD
$checkStmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
if ($checkStmt) {
    $checkStmt->bind_param("s", $correo);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        http_response_code(400);
        echo "El correo ya está registrado";
        exit;
    }
    $checkStmt->close();
}

// Cifrado seguro de contraseña
$passwordHash = password_hash($password, PASSWORD_DEFAULT);


$stmt = $conn->prepare("
    INSERT INTO usuarios (perfil, nombre_completo, correo, password, jugador_favorito, primer_ingreso)
    VALUES (?, ?, ?, ?, ?, 1)
");

if (!$stmt) {
    error_log("Error en prepare() de registro: " . $conn->error);
    http_response_code(500);
    echo "Error interno del servidor";
    exit;
}

$stmt->bind_param("sssss", $perfil, $nombre, $correo, $passwordHash, $jugador);

if ($stmt->execute()) {
    
    session_regenerate_id(true);

    // CREAR SESIÓN AUTOMÁTICA AL REGISTRAR
    $_SESSION["usuario_id"] = $stmt->insert_id;
    $_SESSION["nombre"]     = $nombre;
    $_SESSION["perfil"]     = $perfil;
    $_SESSION["correo"]     = $correo;
    $_SESSION["jugador"]    = $jugador;

    $stmt->close();
    echo "OK";
} else {
    error_log("Error en execute() de registro: " . $stmt->error);
    $stmt->close();
    http_response_code(500);
    echo "Error al registrar usuario";
}
?>