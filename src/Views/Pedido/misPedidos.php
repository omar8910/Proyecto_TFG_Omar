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
        text-align: left;
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

<section class="orders-container">
    <h1>Mis Pedidos</h1>
    <?php if (isset($_SESSION['inicioSesion']) && $pedidos >= 1) : ?>
        <table>
            <tr>
                <th>Id</th>
                <th>Coste</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol == 'administrador') : ?>
                    <th>Confirmar Pedido</th>
                <?php endif; ?>
            </tr>
            <?php foreach ($pedidos as $pedido) : ?>
                <tr>
                    <td><a href="<?= BASE_URL ?>Pedido/verPedido/?id=<?= $pedido['id'] ?>"><?= $pedido['id'] ?></a></td>
                    <td><?= $pedido['coste'] ?>€</td>
                    <td><?= $pedido['fecha'] ?></td>
                    <td><?= $pedido['hora'] ?></td>
                    <td><?= $pedido['estado'] ?></td>
                    <?php if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol == 'administrador') : ?>
                        <td><a href="<?= BASE_URL ?>Administrador/gestionarPedidos">Confirmar pedido</i></a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <strong class="alert_red">No has realizado ningun pedido</strong>
    <?php endif; ?>
</section>