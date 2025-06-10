-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2025 a las 21:25:21
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
-- Base de datos: `escueladb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `pk_alumno` int(255) NOT NULL,
  `n_legajo` int(255) NOT NULL,
  `dni` int(255) NOT NULL,
  `curso` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`pk_alumno`, `n_legajo`, `dni`, `curso`) VALUES
(1, 8, 0, 5),
(2, 2, 50016634, 1),
(3, 1, 50123526, 2),
(4, 9, 50123652, 8),
(5, 0, 0, 0),
(6, 7, 49016784, 1),
(7, 4, 49016777, 45),
(8, 12, 49011234, 455),
(9, 4545, 49099934, 88),
(10, 123123, 49016969, 7787),
(11, 0, 0, 123),
(12, 0, 0, 0),
(13, 2147483647, 0, 0),
(14, 0, 0, 0),
(15, 0, 0, 0),
(16, 15, 0, 0),
(17, 0, 0, 70000000),
(18, 0, 0, 70000000),
(19, 0, 0, 70000000),
(20, 123, 1414214214, 2147483647);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`pk_alumno`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `pk_alumno` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
