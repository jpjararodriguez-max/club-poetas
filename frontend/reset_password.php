<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once "../backend/conexion.php";

$token = trim($_GET["token"] ?? '');
$tokenValido = false;

if (!empty($token)) {
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE reset_token = ? AND reset_token IS NOT NULL LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tokenValido = true;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Estructura del contenedor para alineación relativa */
        .password-container {
            position: relative !important;
            width: 100%;
            display: flex !important;
            align-items: center !important;
        }

        /* Aseguramos que el input tenga espacio a la derecha para que el texto no pise el ojito */
        .password-container input[type="password"],
        .password-container input[type="text"] {
            width: 100%;
            padding-right: 45px !important;
            box-sizing: border-box !important;
        }

        /* Centrado preciso del ojito a la derecha */
        .toggle-password {
            position: absolute !important;
            right: 15px !important;
            top: 40% !important;
            transform: translateY(-50%) !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 100% !important;
            font-size: 18px !important;
            user-select: none !important;
            z-index: 10 !important;
        }

        /* Centrado del texto dentro del botón dorado */
        .btn-reset {
            width: 100%;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            text-align: center !important;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<a href="login.html" class="back-arrow">&lt;</a>

<div class="login-container reset-box">

    <h2>🔑 Nueva contraseña</h2>

    <?php if ($tokenValido): ?>
        <p>Ingresa tu nueva contraseña para recuperar tu cuenta.</p>

        <form id="resetForm" action="update_password.php" method="POST" autocomplete="off">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">

            <div class="password-container">
                <input 
                    type="password" 
                    name="nueva_password" 
                    id="password"
                    placeholder="Nueva contraseña" 
                    required 
                >
                <span id="togglePassword" class="toggle-password">◎</span>
            </div>

            <button type="submit" class="btn btn-primary btn-reset">Cambiar contraseña</button>
        </form>
    <?php else: ?>
        <p style="color: #ff6b6b; font-weight: bold;">❌ El enlace de recuperación es inválido o ya ha caducado.</p>
        <a href="login.html" class="back-link">← Volver al inicio de sesión</a>
    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const resetForm = document.getElementById('resetForm');

    // 1. Funcionalidad del ojito (mostrar/ocultar contraseña)
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            togglePassword.textContent = isPassword ? '◉' : '◎';
        });
    }

    // 2. Validación de seguridad igual a la del registro
    if (resetForm) {
        resetForm.addEventListener('submit', (e) => {
            const password = passwordInput.value.trim();
            const regex = /^(?=.*[A-Z])(?=.*[!@#$%^&*]).{6,}$/;

            if (!regex.test(password)) {
                e.preventDefault();
                alert(
                    "Contraseña insegura.\n\n" +
                    "Debe tener:\n" +
                    "- Mínimo 6 caracteres\n" +
                    "- Una letra MAYÚSCULA\n" +
                    "- Un carácter especial (!@#$%^&*)"
                );
            }
        });
    }
});
</script>

</body>
</html>