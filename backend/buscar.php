<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$jugadores = require_once "jugadores.php";
$busquedaRaw = trim($_GET['q'] ?? "");
$busqueda = mb_strtolower($busquedaRaw, 'UTF-8');

$resultados = [];

if ($busqueda !== "") {
    foreach ($jugadores as $clave => $datos) {
        $claveLimpia = mb_strtolower($clave, 'UTF-8');
     
        if (strpos($claveLimpia, $busqueda) !== false) {
            $resultados[] = $datos["nombre"];
        }
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($resultados);
exit();
?>