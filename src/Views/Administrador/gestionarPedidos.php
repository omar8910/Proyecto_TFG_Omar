<style>
    .admin-section {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        background-color: #333;
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .admin-section h1 {
        color: #ff9900;
        text-align: center;
    }

    .error-message {
        color: #ff4c4c;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #555;
    }

    th {
        background-color: #444;
        color: #ff9900;
        text-align: center;
    }

    tr:nth-child(even) {
        background-color: #444;
    }

    .alert_red {
        color: #ff4c4c;
        font-weight: bold;
        text-align: center;
        display: block;
        margin-top: 20px;
    }

    .action-links a {
        margin-right: 10px;
        color: #ff9900;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .action-links a:hover {
        color: #ffd700;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    input[type="submit"] {
        padding: 8px 16px;
        background-color: #ff9900;
        color: white;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #ffd700;
    }

    a {
        text-decoration: none;
        color: #ff9900;
    }

    td {
        text-align: center;
    }

    .adminContainer {
        min-height: 65vh;
        padding: 20px;
    }
</style>

<?php if (($_SESSION['inicioSesion']->rol === 'administrador') && (isset($_SESSION['inicioSesion']))) : ?>

    <div class="adminContainer">
        <section class="admin-section">
            <h1>Gestionar Pedidos</h1>

            <?php if (isset($mensajesError)) : ?>
                <?php foreach ($mensajesError as $mensaje) : ?>
                    <p class="error-message"><?= htmlspecialchars($mensaje); ?></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['inicioSesion']) && $pedidos >= 1) : ?>
                <table>
                    <thead>
                        <th>Id</th>
                        <th>Coste</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>ID Usuario</th>
                        <th colspan="4">Acciones</th>
                    </thead>
                    <?php foreach ($pedidos as $pedido) : ?>
                        <tr>
                            <td><?= htmlspecialchars($pedido['id']) ?></td>
                            <td><?= htmlspecialchars($pedido['coste']) ?>€</td>
                            <td><?= htmlspecialchars($pedido['fecha']) ?></td>
                            <td><?= htmlspecialchars($pedido['hora']) ?></td>
                            <td><?= htmlspecialchars($pedido['estado']) ?></td>
                            <td><?= htmlspecialchars($pedido['usuario_id']) ?></td>
                            <?php if ($pedido['estado'] === 'Pendiente a confirmar') : ?>
                                <td><a href="<?= BASE_URL ?>Administrador/confirmarPedido/?id=<?= $pedido['id'] ?>">Confirmar pedido</a></td>
                            <?php elseif ($pedido['estado'] === 'Cancelado') : ?>
                                <td>El pedido ya ha sido cancelado</td>
                            <?php else: ?>
                                <td>El pedido ya ha sido confirmado</td>
                            <?php endif; ?>

                            <?php if ($pedido['estado'] !== 'Cancelado') : ?>
                                <td><a href="<?= BASE_URL ?>Administrador/cancelarPedido/?id=<?= $pedido['id'] ?>">Cancelar pedido</a></td>
                            <?php else : ?>
                                <td>El pedido ya ha sido cancelado</td>
                            <?php endif; ?>

                            <td class="action-links">
                                <?php if ($pedido['estado'] === 'Pendiente a confirmar') : ?>
                                    <a href="<?= BASE_URL ?>Administrador/eliminarPedido/?id=<?= $pedido['id']; ?>">Eliminar</a>
                                <?php else: ?>
                                    <p>No se pueden realizar operaciones</p>
                                <?php endif; ?>
                            </td>

                            <td class="action-links">
                                <a href="<?= BASE_URL ?>Pedido/verPedido/?id=<?= $pedido['id'] ?>">Ver Pedido</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <strong class="alert_red">No tienes pedidos</strong>
            <?php endif; ?>
        </section>
    </div>

<?php else : ?>
    <h2>No tienes permiso para entrar en esta página</h2>
<?php endif; ?>