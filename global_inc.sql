-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2025 a las 20:04:27
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
-- Base de datos: `empresa1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` int(9) DEFAULT NULL,
  `fecha_alta` date DEFAULT curdate(),
  `zona` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`dni`, `nombre`, `apellido`, `telefono`, `fecha_alta`, `zona`) VALUES
('11111111A', 'Luis', 'Ruiz', 678987123, '2025-02-21', 1),
('22222222B', 'María', 'Sánchez', 687654321, '2025-02-21', 2),
('33333333C', 'Manuel', 'Pérez', 698745632, '2025-02-21', 3),
('44444444D', 'Laura', 'Díaz', 612345678, '2025-02-21', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correocorp`
--

CREATE TABLE `correocorp` (
  `cod_trabajador` int(3) NOT NULL,
  `user` varchar(50) NOT NULL,
  `passwd` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `correocorp`
--

INSERT INTO `correocorp` (`cod_trabajador`, `user`, `passwd`) VALUES
(1, 'cgo78A@globalinc.com', 'bcc67d8524948bbd873e4df12c89b182'),
(2, 'alo89B@globalinc.com', '5ee9f6327e32a2639fb7113b5b1e8e35'),
(3, 'pma90C@globalinc.com', 'b98f3525df988920fba80c7533a36ba1'),
(4, 'lfe01D@globalinc.com', '79d17f9576b1179c911f977fa509149a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `cod` int(3) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `cantidad` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`cod`, `descripcion`, `cantidad`) VALUES
(1, 'Ordenador portátil', 10),
(2, 'Teléfono móvil', 13),
(3, 'Tablet', 8),
(4, 'Audifonos', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `cod` int(2) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`cod`, `descripcion`) VALUES
(1, 'Efectivo'),
(2, 'Transferencia'),
(3, 'Tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `cod` int(3) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` int(9) DEFAULT NULL,
  `administer` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`cod`, `dni`, `nombre`, `apellido`, `telefono`, `administer`) VALUES
(1, '12345678A', 'Carlos', 'Gomez', NULL, 1),
(2, '23456789B', 'Juana', 'Lopez', 0, 0),
(3, '34567890C', 'Pedro', 'Martinez', 0, 1),
(4, '45678901D', 'Lucia', 'Fernandez', NULL, 0);

--
-- Disparadores `trabajadores`
--
DELIMITER $$
CREATE TRIGGER `generar_cuentas_auto` AFTER INSERT ON `trabajadores` FOR EACH ROW BEGIN
 
    INSERT INTO correoCorp (cod_trabajador, user, passwd)
    VALUES (
        NEW.cod,
        CONCAT(
            LOWER(SUBSTRING(NEW.nombre, 1, 1)),
            LOWER(SUBSTRING(NEW.apellido, 1, 2)),
            RIGHT(NEW.dni, 3),
            '@globalinc.com'
        ),
        md5(NEW.dni)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `cod` int(10) NOT NULL,
  `dni_cliente` varchar(9) DEFAULT NULL,
  `cod_trabajador` int(3) DEFAULT NULL,
  `cod_producto` int(3) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `cod_tipo_pago` int(10) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_venta` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`cod`, `dni_cliente`, `cod_trabajador`, `cod_producto`, `cantidad`, `cod_tipo_pago`, `monto`, `fecha_venta`) VALUES
(1, '11111111A', 1, 1, 0, 3, 899.99, '2025-02-21'),
(2, '22222222B', 2, 2, 0, 3, 599.50, '2025-02-21'),
(3, '33333333C', 3, 3, 0, 2, 299.99, '2025-02-21'),
(4, '11111111A', 2, 2, 0, 2, 154.00, '2025-02-24'),
(5, '11111111A', 2, 3, 2, 3, 1450.00, '2025-02-28');

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `actualizar_stock` BEFORE INSERT ON `ventas` FOR EACH ROW BEGIN
    IF (SELECT cantidad FROM productos WHERE cod = NEW.cod_producto) < NEW.cantidad THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Stock insuficiente';
    ELSE
        UPDATE productos 
        SET cantidad = cantidad - NEW.cantidad 
        WHERE cod = NEW.cod_producto;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `cod` int(2) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`cod`, `descripcion`) VALUES
(1, 'Sevilla'),
(2, 'Córdoba'),
(3, 'Granada'),
(4, 'Huelva');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`dni`),
  ADD KEY `zona` (`zona`);

--
-- Indices de la tabla `correocorp`
--
ALTER TABLE `correocorp`
  ADD PRIMARY KEY (`cod_trabajador`,`user`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`cod`),
  ADD KEY `dni_cliente` (`dni_cliente`),
  ADD KEY `cod_trabajador` (`cod_trabajador`),
  ADD KEY `cod_producto` (`cod_producto`),
  ADD KEY `cod_tipo_pago` (`cod_tipo_pago`);

--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`cod`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `cod` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `cod` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `cod` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`zona`) REFERENCES `zonas` (`cod`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `correocorp`
--
ALTER TABLE `correocorp`
  ADD CONSTRAINT `correocorp_ibfk_1` FOREIGN KEY (`cod_trabajador`) REFERENCES `trabajadores` (`cod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`dni_cliente`) REFERENCES `clientes` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`cod_trabajador`) REFERENCES `trabajadores` (`cod`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`cod_producto`) REFERENCES `productos` (`cod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_4` FOREIGN KEY (`cod_tipo_pago`) REFERENCES `tipo_pago` (`cod`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
