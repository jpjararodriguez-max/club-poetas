// ===========================================================
// DETECTAR TIPO DE PERFIL DESDE LA URL
// ===========================================================
const params = new URLSearchParams(window.location.search);
const tipo = params.get("tipo");

let perfilUsuario = "FANÁTICO";
if (tipo === "periodista") {
    perfilUsuario = "PERIODISTA DEPORTIVO";
}
// ===========================================================
// asignacion del perfiloculto
// ===========================================================
document.addEventListener("DOMContentLoaded", () => {
    const inputPerfil = document.getElementById("perfil");
    if (inputPerfil) {
        inputPerfil.value = perfilUsuario;
    }
});

// ===========================================================
// CAMBIAR PLACEHOLDER DEL CORREO SEGÚN PERFIL
// ===========================================================
document.addEventListener("DOMContentLoaded", function () {
    const inputCorreo = document.getElementById("correo");

    if (tipo === "periodista") {
        inputCorreo.placeholder = "nombre@empresa.com";
    } else {
        inputCorreo.placeholder = "tucorreo@gmail.com";
    }
});

// ===========================================================
// PERSONALIZAR TÍTULO SEGÚN PERFIL
// ===========================================================
const titulo = document.getElementById("tituloRegistro");

if (titulo) {
    if (tipo === "periodista") {
        titulo.textContent = "Registro Periodista Deportivo";
    } else {
        titulo.textContent = "Registro Fanático";
    }
}

// ===========================================================
// LISTA COMPLETA DE JUGADORES (ORDEN ORIGINAL MIO)
// ===========================================================
const jugadores = [
    "Cristiano Ronaldo", "Pelé", "Di Stéfano", "Beckenbauer", "Maradona",
    "Messi", "Ferenc Puskas", "Johan Cruyff", "Ronaldinho", "Bobby Charlton",
    "Eusebio", "Gerd Muller", "Ronaldo Nazário", "Zinedine Zidane", "Platini",
    "Lev Yashin","Batistuta","G. Hagi","G. Banks","D. Zoff","Eto'o","D. Law","Drogba","Rooney",
    "Lewandowski","P. Rossi","Marcelo","Dani Alves","Del Piero","Jairzinho","Kaká",
    "Sindelar","Rummenigge","Totti","Kubala","Rivera","Cubillas","G. Meazza","Socrates",
    "J. Moreno","Matthews","Sivori","K. Dalglish","K. Keegan","F. Rijkaard","Rivelinho",
    "E. Figueroa","R. Giggs","Ibrahimovic","K. De Bruyne","Kempes","Neuer","Neymar",
    "Raúl","Luis Suárez","Benzema","Thierry Henry","Passarella","Toni Kroos","Sergio Ramos",
    "Figo","Bobby Moore","Rivaldo","Cafú","Franco Baresi","Hugo Sánchez","Casillas","Buffon",
    "Courtois","Roberto Carlos","Ruud Gullit","Raymond Kopa","Zico","Paco Gento","Josef Bican",
    "Lucho Suárez","Erling Haaland","Kylian Mbappé","Lothar Matthaus","Roberto Baggio",
    "Xavi Hernández","Iniesta","Luka Modric","Romario","Paolo Maldini","George Best",
    "Marco Van Basten","Thomas Müller","Garrincha"
];

const selectJugadores = document.getElementById("jugador");
jugadores.forEach(j => {
    const option = document.createElement("option");
    option.value = j;
    option.textContent = j;
    selectJugadores.appendChild(option);
});

// ===========================================================
// VALIDACIONES DE CORREO
// ===========================================================

// Correos personales PERMITIDOS solo para FANÁTICO
const correoPersonal = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|icloud\.com)$/;

// Correos corporativos (NO gmail, NO outlook, NO icloud)
const correoCorporativo = /^[a-zA-Z0-9._%+-]+@(?!(gmail|hotmail|yahoo|outlook|icloud|live|proton|aol)\.)[a-zA-Z0-9-]+\.(com|net|org|co|mx|es|us|edu)$/i;

// ===========================================================
// VALIDAR CONTRASEÑA SEGURA
// ===========================================================
function validarPassword(password) {
    const regex = /^(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;
    return regex.test(password);
}

// ===========================================================
// PROCESAR REGISTRO
// ===========================================================
const form = document.getElementById("registroForm");

form.addEventListener("submit", function (e) {
    e.preventDefault();

    const nombreCompleto = document.getElementById("nombreCompleto").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const password = document.getElementById("password").value.trim();
    const jugador = document.getElementById("jugador").value;

    if (!nombreCompleto || !correo || !password || !jugador) {
        alert("Por favor completa todos los campos.");
        return;
    }

    // 🔐 VALIDACIÓN SEGÚN PERFIL
    if (perfilUsuario === "PERIODISTA DEPORTIVO") {
        if (!correoCorporativo.test(correo)) {
            alert(
                  "Correo inválido para PERIODISTA.\n\n" +
                  "Solo se permiten correos corporativos.\n\n" +

                "Dominios permitidos:\n" +
                "- nombre@empresa.com\n" +
                "- nombre@empresa.net\n" +
                "- nombre@empresa.org\n" +
                "- nombre@empresa.co\n" +
                "- nombre@empresa.us\n" +
                "- nombre@empresa.mx\n" +
                "- nombre@empresa.es\n" +
                "- nombre@empresa.com.co\n"+
                "- nombre@empresa.com.us\n"+
                "- nombre@empresa.com.mx\n"+
                "- nombre@empresa.com.es\n"
                 );
            return;
        }
    } else {
        // FANÁTICO
        if (!correoPersonal.test(correo)) {
            alert(
                "Correo inválido.\n\n" +
                "Ejemplos válidos:\n" +
                "- nombre@gmail.com\n" +
                "- nombre@outlook.com\n" +
                "- nombre@icloud.com\n"
            );
            return;
        }
    }

    if (!validarPassword(password)) {
        alert(
            "Contraseña insegura.\n\n" +
            "Debe tener:\n" +
            "- Mínimo 6 caracteres\n" +
            "- Una letra MAYÚSCULA\n" +
            "- Un carácter especial (!@#$%^&*)"
        );
        return;
    }

    const usuario = {
        perfil: perfilUsuario,
        nombreCompleto,
        correo,
        jugador
    };

    fetch("../backend/registrar_usuario.php", {
    method: "POST",
    body: new FormData(document.getElementById("registroForm"))
})
.then(res => res.text())
.then(data => {
    if (data.trim() === "OK") {
        alert("Usuario registrado correctamente");
        window.location.href = "carnet.php";
    } else {
        alert("Error del servidor: " + data);
    }
});
});

// ===========================================================
// MOSTRAR / OCULTAR PASSWORD
// ===========================================================

const passwordInput = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");

togglePassword.addEventListener("click", () => {

    if (passwordInput.type === "password") {

        passwordInput.type = "text";

        togglePassword.textContent = "◉";

    } else {

        passwordInput.type = "password";

        togglePassword.textContent = "◎";
    }

});