document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('registroForm') || document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    //  Funcionalidad del ojo (alterna entre contraseña oculta y visible)
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            togglePassword.textContent = isPassword ? '◉' : '◎';
        });
    }

    // Control del envío del formulario sin recargar la página
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Detiene la recarga por defecto

            const correoInput = document.getElementById('correo');
            const passwordVal = passwordInput ? passwordInput.value.trim() : '';
            const correoVal = correoInput ? correoInput.value.trim() : '';

            // Validación de campos vacíos
            if (!correoVal || !passwordVal) {
                alert('Debes ingresar correo y contraseña');
                return;
            }

            
            fetch('../backend/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `correo=${encodeURIComponent(correoVal)}&password=${encodeURIComponent(passwordVal)}`
            })
            .then(res => res.text())
            .then(data => {
                data = data.trim();

                if (data === 'CARNET') {
                    window.location.href = 'carnet.php';
                } else if (data === 'OK') {
                    window.location.href = 'dashboard.php';
                } else {
                    alert(data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar conectar con el servidor.');
            });
        });
    }
});