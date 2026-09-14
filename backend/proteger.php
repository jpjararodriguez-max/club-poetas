<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Prevenir que el navegador guarde en caché páginas privadas tras cerrar sesión
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0"); // Proxies

if (!isset($_SESSION["usuario_id"]) || empty($_SESSION["usuario_id"])) {
    header("Location: ../frontend/login.html");
    exit();
}
?>