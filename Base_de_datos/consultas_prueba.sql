-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2024 a las 02:24:23
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
-- Base de datos: `sumzone`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `ID` int(11) NOT NULL,
  `ID_usuario` int(11) DEFAULT NULL,
  `tipo_consulta` enum('sugerencia','pregunta','solicitud') DEFAULT NULL,
  `texto_consulta` text DEFAULT NULL,
  `fecha_consulta` timestamp NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','respondida','resuelta') DEFAULT 'pendiente',
  `texto_respuesta` text DEFAULT NULL,
  `ID_usuario_respuesta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`ID`, `ID_usuario`, `tipo_consulta`, `texto_consulta`, `fecha_consulta`, `estado`, `texto_respuesta`, `ID_usuario_respuesta`) VALUES
(1, 1, 'sugerencia', 'hagan mas torneos de futbol', '2024-11-10 00:11:54', 'pendiente', NULL, NULL),
(2, 1, 'solicitud', 'quiero jugar basquet mañana con mis amigos', '2024-11-10 00:13:54', '', 'porque no funtiona', NULL),
(3, 1, 'pregunta', 'cuando habre el sum?', '2024-11-10 00:14:05', '', 'mañana', NULL),
(4, 1, 'pregunta', 'cuando habre el sum?', '2024-11-10 00:16:14', '', 'a', NULL),
(5, 1, 'sugerencia', 'asd', '2024-11-10 00:16:37', 'pendiente', NULL, NULL),
(6, 1, 'sugerencia', 'asd', '2024-11-10 00:18:39', '', 'a', NULL),
(7, 1, 'sugerencia', 'asd', '2024-11-10 00:20:15', '', 'muy mal', NULL),
(8, 1, 'solicitud', 'dddddd', '2024-11-10 00:20:19', 'pendiente', NULL, NULL),
(9, 1, 'sugerencia', 'simon', '2024-11-10 00:21:26', 'pendiente', NULL, NULL),
(10, 1, 'sugerencia', 'sdfdsffds', '2024-11-10 00:24:28', 'pendiente', NULL, NULL),
(11, 1, 'solicitud', 'no sirve xd', '2024-11-10 00:24:51', 'pendiente', NULL, NULL),
(12, 1, 'sugerencia', 'sisisi', '2024-11-10 00:27:43', 'pendiente', NULL, NULL),
(13, 1, 'sugerencia', 'sss', '2024-11-10 00:59:11', 'pendiente', NULL, NULL),
(14, 1, 'pregunta', 'ssdf', '2024-11-10 00:59:14', 'pendiente', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_usuario` (`ID_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuario` (`ID_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
