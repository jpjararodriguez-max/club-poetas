const form = document.getElementById("loginForm");

form.addEventListener("submit", function (e) {
    e.preventDefault(); //  MUY IMPORTANTE

    const correo = document.getElementById("correo").value.trim();
    const password = document.getElementById("password").value.trim();

    // 1️⃣ VALIDAR CAMPOS VACÍOS
    if (!correo || !password) {
        alert("Debes ingresar correo y contraseña");
        return;
    }

    // 2️⃣ ENVIAR AL BACKEND
    fetch("../backend/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `correo=${encodeURIComponent(correo)}&password=${encodeURIComponent(password)}`
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "OK") {
            window.location.href = "dashboard.php";
        } else {
            alert(data);
        }
    });
});








