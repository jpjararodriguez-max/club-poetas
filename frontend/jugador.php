<?php
require_once "../backend/proteger.php";
$jugadores = require_once "../backend/jugadores.php";

/* 🔎 CAPTURAR BUSQUEDA */
$busqueda = strtolower(trim($_GET['nombre'] ?? ""));

/*  BUSCAR COINCIDENCIA FLEXIBLE */
$jugador = null;
$claveJugador = null;

foreach ($jugadores as $clave => $datos) {
    if (
        strpos($clave, $busqueda) !== false ||
        strpos(strtolower($datos["nombre"]), $busqueda) !== false
    ) {
        $jugador = $datos;
        $claveJugador = $clave; //  GUARDA  LA CLAVE REAL
        break;
    }
}

/*  SI NO ENCUENTRA */
if (!$jugador) {
    echo "<div style='color:#d4af37; text-align:center; margin-top:100px;'>
            <h2> No se encontraron resultados</h2>
            <p>Intenta buscar otro jugador</p>
          </div>";
    exit;
}

/*  CARGAR NUMEROS */
$numeros = require_once "../backend/numeros_jugadores.php";

$stats = $numeros[$claveJugador] ?? null;
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $jugador["nombre"] ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="jugador-body">

<header class="dash-header-pro">
    <h1>⚽ Jugador</h1>
    <a href="dashboard.php" class="btn">⬅ Volver</a>
</header>

<div class="jugador-nav">

    <div class="nav-tabs">
        <span class="active">Todo</span>
        <span>Números</span>
        <span>Impacto</span>
    </div>

    <div class="mini-search">
        <form action="jugador.php" method="GET">
            <input 
                type="text" 
                name="nombre"
                class="mini-search-bar"
                placeholder="Buscar..."
                required
            >
            <button type="submit">🔎</button>
        </form>
    </div>

</div>

<main class="jugador-container">

<div id="todo-section">

    <div class="jugador-header">
        <h2><?= $jugador["nombre"] ?></h2>
        <p class="frase">"<?= $jugador["frase"] ?>"</p>
    </div>

    <div class="jugador-main">

        <div class="jugador-img card-hover">
    <?php if (!empty($jugador['imagen'])): ?>
        <img src="<?= $jugador['imagen'] ?>" alt="<?= $jugador['nombre'] ?>">
    <?php else: ?>
        ⚽
    <?php endif; ?>
</div>

        <div class="jugador-info card-hover">
            <p><strong>Edad:</strong> <?= $jugador["edad"] ?></p>
            <p><strong>Nacionalidad:</strong> <?= $jugador["pais"] ?></p>
            <p><strong>Posición:</strong> <?= $jugador["posicion"] ?></p>

            <p class="descripcion">
                <?= $jugador["descripcion"] ?>
            </p>
        </div>

    </div>

    <div class="stats-grid">

        <div class="stat-card card-hover">
            <span>⚽</span>
            <h3><?= $jugador["goles"] ?></h3>
            <p>Goles</p>
        </div>

        <div class="stat-card card-hover">
            <span>🎯</span>
            <h3><?= $jugador["asistencias"] ?></h3>
            <p>Asistencias</p>
        </div>

        <div class="stat-card card-hover">
            <span>🧠</span>
            <h3><?= $jugador["partidos"] ?></h3>
            <p>Partidos</p>
        </div>

        <div class="stat-card card-hover">
            <span>🏆</span>
            <h3><?= $jugador["titulos"] ?></h3>
            <p>Títulos</p>
        </div>

    </div>

    <div class="jugador-clubes card-hover">
        <h3>Clubes</h3>
        <ul>
            <?php foreach ($jugador["clubes"] as $club): ?>
                <li><?= $club ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="jugador-veredicto card-hover">
        <h3>Impacto Histórico</h3>
        <p>★★★★★</p>
    </div>

</div>
<div id="numeros-section" style="display:none;">

    <h2 style="color:#C6A34A;">📊 Análisis Detallado</h2>

    <?php if($stats): ?>

    <div class="numeros-box">
        <h3>Goles por club</h3>
        <ul>
            <?php foreach ($stats["goles_club"] as $club => $goles): ?>
                <li><?= $club ?> - <?= $goles ?> goles</li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="numeros-box">
        <h3>Tipos de gol</h3>
        <ul>
            <?php foreach ($stats["goles_tipo"] as $tipo => $valor): ?>
                <li><?= $tipo ?> - <?= $valor ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="numeros-box">
        <h3>Momentos clave</h3>
        <ul>
            <?php foreach ($stats["momentos"] as $momento => $valor): ?>
                <li><?= $momento ?> - <?= $valor ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php else: ?>
        <p>No hay datos detallados disponibles</p>
    <?php endif; ?>

</div>

</main>

<script>
const tabs = document.querySelectorAll(".nav-tabs span");

tabs.forEach(tab => {
    tab.addEventListener("click", () => {

        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");

        document.getElementById("todo-section").style.display = "none";
        document.getElementById("numeros-section").style.display = "none";

        if(tab.textContent === "Todo"){
            document.getElementById("todo-section").style.display = "block";
        }

        if(tab.textContent === "Números"){
            document.getElementById("numeros-section").style.display = "block";
        }

    });
});
</script>
</body>
</html>
