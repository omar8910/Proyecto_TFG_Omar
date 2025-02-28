<style>
    /* Estilos para la sección de productos */
    .product-section {
        background-color: #222;
        color: #ddd;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 65vh;
    }

    .product-section .section-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: white;
    }

    .product-section .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #555;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
    }

    .product-section .btn:hover {
        background-color: #666;
    }

    /* Estilos para la tabla */
    .product-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .product-table th,
    .product-table td {
        border: 1px solid #ccc;
        padding: 8px;
        color: white;
        text-align: center;
    }

    .product-table th {
        background-color: #000000;
        text-align: center;
    }

    /* Estilos para botones de acciones */
    .product-section .btn.edit-btn {
        background-color: #28a745;
    }

    .product-section .btn.delete-btn {
        background-color: #dc3545;
    }

    .product-section .btn.cancel-btn {
        background-color: #ff6600;
    }

    .product-section .btn.edit-btn:hover,
    .product-section .btn.delete-btn:hover,
    .product-section .btn.cancel-btn:hover {
        background-color: #333;
    }

    /* Estilos para el formulario de edición */
    .product-section form input[type="text"] {
        padding: 8px;
        margin-bottom: 10px;
        border: none;
        border-radius: 5px;
        background-color: #444;
        color: white;
        width: calc(100% - 16px);
    }

    .product-section form input[type="submit"] {
        background-color: #555;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .product-section form input[type="submit"]:hover {
        background-color: #666;
    }
</style>


<section class="product-section">
    <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'administrador') : ?>
        <h1 class="section-title">Gestionar Productos</h1>
        <a class="btn" href="<?= BASE_URL ?>Administrador/crearProducto">Nuevo Producto</a>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Id Categoría</th>
                    <th>Nombre Categoría</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) : ?>
                    <!-- <?php var_dump($producto); ?> -->
                    <tr>
                        <td><?= $producto['id'] ?></td>
                        <td><?= $producto['categoria_id'] ?></td>
                        <td>
                            <?php foreach ($categorias as $categoria) : ?>
                                <?php if ($categoria['id'] === $producto['categoria_id']) : ?>
                                    <?= $categoria['nombre'] ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td><?= $producto['nombre'] ?></td>
                        <td><?= $producto['descripcion'] ?></td>
                        <td><?= $producto['precio'] ?></td>
                        <td><?= $producto['stock'] ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>Administrador/editarProducto/?id=<?= $producto['id'] ?>" class="btn edit-btn">Editar</a>
                            <a href="<?= BASE_URL ?>Administrador/eliminarProducto/?id=<?= $producto['id'] ?>" class="btn delete-btn">Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <h1 class="access-denied">No tienes permisos para acceder a esta página</h1>
    <?php endif; ?>
</section>