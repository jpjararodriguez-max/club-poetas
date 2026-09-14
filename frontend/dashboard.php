<?php
require_once "../backend/proteger.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="dashboard-body">
    
<?php include "sidebar_ads.php"; ?>

    <!-- HEADER -->
    <header class="dash-header-pro">
        <h1>🏆 EL CLUB DE LOS POETAS DEL FÚTBOL 🖋️</h1>

        <div class="user-info">
            Usuario: <strong><?= htmlspecialchars($_SESSION["nombre"] ?? '', ENT_QUOTES, 'UTF-8') ?></strong> |
            Perfil: <strong><?= htmlspecialchars($_SESSION["perfil"] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
        </div>

        <div class="header-buttons">
            <a href="carnet.php" class="btn">Ver mi carnet</a>
            <a href="../backend/logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>
    </header>

    <!-- BUSCADOR -->
    <main class="search-section">
        <h2 class="search-title">🔎Busca tu jugador</h2>
        
        <form action="jugador.php" method="GET" autocomplete="off">
            <input 
                type="text" 
                name="nombre"
                id="buscador"
                class="search-bar"
                placeholder="Ej: Messi, Cristiano Ronaldo..."
                required
            >
        </form>

        <!-- SUGERENCIAS -->
        <div id="sugerencias" class="sugerencias-box"></div>
    </main>

    <!-- BOTÓN FLOTANTE -->
    <div class="floating-menu" id="menuBtn">
        ⚽
        <div class="menu-options" id="menuOptions">
            <a href="#">Puntaje</a>
            <a href="#">Poemas</a>
            <a href="#">Comunidad</a>
            <a href="nosotros.php">Nosotros</a>
            <a href="perfil.php">Mi Perfil</a>
            <a href="favoritos.php">Mis Favoritos</a>
        </div>
    </div>

    <!-- SCRIPT MENÚ -->
    <script>
    const menuBtn = document.getElementById("menuBtn");
    const menu = document.getElementById("menuOptions");

    menuBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    });

    document.addEventListener("click", () => {
        menu.style.display = "none";
    });

    menu.addEventListener("click", (e) => {
        e.stopPropagation();
    });
    </script>

    <!-- SCRIPT BUSCADOR PRO -->
    <script>
    const buscador = document.getElementById("buscador");
    const sugerencias = document.getElementById("sugerencias");

    buscador.addEventListener("keyup", function() {
        let valor = this.value.trim();

        if (valor.length < 2) {
            sugerencias.style.display = "none";
            sugerencias.innerHTML = "";
            return;
        }

        fetch("../backend/buscar.php?q=" + encodeURIComponent(valor))
            .then(res => {
                if (!res.ok) throw new Error("Error en la respuesta del servidor");
                return res.json();
            })
            .then(data => {
                sugerencias.innerHTML = "";

                if (!Array.isArray(data) || data.length === 0) {
                    sugerencias.style.display = "none";
                    return;
                }

                sugerencias.style.display = "block";

                data.forEach(nombre => {
                    let div = document.createElement("div");
                    div.classList.add("sugerencia-item");
                    div.textContent = nombre;

                    div.onclick = () => {
                        window.location.href = "jugador.php?nombre=" + encodeURIComponent(nombre.toLowerCase());
                    };

                    sugerencias.appendChild(div);
                });
            })
            .catch(err => {
                console.error("Error al buscar sugerencias:", err);
                sugerencias.style.display = "none";
            });
    });
    </script>

</body>
</html>