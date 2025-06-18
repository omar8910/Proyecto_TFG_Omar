<?php
/* Utilizamos la clase Utils para poder utilizar sus métodos
    como por ejemplo el deleteSession() que nos permite cerrar la sesión
*/

use Utils\Utils;
?>

<style>
    /* Estilos iniciarSesion */
    .login-section {
        background-color: #222;
        color: #ddd;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
    }

    .login-section h1 {
        color: white;
        margin-bottom: 20px;
    }

    /* Formulario iniciar sesion */
    .login-form {
        background-color: #333;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .login-form label {
        color: white;
        margin-bottom: 5px;
    }

    .login-form input[type="email"],
    .login-form input[type="password"] {
        padding: 10px;
        margin-bottom: 10px;
        border: none;
        border-radius: 5px;
        background-color: #444;
        color: white;
    }

    .login-form input[type="submit"] {
        background-color: #555;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .login-form input[type="submit"]:hover {
        background-color: #666;
    }

    .login-form p {
        margin-top: 10px;
        text-align: center;
    }

    .login-form a {
        color: #bbb;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .login-form a:hover {
        color: white;
    }

    /* Mensajes */
    .success-message {
        color: #00ff08;
        margin-bottom: 20px;
    }

    .error-message {
        color: #ff0000;
        background-color: #330000;
        padding: 10px;
        border-radius: 5px;

    }

    /* Recordar usuario */
    .recordarUsuario {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 10px;
        margin-top: 10px;
    }
</style>

<section class="login-section">
    <h1>Iniciar sesión</h1>
    <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion'] === 'correcto') : ?>
        <p class="success-message">Sesión iniciada correctamente</p>
    <?php endif; ?>

    <?php if (isset($mensajesError)) : ?>
        <?php foreach ($mensajesError as $mensaje) : ?>
            <p class="error-message"><?= $mensaje; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!isset($_SESSION['inicioSesion']) || $_SESSION['inicioSesion'] == 'incorrecto') : ?>
        <form action="<?= BASE_URL; ?>Usuario/iniciarSesion" method="POST" class="login-form">
            <label for="email">Correo electrónico</label>
            <input type="email" name="datos[email]" id="email" required>
            <label for="password">Contraseña</label>
            <input type="password" name="datos[password]" id="password" required>
            <div class="recordarUsuario">
                <label for="remember">Recordar usuario</label>
                <input type="checkbox" name="remember" id="remember">
            </div>
            <input type="submit" value="Iniciar sesión">
            <p><a href="<?= BASE_URL ?>Usuario/registrarUsuarios">Regístrate aquí</a></p>
        </form>
    <?php endif; ?>
</section>