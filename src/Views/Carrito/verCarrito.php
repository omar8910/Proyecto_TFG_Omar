<style>
    /* Estilos para el carrito */
    .cart-container {
        width: 90%;
        padding: 20px;
        background-color: #333;
        color: white;
        border-radius: 8px;
    }

    .cart-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th,
    .cart-table td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #555;
    }

    .cart-product {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-product img {
        max-width: 100px;
        border-radius: 8px;
        margin-right: 10px;
    }

    .cart-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .cart-actions a {
        margin: 5px;
        color: white;
        text-decoration: none;
        background-color: black;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .cart-actions a:hover {
        background-color: orange;
    }

    .cart-summary {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding: 20px;
        background-color: #222;
        border-radius: 8px;
    }

    .cart-summary p {
        margin: 0;
    }

    .checkout-button {
        text-align: center;
    }

    .checkout-button button {
        padding: 10px 20px;
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .checkout-button button:hover {
        background-color: #218838;
    }

    .checkout-button .vaciarCarrito button {
        background-color: #dc3545;
    }   

    .checkout-button .vaciarCarrito button:hover {
        background-color: #c82333;
    }

    .error-message {
        text-align: center;
        color: white;
        margin-bottom: 20px;
        background-color: lightcoral; ;
        padding: 10px;
        border-radius: 8px;
        width: 30%;
        margin: 0 auto;
        margin-top: 10px;
    }

    .formatContainer {
        margin-top: 15px;
        margin-bottom: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 65vh;
    }
</style>


</style>
</head>

<section class="formatContainer">
    <section class="cart-container">
        <div id="cart" class="cart">
            <h1 class="cart-header">Carrito</h1>
            <?php if (isset($mensajesError)) : ?>
                <?php foreach ($mensajesError as $mensaje) : ?>
                    <p class="error-message"><?= $mensaje; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($_SESSION['carrito'])) : ?>
                        <tr>
                            <td colspan="6">No hay productos en el carrito</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($productos as $producto) : ?>
                            <tr>
                                <td>
                                    <div class="cart-product">
                                        <!-- <img src="<?= BASE_URL ?>public/img/productos/<?= ($producto['imagen']) ?>" alt="<?= ($producto['nombre']) ?>"> Ruta local -->
                                        <img src="<?= BASE_URL ?>img/productos/<?= ($producto['imagen']) ?>" alt="<?= ($producto['nombre']) ?>">
                                </td>
                                <td>
                                    <div class="cart-product">
                                        <div>
                                            <p><?= htmlspecialchars($producto['nombre']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p><?= htmlspecialchars($producto['precio']) ?>€</p>
                                </td>
                                <td>
                                    <p><?= htmlspecialchars($producto['stock']) ?></p>
                                </td>
                                <td>
                                    <div class="cart-actions">
                                        <a href="<?= BASE_URL ?>Carrito/sumarProductos/?id=<?= $producto['id'] ?>"> + </a>
                                        <span><?= htmlspecialchars($producto['cantidad']) ?></span>
                                        <a href="<?= BASE_URL ?>Carrito/restarProductos/?id=<?= $producto['id'] ?>"> - </a>
                                        <a href="<?= BASE_URL ?>Carrito/eliminarProducto/?id=<?= $producto['id'] ?>" class="remove-product">Eliminar producto</a>
                                    </div>
                                </td>
                                <td>
                                    <p><?= htmlspecialchars($producto['precio'] * $producto['cantidad']) ?>€</p>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php if (isset($_SESSION['error_carrito'])) : ?>
                    <p class="error-message"><?= htmlspecialchars($_SESSION['error_carrito']) ?></p>
                    <?php unset($_SESSION['error_carrito']); // Eliminar el mensaje después de mostrarlo 
                    ?>
                <?php endif; ?>
            <div class="cart-summary">
                
                
                <div class="total-info">
                    <?php if (empty($_SESSION['carrito'])) : ?>
                        <p>Total: <b>0€</b></p>
                        <p>Número de artículos: 0</p>
                    <?php else : ?>
                        <!-- <?php var_dump($_SESSION['carrito']); ?> -->
                        <p>Total: <b><?= htmlspecialchars($cantidadDinero) ?>€</b></p>
                        <p>Número de artículos: <?= htmlspecialchars($cantidadProductos) ?></p>
                    <?php endif; ?>
                </div>
                <div class="checkout-button">
                    <a class="vaciarCarrito" href="<?= BASE_URL ?>Carrito/vaciarCarrito">
                        <button>Vaciar Carrito</button>
                    </a>
                    <a href="<?= BASE_URL ?>Pedido/realizarPedido">
                        <button>Realizar Pedido</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
</section>