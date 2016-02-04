-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2015 a las 22:53:45
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `fotaza`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE IF NOT EXISTS `comentario` (
  `Co_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Co_Detalle` text COLLATE utf8_spanish_ci NOT NULL,
  `Co_FechaCreacion` datetime NOT NULL,
  `P_ID_Contiene` int(11) NOT NULL,
  `U_ID_Realiza` int(11) NOT NULL,
  PRIMARY KEY (`Co_ID`),
  KEY `U_ID_Realiza` (`U_ID_Realiza`),
  KEY `P_ID_Contiene` (`P_ID_Contiene`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`Co_ID`, `Co_Detalle`, `Co_FechaCreacion`, `P_ID_Contiene`, `U_ID_Realiza`) VALUES
(1, 'que lindo zapato', '2015-10-09 00:00:00', 2, 2),
(3, 'que lindo!!!', '2015-10-28 00:00:00', 2, 5),
(4, 'excelente...', '2015-11-02 00:00:00', 2, 5),
(5, 'perfecto, como me gusta!', '2015-11-02 05:11:54', 2, 6),
(6, 'genial', '2015-11-02 05:22:37', 2, 6),
(7, 'ppppp', '2015-11-02 01:24:24', 2, 6),
(8, 'eeeee', '2015-11-02 01:25:32', 2, 6),
(9, 'pepepe', '2015-11-03 22:26:01', 2, 2),
(10, 'me gusta', '2015-11-04 00:50:50', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denuncia`
--

CREATE TABLE IF NOT EXISTS `denuncia` (
  `D_ID` int(11) NOT NULL AUTO_INCREMENT,
  `D_Motivo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `D_Argumento` text COLLATE utf8_spanish_ci NOT NULL,
  `U_ID_Hace` int(11) NOT NULL,
  `P_ID_EnEl` int(11) NOT NULL,
  PRIMARY KEY (`D_ID`),
  KEY `U_ID_Hace` (`U_ID_Hace`),
  KEY `P_ID_EnEl` (`P_ID_EnEl`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `denuncia`
--

INSERT INTO `denuncia` (`D_ID`, `D_Motivo`, `D_Argumento`, `U_ID_Hace`, `P_ID_EnEl`) VALUES
(17, 'Contenido vulgar', 'Malas palabras', 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiqueta`
--

CREATE TABLE IF NOT EXISTS `etiqueta` (
  `E_ID` int(11) NOT NULL AUTO_INCREMENT,
  `E_Detalle` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`E_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `etiqueta`
--

INSERT INTO `etiqueta` (`E_ID`, `E_Detalle`) VALUES
(1, 'zapato'),
(2, 'negro'),
(3, 'formulario'),
(4, 'php'),
(5, 'soda'),
(6, 'musica'),
(7, 'bootstrap'),
(8, 'curso'),
(9, 'pollo'),
(10, 'disco'),
(11, 'ttt'),
(12, 'ee'),
(13, 'lasfjdjn'),
(14, 'xml'),
(15, 'sos'),
(16, 'Tutorial'),
(17, 'menÃº'),
(18, 'Musica'),
(19, 'Depeche Mode'),
(20, 'ecografia'),
(21, 'bebe'),
(22, 'monos'),
(23, 'selva'),
(24, 'tooltip'),
(25, 'bootstrap'),
(26, 'Mar del Plata'),
(27, 'vacaciones'),
(28, 'tooltip'),
(29, 'Oasis'),
(30, 'whatever'),
(31, 'feli'),
(32, 'sobrino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE IF NOT EXISTS `notificacion` (
  `N_ID` int(11) NOT NULL AUTO_INCREMENT,
  `N_Fecha` datetime NOT NULL,
  `N_Tipo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `N_Visto` tinyint(1) NOT NULL,
  `U_ID_Recibe` int(11) NOT NULL,
  `U_ID_Genera` int(11) DEFAULT NULL,
  `P_ID_Sobre` int(11) NOT NULL,
  PRIMARY KEY (`N_ID`),
  KEY `U_ID_Recibe` (`U_ID_Recibe`),
  KEY `P_ID_Sobre` (`P_ID_Sobre`),
  KEY `U_ID_Genera` (`U_ID_Genera`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=49 ;

--
-- Volcado de datos para la tabla `notificacion`
--

INSERT INTO `notificacion` (`N_ID`, `N_Fecha`, `N_Tipo`, `N_Visto`, `U_ID_Recibe`, `U_ID_Genera`, `P_ID_Sobre`) VALUES
(1, '2015-11-02 00:00:00', 'comentario', 0, 2, 5, 2),
(2, '2015-11-02 05:11:54', 'comentario', 0, 2, 6, 2),
(3, '2015-11-02 05:22:37', 'comentario', 0, 2, 6, 2),
(4, '2015-11-02 01:24:24', 'comentario', 0, 2, 6, 2),
(5, '2015-11-02 01:25:32', 'comentario', 0, 2, 6, 2),
(6, '2015-11-04 00:50:51', 'comentario', 0, 5, 2, 3),
(17, '2015-11-16 01:10:48', 'denuncia', 0, 2, 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `P_ID` int(11) NOT NULL AUTO_INCREMENT,
  `P_Titulo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `P_Detalle` text COLLATE utf8_spanish_ci NOT NULL,
  `P_Fecha` datetime NOT NULL,
  `P_Visibilidad` int(11) NOT NULL,
  `P_ID_Video` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `U_ID_Publica` int(11) NOT NULL,
  PRIMARY KEY (`P_ID`),
  KEY `U_ID_Publica` (`U_ID_Publica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`P_ID`, `P_Titulo`, `P_Detalle`, `P_Fecha`, `P_Visibilidad`, `P_ID_Video`, `U_ID_Publica`) VALUES
(2, 'Zapato 1', 'primer zapato', '2015-10-09 00:00:00', 1, NULL, 2),
(3, 'pollo al disco', 'muy rapido el sistema', '2015-11-04 04:36:21', 1, NULL, 5),
(7, 'curso bootstrap', 'Paginacion', '2015-11-18 00:00:00', 1, 'djbopF-PCtQ', 2),
(8, 'sistema con php', 'ValidaciÃ³n csrf para formularios', '2015-11-18 00:00:00', 1, 'HM2RDLpis30', 2),
(9, 'yyeyey', 'aaa', '2015-11-20 00:00:00', 1, '3Y9zLXLNA5A', 2),
(10, 'soda estereo', 'concierto', '2015-11-20 00:00:00', 1, '69K8jCRNWdQ', 2),
(11, 'ee', 'eewq', '2015-11-23 16:42:48', 1, 'HsftXewWmfs', 2),
(12, 'xml', 'IntroducciÃ³n a xml', '2015-11-23 16:46:28', 1, 'bCd2xaQrTAo', 2),
(13, 'Rescate', 'Google earth encuentra a una mujer', '2015-11-23 21:42:04', 1, 'PltNzetLF74', 5),
(14, 'Menu Desplegable Responsive', 'Tutorial para crear un menÃº ', '2015-11-23 21:44:57', 1, 'feqtft3OVQA', 5),
(15, 'Enjoy the Silence', 'Tema de la banda Depeche Mode', '2015-11-23 21:48:18', 1, 'aGSKrC7dGcY', 5),
(17, 'Ecografia', 'Ecografia del feli', '2015-11-27 02:00:03', 1, NULL, 2),
(18, 'Monos', 'Monos en la selva', '2015-11-27 02:18:35', 1, NULL, 2),
(19, 'Tutorial 11 Tooltips Bootstrap', 'Tutorial donde se explica el uso del componente tooltip de bootstrap 3', '2015-11-27 17:26:14', 1, 'jkaXMmw04Es', 2),
(20, 'Vacaciones Mar del Plata', 'El maple de vacaciones', '2015-11-27 17:28:28', 1, NULL, 2),
(21, 'Tooltip', 'Tutorial de tooltip de bootstrap', '2015-11-27 18:10:46', 1, 'g8QX5Rs3ogQ', 2),
(22, 'Oasis - Whatever', 'Tema de la banda Oasis', '2015-11-27 18:17:04', 1, 'EHfx9LXzxpw', 2),
(23, 'Feli', 'el feli en la casa de las chicas', '2015-11-27 18:19:05', 1, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiene`
--

CREATE TABLE IF NOT EXISTS `tiene` (
  `P_ID_Tiene` int(11) NOT NULL,
  `E_ID_Tiene` int(11) NOT NULL,
  PRIMARY KEY (`P_ID_Tiene`,`E_ID_Tiene`),
  KEY `E_ID_Tiene` (`E_ID_Tiene`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tiene`
--

INSERT INTO `tiene` (`P_ID_Tiene`, `E_ID_Tiene`) VALUES
(2, 1),
(2, 2),
(8, 3),
(8, 4),
(9, 5),
(10, 6),
(7, 7),
(7, 8),
(3, 9),
(3, 10),
(11, 11),
(11, 12),
(11, 13),
(12, 14),
(13, 15),
(14, 16),
(14, 17),
(15, 18),
(15, 19),
(17, 20),
(17, 21),
(18, 22),
(18, 23),
(19, 24),
(19, 25),
(20, 26),
(20, 27),
(21, 28),
(22, 29),
(22, 30),
(23, 31),
(23, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `U_ID` int(11) NOT NULL AUTO_INCREMENT,
  `U_Email` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `U_Password` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `U_Nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `U_Apellido` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `U_Domicilio` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `U_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`U_ID`),
  UNIQUE KEY `U_Email` (`U_Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`U_ID`, `U_Email`, `U_Password`, `U_Nombre`, `U_Apellido`, `U_Domicilio`, `U_Activo`) VALUES
(1, 'admin@fotaza.com', 'admin', 'Ernesto', 'Gonzalez', '', 1),
(2, 'beltrusena@gmail.com', '950', 'Edgar', 'Aguilera', 'Esteban Adaro 45', 1),
(5, 'nicorder@hotmail.com', '825', 'nico', 'res', '', 1),
(6, 'pepe@hotmail.com', 'pepe', 'jose nicolÃ¡s', 'aguilera', 'wer', 1),
(7, 'pedro@gmail.com', 'pedro', 'pedro', 'ojeda', '', 1),
(9, 'nico@gmail.com', 'nico', 'nico', 'asaa', '', 1),
(10, 'rick@hotmail.com', 'rick', 'Ricardo', 'Romero', '', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `Contiene` FOREIGN KEY (`P_ID_Contiene`) REFERENCES `post` (`P_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Realiza` FOREIGN KEY (`U_ID_Realiza`) REFERENCES `usuario` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `denuncia`
--
ALTER TABLE `denuncia`
  ADD CONSTRAINT `En el` FOREIGN KEY (`P_ID_EnEl`) REFERENCES `post` (`P_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Hace` FOREIGN KEY (`U_ID_Hace`) REFERENCES `usuario` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `Genera` FOREIGN KEY (`U_ID_Genera`) REFERENCES `usuario` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Recibe` FOREIGN KEY (`U_ID_Recibe`) REFERENCES `usuario` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Sobre` FOREIGN KEY (`P_ID_Sobre`) REFERENCES `post` (`P_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `Publica` FOREIGN KEY (`U_ID_Publica`) REFERENCES `usuario` (`U_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tiene`
--
ALTER TABLE `tiene`
  ADD CONSTRAINT `Tiene` FOREIGN KEY (`P_ID_Tiene`) REFERENCES `post` (`P_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tiene_ibfk_1` FOREIGN KEY (`E_ID_Tiene`) REFERENCES `etiqueta` (`E_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
