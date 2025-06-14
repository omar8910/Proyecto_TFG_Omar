<style>
    :root {
        --primary-bg: #333;
        --primary-color: white;
        --accent-color: orange;
        --success-color: #28a745;
        --error-color: #dc3545;
    }
    /* Estilos para category-section */
    .category-section-container {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #222;
    }

    .category-section {
        background-color: var(--primary-bg);
        color: var(--primary-color);
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 50%;
        border-radius: 5px;
        margin: 20px auto;
    }

    .section-title {
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    .category-form {
        display: grid;
        gap: 10px;
        width: 50%;
    }

    .category-label {
        color: var(--primary-color);
    }

    .category-input {
        padding: 10px;
        border-radius: 5px;
        width: 100%;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
        background-color: #444;
        color: white;
    }

    .category-input:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.1rem var(--accent-color);
    }

    .category-submit {
        background-color: #555;
        color: var(--primary-color);
        border-radius: 5px;
        padding: 10px;
        cursor: pointer;
        text-align: center;
        margin-left: 10px;
        transition: background 0.3s ease;
        text-decoration: none;
    }

    .category-submit:hover {
        background-color: #666;
    }

    .success-message {
        color: var(--success-color);
        font-size: 18px;
        margin-bottom: 10px;
    }

    .error-message {
        color: var(--error-color);
        font-size: medium;
        margin-bottom: 10px;
        background-color: #331515;
        padding: 10px;
        border-radius: 5px;
    }

    .access-denied {
        color: var(--primary-color);
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
            <?php if (isset($errores) && is_array($errores)) : ?>
                <?php foreach ($errores as $error) : ?>
                    <p class="error-message"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
            <form class="category-form" action="<?= BASE_URL; ?>Administrador/crearCategoria" method="POST">
                <label for="nombre" class="category-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="category-input" required value="<?= isset($old['nombre']) ? htmlspecialchars($old['nombre']) : '' ?>">
                <input type="submit" value="Crear" class="category-submit">
                <a href="<?= BASE_URL; ?>Administrador/gestionarCategorias" class="category-submit" >Volver</a>
            </form>
        <?php else : ?>
            <h1 class="access-denied">Acceso denegado</h1>
        <?php endif; ?>
    </section>
</div>