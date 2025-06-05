-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2025 a las 02:14:45
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
-- Base de datos: `login`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
(1, 'holax', '$2y$10$ePsDb.ETnG1/BAZWfQJM2OIhtMSbWJcq/CxIzJwmhr4c12BeoI/N.'),
(2, 'mariano', '$2y$10$ZFDzbWJNlxeeYhdIvhGQNOLfzw/PfQ0V7XQWyEjV/XW7YfFsKw7Wy'),
(3, 'franco', '$2y$10$JG3jrs9tXXYB9lbTjsc9R.uCNfeF/qXRctKH1rzaL/95H213cpBta'),
(4, 'holaxrr', '$2y$10$FT5yN.o6Ru/rKu0MPlBrcOK8farcSep1qCz.EQOt5I24F2NVhnqY6'),
(5, 'carlos', '$2y$10$H9pAr5ZcFdithmFOyE25teMzQIWegyMVye1MkrO5Q6941cp2zyGPa'),
(6, 'agus', '$2y$10$FyNwlmxRFyaXSrcKiwhXxedjlQ2cV7blLe3HGR/ukIIsmqC4MTsTS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
