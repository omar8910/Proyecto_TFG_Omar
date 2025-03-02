<style>
    .pedido-details {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #333;
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .pedido-details h1 {
        text-align: center;
        color: #ff9900;
    }

    .pedido-details h3 {
        margin-top: 20px;
        color: #ff9900;
        font-style: italic;
    }

    .pedido-details p {
        margin: 5px 0;
        font-style: italic;
    }

    .pedido-details table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .pedido-details th,
    .pedido-details td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #555;
    }

    .pedido-details th {
        background-color: #444;
        color: #ff9900;
    }

    .btn {
        display: block;
        text-decoration: none;
        width: 100px;
        margin: 20px auto;
        padding: 10px;
        text-align: center;
        background-color: #ff9900;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #ffd700;
    }

    .pedidoContainer {
        min-height: 65vh;
    }
</style>

<div class="pedidoContainer">
    <section class="pedido-details">
        <h1>Detalles del Pedido #<?= $pedido['id'] ?></h1>

        <!-- Mostrar información del usuario -->
        <h3>Información del Usuario:</h3>
        <p><strong>Id de usuario:</strong> <?= htmlspecialchars($pedido['usuario_id']) ?></p>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($pedido['nombre_usuario']) ?></p>
        <p><strong>Correo:</strong> <?= htmlspecialchars($pedido['correo_usuario']) ?></p>

        <!-- Tabla de productos del pedido -->
        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
            <?php
            $totalPedido = 0; // Inicializamos la variable para almacenar el total del pedido
            foreach ($productos as $producto) :
                $totalProducto = $producto['precio'] * $producto['unidades']; // Calculamos el total por producto
                $totalPedido += $totalProducto; // Sumamos al total del pedido
            ?>
                <tr>
                    <td><?= htmlspecialchars($producto['nombre']) ?></td>
                    <td><?= htmlspecialchars($producto['unidades']) ?></td>
                    <td><?= htmlspecialchars($producto['precio']) ?>€</td>
                    <td><?= htmlspecialchars($totalProducto) ?>€</td>
                </tr>
            <?php endforeach; ?>
            <!-- Fila para mostrar el total del pedido -->
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total del Pedido:</strong></td>
                <td><strong><?= htmlspecialchars($totalPedido) ?>€</strong></td>
            </tr>
        </table>

        <!-- Botón para volver -->
        <button class="btn" onclick="history.back()">Volver</button>
    </section>
</div>