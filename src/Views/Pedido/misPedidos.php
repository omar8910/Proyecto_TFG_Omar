<style>
    /* Estilos para la sección de mis pedidos */
    .orders-container {
        max-width: 1000px;
        margin: 20px auto;
        padding: 20px;
        background-color: #333;
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* min-height: 65vh; */
    }

    .orders-container h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2em;
        color: #ff9900;
    }

    .orders-container table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .orders-container th,
    .orders-container td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #555;
    }

    .orders-container th {
        background-color: #444;
        color: #ff9900;
    }

    .orders-container td a {
        color: #ff9900;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .orders-container td a:hover {
        color: #ffd700;
    }

    .orders-container .alert_red {
        color: #ff4c4c;
        font-weight: bold;
        text-align: center;
        display: block;
        margin-top: 20px;
    }

    .orders-containerFormat {
        min-height: 65vh;
    }

    .no-pedidos-message {
        text-align: center;
        /* Centrar horizontalmente */
        margin: 50px auto;
        /* Centrar verticalmente y dar espacio */
        padding: 20px;
        /* Espaciado interno */
        font-size: 1.5em;
        /* Tamaño de fuente */
        color: orange;
        /* Color del texto */
        font-weight: bold;
        /* Texto en negrita */
        background-color: #444;
        /* Fondo oscuro */
        border-radius: 10px;
        /* Bordes redondeados */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Sombra suave */
        max-width: 400px;
        /* Ancho máximo del mensaje */
    }

    @media (max-width: 768px) {

        .orders-container th,
        .orders-container td {
            padding: 10px;
        }

        .orders-container h1 {
            font-size: 1.5em;
        }
    }
</style>
<div class="orders-containerFormat">
    <section class="orders-container">
        <h1>Mis Pedidos</h1>
        <?php if (isset($_SESSION['inicioSesion']) && !empty($pedidos)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Coste</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th colspan="2">Acciones</th>
                        <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol == 'administrador') : ?>
                            <th>Confirmar Pedido</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido) : ?>
                        <tr>
                            <td><?= $pedido['id'] ?></td>
                            <td><?= $pedido['coste'] ?>€</td>
                            <td><?= $pedido['fecha'] ?></td>
                            <td><?= $pedido['hora'] ?></td>
                            <td><?= $pedido['estado'] ?></td>
                            <td><a href="<?= BASE_URL ?>Pedido/verPedido/?id=<?= $pedido['id'] ?>">Ver Pedido</a></td>
                            <td class="action-links">
                                <a href="<?= BASE_URL ?>Pedido/eliminarPedido/?id=<?= $pedido['id']; ?>">Eliminar</a>
                            </td>
                            <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol == 'administrador') : ?>
                                <?php if ($pedido['estado'] != 'Cancelado') : ?>
                                    <td><a href="<?= BASE_URL ?>Administrador/confirmarPedido/?id=<?= $pedido['id'] ?>">Confirmar pedido</a></td>
                                <?php else : ?>
                                    <td>No se puede confirmar un pedido cancelado</td>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="no-pedidos-message">
                No has realizado ningún pedido
            </div>
        <?php endif; ?>
    </section>
</div>