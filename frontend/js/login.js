const form = document.getElementById("loginForm");

form.addEventListener("submit", function (e) {
    e.preventDefault(); //  MUY IMPORTANTE

    const correo = document.getElementById("correo").value.trim();
    const password = document.getElementById("password").value.trim();

    // 1️ VALIDAR CAMPOS VACÍOS
    if (!correo || !password) {
        alert("Debes ingresar correo y contraseña");
        return;
    }

    // 2️ ENVIAR AL BACKEND
    fetch("../backend/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `correo=${encodeURIComponent(correo)}&password=${encodeURIComponent(password)}`
    })

    .then(res => res.text())
    .then(data => {
    data = data.trim();

    if (data === "CARNET") {

        window.location.href = "carnet.php";

    } else if (data === "OK") {

        window.location.href = "dashboard.php";

    } else {
        alert(data);
    }
    });

 });

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