<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_start();
require "conexion.php";

$correo = trim($_POST["correo"] ?? '');
$password = $_POST["password"] ?? '';

// Validar que los campos no estén vacíos
if (empty($correo) || empty($password)) {
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
    LIMIT 1
");

if (!$stmt) {
    error_log("Error en prepare() de login: " . $conn->error);
    echo "Error interno del servidor";
    exit;
}

$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Correo no registrado";
    $stmt->close();
    exit;
}

$usuario = $resultado->fetch_assoc();
$stmt->close();

// Verificar la contraseña cifrada
if (!password_verify($password, $usuario["password"])) {
    echo "Contraseña incorrecta";
    exit;
}

session_regenerate_id(true);

// ASIGNACIÓN DE SESIÓN REAL
$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["perfil"] = $usuario["perfil"];
$_SESSION["nombre"] = $usuario["nombre_completo"];
$_SESSION["correo"] = $usuario["correo"];
$_SESSION["jugador"] = $usuario["jugador_favorito"];

// Respuesta según primer ingreso
if ((int)$usuario["primer_ingreso"] === 1) {
    echo "CARNET";
} else {
    echo "OK";
}
?>