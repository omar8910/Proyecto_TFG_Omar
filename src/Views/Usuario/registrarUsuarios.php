<?php

use Utils\Utils;
?>

<style>
    /* Estilos registrarUsuarios */
    .register-section {
        background-color: #222;
        color: #ddd;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
    }

    .register-section h1 {
        color: white;
        margin-bottom: 20px;
    }

    /* Estilos formulario */
    .register-form {
        background-color: #333;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .register-form label {
        color: white;
        margin-bottom: 5px;
    }

    .register-form input[type="text"],
    .register-form input[type="email"],
    .register-form input[type="password"] {
        padding: 10px;
        margin-bottom: 10px;
        border: none;
        border-radius: 5px;
        background-color: #444;
        color: white;
    }

    .register-form select {
        padding: 10px;
        margin-bottom: 10px;
        border: none;
        border-radius: 5px;
        background-color: #444;
        color: white;
    }

    .register-form input[type="submit"] {
        background-color: #555;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .register-form input[type="submit"]:hover {
        background-color: #666;
    }

    .register-form a {
        color: #bbb;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .register-form a:hover {
        color: white;
    }



    .return-link {
        display: inline-block;
        text-align: center;
        margin-top: 20px;
        background-color: #555;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .return-link:hover {
        background-color: #666;
    }

    /* Mensajes */
    .success-message {
        color: #00ff08;
        margin-bottom: 20px;
    }

    .error-message {
        color: #ff4d4d;
        background-color: #331515;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        width: 50%;
        text-align: center;
    }
</style>


<section class="register-section">
    <h1>Registro de usuario</h1>
    <?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === 'correcto') : ?>
        <p class="success-message">Usuario registrado correctamente</p>
    <?php elseif (isset($_SESSION['registro']) && $_SESSION['registro'] === 'incorrecto') : ?>
        <p class="error-message">Error al registrar el usuario</p>
    <?php endif; ?>

    <?php Utils::eliminarSesion('registro'); ?>
    <?php if (isset($mensajesError)) : ?>
        <?php foreach ($mensajesError as $mensaje) : ?>
            <p class="error-message"><?= $mensaje ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>Usuario/registrarUsuarios/" method="POST" class="register-form">
        <label for="nombre">Nombre:</label>
        <input type="text" name="datos[nombre]" id="nombre" required value="<?= isset($_POST['datos']['nombre']) ? htmlspecialchars($_POST['datos']['nombre']) : '' ?>">
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="datos[apellidos]" id="apellidos" required value="<?= isset($_POST['datos']['apellidos']) ? htmlspecialchars($_POST['datos']['apellidos']) : '' ?>">
        <br>
        <label for="email">Correo electrónico:</label>
        <input type="email" name="datos[email]" id="email" required value="<?= isset($_POST['datos']['email']) ? htmlspecialchars($_POST['datos']['email']) : '' ?>">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="datos[password]" id="password" required>
        <br>
        <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'administrador') : ?>
            <label for="rol">Rol:</label>
            <select name="datos[rol]" id="rol">
                <option value="usuario" <?= (isset($_POST['datos']['rol']) && $_POST['datos']['rol'] === 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                <option value="administrador" <?= (isset($_POST['datos']['rol']) && $_POST['datos']['rol'] === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
            </select>
        <?php endif; ?>
        <br>
        <input type="submit" value="Registrar">
    </form>

    <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'administrador') : ?>
        <a href="<?= BASE_URL ?>Administrador/mostrarUsuarios" class="return-link">Volver</a>
    <?php else : ?>
        <a href="<?= BASE_URL ?>Usuario/iniciarSesion" class="return-link">Volver a inicio de sesión</a>
    <?php endif; ?>
</section>