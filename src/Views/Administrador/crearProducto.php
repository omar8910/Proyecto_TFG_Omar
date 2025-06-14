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
        background-color: #222;
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

    /* Estilos heredados de editarProducto */
    #crear-producto-section {
        background-color: #222;
        color: #ddd;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    #crear-producto-section h1 {
        color: white;
        margin-bottom: 20px;
    }

    #crear-producto-form {
        background-color: #333;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    #crear-producto-form .form-label {
        color: white;
        margin-bottom: 5px;
    }

    #crear-producto-form .form-input,
    #crear-producto-form .form-textarea,
    #crear-producto-form .form-select {
        padding: 10px;
        margin-bottom: 10px;
        border: none;
        border-radius: 5px;
        background-color: #444;
        color: white;
    }

    #crear-producto-form .btn {
        background-color: #555;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #crear-producto-form .btn:hover {
        background-color: #666;
    }

    .product-error-message {
        color: #ff4d4d;
        background-color: #331515;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        width: 100%;
        text-align: center;
        font-size: medium;
    }

    .access-denied {
        color: white;
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
    <section id="crear-producto-section">
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

            <?php if (isset($errores) && is_array($errores)) : ?>
                <?php foreach ($errores as $error) : ?>
                    <p class="product-error-message"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <form action="<?= BASE_URL; ?>Administrador/crearProducto" method="POST" enctype="multipart/form-data" id="crear-producto-form">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-input" required value="<?= isset($old['nombre']) ? htmlspecialchars($old['nombre']) : '' ?>">

                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-textarea" required><?= isset($old['descripcion']) ? htmlspecialchars($old['descripcion']) : '' ?></textarea>

                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" min="0" name="precio" id="precio" class="form-input" required value="<?= isset($old['precio']) ? htmlspecialchars($old['precio']) : '' ?>">

                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-input" required value="<?= isset($old['stock']) ? htmlspecialchars($old['stock']) : '' ?>">

                <label for="imagen" class="form-label">Selecciona una imagen:</label>
                <input type="file" name="imagen" id="imagen" class="form-input" required>

                <label for="categoria" class="form-label">Categoría</label>
                <select name="categoria_id" id="categoria" class="form-select" required>
                    <option value="">Selecciona una categoría</option>
                    <?php foreach ($categorias as $categoria) : ?>
                        <option value="<?= $categoria['id']; ?>" <?= (isset($old['categoria_id']) && $old['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>><?= $categoria["nombre"]; ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Crear" class="btn">
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