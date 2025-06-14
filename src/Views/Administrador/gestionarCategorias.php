<style>
    /* Estilos categoria */
    .panel-section {
        background-color: #222;
        color: #ddd;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: fit-content;
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

    /* Estilos para los botones */
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

    .edit-btn {
        background-color: #28a745;
    }

    .delete-btn {
        background-color: #dc3545;
    }

    .category-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .category-table th,
    .category-table td {
        border: 1px solid #ccc;
        padding: 8px;
        color: white;
        text-align: center;
    }

    .category-table th {
        background-color: #000000;
        text-align: center;

    }

    .category-section {
        background-color: #222;
        color: #ddd;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 65vh;
    }

    .category-section .section-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: white;
    }

    .error-message {
        color: #ff4d4d;
        background-color: #331515;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        width: 50%;
        text-align: center;
    }
</style>


<section class="category-section">
    <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'administrador') : ?>
        <h1 class="section-title">Gestionar categorías</h1>
        <a class="btn" href="<?= BASE_URL ?>Administrador/crearCategoria">Crear nueva categoría</a>
        <table class="category-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // var_dump($categorias);
                ?>
                <?php if (isset($errores) && is_array($errores)) : ?>
                            <?php foreach ($errores as $error) : ?>
                                <p class="error-message" ><?= htmlspecialchars($error) ?></p>
                            <?php endforeach; ?>

                <?php endif; ?>
                <?php foreach ($categorias as $categoria) : ?>
                    <?php if ((isset($_GET['id'])) && $categoria['id'] == $_GET['id']) : ?>
                        <form action="<?= BASE_URL ?>Administrador/actualizarCategoria" method="POST">
                            <tr>
                                <td><?= $categoria['id']; ?></td>

                                <td><input type="text" name="datos[nombre]" value="<?= isset($old['nombre']) ? htmlspecialchars($old['nombre']) : $categoria['nombre']; ?>"></td>
                                <td>
                                    <input type="hidden" name="datos[id]" value="<?= $categoria['id']; ?>">
                                    <input type="submit" value="Guardar" class="btn">
                                    <a href="<?= BASE_URL ?>Administrador/gestionarCategorias" class="btn cancel-btn">Cancelar</a>
                                </td>
                            </tr>
                        </form>

                    <?php else : ?>

                        <tr>
                            <td><?= $categoria['id']; ?></td>
                            <td><?= $categoria['nombre']; ?></td>

                            <td>
                                <a href="<?= BASE_URL ?>Administrador/editarCategoria/?id=<?= $categoria['id']; ?>" class="btn edit-btn">Editar</a>
                                <a href="<?= BASE_URL ?>Administrador/eliminarCategoria/?id=<?= $categoria['id']; ?>" class="btn delete-btn">Eliminar</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <h1 class="access-denied">No tienes permisos para acceder a esta página</h1>
    <?php endif; ?>
</section>