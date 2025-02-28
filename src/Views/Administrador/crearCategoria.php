<style>
    /* Estilos para category-section */
    .category-section-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px;
        width: 96%;
    }

    .category-section {
        background-color: rgb(51, 51, 51);
        color: #333;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 50%;
        border-radius: 5px;
    }

    .section-title {
        text-align: center;
        color: rgb(255, 255, 255);
        margin-bottom: 20px;
    }

    .category-form {
        display: grid;
        gap: 10px;
    }

    .category-form label {
        color: rgb(255, 255, 255);
    }

    .category-form input[type="text"],
    .category-form input[type="submit"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
    }

    .category-form input[type="text"]:focus {
        border-color: #007BFF;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

    .btn-primary {
        background-color: #007BFF;
        color: white;
        border-radius: 5px;
        padding: 10px;
        cursor: pointer;
        text-align: center;
        margin-left: 10px;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .success-message {
        color: #28a745;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .error-message {
        color: #dc3545;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .access-denied {
        color: white;
        font-size: 24px;
        text-align: center;
    }
</style>

<?php

use Utils\Utils; ?>

<div class="category-section-container">
    <section class="category-section">
        <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'administrador') : ?>

            <h1 class="section-title">Crear categoría</h1>

            <?php if (isset($_SESSION['categoria']) && $_SESSION['categoria'] === 'correcto') : ?>
                <p class="success-message">La categoría ha sido creada correctamente</p>
            <?php elseif (isset($_SESSION['categoria']) && $_SESSION['categoria'] === 'incorrecto') : ?>
                <p class="error-message">No se ha podido crear la categoría</p>
                <?php if (isset($mensajesError)) : ?>
                    <?php foreach ($mensajesError as $mensaje) : ?>
                        <p class="error-message"><?= $mensaje; ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php Utils::eliminarSesion('categoria'); ?>
            <?php endif; ?>

            <form class="category-form" action="<?= BASE_URL; ?>Administrador/crearCategoria" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required>
                <input type="submit" value="Crear" class="btn btn-primary">
            </form>

        <?php else : ?>
            <h1 class="access-denied">Acceso denegado</h1>
        <?php endif; ?>
    </section>
</div>