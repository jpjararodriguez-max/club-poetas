<?php

$jugadores = require_once "jugadores.php";

$busqueda = strtolower($_GET['q'] ?? "");

$resultados = [];

foreach ($jugadores as $clave => $datos) {
    if (strpos($clave, $busqueda) !== false) {
        $resultados[] = $datos["nombre"];
    }
}

echo json_encode($resultados);
