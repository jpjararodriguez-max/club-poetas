<?php
// desactivar la visualización de errores técnicos en pantalla
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$host = "localhost";
$user = "root";
$password = "";
$database = "club_poetas";

// conexión con MySQL
$conn = new mysqli($host, $user, $password, $database);

// verificar conexión sin exponer detalles al usuario 
if ($conn->connect_error) {
    // Registra el error real en un archivo de log interno de PHP para que yo lo vea
    error_log("Falla crítica en MySQL: " . $conn->connect_error);
    
    // Muestra solo un mensaje de advertencia al usuario sin dar info
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        "status" => "error",
        "message" => "Ocurrió un inconveniente temporal. Por favor, intente nuevamente ó intenta mas tarde"
    ]);
    exit();
}
$conn->set_charset("utf8mb4");
?>