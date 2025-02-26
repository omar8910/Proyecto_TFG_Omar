<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Destacados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #111;
            /* Fondo oscuro */
            color: #fff;
            /* Texto en blanco para contrastar con el fondo oscuro */
        }

        section {
            max-width: 800px;
            margin: 20px auto;
            background-color: #333;
            /* Fondo más claro para destacar los productos */
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 28px;
            color: #fff;
            /* Texto blanco */
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product {
            background-color: #444;
            /* Fondo de los productos */
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            /* Centra el contenido dentro del producto */
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product h2 {
            font-size: 20px;
            color: #fff;
            /* Texto blanco */
            margin-bottom: 10px;
        }

        .product p {
            font-size: 16px;
            color: #ccc;
            /* Texto gris claro */
            margin-bottom: 8px;
        }

        .product p.price {
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            /* Texto blanco */
        }

        .product a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            /* Color azul para el botón */
            color: #fff;
            /* Texto blanco */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .product a:hover {
            background-color: orange;
            /* Cambia el color al pasar el mouse */
        }

        .mini-menu {
            display: flex;
            justify-content: space-evenly;
            margin-bottom: 20px;
            text-align: center;
        }

        .mini-menu a {
            padding: 10px 15px;
            margin: 0 5px;
            background-color: black;
            /* Color azul */
            color: #fff;
            /* Texto blanco */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .mini-menu a:hover {
            background-color: coral;
            /* Color azul oscuro al pasar el mouse */
        }
    </style>
</head>

<body>

    <section>
        <div class="mini-menu">
            <?php foreach ($categorias as $categoria) : ?>
                <a href="<?= BASE_URL ?>Categoria/verCategoria/?id=<?= $categoria['id'] ?>">
                    <?= ($categoria['nombre']) ?>
                </a>
            <?php endforeach; ?>
        </div>
        <h1>Productos Destacados</h1>
        <div class="product-container">
            <?php foreach ($productos as $producto) : ?>
                <div class="product">
                    <img src="<?= BASE_URL ?>public/img/productos/<?= ($producto["imagen"]) ?>" alt="<?= ($producto["nombre"]) ?>">
                    <h2><?= ($producto["nombre"]) ?></h2>
                    <p><?= ($producto["descripcion"]) ?></p>
                    <p class="price">Precio: $<?= number_format($producto["precio"], 2) ?></p>
                    <a href="<?= BASE_URL ?>Producto/verProducto/?id=<?= $producto['id'] ?>">Ver detalles</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</body>

</html>