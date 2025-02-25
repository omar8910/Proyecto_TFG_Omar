-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2025 a las 14:39:13
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendaomar`
--
CREATE DATABASE IF NOT EXISTS `tiendaomar` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tiendaomar`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--
-- Creación: 25-02-2025 a las 13:37:37
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncar tablas antes de insertar `categorias`
--

TRUNCATE TABLE `categorias`;
--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Móviles'),
(2, 'Ordenadores'),
(4, 'Accesorios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--
-- Creación: 25-02-2025 a las 13:37:38
--

DROP TABLE IF EXISTS `lineas_pedidos`;
CREATE TABLE IF NOT EXISTS `lineas_pedidos` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(255) NOT NULL,
  `producto_id` int(255) NOT NULL,
  `unidades` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_linea_pedido` (`pedido_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncar tablas antes de insertar `lineas_pedidos`
--

TRUNCATE TABLE `lineas_pedidos`;
--
-- Volcado de datos para la tabla `lineas_pedidos`
--

INSERT INTO `lineas_pedidos` (`id`, `pedido_id`, `producto_id`, `unidades`) VALUES
(11, 29, 44, 1),
(12, 30, 42, 1),
(13, 31, 44, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--
-- Creación: 25-02-2025 a las 13:37:38
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(255) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `coste` float(200,2) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncar tablas antes de insertar `pedidos`
--

TRUNCATE TABLE `pedidos`;
--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `provincia`, `localidad`, `direccion`, `coste`, `estado`, `fecha`, `hora`) VALUES
(29, 59, 'Granada', 'Maracena', 'Calle Managua', 25.00, 'confirmado', '2024-06-17', '03:31:45'),
(30, 59, 'Maracen', 'Granada', 'calle managua', 269.00, 'confirmado', '2024-06-17', '14:04:19'),
(31, 59, 'Granada', 'Maracena', 'Calle Managua', 25.00, 'confirmado', '2024-06-17', '14:09:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--
-- Creación: 25-02-2025 a las 13:37:38
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(255) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` float(100,2) NOT NULL,
  `stock` int(255) NOT NULL,
  `oferta` varchar(2) DEFAULT NULL,
  `fecha` date DEFAULT current_timestamp(),
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncar tablas antes de insertar `productos`
--

TRUNCATE TABLE `productos`;
--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(37, 1, 'PcCom Work AMD Ryzen 7 5700G/16GB/500GB SSD', 'Potente ordenador gaming', 649.00, 10, NULL, '2024-06-17', 'Ordenador1.webp'),
(38, 2, 'PcCom Ready AMD Ryzen 7 5800X / 32GB / 1TB SSD / RTX 4060 Ti ', 'Ordenador de gama media/alta bastante potente', 1359.00, 5, NULL, '2024-06-17', 'Ordenador2.webp'),
(39, 2, 'PcCom Studio Intel Core i7-14700KF / 32GB / 2TB SSD / RTX 4070 Super', 'Ordenador de gama alta, muy potente para jugar y editar videos', 2299.00, 3, NULL, '2024-06-17', 'Ordenador3.webp'),
(41, NULL, 'Apple iPhone 12 256GB Verde Libre', 'Iphone de nueva generacion', 589.00, 20, NULL, '2024-06-17', 'movil1.webp'),
(42, 1, 'Samsung Galaxy A34 5G 8/256GB Negro Libre + Protector Pantalla', 'Un movil potente que incluye protector de pantalla', 269.00, 9, NULL, '2024-06-17', 'movil2.webp'),
(44, NULL, 'MPN MKR-05 Rebanadora 150W Blanca', 'Para que puedas rebanar bien tus panes', 25.00, 23, NULL, '2024-06-17', 'Electrodomestico2.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
-- Creación: 25-02-2025 a las 13:37:38
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`) VALUES
(59, 'Omar', 'AlSarsour', 'omarqneiby@gmail.com', '$2y$10$pmeiEbdA7phvuamK/CF1dup7MEZ0Cl38JPAyeYzaGjt63EOiddpXW', 'administrador');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `fk_linea_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `lineas_pedidos_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
