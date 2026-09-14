<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - El Club de los Poetas del Fútbol</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container forgot-box">

    <h2>🔐 Recuperar contraseña</h2>

    <p>Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>

    <form action="send_reset.php" method="POST" autocomplete="off">

        <input 
            type="email" 
            name="correo" 
            placeholder="tucorreo@gmail.com" 
            required
        >

        <button type="submit">Enviar enlace</button>

    </form>

    <br>
    <a href="login.html" class="back-link">← Volver al inicio de sesión</a>

</div>

</body>
</html>