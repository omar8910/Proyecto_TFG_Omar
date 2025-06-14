<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos de la categoría <?= $categoria['nombre'] ?></title>
    <style>
        section {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #333;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 28px;
            color: #fff;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .product {
            background-color: #444;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product img {
            width: 50%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product .imgContainer {
            display: flex;
            justify-content: center;
        }

        .product h2 {
            font-size: 20px;
            color: #fff;
            margin-bottom: 10px;
        }

        .product p {
            font-size: 16px;
            color: #ccc;
            margin-bottom: 8px;
            flex-grow: 1;
        }

        .product p.price {
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 20px;
        }

        .product a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .product a:hover {
            background-color: orange;
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
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .mini-menu a:hover {
            background-color: coral;
        }

        .no-products {
            text-align: center;
            margin-top: 50px;
            background-color: #444;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .no-products h2 {
            font-size: 24px;
            color: #fff;
            margin-bottom: 10px;
        }

        .no-products p {
            font-size: 18px;
            color: #ccc;
        }

        .no-products img {
            max-width: 300px;
            height: auto;
            margin-top: 20px;
            border-radius: 8px;
        }

        .contentContainer {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>

<body>
    <section>
        <div class="mini-menu">
            <?php foreach ($menu as $categoria_menu) : ?>
                <a href="<?= BASE_URL ?>Categoria/verCategoria/?id=<?= $categoria_menu['id'] ?>">
                    <?= ($categoria_menu['nombre']) ?>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="contentContainer">
            <h1>
                <?php if (!empty($categoria)) : ?>
                    Productos de la categoría <?= ($categoria["nombre"]) ?>
                <?php else : ?>
                    Categoría no encontrada
                <?php endif; ?>
            </h1>

            <?php if (empty($productos)) : ?>
                <div class="no-products">
                    <h2>No se añadieron productos a esta categoría</h2>
                    <p>Lo sentimos.</p>
                    <img src="<?= BASE_URL ?>public/img/sin_productos/oos.png" alt="No hay productos">
                </div>
            <?php else : ?>
                <div class="product-container">
                    <?php foreach ($productos as $producto) : ?>
                        <div class="product">
                            <div class="imgContainer">
                                <img src="<?= BASE_URL ?>public/img/productos/<?= ($producto["imagen"]) ?>" alt="<?= ($producto["nombre"]) ?>">
                            </div>
                            <h2><?= ($producto["nombre"]) ?></h2>
                            <p><?= ($producto["descripcion"]) ?></p>
                            <p class="price">Precio: $<?= number_format($producto["precio"], 2) ?></p>
                            <a href="<?= BASE_URL ?>Producto/verProducto/?id=<?= $producto['id'] ?>">Ver detalles</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>