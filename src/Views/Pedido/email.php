<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #27ae60;
        }

        p {
            margin: 10px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>¡Su pedido ha sido confirmado!</h1>
        <p>Estimado(a) <?php echo htmlspecialchars($nombre); ?>,</p>
        <p>El reparto estimado de su pedido será de 1 a 7 días hábiles</p>
        <p>
            <strong>Nota:</strong> Los plazos de entrega pueden variar dependiendo de la disponibilidad de los productos y la zona de envío.
        </p>
        </p>Gracias por confiar en nosotros.</p>
        <p>Detalles del envío:</p>
        <ul>
            <li>ID del pedido: <?php echo htmlspecialchars($id_pedido); ?></li>
            <li>Fecha del pedido: <?php echo htmlspecialchars($fecha) . " a las " . htmlspecialchars($hora); ?></li>
        </ul>
        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>


            </tr>
            <?php $total = 0; ?>
            <?php foreach ($productos as $producto) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['unidades']); ?></td>
                    <td><?php echo htmlspecialchars($producto['precio']); ?> €</td>
                    <td><?php echo htmlspecialchars($producto['precio'] * $producto['unidades']); ?> €</td>
                </tr>
                <?php $total += $producto['precio'] * $producto['unidades']; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong><?php echo $total; ?> €</strong></td>
            </tr>
        </table>
        <p class="footer">Vuestra tienda de confianza,<br>
            PC Componentes Omar</p>
    </div>
</body>

</html>