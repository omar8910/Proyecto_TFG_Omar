-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2025 a las 22:28:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
-- Estructura de tabla para la tabla `carritos`
--
-- Creación: 11-06-2025 a las 19:20:09
--

DROP TABLE IF EXISTS `carritos`;
CREATE TABLE IF NOT EXISTS `carritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id` (`usuario_id`,`producto_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `carritos`:
--   `usuario_id`
--       `usuarios` -> `id`
--   `producto_id`
--       `productos` -> `id`
--

--
-- Truncar tablas antes de insertar `carritos`
--

TRUNCATE TABLE `carritos`;
--
-- Volcado de datos para la tabla `carritos`
--

INSERT INTO `carritos` (`id`, `usuario_id`, `producto_id`, `cantidad`, `creado_en`) VALUES
(37, 1, 6, 1, '2025-06-12 00:13:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--
-- Creación: 04-06-2025 a las 22:36:52
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELACIONES PARA LA TABLA `categorias`:
--

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
(3, 'Accesorios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--
-- Creación: 04-06-2025 a las 22:36:52
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELACIONES PARA LA TABLA `lineas_pedidos`:
--   `pedido_id`
--       `pedidos` -> `id`
--   `producto_id`
--       `productos` -> `id`
--

--
-- Truncar tablas antes de insertar `lineas_pedidos`
--

TRUNCATE TABLE `lineas_pedidos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--
-- Creación: 04-06-2025 a las 22:36:53
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELACIONES PARA LA TABLA `pedidos`:
--   `usuario_id`
--       `usuarios` -> `id`
--

--
-- Truncar tablas antes de insertar `pedidos`
--

TRUNCATE TABLE `pedidos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--
-- Creación: 04-06-2025 a las 22:36:53
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELACIONES PARA LA TABLA `productos`:
--   `categoria_id`
--       `categorias` -> `id`
--

--
-- Truncar tablas antes de insertar `productos`
--

TRUNCATE TABLE `productos`;
--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(1, 2, 'PcCom Work AMD Ryzen 7 5700G/16GB/500GB SSD', 'Potente ordenador gaming', 649.00, 10, NULL, '2024-06-17', 'Ordenador1.webp'),
(2, 2, 'PcCom Ready AMD Ryzen 7 5800X / 32GB / 1TB SSD / RTX 4060 Ti ', 'Ordenador de gama media/alta bastante potente', 1359.00, 10, NULL, '2024-06-17', 'Ordenador2.webp'),
(3, 2, 'PcCom Studio Intel Core i7-14700KF / 32GB / 2TB SSD / RTX 4070 Super', 'Ordenador de gama alta, muy potente para jugar y editar videos', 2299.00, 10, NULL, '2024-06-17', 'Ordenador3.webp'),
(4, 1, 'Apple iPhone 12 256GB Verde Libre', 'Iphone de nueva generacion', 589.00, 10, NULL, '2024-06-17', 'movil1.webp'),
(5, 1, 'Samsung Galaxy A34 5G 8/256GB Negro Libre + Protector Pantalla', 'Un movil potente que incluye protector de pantalla', 269.00, 10, NULL, '2024-06-17', 'movil2.webp'),
(6, NULL, 'MPN MKR-05 Rebanadora 150W Blanca', 'Para que puedas rebanar bien tus panes', 25.00, 20, NULL, '2024-06-17', 'Electrodomestico2.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
-- Creación: 04-06-2025 a las 22:36:53
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- RELACIONES PARA LA TABLA `usuarios`:
--

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', '$2y$10$/UGRhxZ8OXoNIeILTHJ.Gu.EgTPPj1SAwlbTTOi1HcI/237WlIzD6', 'administrador');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `carritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `carritos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

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
