<style>
    /* Estilos generales */
    .panel-section {
        background-color: #222;
        color: #ddd;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 65vh;
    }

    .panel-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: white;
    }

    .section-title {
        font-size: 18px;
        margin-bottom: 10px;
        color: white;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        background-color: #020405;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        margin-right: 10px;
    }

    .btn:hover {
        background-color: #333;
        text-decoration: none;
    }

    .cancel-btn {
        background-color: #dc3545;
    }

    .cancel-btn:hover {
        background-color: #c82333;
    }

    .edit-btn {
        background-color: #28a745;
    }

    /* Estilos para el formulario de edición */
    .form-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 600px;
        margin-top: 20px;
        background-color: #444;
        padding: 20px;
        border-radius: 5px;
    }

    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="password"],
    .form-container select {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        background-color: #333;
        color: #fff;
        border: 1px solid #444;
        border-radius: 4px;
    }

    .form-container input[type="submit"] {
        width: auto;
        padding: 10px 20px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-container input[type="submit"]:hover {
        background-color: #218838;
    }

    .form-container .buttonContainer {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .form-container label {
        font-size: 16px;
        margin-bottom: 6px;
        color: white;
    }

    /* Estilos para el mensaje de éxito */
    .success-message {
        background-color: #d4edda;
        /* Fondo verde claro */
        color: #155724;
        /* Texto verde oscuro */
        padding: 12px 20px;
        /* Espaciado interno */
        border-radius: 5px;
        /* Bordes redondeados */
        margin-bottom: 20px;
        /* Espaciado inferior */
        font-size: 16px;
        /* Tamaño de fuente */
        text-align: center;
        /* Centrar texto */
        border: 1px solid #c3e6cb;
        /* Borde verde */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Sombra suave */
    }

    /* Estilos para el mensaje de error */
    .error-message {
        background-color: #f8d7da;
        /* Fondo rojo claro */
        color: #721c24;
        /* Texto rojo oscuro */
        padding: 12px 20px;
        /* Espaciado interno */
        border-radius: 5px;
        /* Bordes redondeados */
        margin-bottom: 20px;
        /* Espaciado inferior */
        font-size: 16px;
        /* Tamaño de fuente */
        text-align: center;
        /* Centrar texto */
        border: 1px solid #f5c6cb;
        /* Borde rojo */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Sombra suave */
    }

    /* Estilos para mensaje de acceso denegado */
    .access-denied {
        font-size: 18px;
        color: #dc3545;
        margin-top: 20px;
    }
</style>


<div class="main-content">
    <section class="panel-section">
        <h1 class="panel-title">Editar Perfil</h1>

        <!-- Mensaje de éxito -->
        <?php if (isset($_SESSION['actualizacion']) && $_SESSION['actualizacion'] == 'correcta') : ?>
            <div class="success-message">
                ¡Perfil actualizado correctamente!
            </div>
            <?php unset($_SESSION['actualizacion']); // Limpiar el mensaje después de mostrarlo 
            ?>
        <?php endif; ?>

        <!-- Mensaje de error -->
        <?php if (isset($_SESSION['actualizacion']) && $_SESSION['actualizacion'] == 'incorrecta') : ?>
            <div class="error-message">
                Hubo un error al actualizar los datos. Por favor, intenta nuevamente.
            </div>
            <?php unset($_SESSION['actualizacion']); // Limpiar el mensaje después de mostrarlo 
            ?>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <form action="<?= BASE_URL ?>Usuario/editarPerfil" method="POST" class="form-container">
            <label for="nombre">Nombre</label>
            <input type="text" name="datos[nombre]" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

            <label for="apellidos">Apellidos</label>
            <input type="text" name="datos[apellidos]" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required>

            <label for="email">Correo electrónico</label>
            <input type="email" name="datos[email]" value="<?= htmlspecialchars($usuario['email']) ?>" required>

            <input type="hidden" name="datos[id]" value="<?= $usuario['id']; ?>">
            <input type="hidden" name="datos[rol]" value="<?= htmlspecialchars($usuario['rol']) ?>">

            <div class="buttonContainer">
                <input type="submit" value="Guardar Cambios" class="btn">
                <a href="<?= BASE_URL ?>" class="btn cancel-btn">Cancelar</a>
            </div>
        </form>
    </section>
</div>