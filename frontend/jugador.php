<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once "../backend/proteger.php";
$jugadores = require_once "../backend/jugadores.php";

/* 🔎 CAPTURAR BÚSQUEDA */
$busqueda = strtolower(trim($_GET['nombre'] ?? ""));

/* BUSCAR COINCIDENCIA FLEXIBLE */
$jugador = null;
$claveJugador = null;

if (!empty($busqueda)) {
    foreach ($jugadores as $clave => $datos) {
        if (
            strpos(strtolower($clave), $busqueda) !== false ||
            strpos(strtolower($datos["nombre"] ?? ''), $busqueda) !== false
        ) {
            $jugador = $datos;
            $claveJugador = $clave; // GUARDA LA CLAVE REAL
            break;
        }
    }
}

/* CARGAR NÚMEROS Y ESTADÍSTICAS */
$numeros = require_once "../backend/numeros_jugadores.php";
$stats = ($claveJugador && isset($numeros[$claveJugador])) ? $numeros[$claveJugador] : null;

/*  VISTA LIMPIA PARA SIN RESULTADOS (FONDO BLANCO, DORADO Y FLECHA) */
if (!$jugador): 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugador No Encontrado - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #ffffff !important;
            color: #d4af37 !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .no-results-box {
            padding: 20px;
            max-width: 450px;
        }
        .no-results-box h2 {
            color: #d4af37;
            font-size: 26px;
            margin-bottom: 15px;
        }
        .no-results-box p {
            color: #b89628;
            font-size: 16px;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<!-- FLECHA PARA VOLVER A DASHBOARD -->
<a href="dashboard.php" class="back-arrow">&lt;</a>

<div class="no-results-box">
    <h2>No se han encontrado resultados</h2>
    <p>El jugador que buscas no se encuentra en nuestro club de poetas.</p>
</div>

</body>
</html>
<?php 
exit(); 
endif; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($jugador["nombre"] ?? "Jugador no encontrado", ENT_QUOTES, 'UTF-8') ?> - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="jugador-body">
<?php include "sidebar_ads.php"; ?>

<header class="dash-header-pro">
    <h1>⚽ Perfil del Jugador</h1>
    <a href="dashboard.php" class="btn">⬅ Volver</a>
</header>

<div class="jugador-nav">

    <div class="nav-tabs">
        <span class="active">Todo</span>
        <span>Números</span>
        <span>Impacto</span>
    </div>

    <div class="mini-search">
        <form action="jugador.php" method="GET" autocomplete="off">
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
        <h2><?= htmlspecialchars($jugador["nombre"] ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="frase">"<?= htmlspecialchars($jugador["frase"] ?? '', ENT_QUOTES, 'UTF-8') ?>"</p>
    </div>

    <div class="jugador-main">

        <div class="jugador-img card-hover">
            <?php if (!empty($jugador['imagen'])): ?>
                <img src="<?= htmlspecialchars($jugador['imagen'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($jugador['nombre'], ENT_QUOTES, 'UTF-8') ?>">
            <?php else: ?>
                ⚽
            <?php endif; ?>
        </div>

        <div class="jugador-info card-hover">
            <p><strong>Edad:</strong> <?= htmlspecialchars((string)($jugador["edad"] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Nacionalidad:</strong> <?= htmlspecialchars($jugador["pais"] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Posición:</strong> <?= htmlspecialchars($jugador["posicion"] ?? '', ENT_QUOTES, 'UTF-8') ?></p>

            <p class="descripcion">
                <?= htmlspecialchars($jugador["descripcion"] ?? '', ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>

    </div>

    <div class="stats-grid">

        <div class="stat-card card-hover">
            <span>⚽</span>
            <h3><?= htmlspecialchars((string)($jugador["goles"] ?? 0), ENT_QUOTES, 'UTF-8') ?></h3>
            <p>Goles</p>
        </div>

        <div class="stat-card card-hover">
            <span>🎯</span>
            <h3><?= htmlspecialchars((string)($jugador["asistencias"] ?? 0), ENT_QUOTES, 'UTF-8') ?></h3>
            <p>Asistencias</p>
        </div>

        <div class="stat-card card-hover">
            <span>🧠</span>
            <h3><?= htmlspecialchars((string)($jugador["partidos"] ?? 0), ENT_QUOTES, 'UTF-8') ?></h3>
            <p>Partidos</p>
        </div>

        <div class="stat-card card-hover">
            <span>🏆</span>
            <h3><?= htmlspecialchars((string)($jugador["titulos"] ?? 0), ENT_QUOTES, 'UTF-8') ?></h3>
            <p>Títulos</p>
        </div>

    </div>

    <div class="jugador-clubes card-hover">
        <h3>Clubes</h3>
        <ul>
            <?php if (isset($jugador["clubes"]) && is_array($jugador["clubes"])): ?>
                <?php foreach ($jugador["clubes"] as $club): ?>
                    <li><?= htmlspecialchars($club, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <div class="jugador-veredicto card-hover">
        <h3>Impacto Histórico</h3>
        <p>★★★★★</p>
    </div>

</div>

<div id="numeros-section" style="display:none;">

    <h2 class="titulo-numeros">📊 Análisis Detallado</h2>

    <?php if ($stats): ?>

    <div class="numeros-box">
        <h3>Goles por club</h3>
        <ul>
            <?php if (isset($stats["goles_club"]) && is_array($stats["goles_club"])): ?>
                <?php foreach ($stats["goles_club"] as $club => $goles): ?>
                    <li><?= htmlspecialchars($club, ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars((string)$goles, ENT_QUOTES, 'UTF-8') ?> goles</li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <div class="numeros-box">
        <h3>Tipos de gol</h3>
        <ul>
            <?php if (isset($stats["goles_tipo"]) && is_array($stats["goles_tipo"])): ?>
                <?php foreach ($stats["goles_tipo"] as $tipo => $valor): ?>
                    <li><?= htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <div class="numeros-box">
        <h3>Momentos clave</h3>
        <ul>
            <?php if (isset($stats["momentos"]) && is_array($stats["momentos"])): ?>
                <?php foreach ($stats["momentos"] as $momento => $valor): ?>
                    <li><?= htmlspecialchars($momento, ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <?php else: ?>
        <p style="padding: 15px; color: #888;">No hay datos detallados disponibles para este jugador.</p>
    <?php endif; ?>

</div>

</main>

<script>
const tabs = document.querySelectorAll(".nav-tabs span");

tabs.forEach(tab => {
    tab.addEventListener("click", () => {

        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");

        const todoSection = document.getElementById("todo-section");
        const numerosSection = document.getElementById("numeros-section");

        if (todoSection) todoSection.style.display = "none";
        if (numerosSection) numerosSection.style.display = "none";

        if (tab.textContent.trim() === "Todo" && todoSection) {
            todoSection.style.display = "block";
        }

        if (tab.textContent.trim() === "Números" && numerosSection) {
            numerosSection.style.display = "block";
        }

    });
});
</script>
</body>
<?php include "footer.php"; ?>
</html>