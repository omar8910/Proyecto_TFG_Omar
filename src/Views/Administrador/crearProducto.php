<style>
    /* Variables para colores */
    :root {
        --primary-bg: #333;
        --primary-color: white;
        --accent-color: orange;
        --success-color: #28a745;
        --error-color: #dc3545;
    }

    /* Contenedor principal */
    .product-section-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px;
        width: 96%;
    }

    /* Sección del formulario */
    .product-section {
        background-color: var(--primary-bg);
        color: var(--primary-color);
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 50%;
        border-radius: 5px;
    }

    /* Título */
    .product-section-title {
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 20px;
    }

    /* Formulario */
    .product-form {
        display: grid;
        gap: 10px;
        width: 50%;
    }

    /* Etiquetas */
    .product-label {
        color: var(--primary-color);
    }

    /* Inputs y selects */
    .product-input,
    .product-textarea,
    .product-select {
        padding: 10px;
        border-radius: 5px;
        width: 100%;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .product-input:focus,
    .product-textarea:focus,
    .product-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.1rem var(--accent-color);
    }

    /* Botón de envío */
    .product-submit {
        background-color: var(--primary-bg);
        color: var(--primary-color);
        border-radius: 5px;
        padding: 10px;
        cursor: pointer;
        text-align: center;
        margin-left: 10px;
        width: 100%;
        border: 1px solid var(--accent-color);
        transition: background 0.3s ease;
    }

    .product-submit:hover {
        background-color: var(--accent-color);
    }

    /* Mensajes de éxito y error */
    .product-success-message {
        color: var(--success-color);
        font-size: 18px;
        margin-bottom: 10px;
    }

    .product-error-message {
        color: var(--error-color);
        font-size: 18px;
        margin-bottom: 10px;
    }

    /* Mensaje de acceso denegado */
    .access-denied {
        color: var(--primary-color);
        font-size: 24px;
        text-align: center;
    }

    /* Contenedor de imagen */
    .imagen-container {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        justify-content: space-between;
        padding: 10px;
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .product-inputImagen {
        flex-grow: 1;
        color: var(--primary-color);
    }

    form div{
        margin-bottom: 5px;
    }
</style>


<?php

use Utils\Utils; ?>

<div class="product-section-container">
    <section class="product-section">
        <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'administrador') : ?>
            <h1 class="product-section-title">Crear producto</h1>

            <!-- Mensajes de éxito o error -->
            <?php if (isset($_SESSION['producto'])) : ?>
                <p class="<?= $_SESSION['producto'] === 'correcto' ? 'product-success-message' : 'product-error-message'; ?>">
                    <?= $_SESSION['producto'] === 'correcto' ? 'El producto ha sido creado correctamente' : 'No se ha podido crear el producto'; ?>
                </p>
                <?php Utils::eliminarSesion('producto'); ?>
            <?php endif; ?>

            <?php if (isset($mensajesError)) : ?>
                <?php foreach ($mensajesError as $mensaje) : ?>
                    <p class="product-error-message"><?= $mensaje; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <form class="product-form" action="<?= BASE_URL; ?>Administrador/crearProducto" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="nombre" class="product-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="product-input" required>
                </div>

                <div>
                    <label for="descripcion" class="product-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="product-textarea" required></textarea>
                </div>

                <div>
                    <label for="precio" class="product-label">Precio</label>
                    <input type="number" step="0.01" min="0" name="precio" id="precio" class="product-input" required>
                </div>

                <div>
                    <label for="stock" class="product-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="product-input" required>
                </div>

                <div>
                    <label for="imagen" class="product-label">Selecciona una imagen:</label>
                    <div class="imagen-container">
                        <input type="file" name="imagen" id="imagen" class="product-inputImagen" required>
                    </div>
                </div>

                <div>
                    <label for="categoria" class="product-label">Categoría</label>
                    <select name="categoria_id" id="categoria" class="product-select" required>
                        <option value="">Selecciona una categoría</option>
                        <?php foreach ($categorias as $categoria) : ?>
                            <option value="<?= $categoria['id']; ?>"><?= $categoria["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="submit" value="Crear" class="product-submit">
            </form>
        <?php else : ?>
            <h1 class="access-denied">No tienes permisos para acceder a esta página</h1>
        <?php endif; ?>
    </section>
</div>

<!-- <script>
    document.getElementById('imagen').addEventListener('change', function(event) {
        let fileName = event.target.files[0] ? event.target.files[0].name : 'Ningún archivo seleccionado';
        document.getElementById('file-name').textContent = fileName;
    });
</script> -->