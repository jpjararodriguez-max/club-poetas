<?php
require_once "../backend/proteger.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Favoritos - Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="dashboard-body">

<header class="dash-header-pro">
    <h1>⭐ Mis Jugadores Favoritos</h1>
    <a href="dashboard.php" class="btn">⬅ Volver</a>
</header>

<?php if (isset($_GET["guardado"])): ?>
    <div style="color: #d4af37; text-align:center; margin: 10px; font-weight: bold;">
        ✅ Favoritos guardados correctamente
    </div>
<?php endif; ?>

<main class="favoritos-container">

    <h2 class="favoritos-title">
        ❤️ Elige con sabiduría tus 10 mejores jugadores de la historia
    </h2>

    <div class="favoritos-content">

        <!-- LISTA DE JUGADORES -->
        <div class="lista-jugadores">
            <div class="jugador">Cristiano Ronaldo</div>
            <div class="jugador">Pele</div>
            <div class="jugador">Di Stéfano</div>
            <div class="jugador">Beckenbauer</div>
            <div class="jugador">Maradona</div>
            <div class="jugador">Messi</div>
            <div class="jugador">Ferenc Puskas</div>
            <div class="jugador">Johan Cruyff</div>
            <div class="jugador">Ronaldinho</div>
            <div class="jugador">Bobby Charlton</div>
            <div class="jugador">Gerd Muller</div>
            <div class="jugador">Eusebio</div>
            <div class="jugador">Ronaldo Nazario</div>
            <div class="jugador">Zinedine Zidane</div>
            <div class="jugador">Lev Yashin</div>
            <div class="jugador">M.Neuer</div>
            <div class="jugador">Casillas</div>
            <div class="jugador">G.Buffon</div>
            <div class="jugador">Josef Bican</div>
            <div class="jugador">Iniesta</div>
            <div class="jugador">Xavi H.</div>
            <div class="jugador">Garrincha</div>
            <div class="jugador">Paolo Maldini</div>
            <div class="jugador">Luka Modric</div>
            <div class="jugador">T.Kroos</div>
            <div class="jugador">Romario</div>
            <div class="jugador">Platini</div>
            <div class="jugador">Sindelar</div>
            <div class="jugador">Lewandowski</div>
            <div class="jugador">Ibrahimovic</div>
            <div class="jugador">R.Gullit</div>
            <div class="jugador">G.Meazza</div>
            <div class="jugador">P.Rossi</div>
            <div class="jugador">R.Baggio</div>
            <div class="jugador">Rivera</div>
            <div class="jugador">Marcelo</div>
            <div class="jugador">Dani alves</div>
            <div class="jugador">Cubillas</div>
            <div class="jugador">Rummenigge</div>
            <div class="jugador">Totti</div>
            <div class="jugador">Kubala</div>
            <div class="jugador">K.Dalglish</div>
            <div class="jugador">A.Del Pierro</div>
            <div class="jugador">Jairzinho</div>
            <div class="jugador">Kaka</div>
            <div class="jugador">Neymar</div>
            <div class="jugador">G.Banks</div>
            <div class="jugador">D.Zoff</div>
            <div class="jugador">L.Matthaus</div>
            <div class="jugador">K.Keegan</div>
            <div class="jugador">Rijkaard</div>
            <div class="jugador">Rivelino</div>
            <div class="jugador">Sergio Ramos</div>
            <div class="jugador">Puyol</div>
            <div class="jugador">Roberto Carlos</div>
            <div class="jugador">Raymond Kopa</div>
            <div class="jugador">P.Gento</div>
            <div class="jugador">Figo</div>
            <div class="jugador">B.Moore</div>
            <div class="jugador">Lucho Suarez</div>
            <div class="jugador">Mbappe</div>
            <div class="jugador">E.Haaland</div>
            <div class="jugador">Eto'o</div>
            <div class="jugador">D. Law</div>
            <div class="jugador">G.Best</div>
            <div class="jugador">Drogba</div>
            <div class="jugador">Rooney</div>
            <div class="jugador">E.Figueroa</div>
            <div class="jugador">R.Giggs</div>
            <div class="jugador">K.De Bruyne</div>
            <div class="jugador">P.Scholes</div>
            <div class="jugador">Kempes</div>
            <div class="jugador">Luiz Suarez</div>
            <div class="jugador">H.Sanchez</div>
            <div class="jugador">Passarella</div>
            <div class="jugador">T.Henry</div>
            <div class="jugador">Benzama</div>
            <div class="jugador">O.Dembele</div>
            <div class="jugador">Raul</div>
            <div class="jugador">Rivaldo</div>
            <div class="jugador">Cafu</div>
            <div class="jugador">Franco Baresi</div>
            <div class="jugador">Courtois</div>
            <div class="jugador">Zico</div>
            <div class="jugador">Matthews</div>
            <div class="jugador">M.Van Basten</div>
            <div class="jugador">T.Muller</div>
            <div class="jugador">G.Hagi</div>
        </div>

        <!-- SELECCIONADOS -->
        <div class="seleccionados">
            <h3>Tus favoritos (0/10)</h3>
            <ul id="lista-favoritos"></ul>

            <!-- BOTÓN GUARDAR -->
            <button onclick="guardarFavoritos()" class="btn">💾 Guardar favoritos</button>
        </div>

    </div>

</main>

<!-- FORM OCULTO -->
<form id="formFavoritos" action="guardar_favoritos.php" method="POST">
    <input type="hidden" name="favoritos" id="inputFavoritos">
</form>

<script>
let favoritos = [];

// CARGAR DESDE BD AL ENTRAR
fetch("../backend/obtener_favoritos.php")
.then(res => {
    if (!res.ok) throw new Error("Error al consultar favoritos");
    return res.json();
})
.then(data => {
    if (Array.isArray(data)) {
        favoritos = data;
        renderFavoritos();
    }
})
.catch(err => console.error("Error cargando favoritos:", err));

// SELECCIONAR
document.querySelectorAll(".jugador").forEach(jugador => {
    jugador.addEventListener("click", () => {
        let nombre = jugador.innerText.trim();

        if (favoritos.includes(nombre)) return;

        if (favoritos.length >= 10) {
            alert("Solo puedes elegir 10 jugadores");
            return;
        }

        favoritos.push(nombre);
        renderFavoritos();
    });
});

function renderFavoritos() {
    const lista = document.getElementById("lista-favoritos");
    lista.innerHTML = "";

    favoritos.forEach((nombre, index) => {
        const li = document.createElement("li");
        
        const spanTexto = document.createElement("span");
        spanTexto.textContent = nombre + " ";
        
        const btnEliminar = document.createElement("button");
        btnEliminar.textContent = "❌";
        btnEliminar.onclick = () => eliminar(index);

        li.appendChild(spanTexto);
        li.appendChild(btnEliminar);
        lista.appendChild(li);
    });

    document.querySelector(".seleccionados h3").innerText =
        `Tus favoritos (${favoritos.length}/10)`;
}

// ELIMINAR
function eliminar(index) {
    favoritos.splice(index, 1);
    renderFavoritos();
}

// GUARDAR
function guardarFavoritos() {
    if (favoritos.length === 0) {
        alert("Selecciona al menos 1 jugador");
        return;
    }

    document.getElementById("inputFavoritos").value = JSON.stringify(favoritos);
    document.getElementById("formFavoritos").submit();
}
</script>

</body>
</html>