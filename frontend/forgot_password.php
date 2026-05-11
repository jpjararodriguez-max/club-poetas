<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container forgot-box">

    <h2>🔐 Recuperar contraseña</h2>

    <p>Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>

    <form action="send_reset.php" method="POST">

        <input type="email" name="correo" placeholder="tucorreo@gmail.com" required>

        <button type="submit">Enviar enlace</button>

    </form>


</div>

</body>
</html>