<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <style>
        .product-detail {
            max-width: 600px;
            margin: 20px auto;
            background-color: #444;
            /* Fondo más claro para destacar los detalles */
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .product-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .product-detail h2 {
            font-size: 24px;
            color: #fff;
            /* Texto blanco */
            margin-bottom: 10px;
            text-align: center;
        }

        .product-detail p {
            font-size: 18px;
            color: #ccc;
            /* Texto gris claro */
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .product-detail p.price {
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            /* Texto blanco */
            text-align: center;
            margin-bottom: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            /* Texto blanco */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-link a:hover {
            background-color: orange;
            /* Cambia el color al pasar el mouse */
        }

        .containerProducto{
            min-height: 65vh;
        }
    </style>
</head>

<body>
    <div class="containerProducto">
        <div class="product-detail">
            <img src="<?= BASE_URL ?>public/img/productos/<?= $producto['imagen'] ?>" alt="<?= ($producto["nombre"]) ?>">
            <h2><?= ($producto["nombre"]) ?></h2>
            <p>Descripcion: <?= ($producto["descripcion"]) ?></p>
            <p>Stock: <?= ($producto["stock"]) ?></p>
            <p class="price">Precio: <?= number_format($producto["precio"], 2) . " €" ?></p>
            <div class="back-link">
                <a href="<?= BASE_URL ?>">Volver a la lista de productos</a>
                <a href="<?= BASE_URL ?>Carrito/agregarProducto/?id=<?= $producto['id'] ?>">Agregar al carrito</a>
            </div>
        </div>
    </div>
</body>

</html>