<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda PCComponentes</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/styles.css">
    <style>
        /* Estilos header */
        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #ffffff;
        }

        .logo img {
            max-width: 150px;
        }

        nav {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
        }

        .nav-links,
        .user-links {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-links li,
        .user-links li {
            margin: 0 15px;
        }

        .nav-links li a,
        .user-links li a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-links li a:hover,
        .user-links li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .user-info {
            font-weight: bold;
            color: orange;
        }

        /* Menu desplegable */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Estilos responsive */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            .nav-links,
            .user-links {
                flex-direction: column;
                align-items: center;
            }

            .nav-links li,
            .user-links li {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="https://cdn.pccomponentes.com/img/logos/logo-pccomponentes.png" alt="Logo">
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                <?php if (isset($_SESSION['inicioSesion']) && is_object($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'administrador') : ?>
                    <div class="dropdown">
                        <li><a href="#">Administrar</a></li>
                        <div class="dropdown-content">
                            <a href="<?= BASE_URL ?>Administrador/mostrarUsuarios">Usuarios</a>
                            <a href="<?= BASE_URL ?>Administrador/gestionarCategorias">Gestionar categorías</a>
                            <a href="<?= BASE_URL ?>Administrador/gestionarProductos">Gestionar productos</a>
                            <a href="<?= BASE_URL ?>Administrador/gestionarPedidos">Gestionar pedidos</a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!isset($_SESSION['inicioSesion']) || $_SESSION['inicioSesion'] === 'incorrecto') : ?>
                    <li><a href="<?= BASE_URL ?>Usuario/iniciarSesion">Iniciar sesión</a></li>
                    <li><a href="<?= BASE_URL ?>Usuario/registrarUsuarios">Registro</a></li>
                    <li><a href="<?= BASE_URL ?>Carrito/verCarrito">Carrito: <?= isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0 ?></a></li>


                <?php endif; ?>
            </ul>
            <ul class="user-links">
                <?php if (isset($_SESSION['inicioSesion']) && is_object($_SESSION['inicioSesion']) && $_SESSION['inicioSesion'] !== 'incorrecto') : ?>
                    <li><a href="<?= BASE_URL ?>Pedido/misPedidos">Mis pedidos</a></li>
                    <li><a href="<?= BASE_URL ?>Carrito/verCarrito">Carrito: <?= isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0 ?></a></li>
                    <li class="user-info">Usuario: <?= $_SESSION['inicioSesion']->nombre . " " . $_SESSION['inicioSesion']->apellidos ?></li>
                    <li><a href="<?= BASE_URL ?>Usuario/editarPerfil">Editar perfil</a></li>
                    <li><a href="<?= BASE_URL ?>Usuario/cerrarSesion">Cerrar sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>

</html>