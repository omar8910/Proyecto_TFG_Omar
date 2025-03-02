<style>
    /* Estilos para la sección de detalles del pedido */
    .order-details-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #333;
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .order-details-container h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2em;
        color: #ff9900;
    }

    .order-details-container h3 {
        text-align: center;
        margin-bottom: 20px;
        color: #ccc;
    }

    .error-message {
        background-color: #ff4c4c;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .error-message p {
        margin: 0;
    }

    .order-details-container form {
        display: flex;
        flex-direction: column;
    }

    .order-details-container label {
        margin: 10px 0 5px;
        font-weight: bold;
    }

    .order-details-container input[type="text"],
    .order-details-container input[type="submit"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .order-details-container input[type="text"] {
        background-color: #444;
        color: white;
    }

    .order-details-container input[type="submit"] {
        background-color: #28a745;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .order-details-container input[type="submit"]:hover {
        background-color: #218838;
    }
</style>
</head>

<body>
    <section class="order-details-container">
        <h1>Detalles del pedido</h1>
        <h3>Introduce tus datos para realizar el pedido</h3>
        <?php if (isset($mensajesError) && count($mensajesError) > 0) : ?>
            <div class="error-message">
                <?php foreach ($mensajesError as $mensaje) : ?>
                    <p><?= $mensaje ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="<?= BASE_URL ?>Pedido/crearPedido" method="POST">
            <label for="provincia">Provincia</label>
            <input type="text" name="provincia" required>

            <label for="localidad">Localidad</label>
            <input type="text" name="localidad" required>

            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" required>

            <input type="submit" value="Confirmar Pedido">
        </form>
    </section>