-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-03-2025 a las 02:34:46
-- Versión del servidor: 10.11.10-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u132635152_montrer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_area`
--

CREATE TABLE `montrer_area` (
  `idArea` int(11) NOT NULL,
  `nameArea` text NOT NULL,
  `description` text NOT NULL,
  `areaCode` text NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_area`
--

INSERT INTO `montrer_area` (`idArea`, `nameArea`, `description`, `areaCode`, `idUser`, `status`, `active`) VALUES
(3, 'BANDA DE GUERRA', '', '5002-006', NULL, 1, 1),
(19, 'CONTABILIDAD', '', '5002-001', NULL, 1, 1),
(20, 'COORDINACION DE IDIOMAS', '', '5002-001', NULL, 1, 1),
(22, 'COORDINACIÓN DEPORTIVA', '', '5002-001', NULL, 1, 1),
(31, 'CENTRO DE MEDIOS', '', '5002-001', NULL, 1, 1),
(33, 'DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS', '', '5002-001', NULL, 1, 1),
(34, 'DIRECCIÓN DE CONTROL ESCOLAR Y SERVICIOS ESCOLARES', '', '5002-001', NULL, 1, 1),
(35, 'DIRECCION DE PREPARATORIAS', '', '5002-001', NULL, 1, 1),
(36, 'DISEÑO GRAFICO', '', '5002-001', NULL, 1, 1),
(37, 'INFORMATICA', '', '5002-001', NULL, 1, 1),
(38, 'LICENCIATURA EN MEDICINA', '', '5002-001', NULL, 1, 1),
(39, 'PROMOCION', '', '5002-001', NULL, 1, 1),
(40, 'RECTORIA', '', '5002-001', NULL, 1, 1),
(41, 'DIRECTOR COMERCIAL', '', '5002-001', NULL, 1, 1),
(42, 'RECTORIA ADJUNTA', '', '5002-001', NULL, 1, 1),
(43, 'RECURSOS HUMANOS', '', '5002-001', NULL, 1, 1),
(44, 'SERVICIOS GENERALES', '', '5002-001', NULL, 1, 1),
(45, 'RECURSOS HUMANOS', '', '5002-001', NULL, 1, 1),
(46, 'SERVICIOS GENERALES', '', '5002-001', NULL, 1, 1),
(47, 'UNIVERSIDAD EN LINEA', '', '5002-001', NULL, 1, 1),
(48, 'VICERRECTORA DE ADMINISTRACION Y NEGOCIOS Y CIENCIAS SOCIALES', '', '5002-001', NULL, 1, 1),
(49, 'VICERRECTORA DE COMUNICACIÓN Y ARTE, Y CIENCIAS DE LA SALUD', '', '5002-001', NULL, 1, 1),
(50, 'COORDINACIÓN DE LOGISTICA', '', '5002-001', NULL, 1, 1),
(51, 'ENTRENAMIENTOS Y CAMPEONATOS COR.DEP', '', '5002-002', NULL, 1, 1),
(52, 'GASTOS LEGALES', '', '5002-003', NULL, 1, 1),
(53, 'PUBLICIDAD GENERAL', '', '5002-004', NULL, 1, 1),
(54, 'GASTOS GENERALES', '', '5002-005', NULL, 1, 1),
(55, 'CUOTAS SOCIALES ENTRE ASOCIADOS', '', '5002-007', NULL, 1, 1),
(56, 'DESARROLLO DE CONTENIDOS', 'DESARROLLO DE CONTENIDOS', '5000-001', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_budgets`
--

CREATE TABLE `montrer_budgets` (
  `idBudget` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `AuthorizedAmount` double NOT NULL,
  `idExercise` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_budgets`
--

INSERT INTO `montrer_budgets` (`idBudget`, `idArea`, `AuthorizedAmount`, `idExercise`, `status`) VALUES
(37, 3, 200000, 17, 1),
(38, 22, 1500000, 17, 1),
(39, 31, 500000, 17, 1),
(40, 37, 1000000, 17, 1),
(41, 20, 500000, 17, 1),
(42, 40, 1000000, 17, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_budget_requests`
--

CREATE TABLE `montrer_budget_requests` (
  `idRequest` int(11) NOT NULL,
  `solicitante_nombre` text NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `cuentaAfectada` text NOT NULL,
  `partidaAfectada` text NOT NULL,
  `idEmployer` text DEFAULT NULL,
  `idAreaCargo` text DEFAULT NULL,
  `idCuentaAfectada` text DEFAULT NULL,
  `idPartidaAfectada` text DEFAULT NULL,
  `idConcepto` text DEFAULT NULL,
  `importe_solicitado` double NOT NULL,
  `importe_letra` text NOT NULL,
  `fecha_pago` date NOT NULL,
  `clabe` varchar(100) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `numero_cuenta` varchar(100) NOT NULL,
  `swift_code` varchar(100) DEFAULT NULL,
  `beneficiario_direccion` text DEFAULT NULL,
  `tipo_divisa` varchar(100) DEFAULT NULL,
  `concepto_pago` text NOT NULL,
  `folio` text NOT NULL,
  `approvedAmount` double DEFAULT NULL,
  `importe_letra_aprobado` text DEFAULT NULL,
  `responseDate` timestamp NULL DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT 'Status values:\r\n0: No respondido\r\n1: Aprobado\r\n2: Envió de comprobante\r\n3: rechazado\r\n4: Denegado el comprobante\r\n5: Aprobado el comprobante',
  `active` tinyint(1) DEFAULT NULL,
  `pagado` int(11) DEFAULT 0,
  `paymentDate` date DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `requestDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `idAdmin` int(11) DEFAULT NULL,
  `idProvider` int(11) NOT NULL,
  `idBudget` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `cuentaAfectadaCount` text DEFAULT NULL,
  `partidaAfectadaCount` text DEFAULT NULL,
  `polizeType` text DEFAULT NULL,
  `numberPolize` text DEFAULT NULL,
  `cargo` double DEFAULT NULL,
  `abono` double DEFAULT NULL,
  `complete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_budget_requests`
--

INSERT INTO `montrer_budget_requests` (`idRequest`, `solicitante_nombre`, `empresa`, `concepto`, `cuentaAfectada`, `partidaAfectada`, `idEmployer`, `idAreaCargo`, `idCuentaAfectada`, `idPartidaAfectada`, `idConcepto`, `importe_solicitado`, `importe_letra`, `fecha_pago`, `clabe`, `banco`, `numero_cuenta`, `swift_code`, `beneficiario_direccion`, `tipo_divisa`, `concepto_pago`, `folio`, `approvedAmount`, `importe_letra_aprobado`, `responseDate`, `status`, `active`, `pagado`, `paymentDate`, `comentarios`, `requestDate`, `idAdmin`, `idProvider`, `idBudget`, `idArea`, `idUser`, `cuentaAfectadaCount`, `partidaAfectadaCount`, `polizeType`, `numberPolize`, `cargo`, `abono`, `complete`) VALUES
(15, 'J NOE  GONZALEZ GOMEZ ', '', '', '', '', '1000-001-004-005', '5002-001-000-000-000', NULL, NULL, NULL, 50000, 'Cincuenta mil pesos', '2025-02-21', '012470001822406292', 'BBVA', '0182240629  ', NULL, NULL, 'MXN', 'PAGO DE LIBROS IDIOMAS LOS REYES', '1REC250213', NULL, NULL, NULL, 0, NULL, 0, '2025-02-14', NULL, '2025-02-13 21:39:50', NULL, 2, 42, 40, 71, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(16, 'ANTONIO AGUSTÍN GALLEGOS DOMÍNGUEZ', '', '', '', '', NULL, '5002-001-000-000-000', NULL, NULL, NULL, 20000, 'Veinte mil pesos', '2025-02-21', '012470001822406292', 'BBVA', '0182240629  ', NULL, NULL, 'MXN', 'COMPRA DE LIRBOS DE DIPLOMADO DE IDIOMAS', '16CDI250214', NULL, NULL, NULL, 0, NULL, 0, '2025-02-21', NULL, '2025-02-14 21:52:45', NULL, 2, 41, 20, 59, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_business`
--

CREATE TABLE `montrer_business` (
  `idBusiness` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_business`
--

INSERT INTO `montrer_business` (`idBusiness`, `name`, `description`, `status`) VALUES
(2, 'IMO', 'Instituto Montrer', 1),
(3, 'UNIMO', 'Universidad Montrer', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_conceptos`
--

CREATE TABLE `montrer_conceptos` (
  `idConcepto` int(11) NOT NULL,
  `concepto` text NOT NULL,
  `numeroConcepto` varchar(8) NOT NULL,
  `idPartida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `montrer_conceptos`
--

INSERT INTO `montrer_conceptos` (`idConcepto`, `concepto`, `numeroConcepto`, `idPartida`) VALUES
(5, 'TRAJES', '000', 3),
(6, 'ESTANDARTES', '000', 3),
(7, 'BANDERINES', '000', 3),
(8, 'HIDRATACIÓN', '000', 3),
(9, 'OTROS MATERIALES', '000', 3),
(10, 'HOSPESAJE Y COMIDA INVITADOS', '000', 3),
(11, 'HIDRATACIÓN', '000', 4),
(12, 'OTROS MATERIALES', '000', 4),
(13, 'HOSPESAJE Y COMIDA INVITADOS', '000', 4),
(14, 'VESTIMENTA', '000', 5),
(15, 'PLATAFORMA', '000', 5),
(16, 'HIDRATACIÓN', '000', 5),
(17, 'OTROS MATERIALES', '000', 5),
(18, 'DESAYUNO ADMINISTRATIVOS', '000', 5),
(19, 'ENVIO DE UNIFORMES, ESTANDARTES Y BANDERINES', '000', 6),
(20, 'HIDRATACIÓN', '000', 6),
(21, 'OTROS MATERIALES', '000', 6),
(22, 'TRANSPORTE BANDA DE GUERRA', '000', 6),
(23, 'HOSPEDAJE BANDA DE GUERRA', '000', 6),
(24, 'TAPETES', '000', 7),
(25, 'ASERRIN', '000', 7),
(26, 'FLORES', '000', 7),
(27, 'DECORACIÓN', '000', 7),
(28, 'VELADORAS', '000', 7),
(29, 'ESTRUCTURAS', '000', 7),
(30, 'PROYECTO', '000', 7),
(31, 'DERECHOS', '000', 7),
(32, 'HIDRATACIÓN', '000', 7),
(33, 'OTROS MATERIALES', '000', 7),
(34, 'INSUMOS PARA DECORACIÓN', '000', 8),
(35, 'RENTA DEL TEATRO', '000', 9),
(36, 'ARREGLOS FLORALES', '000', 9),
(37, 'PAPELERIA PARA CARPETAS Y CONSTANCIAS', '000', 9),
(38, 'BOX LUNCH', '000', 9),
(39, 'HIDRATACIÓN', '000', 9),
(40, 'MATERIALES', '000', 9),
(41, 'RENTA DE SALÓN', '000', 10),
(42, 'ARREGLOS FLORALES', '000', 10),
(43, 'HIDRATACIÓN', '000', 10),
(44, 'MATERIALES', '000', 10),
(45, 'ARREGLOS FLORALES', '000', 11),
(46, 'ARREGLOS FLORALES', '000', 12),
(47, 'COMIDA DÍA DEL MAESTRO', '000', 13),
(48, 'COMIDA DÍA DEL MAESTRO', '000', 14),
(49, 'EVENTO DÍA DEL ESTUDIANTE', '000', 15),
(50, 'EVENTO DÍA DEL ESTUDIANTE', '000', 16),
(51, 'TOLDO, MOBLIARIO, BIDONES, ALFOMBRA ', '000', 17),
(52, 'COFFEE BREAK', '000', 17),
(53, 'AMBULANCIA', '000', 17),
(54, 'RECONOCIMIENTOS', '000', 17),
(55, 'COBERTURA DE MEDIOS DE COMUNICACIÓN', '000', 17),
(56, 'RENTA DE PANTALLAS', '000', 17),
(57, 'ARREGLOS FLORALES', '000', 17),
(58, 'RENTA DE TEMPLETES', '000', 17),
(59, 'EQUIPO DE AUDIO Y SONIDO', '000', 17),
(60, 'INTERPRETE DEL HIMNO NACIONAL', '000', 17),
(61, 'BASTIDOR Y LONA', '000', 17),
(62, 'OTROS MATERIALES', '000', 17),
(63, 'EVENTO PROTOCOLARIO', '000', 18),
(64, 'COMIDA DE FIN DE AÑO', '000', 19),
(65, 'COMIDA DE FIN DE AÑO', '000', 20),
(66, 'DESAYUNOS', '000', 21),
(67, '….', '000', 21),
(68, 'RENTA DE INMUEBLE', '000', 22),
(69, 'HONORARIOS PONENTES', '000', 22),
(70, 'HOSPEDAJE PONENTE', '000', 22),
(71, 'ALIMENTOS PONENTE', '000', 22),
(72, 'PRESENTES PONENTE', '000', 22),
(73, 'MATERIALES PARA DIPLOMAS', '000', 22),
(74, 'MATERIALES PARA GAFETTE', '000', 22),
(75, 'PUBLICIDAD', '000', 22),
(76, 'ARREGLOS FLORALES', '000', 22),
(77, 'ALIMENTOS STAFF', '000', 22),
(78, 'OBSEQUIOS ASISTENTES', '000', 22),
(79, 'COFFE BREAK', '000', 22),
(80, 'OTROS MATERIALES', '000', 22),
(81, 'RENTA DE INMUEBLE', '000', 23),
(82, 'HONORARIOS PONENTES', '000', 23),
(83, 'HOSPEDAJE PONENTE', '000', 23),
(84, 'ALIMENTOS PONENTE', '000', 23),
(85, 'PRESENTES PONENTE', '000', 23),
(86, 'MATERIALES PARA DIPLOMAS', '000', 23),
(87, 'MATERIALES PARA GAFETTE', '000', 23),
(88, 'PUBLICIDAD ', '000', 23),
(89, 'ARREGLOS FLORALES', '000', 23),
(90, 'ALIMENTOS STAFF', '000', 23),
(91, 'OBSEQUIOS ASISTENTES', '000', 23),
(92, 'COFFE BREAK', '000', 23),
(93, 'OTROS MATERIALES', '000', 23),
(94, 'RENTA DE INMUEBLE', '000', 24),
(95, 'HONORARIOS PONENTES', '000', 24),
(96, 'HOSPEDAJE PONENTE', '000', 24),
(97, 'ALIMENTOS PONENTE', '000', 24),
(98, 'PRESENTES PONENTE', '000', 24),
(99, 'MATERIALES PARA DIPLOMAS', '000', 24),
(100, 'MATERIALES PARA GAFETTE', '000', 24),
(101, 'PUBLICIDAD', '000', 24),
(102, 'ARREGLOS FLORALES', '000', 24),
(103, 'ALIMENTOS STAFF', '000', 24),
(104, 'OBSEQUIOS ASISTENTES', '000', 24),
(105, 'COFFE BREAK', '000', 24),
(106, 'OTROS MATERIALES', '000', 24),
(107, 'RENTA DE INMUEBLE', '000', 25),
(108, 'HONORARIOS PONENTES', '000', 25),
(109, 'HOSPEDAJE PONENTE', '000', 25),
(110, 'ALIMENTOS PONENTE', '000', 25),
(111, 'PRESENTES PONENTE', '000', 25),
(112, 'MATERIALES PARA DIPLOMAS', '000', 25),
(113, 'MATERIALES PARA GAFETTE', '000', 25),
(114, 'PUBLICIDAD ', '000', 25),
(115, 'ARREGLOS FLORALES', '000', 25),
(116, 'ALIMENTOS STAFF', '000', 25),
(117, 'OBSEQUIOS ASISTENTES', '000', 25),
(118, 'COFFE BREAK', '000', 25),
(119, 'OTROS MATERIALES', '000', 25),
(120, 'RENTA DE INMUEBLE', '000', 26),
(121, 'HONORARIOS PONENTES', '000', 26),
(122, 'HOSPEDAJE PONENTE', '000', 26),
(123, 'ALIMENTOS PONENTE', '000', 26),
(124, 'PRESENTES PONENTE', '000', 26),
(125, 'MATERIALES PARA DIPLOMAS', '000', 26),
(126, 'MATERIALES PARA GAFETTE', '000', 26),
(127, 'PUBLICIDAD ', '000', 26),
(128, 'ARREGLOS FLORALES', '000', 26),
(129, 'ALIMENTOS STAFF', '000', 26),
(130, 'OBSEQUIOS ASISTENTES', '000', 26),
(131, 'COFFE BREAK', '000', 26),
(132, 'OTROS MATERIALES', '000', 26),
(133, 'RENTA DE INMUEBLE', '000', 27),
(134, 'HONORARIOS PONENTES', '000', 27),
(135, 'HOSPEDAJE PONENTE', '000', 27),
(136, 'ALIMENTOS PONENTE', '000', 27),
(137, 'PRESENTES PONENTE', '000', 27),
(138, 'MATERIALES PARA DIPLOMAS', '000', 27),
(139, 'MATERIALES PARA GAFETTE', '000', 27),
(140, 'PUBLICIDAD ', '000', 27),
(141, 'ARREGLOS FLORALES', '000', 27),
(142, 'ALIMENTOS STAFF', '000', 27),
(143, 'OBSEQUIOS ASISTENTES', '000', 27),
(144, 'COFFE BREAK', '000', 27),
(145, 'OTROS MATERIALES', '000', 27),
(146, 'RENTA DE ILUMINACIÓN', '000', 28),
(147, 'TOLDO', '000', 28),
(148, 'ESCENARIO Y MOBILIARIO', '000', 28),
(149, 'HONORARIOS JURADO', '000', 28),
(150, 'HOSPEDAJE JURADO', '000', 28),
(151, 'ALIMENTOS JURADO', '000', 28),
(152, 'TRASLADO PARTICIPANTES', '000', 28),
(153, 'HOSPEDAJE PARTICIPANTES', '000', 28),
(154, 'PREMIOS', '000', 28),
(155, 'AMAC', '000', 29),
(156, 'NIÑOS DE JESUS DEL MONTE', '000', 29),
(157, 'DONATIVO EN EFECTIVO', '001', 30),
(158, 'DONATIVO EN ESPECIE', '001', 30),
(159, 'PATROCINIO', '002', 31),
(160, 'TRASLADOS INTERNOS', '002', 31),
(161, 'VIATICOS CENTRO DE MEDIOS', '002', 31),
(162, 'BASQUETBOL 1RA DIV VAR', '000', 32),
(163, 'BASQUETBOL UNIV FEMENIL', '000', 32),
(164, 'BASQUETBOL JUV VARONES', '000', 32),
(165, 'BASQUETBOL JUV FEMENIL', '000', 32),
(166, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 32),
(167, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 32),
(168, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 32),
(169, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 32),
(170, 'DISCIPLINAS INDIVIDUALES', '000', 32),
(171, 'BASQUETBOL 1RA DIV VAR', '000', 33),
(172, 'BASQUETBOL UNIV FEMENIL', '000', 33),
(173, 'BASQUETBOL JUV VARONES', '000', 33),
(174, 'BASQUETBOL JUV FEMENIL', '000', 33),
(175, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 33),
(176, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 33),
(177, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 33),
(178, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 33),
(179, 'DISCIPLINAS INDIVIDUALES', '000', 33),
(180, 'BASQUETBOL 1RA DIV VAR', '000', 34),
(181, 'BASQUETBOL UNIV FEMENIL', '000', 34),
(182, 'BASQUETBOL JUV VARONES', '000', 34),
(183, 'BASQUETBOL JUV FEMENIL', '000', 34),
(184, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 34),
(185, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 34),
(186, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 34),
(187, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 34),
(188, 'DISCIPLINAS INDIVIDUALES', '000', 34),
(189, 'BASQUETBOL 1RA DIV VAR', '000', 35),
(190, 'BASQUETBOL UNIV FEMENIL', '000', 35),
(191, 'BASQUETBOL JUV VARONES', '000', 35),
(192, 'BASQUETBOL JUV FEMENIL', '000', 35),
(193, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 35),
(194, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 35),
(195, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 35),
(196, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 35),
(197, 'DISCIPLINAS INDIVIDUALES', '000', 35),
(198, 'BASQUETBOL 1RA DIV VAR', '000', 36),
(199, 'BASQUETBOL UNIV FEMENIL', '000', 36),
(200, 'BASQUETBOL JUV VARONES', '000', 36),
(201, 'BASQUETBOL JUV FEMENIL', '000', 36),
(202, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 36),
(203, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 36),
(204, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 36),
(205, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 36),
(206, 'DISCIPLINAS INDIVIDUALES', '000', 36),
(207, 'BASQUETBOL 1RA DIV VAR', '000', 37),
(208, 'BASQUETBOL UNIV FEMENIL', '000', 37),
(209, 'BASQUETBOL JUV VARONES', '000', 37),
(210, 'BASQUETBOL JUV FEMENIL', '000', 37),
(211, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 37),
(212, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 37),
(213, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 37),
(214, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 37),
(215, 'DISCIPLINAS INDIVIDUALES', '000', 37),
(216, 'BASQUETBOL 1RA DIV VAR', '000', 38),
(217, 'BASQUETBOL UNIV FEMENIL', '000', 38),
(218, 'BASQUETBOL JUV VARONES', '000', 38),
(219, 'BASQUETBOL JUV FEMENIL', '000', 38),
(220, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 38),
(221, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 38),
(222, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 38),
(223, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 38),
(224, 'DISCIPLINAS INDIVIDUALES', '000', 38),
(225, 'BASQUETBOL 1RA DIV VAR', '000', 39),
(226, 'BASQUETBOL UNIV FEMENIL', '000', 39),
(227, 'BASQUETBOL JUV VARONES', '000', 39),
(228, 'BASQUETBOL JUV FEMENIL', '000', 39),
(229, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 39),
(230, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 39),
(231, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 39),
(232, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 39),
(233, 'DISCIPLINAS INDIVIDUALES', '000', 39),
(234, 'BASQUETBOL 1RA DIV VAR', '000', 40),
(235, 'BASQUETBOL UNIV FEMENIL', '000', 40),
(236, 'BASQUETBOL JUV VARONES', '000', 40),
(237, 'BASQUETBOL JUV FEMENIL', '000', 40),
(238, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 40),
(239, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 40),
(240, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 40),
(241, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 40),
(242, 'DISCIPLINAS INDIVIDUALES', '000', 40),
(243, 'BASQUETBOL 1RA DIV VAR', '000', 41),
(244, 'BASQUETBOL UNIV FEMENIL', '000', 41),
(245, 'BASQUETBOL JUV VARONES', '000', 41),
(246, 'BASQUETBOL JUV FEMENIL', '000', 41),
(247, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 41),
(248, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 41),
(249, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 41),
(250, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 41),
(251, 'DISCIPLINAS INDIVIDUALES', '000', 41),
(252, 'BASQUETBOL 1RA DIV VAR', '000', 42),
(253, 'BASQUETBOL UNIV FEMENIL', '000', 42),
(254, 'BASQUETBOL JUV VARONES', '000', 42),
(255, 'BASQUETBOL JUV FEMENIL', '000', 42),
(256, 'VOLEIBOL SALA/PLAYA VARONIL JUVENIL', '000', 42),
(257, 'VOLEIBOL SALA/PLAYA FEMENIL JUVENIL', '000', 42),
(258, 'FUTBOL SOCCER/RAPIDO VARONIL 1RA FZA', '000', 42),
(259, 'FUTBOL SOCCER/RAPIDO FEMENIL 1RA FZA', '000', 42),
(260, 'COTEJOS', '000', 43),
(261, 'ACTAS', '000', 43),
(262, 'PODERES', '000', 43),
(263, 'OTROS', '000', 43),
(264, 'MARCAS', '000', 44),
(265, 'AVALUOS', '000', 45),
(266, 'OTROS', '000', 46),
(267, 'LUZ', '001', 86),
(268, 'AGUA', '002', 86),
(269, 'INTERNET', '003', 86),
(270, 'ALARMAS', '004', 86),
(271, 'TELEFONOS', '005', 86),
(272, 'CELULARES', '006', 86),
(273, 'MULTIFUNCIONALES', '007', 86),
(274, 'GAS LP', '008', 86),
(275, 'LUZ', '001', 87),
(276, 'AGUA', '002', 87),
(277, 'INTERNET', '003', 87),
(278, 'ALARMAS', '004', 87),
(279, 'TELEFONOS', '005', 87),
(280, 'CELULARES', '006', 87),
(281, 'MULTIFUNCIONALES', '007', 87),
(282, 'LUZ', '001', 88),
(283, 'AGUA', '002', 88),
(284, 'INTERNET', '003', 88),
(285, 'ALARMAS', '004', 88),
(286, 'TELEFONO', '005', 88),
(287, 'MULTIFUNCIONALES', '006', 88),
(288, 'LUZ', '001', 89),
(289, 'AGUA', '002', 89),
(290, 'INTERNET', '003', 89),
(291, 'ALARMAS', '004', 89),
(292, 'TELEFONOS', '005', 89),
(293, 'LUZ', '001', 90),
(294, 'AGUA', '002', 90),
(295, 'INTERNET', '003', 90),
(296, 'ALARMAS', '004', 90),
(297, 'TELEFONOS', '005', 90),
(298, 'MULTIFUNCIONALES', '006', 90),
(299, 'GAS LP', '007', 90),
(300, 'LUZ', '001', 91),
(301, 'AGUA', '002', 91),
(302, 'INTERNET', '003', 91),
(303, 'ALARMAS', '004', 91),
(304, 'TELEFONOS', '005', 91),
(305, 'MULTIFUNCIONALES', '006', 91),
(306, 'BANDA DE GUERRA', '001', 94),
(307, 'BANDA DE ALIENTOS', '002', 94),
(308, 'AUTOBUSES', '001', 92),
(309, 'SPRINTER', '002', 92),
(310, 'AUTOS DE PROMOCION', '003', 92),
(311, 'PICKUP', '004', 92),
(312, 'AUTOMOVILES', '005', 92),
(313, 'L.C 1760', '001', 93),
(314, 'L.C 1750', '002', 93),
(315, 'J.M EDIF.1', '003', 93),
(316, 'J.M EDFIF.2', '004', 93),
(317, 'J.M EDIF.3', '005', 93),
(318, 'J.M INSTALACIONES DEPORTIVAS', '006', 93),
(319, 'J.M JARDINERIA Y FUENTES', '007', 93),
(320, 'AGUSTIN MELGAR', '008', 93),
(321, 'CASA MATA', '009', 93),
(322, 'LOS REYES', '010', 93),
(323, 'LOS REYES JARDINERIA Y FUENTES', '011', 93),
(324, 'L.C. 2231', '012', 93),
(325, 'EQ. DE COMPUTO', '001', 95),
(326, 'MULTIFUNCIONALES E IMPRESORAS', '002', 95),
(327, 'OTROS', '003', 95),
(328, 'CONSUMIBLES DE TINTA PARA IMPRESORAS', '001', 99),
(329, 'PAPEL BLANCO PARA IMPRESION', '002', 99),
(330, 'OTROS', '003', 99),
(331, 'NUEVO RVOS', '001', 116),
(332, 'INSPECCION Y VIGILANCIA', '002', 116),
(333, 'COTEJOS', '003', 116),
(334, 'CERTIFICADOS', '004', 116),
(335, 'DERECHOS POR TITULOS', '001', 117),
(336, 'DERECHOS POR CEDULAS', '002', 117),
(337, 'POR USO DE SUELO', '001', 118),
(338, 'POR USO DE ANUNCIOS LUMINOSOS', '002', 118),
(339, 'POR FUNCIONAMIENTO DE CAFETERIAS', '003', 118),
(340, 'REFRENDOS Y PLACAS DE AUTOS', '004', 118),
(341, 'XXX', '001', 119),
(342, 'SEGURO POLIZA', '001', 120),
(343, 'SEGURO EDIFICIO L.C. 1760', '002', 120),
(344, 'SEGURO EDIFICIO CASA MATA', '003', 120),
(345, 'EDIFICIO AGUSTIN MELGAR', '004', 120),
(346, 'EDIFICIO J.M. # 1', '005', 120),
(347, 'EDIFICIO J.M. # 2', '006', 120),
(348, 'CAFETERIA J..M.', '007', 120),
(349, 'SNAK J.M.', '008', 120),
(350, 'SPRINTER', '009', 120),
(351, 'AUTO PROMOCIÓN', '010', 120),
(352, 'FRONTIER', '011', 120),
(353, 'MAZDA', '012', 120),
(354, 'HILUX', '013', 120),
(355, 'CAMION 02', '014', 120),
(356, 'AUTO XXX', '015', 120),
(357, 'AUTO XXX', '016', 120),
(358, 'OTRAS POLIZAS DE SEGUROS', '017', 120),
(359, 'GASTOS MEDICOS DEL RECTOR', '018', 120),
(360, 'GASTOS MEDICOS DE CONSEJEROS', '019', 120),
(361, 'GASTOS MEDICOS ALUMNOS', '020', 120),
(362, 'JESUS DEL MONTE 1', '001', 153),
(363, 'JESUS DEL MONTE 2', '002', 153),
(364, 'LAZARO CARDENAS 1750', '003', 153),
(365, 'LOS REYES', '005', 153),
(366, 'JESUS DEL MONTE 1', '001', 154),
(367, 'JESUS DEL MONTE 2', '002', 154),
(368, 'LAZARO CARDENAS 1750', '003', 154),
(369, 'LAZARO CARDENAS 1760', '004', 154),
(370, 'BATALLA DE CASA MATA', '005', 154),
(371, 'LOS REYES', '007', 154),
(372, 'JESUS DEL MONTE 1', '001', 155),
(373, 'JESUS DEL MONTE 2', '002', 155),
(374, 'LAZARO CRDENAS 1750', '003', 155),
(375, 'LAZARO CARDENAS 1760', '004', 155),
(376, 'AGUSTIN MELGAR', '006', 155),
(377, 'LOS REYES', '007', 155),
(378, 'JESUS DEL MONTE 1', '001', 156),
(379, 'JESUS DEL MONTE 2', '002', 156),
(380, 'LAZARO CARDENAS 1750', '003', 156),
(381, 'LAZARO CARDENAS 1760', '004', 156),
(382, 'AGUSTIN MELGAR', '005', 156),
(383, 'LOS REYES', '006', 156),
(384, 'JESUS DEL MONTE 1', '001', 157),
(385, 'JESUS DEL MONTE 2', '002', 157),
(386, 'LAZARO CARDENAS 1750', '003', 157),
(387, 'LAZARO CARDENAS 1760', '004', 157),
(388, 'LOS REYES', '005', 157),
(389, 'CONTRATO 2020', '001', 158),
(390, 'CONTRATO 2021', '002', 158),
(391, 'CONTRAT0 2022', '003', 158),
(392, 'AUDI Q5 2022', '001', 159),
(393, 'MERCEDES BENZ 450', '002', 159),
(394, 'MINI COOPER', '003', 159),
(395, 'BMW X6', '004', 159),
(396, 'BMW X4', '005', 159),
(397, 'Otro', '000', 180);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_cuentas`
--

CREATE TABLE `montrer_cuentas` (
  `idCuenta` int(11) NOT NULL,
  `cuenta` text NOT NULL,
  `numeroCuenta` text NOT NULL,
  `idArea` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_cuentas`
--

INSERT INTO `montrer_cuentas` (`idCuenta`, `cuenta`, `numeroCuenta`, `idArea`, `status`) VALUES
(3, 'DESFILES Y EVENTOS', '001', 50, 1),
(4, 'CONGRESOS', '002', 50, 1),
(5, 'CONCURSOS Y FILANTROPIA', '003', 50, 1),
(6, 'ENTRENAMIENTOS Y CAMPEONATOS COR.DEP', '000', 51, 0),
(7, 'GASTOS DE VIAJE DIRECTIVOS', '001', 51, 1),
(8, 'INSCRIPCIONES  Y CUOTAS', '002', 51, 1),
(9, 'GASTOS DE VIAJE DEPORTISTAS', '003', 51, 1),
(10, 'ALIMENTACION DEPORTISTAS', '004', 51, 1),
(11, 'HOSPEDAJE DEPORTISTAS', '005', 51, 1),
(12, 'UNIFORMES DEPORTISTAS', '006', 51, 1),
(13, 'UNIFORMES DIRECTIVOS', '007', 51, 1),
(14, 'GASTOS MEDICOS Y APOYOS', '008', 51, 1),
(15, 'IMPLEMENTOS DEPORTIVOS', '009', 51, 1),
(16, 'CONGRESOS', '014', 51, 1),
(17, 'SERVICIO DE ARBITRAJE', '015', 51, 1),
(18, 'NOTARIALES', '001', 52, 1),
(19, 'REGISTRABLES', '002', 52, 1),
(20, 'AVALUOS', '003', 52, 1),
(21, 'OTROS', '004', 52, 1),
(22, 'IMPRESIONES', '001', 53, 1),
(23, 'PUBLICIDAD AEREA', '002', 53, 1),
(24, 'TRANSPORTES', '003', 53, 1),
(25, 'RADIO', '004', 53, 1),
(26, 'TELEVISION Y CINES', '005', 53, 1),
(27, 'CENTROS COMERCIALES', '006', 53, 1),
(28, 'PANTALLAS', '007', 53, 1),
(29, 'DIGITAL', '008', 53, 1),
(30, 'PROMOCIÓN Y ADMINISIONES', '009', 53, 1),
(31, 'RENTAS', '001', 54, 1),
(32, 'SERVICIOS', '002', 54, 1),
(33, 'MANTENIMIENTO', '003', 54, 1),
(34, 'COMBUSTIBLES VEHICULOS', '004', 54, 1),
(35, 'CONSUMIBLES DE OFICINA', '005', 54, 1),
(36, 'CONSUMIBLES DE LIMPIEZA Y SANITARIOS', '006', 54, 1),
(37, 'JARDINERIA', '007', 54, 1),
(38, 'GASTOS POR DERECHOS ESTATALES SEE Y SEG.', '008', 54, 1),
(39, 'OTROS GASTOS', '012', 54, 1),
(40, 'CONTRATOS', '013', 54, 1),
(41, 'GASTOS POR FONDO DE CAJA CHICA', '014', 54, 1),
(42, 'GASTOS DE ARRENDAMIENTO', '015', 54, 1),
(43, 'GASTOS DE MANTENIMIENTO', '001', 3, 1),
(44, 'CONCURSOS', '002', 3, 1),
(45, 'RH PREPARATORIOS', '001', 55, 1),
(46, 'ADMINISTRACIÓN CULTURAL ESCOLAR', '002', 55, 1),
(47, 'ESTUDIOS MULTICULTURALES', '003', 55, 1),
(48, 'TECNOLOGIA Y ADMINISTRACION ESCOLAR', '004', 55, 1),
(49, 'EXPOSICIONES, CUOTAS Y SUSCRIPCIONES', '016', 54, 1),
(50, 'Otro', '001', 40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_exercise`
--

CREATE TABLE `montrer_exercise` (
  `idExercise` int(11) NOT NULL,
  `exerciseName` text NOT NULL,
  `initialDate` date NOT NULL,
  `finalDate` date NOT NULL,
  `budget` double NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `idRoot` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_exercise`
--

INSERT INTO `montrer_exercise` (`idExercise`, `exerciseName`, `initialDate`, `finalDate`, `budget`, `status`, `idRoot`, `active`, `creationDate`) VALUES
(17, 'Ejercicio 2025', '2025-01-01', '2025-12-31', 100000000, 1, 100000, 1, '2025-02-04 20:58:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_logs`
--

CREATE TABLE `montrer_logs` (
  `idLog` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `actionType` text DEFAULT NULL,
  `ipAddress` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_logs`
--

INSERT INTO `montrer_logs` (`idLog`, `idUser`, `timestamp`, `actionType`, `ipAddress`) VALUES
(294, 3, '2024-11-30 03:56:54', 'Create user: oscarcontrerasf91@gmail.com', '187.173.152.214'),
(295, 3, '2024-11-30 03:57:18', 'Create user: bandadeguerra@unimontrer.edu.mx', '187.173.152.214'),
(296, 3, '2024-11-30 03:57:40', 'Create user: direccioncm@unimontrer.edu.mx', '187.173.152.214'),
(297, 3, '2024-11-30 03:58:07', 'Create user: ysdelcarmen@unimontrer.edu.mx', '187.173.152.214'),
(298, 3, '2024-11-30 03:58:25', 'Create user: deptoidiomas@unimontrer.edu.mx', '187.173.152.214'),
(299, 3, '2024-11-30 03:58:57', 'Create user: vinculaciondeportiva@unimontrer.edu.mx', '187.173.152.214'),
(300, 3, '2024-11-30 03:59:14', 'Update user: acisneros@unimontrer.edu.mx', '187.173.152.214'),
(301, 3, '2024-11-30 03:59:36', 'Create user: pgonzalez@unimontrer.edu.mx', '187.173.152.214'),
(302, 3, '2024-11-30 03:59:49', 'Create user: cafeteria@unimontrer.edu.mx', '187.173.152.214'),
(303, 3, '2024-11-30 04:00:04', 'Create user: dhuitron@unimontrer.edu.mx', '187.173.152.214'),
(304, 3, '2024-11-30 04:00:20', 'Create user: serviciosescolares@unimontrer.edu.mx', '187.173.152.214'),
(305, 3, '2024-11-30 04:00:32', 'Create user: direccionprepa@unimontrer.edu.mx', '187.173.152.214'),
(306, 3, '2024-11-30 04:00:44', 'Create user: ocornejo@unimontrer.edu.mx', '187.173.152.214'),
(307, 3, '2024-11-30 04:00:57', 'Create user: levillagomezca@unimontrer.edu.mx', '187.173.152.214'),
(308, 3, '2024-11-30 04:01:14', 'Create user: informatica@unimontrer.edu.mx', '187.173.152.214'),
(309, 3, '2024-11-30 04:01:27', 'Create user: msescamillab@unimontrer.edu.mx', '187.173.152.214'),
(310, 3, '2024-11-30 04:01:43', 'Create user: vsdegollado@unimontrer.edu.mx', '187.173.152.214'),
(311, 3, '2024-11-30 04:01:56', 'Create user: rectoria@unimontrer.edu.mx', '187.173.152.214'),
(312, 3, '2024-11-30 04:02:17', 'Create user: direccionsga@unimontrer.edu.mx', '187.173.152.214'),
(313, 3, '2024-11-30 04:02:36', 'Create user: asistenterectoria@unimontrer.edu.mx', '187.173.152.214'),
(314, 3, '2024-11-30 04:02:50', 'Create user: dyortega@unimontrer.edu.mx', '187.173.152.214'),
(315, 3, '2024-11-30 04:03:18', 'Create user: congresos@unimontrer.edu.mx', '187.173.152.214'),
(316, 3, '2024-11-30 04:03:50', 'Create user: rectorad@unimontrer.edu.mx', '187.173.152.214'),
(317, 3, '2024-11-30 04:04:06', 'Create user: recursoshumanos@unimontrer.edu.mx', '187.173.152.214'),
(318, 3, '2024-11-30 04:04:17', 'Create user: imorales@unimontrer.edu.mx', '187.173.152.214'),
(319, 3, '2024-11-30 04:04:34', 'Create user: Error: Email duplicado', '187.173.152.214'),
(320, 3, '2024-11-30 04:04:34', 'Create user: serviciosgenerales@unimontrer.edu.mx', '187.173.152.214'),
(321, 3, '2024-11-30 04:04:45', 'Create user: admonposgrados@unimontrer.edu.mx', '187.173.152.214'),
(322, 3, '2024-11-30 04:04:57', 'Create user: derecho@unimontrer.edu.mx', '187.173.152.214'),
(323, 3, '2024-11-30 04:05:16', 'Create user: admonynegocios@unimontrer.edu.mx', '187.173.152.214'),
(324, 3, '2024-11-30 04:05:31', 'Create user: educacionfisica@unimontrer.edu.mx', '187.173.152.214'),
(325, 3, '2024-11-30 04:05:43', 'Create user: psicologiayeducacion@unimontrer.edu.mx', '187.173.152.214'),
(326, 3, '2024-11-30 04:05:55', 'Create user: vicerrectoriaunimo@unimontrer.edu.mx', '187.173.152.214'),
(327, 3, '2024-11-30 04:06:06', 'Create user: direccionuruapan@unimontrer.edu.mx', '187.173.152.214'),
(328, 3, '2024-11-30 04:06:19', 'Create user: direccionapatzingan@unimontrer.edu.mx', '187.173.152.214'),
(329, 3, '2024-11-30 04:06:29', 'Create user: losreyes@unimontrer.edu.mx', '187.173.152.214'),
(330, 3, '2024-11-30 04:06:41', 'Create user: audioysonido@unimontrer.edu.mx', '187.173.152.214'),
(331, 3, '2024-11-30 04:06:51', 'Create user: areadelasalud@unimontrer.edu.mx', '187.173.152.214'),
(332, 3, '2024-11-30 04:07:03', 'Create user: amarrublae@unimontrer.edu.mx', '187.173.152.214'),
(333, 3, '2024-11-30 04:07:13', 'Create user: comunicacionyarte@unimontrer.edu.mx', '187.173.152.214'),
(334, 3, '2024-11-30 04:07:23', 'Create user: vicerrectoria@unimontrer.edu.mx', '187.173.152.214'),
(335, 3, '2024-11-30 04:07:38', 'Create user: imageninstitucional@unimontrer.edu.mx', '187.173.152.214'),
(336, 3, '2024-11-30 04:07:48', 'Create user: arquitecturaeingenierias@unimontrer.edu.mx', '187.173.152.214'),
(337, 3, '2024-11-30 04:08:33', 'Create user: redessociales@unimontrer.edu.mx', '187.173.152.214'),
(338, 3, '2024-11-30 05:23:21', 'Update departament: 36', '187.173.152.214'),
(339, 3, '2024-11-30 05:25:04', 'Update departament: 36', '187.173.152.214'),
(340, 3, '2024-11-30 06:01:18', 'Update departament: 3', '187.173.152.214'),
(341, 3, '2024-11-30 06:01:45', 'Update departament: 31', '187.173.152.214'),
(342, 3, '2024-11-30 06:10:26', 'Update departament: 19', '187.173.152.214'),
(343, 3, '2024-11-30 21:38:07', 'Update departament: 20', '187.173.152.214'),
(344, 3, '2024-11-30 21:38:57', 'Update departament: 22', '187.173.152.214'),
(345, 3, '2024-11-30 21:39:33', 'Delete departament: 32', '187.173.152.214'),
(346, 3, '2024-11-30 21:39:45', 'Delete departament: 19', '187.173.152.214'),
(347, 3, '2024-11-30 21:39:51', 'Delete departament: 19', '187.173.152.214'),
(348, 3, '2024-11-30 21:41:42', 'Delete departament: 32', '187.173.152.214'),
(349, 3, '2024-11-30 21:43:28', 'Delete departament: 32', '187.173.152.214'),
(350, 3, '2024-11-30 21:45:31', 'Delete departament: 32', '187.173.152.214'),
(351, 3, '2024-11-30 21:48:51', 'Delete departament: 33', '187.173.152.214'),
(352, 3, '2024-11-30 22:37:57', 'Update departament: 33', '187.173.152.214'),
(353, 3, '2024-11-30 22:38:32', 'Update departament: 34', '187.173.152.214'),
(354, 3, '2024-11-30 22:38:50', 'Update departament: 35', '187.173.152.214'),
(355, 3, '2024-11-30 22:38:58', 'Update departament: 37', '187.173.152.214'),
(356, 3, '2024-11-30 22:39:38', 'Update departament: 38', '187.173.152.214'),
(357, 3, '2024-11-30 22:39:59', 'Update departament: 39', '187.173.152.214'),
(358, NULL, '2024-11-30 23:21:14', 'Update departament: 40', '187.173.152.214'),
(359, 3, '2024-11-30 23:22:04', 'Update departament: 41', '187.173.152.214'),
(360, 3, '2024-11-30 23:22:39', 'Update departament: 42', '187.173.152.214'),
(361, 3, '2024-11-30 23:23:19', 'Update departament: 43', '187.173.152.214'),
(362, 3, '2024-11-30 23:23:33', 'Update departament: 44', '187.173.152.214'),
(363, 3, '2024-11-30 23:23:52', 'Delete departament: 45', '187.173.152.214'),
(364, 3, '2024-11-30 23:24:05', 'Delete departament: 46', '187.173.152.214'),
(365, 3, '2024-11-30 23:24:21', 'Update departament: 47', '187.173.152.214'),
(366, 3, '2024-11-30 23:25:38', 'Update departament: 48', '187.173.152.214'),
(367, 3, '2024-11-30 23:26:23', 'Update departament: 49', '187.173.152.214'),
(368, 3, '2024-11-30 23:31:14', 'Update user: oscarcontrerasf91@gmail.com', '187.173.152.214'),
(372, 3, '2024-12-03 20:09:40', 'Update departament: 3', '45.177.43.5'),
(373, 3, '2024-12-03 20:43:50', 'Enable request: 10', '45.177.43.5'),
(379, 3, '2024-12-10 03:20:51', 'Add departament', '187.173.154.91'),
(380, 3, '2024-12-10 04:29:58', 'Add departament', '187.173.154.91'),
(381, 3, '2024-12-10 04:37:10', 'Add departament', '187.173.154.91'),
(382, 3, '2024-12-10 04:40:30', 'Add departament', '187.173.154.91'),
(383, 3, '2024-12-10 04:42:32', 'Update departament: 3', '187.173.154.91'),
(384, 3, '2024-12-10 04:43:25', 'Add departament', '187.173.154.91'),
(385, 3, '2024-12-10 04:50:59', 'Delete request: 12', '187.173.154.91'),
(386, 3, '2024-12-10 04:51:00', 'Delete request: 12', '187.173.154.91'),
(387, 3, '2024-12-10 04:56:41', 'Update departament: 53', '187.173.154.91'),
(388, 3, '2024-12-10 05:00:07', 'Update user: serviciosescolares@unimontrer.edu.mx', '187.173.154.91'),
(389, 3, '2024-12-10 05:00:32', 'Update user: recursoshumanos@unimontrer.edu.mx', '187.173.154.91'),
(390, 3, '2024-12-10 05:00:42', 'Update user: dhuitron@unimontrer.edu.mx', '187.173.154.91'),
(391, 3, '2024-12-10 05:00:51', 'Update user: asistenterectoria@unimontrer.edu.mx', '187.173.154.91'),
(392, 3, '2024-12-10 05:01:16', 'Update user: serviciosgenerales@unimontrer.edu.mx', '187.173.154.91'),
(393, 3, '2024-12-10 05:01:34', 'Update user: informatica@unimontrer.edu.mx', '187.173.154.91'),
(394, 3, '2024-12-10 05:01:57', 'Update user: losreyes@unimontrer.edu.mx', '187.173.154.91'),
(395, 3, '2024-12-10 05:02:12', 'Update user: direccionapatzingan@unimontrer.edu.mx', '187.173.154.91'),
(396, 3, '2024-12-10 05:02:22', 'Update user: vsdegollado@unimontrer.edu.mx', '187.173.154.91'),
(397, 3, '2024-12-10 05:02:44', 'Update user: rectoria@unimontrer.edu.mx', '187.173.154.91'),
(398, 3, '2024-12-10 05:16:21', 'Update departament: 53', '187.173.154.91'),
(399, 3, '2024-12-10 05:16:50', 'Add budget', '187.173.154.91'),
(400, 3, '2024-12-10 06:58:53', 'Delete request: 13', '187.173.154.91'),
(401, 32, '2024-12-10 07:03:39', 'Enable request: 14', '187.173.154.91'),
(402, 3, '2024-12-11 01:41:50', 'Delete departament: 19', '187.173.154.91'),
(403, 3, '2024-12-11 01:41:54', 'Delete departament: 20', '187.173.154.91'),
(404, 3, '2024-12-11 01:41:58', 'Delete departament: 22', '187.173.154.91'),
(405, 3, '2024-12-11 01:42:02', 'Delete departament: 31', '187.173.154.91'),
(406, 3, '2024-12-11 01:42:06', 'Delete departament: 33', '187.173.154.91'),
(407, 3, '2024-12-11 01:42:18', 'Delete departament: 34', '187.173.154.91'),
(408, 3, '2024-12-11 01:42:24', 'Delete departament: 35', '187.173.154.91'),
(409, 3, '2024-12-11 01:42:29', 'Delete departament: 36', '187.173.154.91'),
(410, 3, '2024-12-11 01:42:35', 'Delete departament: 37', '187.173.154.91'),
(411, 3, '2024-12-11 01:42:40', 'Delete departament: 38', '187.173.154.91'),
(412, 3, '2024-12-11 01:42:44', 'Delete departament: 39', '187.173.154.91'),
(413, 3, '2024-12-11 01:42:57', 'Delete departament: 40', '187.173.154.91'),
(414, 3, '2024-12-11 01:43:03', 'Delete departament: 41', '187.173.154.91'),
(415, 3, '2024-12-11 01:43:07', 'Delete departament: 42', '187.173.154.91'),
(416, 3, '2024-12-11 01:43:11', 'Delete departament: 43', '187.173.154.91'),
(417, 3, '2024-12-11 01:43:20', 'Delete departament: 44', '187.173.154.91'),
(418, 3, '2024-12-11 01:43:24', 'Delete departament: 47', '187.173.154.91'),
(419, 3, '2024-12-11 01:43:31', 'Delete departament: 48', '187.173.154.91'),
(420, 3, '2024-12-11 01:43:39', 'Delete departament: 49', '187.173.154.91'),
(421, 3, '2024-12-11 02:19:52', 'Update departament: 50', '187.173.154.91'),
(422, 3, '2024-12-11 02:21:31', 'Delete budget: 34', '187.173.154.91'),
(423, 3, '2024-12-11 02:21:36', 'Delete budget: 30', '187.173.154.91'),
(424, 3, '2024-12-11 02:21:41', 'Delete budget: 31', '187.173.154.91'),
(425, 3, '2025-01-31 22:07:00', 'Update user: rectoria@unimontrer.edu.mx', '45.177.43.5'),
(426, 3, '2025-01-31 22:17:15', 'Add budget', '45.177.43.5'),
(427, 3, '2025-01-31 22:18:14', 'Update departament: 20', '45.177.43.5'),
(428, 3, '2025-01-31 22:18:32', 'Update departament: 19', '45.177.43.5'),
(429, 71, '2025-02-04 20:56:58', 'Delete exercise: 1', '45.177.43.5'),
(430, 71, '2025-02-04 20:58:13', 'Add exercise', '45.177.43.5'),
(431, 71, '2025-02-04 20:58:35', 'Activate exercise: 17', '45.177.43.5'),
(432, 71, '2025-02-04 20:59:17', 'Delete user: 3', '45.177.43.5'),
(433, 71, '2025-02-04 21:17:16', 'Add budget', '45.177.43.5'),
(434, 71, '2025-02-04 21:17:33', 'Add budget', '45.177.43.5'),
(435, 71, '2025-02-04 21:17:44', 'Add budget', '45.177.43.5'),
(436, 71, '2025-02-04 21:17:57', 'Add budget', '45.177.43.5'),
(437, 71, '2025-02-04 21:18:58', 'Update exercise: 17', '45.177.43.5'),
(438, 71, '2025-02-04 21:19:23', 'Delete provider: 1', '45.177.43.5'),
(439, 71, '2025-02-04 21:19:37', 'Delete provider: 4', '45.177.43.5'),
(440, 71, '2025-02-04 21:19:43', 'Delete provider: 3', '45.177.43.5'),
(441, 71, '2025-02-04 21:23:03', 'Send files providers: caratula.pdf', '45.177.43.5'),
(442, 71, '2025-02-04 21:23:03', 'Send files providers: cedula.pdf', '45.177.43.5'),
(443, 71, '2025-02-04 21:29:53', 'Add budget', '45.177.43.5'),
(444, 59, '2025-02-04 21:36:04', 'Send files providers: cedula.pdf', '45.177.43.5'),
(445, 3, '2025-02-05 16:36:34', 'Add budget', '45.177.43.5'),
(446, 71, '2025-02-13 18:56:23', 'Create user: juanpablovg@unimontrer.edu.mx', '45.177.43.5'),
(447, 71, '2025-02-13 21:34:36', 'Send files providers: cedula.pdf', '45.177.43.5'),
(448, 71, '2025-02-13 21:34:36', 'Send files providers: caratula.pdf', '45.177.43.5'),
(449, 7, '2025-02-14 20:35:13', 'Create user: Error: Email duplicado', '189.199.94.210'),
(450, 7, '2025-02-14 20:36:07', 'Create user: Error: Email duplicado', '189.199.94.210'),
(451, 7, '2025-02-14 20:36:33', 'Create user: Error: Email duplicado', '189.199.94.210'),
(452, 7, '2025-02-14 20:37:10', 'Update user: juanpablovg@unimontrer.edu.mx', '189.199.94.210'),
(453, 7, '2025-02-14 20:41:12', 'Update user: juanpablovg@unimontrer.edu.mx', '189.199.94.210'),
(454, 7, '2025-02-14 20:43:14', 'Add departament', '189.199.94.210'),
(455, 7, '2025-02-14 21:06:02', 'Enable provider: 3', '189.199.94.210');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_month_budget`
--

CREATE TABLE `montrer_month_budget` (
  `idMensualBudget` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `budget_month` double NOT NULL,
  `budget_used` double NOT NULL DEFAULT 0,
  `total_used` tinyint(1) DEFAULT NULL,
  `idBudget` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_month_budget`
--

INSERT INTO `montrer_month_budget` (`idMensualBudget`, `month`, `budget_month`, `budget_used`, `total_used`, `idBudget`) VALUES
(132, 1, 16666.67, 0, NULL, 37),
(133, 2, 16666.67, 0, NULL, 37),
(134, 3, 16666.67, 0, NULL, 37),
(135, 4, 16666.67, 0, NULL, 37),
(136, 5, 16666.67, 0, NULL, 37),
(137, 6, 16666.67, 0, NULL, 37),
(138, 7, 16666.67, 0, NULL, 37),
(139, 8, 16666.67, 0, NULL, 37),
(140, 9, 16666.67, 0, NULL, 37),
(141, 10, 16666.67, 0, NULL, 37),
(142, 11, 16666.67, 0, NULL, 37),
(143, 12, 16666.67, 0, NULL, 37),
(144, 1, 125000, 0, NULL, 38),
(145, 2, 125000, 0, NULL, 38),
(146, 3, 125000, 0, NULL, 38),
(147, 4, 125000, 0, NULL, 38),
(148, 5, 125000, 0, NULL, 38),
(149, 6, 125000, 0, NULL, 38),
(150, 7, 125000, 0, NULL, 38),
(151, 8, 125000, 0, NULL, 38),
(152, 9, 125000, 0, NULL, 38),
(153, 10, 125000, 0, NULL, 38),
(154, 11, 125000, 0, NULL, 38),
(155, 12, 125000, 0, NULL, 38),
(156, 1, 41666.67, 0, NULL, 39),
(157, 2, 41666.67, 0, NULL, 39),
(158, 3, 41666.67, 0, NULL, 39),
(159, 4, 41666.67, 0, NULL, 39),
(160, 5, 41666.67, 0, NULL, 39),
(161, 6, 41666.67, 0, NULL, 39),
(162, 7, 41666.67, 0, NULL, 39),
(163, 8, 41666.67, 0, NULL, 39),
(164, 9, 41666.67, 0, NULL, 39),
(165, 10, 41666.67, 0, NULL, 39),
(166, 11, 41666.67, 0, NULL, 39),
(167, 12, 41666.67, 0, NULL, 39),
(168, 1, 83333.33, 0, NULL, 40),
(169, 2, 83333.33, 0, NULL, 40),
(170, 3, 83333.33, 0, NULL, 40),
(171, 4, 83333.33, 0, NULL, 40),
(172, 5, 83333.33, 0, NULL, 40),
(173, 6, 83333.33, 0, NULL, 40),
(174, 7, 83333.33, 0, NULL, 40),
(175, 8, 83333.33, 0, NULL, 40),
(176, 9, 83333.33, 0, NULL, 40),
(177, 10, 83333.33, 0, NULL, 40),
(178, 11, 83333.33, 0, NULL, 40),
(179, 12, 83333.33, 0, NULL, 40),
(180, 1, 41666.67, 0, NULL, 41),
(181, 2, 41666.67, 0, NULL, 41),
(182, 3, 41666.67, 0, NULL, 41),
(183, 4, 41666.67, 0, NULL, 41),
(184, 5, 41666.67, 0, NULL, 41),
(185, 6, 41666.67, 0, NULL, 41),
(186, 7, 41666.67, 0, NULL, 41),
(187, 8, 41666.67, 0, NULL, 41),
(188, 9, 41666.67, 0, NULL, 41),
(189, 10, 41666.67, 0, NULL, 41),
(190, 11, 41666.67, 0, NULL, 41),
(191, 12, 41666.67, 0, NULL, 41),
(192, 1, 83333.33, 0, NULL, 42),
(193, 2, 83333.33, 0, NULL, 42),
(194, 3, 83333.33, 0, NULL, 42),
(195, 4, 83333.33, 0, NULL, 42),
(196, 5, 83333.33, 0, NULL, 42),
(197, 6, 83333.33, 0, NULL, 42),
(198, 7, 83333.33, 0, NULL, 42),
(199, 8, 83333.33, 0, NULL, 42),
(200, 9, 83333.33, 0, NULL, 42),
(201, 10, 83333.33, 0, NULL, 42),
(202, 11, 83333.33, 0, NULL, 42),
(203, 12, 83333.33, 0, NULL, 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_partidas`
--

CREATE TABLE `montrer_partidas` (
  `idPartida` int(11) NOT NULL,
  `Partida` text NOT NULL,
  `numeroPartida` text NOT NULL,
  `idCuenta` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_partidas`
--

INSERT INTO `montrer_partidas` (`idPartida`, `Partida`, `numeroPartida`, `idCuenta`, `status`) VALUES
(3, 'DESFILE 16 DE SEPT', '001', 3, 1),
(4, 'DESFILE 30 DE SEP', '002', 3, 1),
(5, 'DESFILE 20 DE NOV', '003', 3, 1),
(6, 'DESFILE LOS REYES', '004', 3, 1),
(7, 'NOCHE DE MUERTOS MORELIA', '005', 3, 1),
(8, 'NOCHE DE MUERTOS LOS REYES', '006', 3, 1),
(9, 'GRADUACIONES MORELIA', '007', 3, 1),
(10, 'GRADUACIÓN LOS REYES', '008', 3, 1),
(11, 'DIA DE LAS MADRES MORELIA', '009', 3, 1),
(12, 'DIA DE LAS MADRES LOS REYES', '010', 3, 1),
(13, 'DIA DEL MAESTRO MORELIA', '011', 3, 1),
(14, 'DIA DEL MESTRO LOS REYES', '012', 3, 1),
(15, 'DIA DEL ESTUDIANTE MORELIA', '013', 3, 1),
(16, 'DIA DEL ESTUDIANTE LOS REYES', '014', 3, 1),
(17, 'ANIVERSARIO MONTRER', '015', 3, 1),
(18, 'ANIVERSARIO LOS REYES', '016', 3, 1),
(19, 'COMIDA FIN DE AÑO MORELIA', '017', 3, 1),
(20, 'COMIDA FIN DE AÑO LOS REYES', '018', 3, 1),
(21, 'OTROS EVENTOS', '019', 3, 1),
(22, 'COMUNICACION Y ARTE', '001', 4, 1),
(23, 'FISIOTERAPIA Y EDUCACION FISICA', '002', 4, 1),
(24, 'NUTRICION Y PSICOLOGIA', '003', 4, 1),
(25, 'MEDICINA', '004', 4, 1),
(26, 'JUVEVIL (PREPA)', '006', 4, 1),
(27, 'OTRO', '007', 4, 1),
(28, 'CONSURSO DE DISFRACES', '001', 5, 1),
(29, 'FILANTROPIA', '002', 5, 1),
(30, 'APOYO A CRIT', '002', 5, 1),
(31, 'APOYO A FESTIVAL DE MUSICA', '002', 5, 1),
(32, 'GASTOS DE VIAJE DIRECTIVOS', '000', 7, 1),
(33, 'INSCRIPCIONES  Y CUOTAS', '000', 8, 1),
(34, 'GASTOS DE VIAJE DEPORTISTAS', '000', 9, 1),
(35, 'ALIMENTACION DEPORTISTAS', '000', 10, 1),
(36, 'HOSPEDAJE DEPORTISTAS', '000', 11, 1),
(37, 'UNIFORMES DEPORTISTAS', '000', 12, 1),
(38, 'UNIFORMES DIRECTIVOS', '000', 13, 1),
(39, 'GASTOS MEDICOS Y APOYOS', '000', 14, 1),
(40, 'IMPLEMENTOS DEPORTIVOS', '000', 15, 1),
(41, 'CONGRESOS', '000', 16, 1),
(42, 'SERVICIO DE ARBITRAJE', '000', 17, 1),
(43, 'NOTARIALES', '000', 18, 1),
(44, 'REGISTRABLES', '000', 19, 1),
(45, 'AVALUOS', '000', 20, 1),
(46, 'OTROS', '000', 21, 1),
(47, 'IMPRESIONES DE FOLLETERIA PREPAS', '001', 22, 1),
(48, 'IMPRESION DE FOLLETERIA LIC Y POS', '002', 22, 1),
(49, 'IMPRESION FOLLETERIA LOS REYES', '003', 22, 1),
(50, 'MANTAS Y PANCARTAS', '004', 22, 1),
(51, 'MONTAJE DE STANDS', '005', 22, 1),
(52, 'OTROS', '006', 22, 1),
(53, 'PUENTES MORELIA', '001', 23, 1),
(54, 'ESPECTACULARES MORELIA', '002', 23, 1),
(55, 'PUENTES LOS REYES', '003', 23, 1),
(56, 'ESPECTACULARES LOS REYES', '004', 23, 1),
(57, 'OTROS', '005', 23, 1),
(58, 'COMBIS MORELIA', '001', 24, 1),
(59, 'COMBIS LOS REYES', '002', 24, 1),
(60, 'MORELIA', '001', 25, 1),
(61, 'LOS REYES', '002', 25, 1),
(62, 'MORELIA', '001', 26, 1),
(63, 'LOS REYES', '002', 26, 1),
(64, 'LOS REYES', '002', 27, 1),
(65, 'LOS REYES', '002', 28, 1),
(66, 'MORELIA', '001', 27, 1),
(67, 'MORELIA', '001', 28, 1),
(68, 'GOOGLE', '001', 29, 1),
(69, 'FACEBOOK', '002', 29, 1),
(70, 'OTROS', '003', 29, 1),
(71, 'COMISIONES A PROMOTORES', '001', 30, 1),
(72, 'GASTOS DE VIAJE PROMOCIÓN', '002', 30, 1),
(73, 'STANDS Y ARREGLOS', '003', 30, 1),
(74, 'REGALOS DE PROMOCIÓN', '005', 30, 1),
(75, 'OTROS', '006', 30, 1),
(76, 'L.C 1750', '001', 31, 1),
(77, 'L.C 1760', '002', 31, 1),
(78, 'J.M EDIF.1', '003', 31, 1),
(79, 'J.M EDIF.2', '004', 31, 1),
(80, 'EDIF. L.R', '005', 31, 1),
(81, 'RENTA DE MOBILIARIO Y EQUIPOS', '006', 31, 1),
(82, 'RENTA DE VEHICULOS', '007', 31, 1),
(83, 'AGUSTIN MELGAR', '008', 31, 1),
(84, 'BATALLA DE CASA MATA', '009', 31, 1),
(85, 'CASA PANTERAS', '010', 31, 1),
(86, 'L.C 1760', '001', 32, 1),
(87, 'L.C 1750', '002', 32, 1),
(88, 'CASA MATA', '003', 32, 1),
(89, 'AGUSTIN MELGAR', '004', 32, 1),
(90, 'JESUS DEL MONTE', '005', 32, 1),
(91, 'LOS REYES', '006', 32, 1),
(92, 'VEHICULOS', '001', 33, 1),
(93, 'EFDIFICIOS', '002', 33, 1),
(94, 'INSTRUMENTOS', '003', 33, 1),
(95, 'EQUIPO DE COMPUTO Y OFICINA', '004', 33, 1),
(96, 'DISEL AUTOBUSES TRANSPORTE ESC', '001', 34, 1),
(97, 'GASOLINA AUTOS UTILITARIOS', '002', 34, 1),
(98, 'GASOLINA PARA FUNCIONARIOS', '003', 34, 1),
(99, 'PAPELERIA Y ARTICULOS DE OFICINA', '001', 35, 1),
(100, 'LIQUIDOS DE ASEO Y DESINFECCION', '001', 36, 1),
(101, 'PAPEL SANITARIO', '002', 36, 1),
(102, 'TOALLAS PARA MANOS', '003', 36, 1),
(103, 'DESODORANTES', '004', 36, 1),
(104, 'JABON DE MANOS', '005', 36, 1),
(105, 'JABON PARA ASEO', '006', 36, 1),
(106, 'INSTRUMENTOS DE ASEO Y LIMPIEZA', '007', 36, 1),
(107, 'AGUA PARA RIEGO', '001', 37, 1),
(108, 'FERTILIZANTES', '002', 37, 1),
(109, 'INSUMOS PARA FUENTES', '003', 37, 1),
(110, 'ARBOLES Y PLANTAS', '004', 37, 1),
(111, 'HERRAMIENTAS', '005', 37, 1),
(112, 'UNIFORMES', '006', 37, 1),
(113, 'PODAS', '007', 37, 1),
(114, 'COMBUSTIBLES', '008', 37, 1),
(115, 'OTROS', '009', 37, 1),
(116, 'DERECHOS DE LA SECRETARIA DE EDUCACION', '001', 38, 1),
(117, 'DERECHOS A LA DIRECCION DE PROFECIONES', '002', 38, 1),
(118, 'LICENCIAS MUNICIPALES', '003', 38, 1),
(119, 'LICENCIAS SANITARIAS', '004', 38, 1),
(120, 'SEGUROS Y FIANZAS', '005', 38, 1),
(121, 'AGUA PARA ALUMNOS', '001', 39, 1),
(122, 'CUOTAS PARA TIRAR BASURA', '002', 39, 1),
(123, 'MEDICAMENTOS Y BOTIQUIN', '003', 39, 1),
(124, 'MENSAJERIA', '004', 39, 1),
(125, 'UNIFORMES PARA EL PERSONAL ADMINISTRATIV', '005', 39, 1),
(126, 'FUMIGACIONES', '006', 39, 1),
(127, 'SIMULACIONES Y SIMULACROS', '007', 39, 1),
(128, 'CUOTAS ANUALES Y MEMBRESIAS', '008', 39, 1),
(129, 'TIMBRES FISCALES', '009', 39, 1),
(130, 'CONSUMIBLES DE LABORATORIO', '010', 39, 1),
(131, 'RECARGOS', '011', 39, 1),
(132, 'ACTUALIZACIONES', '012', 39, 1),
(133, 'MULTAS', '013', 39, 1),
(134, 'ASESORIA CONTABLE', '014', 39, 1),
(135, 'ACTUALIZACIONES Y MANT A SISTEMAS', '015', 39, 1),
(136, 'APOYO DE GASTOS MEDICOS', '016', 39, 1),
(137, 'DONATIVOS', '017', 39, 1),
(138, 'VIGILANCIA', '018', 39, 1),
(139, 'LIBROS', '019', 39, 1),
(140, 'BIBLIOTECA VIRTUAL', '012', 39, 1),
(141, 'VIGILANCIA EXTERNA', '001', 40, 1),
(142, 'INTENDENCIA EXTERNA', '002', 40, 1),
(143, 'CAJA CHICA RECEPCION', '001', 41, 1),
(144, 'CAJA CHICA RRHH', '002', 41, 1),
(145, 'CAJA CHICA RECTORIA', '004', 41, 1),
(146, 'CAJA CHICA SERVICIOS GENERALES', '005', 41, 1),
(147, 'CAJA CHICA PROMOCION', '006', 41, 1),
(148, 'CAJA CHICA MANTENIMIENTO', '007', 41, 1),
(149, 'CAJA CHICA INFORMATICA', '008', 41, 1),
(150, 'CAJA CHICA LOS REYES', '009', 41, 1),
(151, 'CAJA CHICA CONTROL ESCOLAR', '010', 41, 1),
(152, 'CAJA CHICA AREA DE PROMOCION', '011', 41, 1),
(153, 'ARRENDAMIENTO DE EDIFICIOS', '001', 42, 1),
(154, 'MOBILIARIO Y EQUIPO DE OFICINA', '002', 42, 1),
(155, 'EQUIPO DE COMPUTO Y ELECTRONICOS', '003', 42, 1),
(156, 'MOBILIARIO ESCOLAR', '004', 42, 1),
(157, 'EQUIPO DE LABORATORIOS', '005', 42, 1),
(158, 'AUTOBUSES', '006', 42, 1),
(159, 'AUTOMOVILES', '007', 42, 1),
(160, 'AULANET', '001', 49, 1),
(161, 'SUSCRIPCIONES', '002', 49, 1),
(162, 'SEVEN ARTILLEROS (EMPLEADOS)', '002', 49, 1),
(163, 'SEVEN ARTILLEROS (FAM GONZALEZ GARCIA)', '002', 49, 1),
(164, 'SEVEN ALTOZANO', '002', 49, 1),
(165, 'CAMPESTRE', '002', 49, 1),
(166, 'UNIFORMES', '001', 43, 1),
(167, 'REPOSICIONES', '002', 43, 1),
(168, 'REP DE EQUIPO', '003', 43, 1),
(169, 'ESTANDARTES', '004', 43, 1),
(170, 'OTROS', '005', 43, 1),
(171, 'CUOTAS E INSCRIPCIONES', '001', 44, 1),
(172, 'GASTOS DE HOSPEDAJE', '002', 44, 1),
(173, 'GASTOS DE ALIMENTACIÓN', '003', 44, 1),
(174, 'TRANSPORTE', '004', 44, 1),
(175, 'OTROS', '005', 44, 1),
(176, 'RH PREPARATORIOS', '000', 45, 1),
(177, 'ADMINISTRACIÓN CULTURAL ESCOLAR', '000', 46, 1),
(178, 'ESTUDIOS MULTICULTURALES', '000', 47, 1),
(179, 'TECNOLOGIA Y ADMINISTRACION ESCOLAR', '000', 48, 1),
(180, 'Otro', '001', 50, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_payment_requests`
--

CREATE TABLE `montrer_payment_requests` (
  `idPaymentRequest` int(11) NOT NULL,
  `nombreCompleto` text NOT NULL,
  `fechaSolicitud` date NOT NULL,
  `idProvider` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `importeSolicitado` double NOT NULL,
  `importeLetra` text NOT NULL,
  `titularCuenta` text NOT NULL,
  `entidadBancaria` text NOT NULL,
  `conceptoPago` text NOT NULL,
  `idRequest` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `fechaEnvio` datetime NOT NULL DEFAULT current_timestamp(),
  `statusPayment` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_payment_requests`
--

INSERT INTO `montrer_payment_requests` (`idPaymentRequest`, `nombreCompleto`, `fechaSolicitud`, `idProvider`, `idArea`, `importeSolicitado`, `importeLetra`, `titularCuenta`, `entidadBancaria`, `conceptoPago`, `idRequest`, `idUser`, `fechaEnvio`, `statusPayment`) VALUES
(25, 'HN Gonzalez Garcia', '2024-11-18', 4, 3, 15500, 'Quince mil quinientos pesos', 'Jaime Gomez', 'SANTANDER', 'Trnsf. Gastos de servicios-Banda de guerra-16/9-aasd', 2, 3, '2024-11-19 00:45:17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_providers`
--

CREATE TABLE `montrer_providers` (
  `idProvider` int(11) NOT NULL,
  `provider_key` varchar(10) NOT NULL,
  `representative_name` varchar(255) NOT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `email` text NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) NOT NULL,
  `rfc` varchar(20) NOT NULL,
  `fiscal_address_street` varchar(255) NOT NULL,
  `fiscal_address_colonia` varchar(255) NOT NULL,
  `fiscal_address_municipio` varchar(255) NOT NULL,
  `fiscal_address_estado` varchar(255) NOT NULL,
  `fiscal_address_cp` varchar(10) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_holder` varchar(255) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `clabe` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `extrangero` int(11) NOT NULL DEFAULT 0,
  `swiftCode` text DEFAULT NULL,
  `beneficiaryAddress` text DEFAULT NULL,
  `currencyType` text DEFAULT 'MXN',
  `provider_idUser` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_providers`
--

INSERT INTO `montrer_providers` (`idProvider`, `provider_key`, `representative_name`, `contact_phone`, `email`, `website`, `business_name`, `rfc`, `fiscal_address_street`, `fiscal_address_colonia`, `fiscal_address_municipio`, `fiscal_address_estado`, `fiscal_address_cp`, `bank_name`, `account_holder`, `account_number`, `clabe`, `description`, `extrangero`, `swiftCode`, `beneficiaryAddress`, `currencyType`, `provider_idUser`, `created_at`, `updated_at`, `status`) VALUES
(1, '001', 'AYUNTAMIENTO DE MORELIA', '4433440000', 'PRUEBA@AYUNTAMIENTO.GOM', '', 'AYUNTAMIENTO DE MORELIA', 'XXXXXXXXX', 'PRUEBA', 'prueba', 'MORELIA', 'MICHOACAN', '58260', 'SANTANDER', 'AYUNTAMIENTO DE MORELIA', '5509054456', '014470655090544563', 'LICENCIAS DE CONTRUCCIÓN', 1, '', '', 'MXN', 71, '2025-02-04 21:23:02', '2025-02-05 16:40:29', 1),
(2, '002', 'LIBRERIAS DE MICHOACAN', '4444332200', 'prueba@gmail.com', '', 'LIBRERIAS HIDALGO DE MICHOACAN ', 'XXXXXXXXX', 'PRUEBA', 'PRUEBA', 'MORELIA', 'MICHOACAN', '58260', 'BBVA', 'LIBRERIAS HIDALGO DE MICHOACAN ', '0182240629  ', '012470001822406292', 'LIBROS ESCOLARES', 1, '', '', 'MXN', 59, '2025-02-04 21:36:04', '2025-02-05 16:40:33', 1),
(3, '00325', 'MARIA DEL CARMEN HERRERA CARRILLO', '4431597477', 'facturasbw2020@hotmail.com', '', 'MARIA DEL CARMEN HERRERA CARRILLO', 'HECC860330HK6', ' Fray Luis de Fuensalida 18', 'La unión', 'MORELIA', 'MICHOACAN', '58226', 'BBVA', 'MARIA DEL CARMEN HERRERA CARRILLO', '012470028604763152', '012470028604763152', 'PIPAS DE AGUA', 1, '', '', NULL, 71, '2025-02-13 21:34:36', '2025-02-14 21:06:02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_settings`
--

CREATE TABLE `montrer_settings` (
  `idUser` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `root` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_settings`
--

INSERT INTO `montrer_settings` (`idUser`, `level`, `status`, `root`) VALUES
(3, 1, 1, 0),
(5, 2, 1, 0),
(7, 1, 1, 0),
(32, 1, 1, 0),
(39, 2, 1, 0),
(56, 2, 1, 0),
(57, 2, 1, 0),
(58, 2, 1, 0),
(59, 2, 1, 0),
(60, 2, 1, 0),
(61, 2, 1, 0),
(62, 2, 1, 0),
(63, 2, 1, 0),
(64, 2, 1, 0),
(65, 2, 1, 0),
(66, 2, 1, 0),
(67, 2, 1, 0),
(68, 2, 1, 0),
(69, 2, 1, 0),
(70, 2, 1, 0),
(71, 1, 1, 0),
(72, 2, 1, 0),
(73, 2, 1, 0),
(74, 2, 1, 0),
(75, 2, 1, 0),
(76, 2, 1, 0),
(77, 2, 1, 0),
(78, 2, 1, 0),
(79, 2, 1, 0),
(81, 2, 1, 0),
(82, 2, 1, 0),
(83, 2, 1, 0),
(84, 2, 1, 0),
(85, 2, 1, 0),
(86, 2, 1, 0),
(87, 2, 1, 0),
(88, 2, 1, 0),
(89, 2, 1, 0),
(90, 2, 1, 0),
(91, 2, 1, 0),
(92, 2, 1, 0),
(93, 2, 1, 0),
(94, 2, 1, 0),
(95, 2, 1, 0),
(96, 2, 1, 0),
(97, 2, 1, 0),
(98, 2, 1, 0),
(99, 2, 1, 0),
(101, 2, 1, 0),
(102, 2, 1, 0),
(104, 2, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_temporal_password`
--

CREATE TABLE `montrer_temporal_password` (
  `temporal_password` text NOT NULL,
  `User_idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_temporal_password`
--

INSERT INTO `montrer_temporal_password` (`temporal_password`, `User_idUser`) VALUES
('$2a$07$asxx54ahjppf45sd87a5auo.BhOpLl1HoMFVi0yf0zY/wD0KuZaRC', 98);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_users`
--

CREATE TABLE `montrer_users` (
  `idUsers` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `employerCode` text DEFAULT NULL,
  `createDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastConection` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_users`
--

INSERT INTO `montrer_users` (`idUsers`, `firstname`, `lastname`, `email`, `password`, `employerCode`, `createDate`, `lastConection`, `deleted`) VALUES
(3, 'HN', 'Gonzalez Garcia', 'henogoga@outlook.com1', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '1000-000-000-001', '2024-01-05 04:06:44', '2025-02-13 23:34:12', 1),
(5, 'Noel', 'González García', 'henogoga@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', NULL, '2024-01-12 18:50:49', '2024-04-29 14:47:22', 0),
(7, 'ADRIANA ', 'CISNEROS RUÍZ', 'acisneros@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auCfiqicx9GhQzMF3snzN2Ijai6QoaqJq', NULL, '2024-01-12 20:31:28', '2025-03-03 11:04:04', 0),
(32, 'Administrador', 'General', 'admin@example.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', NULL, '2024-03-11 15:19:31', '2025-01-31 15:54:24', 0),
(39, 'Noel', 'González', 'henogoga@gmail1.com', '$2a$07$asxx54ahjppf45sd87a5auR21yuXMXGZBLx/IDE7UDT641kJYyeeK', NULL, '2024-04-29 19:59:42', '2024-11-26 13:18:40', 0),
(56, 'CHRISTIAN ALEJANDRO ', 'GAONA PERALTA', 'bandadeguerra@unimontrer.edu.mx', '', NULL, '2024-11-30 03:57:18', '0000-00-00 00:00:00', 0),
(57, 'JESÚS EDUARDO', 'CASTORENA ELIZONDO', 'direccioncm@unimontrer.edu.mx', '', NULL, '2024-11-30 03:57:40', '0000-00-00 00:00:00', 0),
(58, 'YAZMÍN SELENE', 'DEL CARMEN ROJAS', 'ysdelcarmen@unimontrer.edu.mx', '', NULL, '2024-11-30 03:58:07', '0000-00-00 00:00:00', 0),
(59, 'ANTONIO AGUSTÍN', 'GALLEGOS DOMÍNGUEZ', 'deptoidiomas@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auCfiqicx9GhQzMF3snzN2Ijai6QoaqJq', NULL, '2024-11-30 03:58:25', '2025-02-14 15:09:38', 0),
(60, 'JOSÉ ALEJANDRO ', 'LÓPEZ CONTRERAS', 'vinculaciondeportiva@unimontrer.edu.mx', '', NULL, '2024-11-30 03:58:57', '0000-00-00 00:00:00', 0),
(61, 'BLANCA PALOMA', 'GONZALEZ HERRERA', 'pgonzalez@unimontrer.edu.mx', '', NULL, '2024-11-30 03:59:36', '0000-00-00 00:00:00', 0),
(62, 'BRISA EGAI', 'BOLAÑOS ESQUIVEL ', 'cafeteria@unimontrer.edu.mx', '', NULL, '2024-11-30 03:59:49', '0000-00-00 00:00:00', 0),
(63, 'DIANA DOLORES ', 'HUITRÓN ÁLVAREZ ', 'dhuitron@unimontrer.edu.mx', '', '1000-001-001-003', '2024-11-30 04:00:04', '0000-00-00 00:00:00', 0),
(64, 'MIREYA SUSANA', 'PÉREZ HERNÁNDEZ ', 'serviciosescolares@unimontrer.edu.mx', '', '1000-001-001-001', '2024-11-30 04:00:20', '0000-00-00 00:00:00', 0),
(65, 'CLAUDIA YADIRA', 'PÉREZ RUIZ ', 'direccionprepa@unimontrer.edu.mx', '', NULL, '2024-11-30 04:00:32', '0000-00-00 00:00:00', 0),
(66, 'OSCAR', 'CORNEJO CARLON ', 'ocornejo@unimontrer.edu.mx', '', NULL, '2024-11-30 04:00:44', '0000-00-00 00:00:00', 0),
(67, 'LUIS ENRIQUE', 'VILLAGOMEZ CARRANZA ', 'levillagomezca@unimontrer.edu.mx', '', NULL, '2024-11-30 04:00:57', '0000-00-00 00:00:00', 0),
(68, 'AARÓN', 'PRADO USEDA ', 'informatica@unimontrer.edu.mx', '', '1000-001-001-007', '2024-11-30 04:01:14', '0000-00-00 00:00:00', 0),
(69, 'MARÍA DEL SOCORRO', 'ESCAMILLA BARRERA ', 'msescamillab@unimontrer.edu.mx', '', NULL, '2024-11-30 04:01:27', '0000-00-00 00:00:00', 0),
(70, 'VANESSA SARAHÍ', 'DEGOLLADO PALOMARES ', 'vsdegollado@unimontrer.edu.mx', '', '1000-001-001-011', '2024-11-30 04:01:43', '0000-00-00 00:00:00', 0),
(71, 'J NOE ', 'GONZALEZ GOMEZ ', 'rectoria@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auCfiqicx9GhQzMF3snzN2Ijai6QoaqJq', '1000-001-004-005', '2024-11-30 04:01:56', '2025-02-13 12:49:10', 0),
(72, 'CARLOS ', 'GONZALEZ HERRERA ', 'direccionsga@unimontrer.edu.mx', '', NULL, '2024-11-30 04:02:17', '0000-00-00 00:00:00', 0),
(73, 'EPIOLOTZIN', 'HERNÁNDEZ ESQUIVEL', 'asistenterectoria@unimontrer.edu.mx', '', '1000-001-001-004', '2024-11-30 04:02:36', '0000-00-00 00:00:00', 0),
(74, 'DANIELA YISEL', 'ORTEGA GONZÁLEZ ', 'dyortega@unimontrer.edu.mx', '', NULL, '2024-11-30 04:02:50', '0000-00-00 00:00:00', 0),
(75, 'ADRIANA ', 'GARCIA VEGA NAVARRO ', 'congresos@unimontrer.edu.mx', '', NULL, '2024-11-30 04:03:18', '0000-00-00 00:00:00', 0),
(76, 'NOE ALONSO ', 'GONZALEZ HERRERA ', 'rectorad@unimontrer.edu.mx', '', NULL, '2024-11-30 04:03:50', '0000-00-00 00:00:00', 0),
(77, 'DULCE MARÍA', 'HERNÁNDEZ GUTIÉRREZ', 'recursoshumanos@unimontrer.edu.mx', '', '1000-001-001-002', '2024-11-30 04:04:06', '0000-00-00 00:00:00', 0),
(78, 'RITA ISABEL', 'MORALES GARCÍA ', 'imorales@unimontrer.edu.mx', '', NULL, '2024-11-30 04:04:17', '0000-00-00 00:00:00', 0),
(79, 'JULIETA', 'GIL GIL ', 'serviciosgenerales@unimontrer.edu.mx', '', '1000-001-001-005', '2024-11-30 04:04:34', '0000-00-00 00:00:00', 0),
(81, 'NEREYDA ISABEL', 'ISLA CASTAÑEDA ', 'admonposgrados@unimontrer.edu.mx', '', NULL, '2024-11-30 04:04:45', '0000-00-00 00:00:00', 0),
(82, 'ALFREDO', 'GUZMÁN DÍAZ ', 'derecho@unimontrer.edu.mx', '', NULL, '2024-11-30 04:04:57', '0000-00-00 00:00:00', 0),
(83, 'OSCAR ', 'LÓPEZ GARCÍA ', 'admonynegocios@unimontrer.edu.mx', '', NULL, '2024-11-30 04:05:16', '0000-00-00 00:00:00', 0),
(84, 'RENÉ', 'MENA RAMOS', 'educacionfisica@unimontrer.edu.mx', '', NULL, '2024-11-30 04:05:31', '0000-00-00 00:00:00', 0),
(85, 'JESÚS ', 'ORTEGA LÓPEZ ', 'psicologiayeducacion@unimontrer.edu.mx', '', NULL, '2024-11-30 04:05:43', '0000-00-00 00:00:00', 0),
(86, 'LILIA', 'RIVERA ORTIZ', 'vicerrectoriaunimo@unimontrer.edu.mx', '', NULL, '2024-11-30 04:05:55', '0000-00-00 00:00:00', 0),
(87, 'KARLA MARIANA', 'FONSECA MUNGUIA', 'direccionuruapan@unimontrer.edu.mx', '', NULL, '2024-11-30 04:06:06', '0000-00-00 00:00:00', 0),
(88, 'JENNIFER HITLAHUIT', 'AGUIRRE MAGALLON ', 'direccionapatzingan@unimontrer.edu.mx', '', '1000-001-001-009', '2024-11-30 04:06:19', '0000-00-00 00:00:00', 0),
(89, 'ANA LISBET ', 'HEREDIA NARANJO ', 'losreyes@unimontrer.edu.mx', '', '1000-001-001-008', '2024-11-30 04:06:29', '0000-00-00 00:00:00', 0),
(90, 'JORGE ALBERTO', 'ALBA MUÑOZ ', 'audioysonido@unimontrer.edu.mx', '', NULL, '2024-11-30 04:06:41', '0000-00-00 00:00:00', 0),
(91, 'MIRELLA', 'ARAIZA MARTÍNEZ ', 'areadelasalud@unimontrer.edu.mx', '', NULL, '2024-11-30 04:06:51', '0000-00-00 00:00:00', 0),
(92, 'ADRIANA MARÍA', 'ARRUBLA ECHAVARRIA ', 'amarrublae@unimontrer.edu.mx', '', NULL, '2024-11-30 04:07:03', '0000-00-00 00:00:00', 0),
(93, 'EUGENIA MARÍA', 'CÁRDENAS CHAPA ', 'comunicacionyarte@unimontrer.edu.mx', '', NULL, '2024-11-30 04:07:13', '0000-00-00 00:00:00', 0),
(94, 'MAYRA', 'CEDEÑO SÁNCHEZ ', 'vicerrectoria@unimontrer.edu.mx', '', NULL, '2024-11-30 04:07:23', '0000-00-00 00:00:00', 0),
(95, 'LISSANDRA THERESA', 'LEMUS ÁLVAREZ ', 'imageninstitucional@unimontrer.edu.mx', '', NULL, '2024-11-30 04:07:38', '0000-00-00 00:00:00', 0),
(96, 'ANDREA XIMENA', 'PÉREZ TINOCO ', 'arquitecturaeingenierias@unimontrer.edu.mx', '', NULL, '2024-11-30 04:07:48', '0000-00-00 00:00:00', 0),
(97, 'MONSERRAT GUADALUPE', 'SIERRA ACOSTA ', 'redessociales@unimontrer.edu.mx', '', NULL, '2024-11-30 04:08:33', '0000-00-00 00:00:00', 0),
(98, 'Juan Pablo', 'Valle Gonzalez', 'juanpablovg@unimontrer.edu.mx', '', '1000-001-005-057', '2025-02-13 18:56:20', '0000-00-00 00:00:00', 0),
(99, 'SAMANTHA', 'S.G.', 'serviciosgeneralesjm@unimontrer.edu.mx', '', '1000-001-005-058', '2025-02-14 20:34:44', '0000-00-00 00:00:00', 0),
(101, 'SAMANTHA', 'S.G.', 'serviciosgeneralesjm-1@unimontrer.edu.mx', '', '1000-001-005-058', '2025-02-14 20:35:31', '0000-00-00 00:00:00', 0),
(102, 'SAMANTHA', 'S.G.', 'serviciosgeneralesjm1@unimontrer.edu.mx', '', '1000-001-005-058', '2025-02-14 20:35:37', '0000-00-00 00:00:00', 0),
(104, 'SAMANTHA', 'GARCIA', 'sg@unimontrer.edu.mx', '', '1000-001-005-058', '2025-02-14 20:36:19', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_users_to_areas`
--

CREATE TABLE `montrer_users_to_areas` (
  `idUser` int(11) NOT NULL,
  `idArea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_users_to_areas`
--

INSERT INTO `montrer_users_to_areas` (`idUser`, `idArea`) VALUES
(66, 36),
(67, 36),
(57, 31),
(60, 22),
(7, 33),
(61, 33),
(63, 34),
(64, 34),
(65, 35),
(68, 37),
(69, 38),
(70, 39),
(71, 40),
(73, 40),
(74, 40),
(72, 41),
(75, 42),
(76, 42),
(77, 43),
(78, 43),
(79, 44),
(81, 47),
(82, 48),
(83, 48),
(84, 48),
(85, 48),
(86, 48),
(87, 48),
(88, 48),
(89, 48),
(90, 49),
(91, 49),
(92, 49),
(93, 49),
(94, 49),
(95, 49),
(96, 49),
(97, 49),
(60, 51),
(7, 52),
(73, 52),
(73, 54),
(3, 3),
(56, 3),
(7, 55),
(3, 53),
(32, 53),
(67, 53),
(70, 53),
(72, 53),
(94, 53),
(56, 50),
(60, 50),
(67, 50),
(75, 50),
(76, 50),
(79, 50),
(83, 50),
(86, 50),
(89, 50),
(90, 50),
(91, 50),
(94, 50),
(95, 50),
(96, 50),
(59, 20),
(58, 19),
(98, 40),
(99, 46),
(101, 46),
(102, 46),
(104, 46),
(63, 56);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_users_to_business`
--

CREATE TABLE `montrer_users_to_business` (
  `idBusiness` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idBusinessUser` bigint(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_users_to_business`
--

INSERT INTO `montrer_users_to_business` (`idBusiness`, `idUser`, `idBusinessUser`) VALUES
(2, 3, 1000001001001),
(2, 5, 1000001001002),
(2, 7, 1000001001003),
(2, 32, 1000001001006),
(2, 39, 1000001001010);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `montrer_area`
--
ALTER TABLE `montrer_area`
  ADD PRIMARY KEY (`idArea`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `montrer_budgets`
--
ALTER TABLE `montrer_budgets`
  ADD PRIMARY KEY (`idBudget`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idExercise` (`idExercise`);

--
-- Indices de la tabla `montrer_budget_requests`
--
ALTER TABLE `montrer_budget_requests`
  ADD PRIMARY KEY (`idRequest`),
  ADD UNIQUE KEY `folio` (`folio`) USING HASH,
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idBudget` (`idBudget`),
  ADD KEY `idAdmin` (`idAdmin`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idProvider` (`idProvider`);

--
-- Indices de la tabla `montrer_business`
--
ALTER TABLE `montrer_business`
  ADD PRIMARY KEY (`idBusiness`);

--
-- Indices de la tabla `montrer_conceptos`
--
ALTER TABLE `montrer_conceptos`
  ADD PRIMARY KEY (`idConcepto`),
  ADD KEY `idPartida` (`idPartida`);

--
-- Indices de la tabla `montrer_cuentas`
--
ALTER TABLE `montrer_cuentas`
  ADD PRIMARY KEY (`idCuenta`),
  ADD KEY `idArea` (`idArea`);

--
-- Indices de la tabla `montrer_exercise`
--
ALTER TABLE `montrer_exercise`
  ADD PRIMARY KEY (`idExercise`),
  ADD KEY `idRoot` (`idRoot`);

--
-- Indices de la tabla `montrer_logs`
--
ALTER TABLE `montrer_logs`
  ADD PRIMARY KEY (`idLog`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `montrer_month_budget`
--
ALTER TABLE `montrer_month_budget`
  ADD PRIMARY KEY (`idMensualBudget`),
  ADD KEY `idBudget` (`idBudget`);

--
-- Indices de la tabla `montrer_partidas`
--
ALTER TABLE `montrer_partidas`
  ADD PRIMARY KEY (`idPartida`),
  ADD KEY `idCuenta` (`idCuenta`);

--
-- Indices de la tabla `montrer_payment_requests`
--
ALTER TABLE `montrer_payment_requests`
  ADD PRIMARY KEY (`idPaymentRequest`);

--
-- Indices de la tabla `montrer_providers`
--
ALTER TABLE `montrer_providers`
  ADD PRIMARY KEY (`idProvider`),
  ADD KEY `provider_idUser` (`provider_idUser`);

--
-- Indices de la tabla `montrer_settings`
--
ALTER TABLE `montrer_settings`
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `montrer_temporal_password`
--
ALTER TABLE `montrer_temporal_password`
  ADD KEY `User_idUser` (`User_idUser`);

--
-- Indices de la tabla `montrer_users`
--
ALTER TABLE `montrer_users`
  ADD PRIMARY KEY (`idUsers`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indices de la tabla `montrer_users_to_areas`
--
ALTER TABLE `montrer_users_to_areas`
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idArea` (`idArea`);

--
-- Indices de la tabla `montrer_users_to_business`
--
ALTER TABLE `montrer_users_to_business`
  ADD UNIQUE KEY `idBusinessUser` (`idBusinessUser`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idBusiness` (`idBusiness`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `montrer_area`
--
ALTER TABLE `montrer_area`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `montrer_budgets`
--
ALTER TABLE `montrer_budgets`
  MODIFY `idBudget` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `montrer_budget_requests`
--
ALTER TABLE `montrer_budget_requests`
  MODIFY `idRequest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `montrer_business`
--
ALTER TABLE `montrer_business`
  MODIFY `idBusiness` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `montrer_conceptos`
--
ALTER TABLE `montrer_conceptos`
  MODIFY `idConcepto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=398;

--
-- AUTO_INCREMENT de la tabla `montrer_cuentas`
--
ALTER TABLE `montrer_cuentas`
  MODIFY `idCuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `montrer_exercise`
--
ALTER TABLE `montrer_exercise`
  MODIFY `idExercise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `montrer_logs`
--
ALTER TABLE `montrer_logs`
  MODIFY `idLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=456;

--
-- AUTO_INCREMENT de la tabla `montrer_month_budget`
--
ALTER TABLE `montrer_month_budget`
  MODIFY `idMensualBudget` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT de la tabla `montrer_partidas`
--
ALTER TABLE `montrer_partidas`
  MODIFY `idPartida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT de la tabla `montrer_payment_requests`
--
ALTER TABLE `montrer_payment_requests`
  MODIFY `idPaymentRequest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `montrer_providers`
--
ALTER TABLE `montrer_providers`
  MODIFY `idProvider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `montrer_users`
--
ALTER TABLE `montrer_users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `montrer_area`
--
ALTER TABLE `montrer_area`
  ADD CONSTRAINT `area_idUser` FOREIGN KEY (`idUser`) REFERENCES `montrer_users` (`idUsers`);

--
-- Filtros para la tabla `montrer_budgets`
--
ALTER TABLE `montrer_budgets`
  ADD CONSTRAINT `Area_idArea` FOREIGN KEY (`idArea`) REFERENCES `montrer_area` (`idArea`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Exercise_idExercise` FOREIGN KEY (`idExercise`) REFERENCES `montrer_exercise` (`idExercise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_budget_requests`
--
ALTER TABLE `montrer_budget_requests`
  ADD CONSTRAINT `montrer_budget_requests_ibfk_1` FOREIGN KEY (`idBudget`) REFERENCES `montrer_budgets` (`idBudget`),
  ADD CONSTRAINT `montrer_budget_requests_ibfk_2` FOREIGN KEY (`idArea`) REFERENCES `montrer_area` (`idArea`),
  ADD CONSTRAINT `montrer_budget_requests_ibfk_3` FOREIGN KEY (`idAdmin`) REFERENCES `montrer_users` (`idUsers`);

--
-- Filtros para la tabla `montrer_conceptos`
--
ALTER TABLE `montrer_conceptos`
  ADD CONSTRAINT `concepto_idPartida` FOREIGN KEY (`idPartida`) REFERENCES `montrer_partidas` (`idPartida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_cuentas`
--
ALTER TABLE `montrer_cuentas`
  ADD CONSTRAINT `cuenta_idArea` FOREIGN KEY (`idArea`) REFERENCES `montrer_area` (`idArea`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_logs`
--
ALTER TABLE `montrer_logs`
  ADD CONSTRAINT `idUser_Log` FOREIGN KEY (`idUser`) REFERENCES `montrer_users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_month_budget`
--
ALTER TABLE `montrer_month_budget`
  ADD CONSTRAINT `montrer_budget_idBudget` FOREIGN KEY (`idBudget`) REFERENCES `montrer_budgets` (`idBudget`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_partidas`
--
ALTER TABLE `montrer_partidas`
  ADD CONSTRAINT `partida_idCuenta` FOREIGN KEY (`idCuenta`) REFERENCES `montrer_cuentas` (`idCuenta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_providers`
--
ALTER TABLE `montrer_providers`
  ADD CONSTRAINT `provider_idUser` FOREIGN KEY (`provider_idUser`) REFERENCES `montrer_users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_settings`
--
ALTER TABLE `montrer_settings`
  ADD CONSTRAINT `montrer_settings_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `montrer_users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_temporal_password`
--
ALTER TABLE `montrer_temporal_password`
  ADD CONSTRAINT `User_idUser` FOREIGN KEY (`User_idUser`) REFERENCES `montrer_users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `montrer_users_to_areas`
--
ALTER TABLE `montrer_users_to_areas`
  ADD CONSTRAINT `area_to_user` FOREIGN KEY (`idArea`) REFERENCES `montrer_area` (`idArea`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_to_area` FOREIGN KEY (`idUser`) REFERENCES `montrer_users` (`idUsers`) ON DELETE CASCADE;

--
-- Filtros para la tabla `montrer_users_to_business`
--
ALTER TABLE `montrer_users_to_business`
  ADD CONSTRAINT `fk_business` FOREIGN KEY (`idBusiness`) REFERENCES `montrer_business` (`idBusiness`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`idUser`) REFERENCES `montrer_users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
