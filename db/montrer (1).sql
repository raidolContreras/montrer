-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2024 a las 09:21:39
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
-- Base de datos: `montrer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_area`
--

CREATE TABLE `montrer_area` (
  `idArea` int(11) NOT NULL,
  `nameArea` text NOT NULL,
  `description` text NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_area`
--

INSERT INTO `montrer_area` (`idArea`, `nameArea`, `description`, `idUser`, `status`, `active`) VALUES
(3, 'Banda de guerra', 'Banda de guerra instituto Montrer', 3, 1, 1),
(19, 'Contabilidad', 'Contabilidad general Montrer', 7, 1, 1),
(20, 'Plataforma', 'Responsabe de llevar la plataforma en Montrer', 39, 1, 1),
(22, 'Viajes', 'Organiza todos los viajes institucionales', 39, 1, 1);

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
(28, 3, 200000, 1, 1),
(30, 20, 125000, 1, 1),
(31, 22, 50000, 1, 1),
(34, 19, 50000, 1, 1);

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
(2, 'HN Gonzalez Garcia', 'colegios.pucp.net', 'rrr', 'wwwww', 'eee', '1111-111-111-111', '2222-222-222-222-222', '3333-333-333-333-333', '4444-444-444-444-444', '5555-555-555-555-555', 15500, 'Quince mil quinientos pesos', '2024-11-28', '5642536599652565', 'SANTANDER', '55256352445', 'ASD22', 'ASDAQQ', 'ASDAEE', 'Trnsf. Gastos de servicios-Banda de guerra-16/9-aasd', '1BDG241118', 15500, NULL, '2024-11-18 23:55:07', 5, 0, 1, '2024-11-22', 'Los archivos están correctos', '2024-11-19 04:46:36', 3, 4, 28, 3, 3, '2222', '1111', 'EG', '125562', 15500, 15500, 1),
(3, 'HN Gonzalez Garcia', 'colegios.pucp.net', 'rrr', 'wwwww', 'eee', NULL, NULL, NULL, NULL, NULL, 35000, 'Treinta y cinco mil pesos', '2024-11-28', '34567789996', 'BBVA', '58980398', NULL, NULL, NULL, 'cheque. Gastos de servicios-Banda de guerra-16/9-aasd', '3BDG241119', NULL, NULL, NULL, 0, NULL, 0, '2024-11-22', NULL, '2024-11-19 06:54:32', NULL, 2, 28, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0);

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
(1, 'Ejercicio 2024', '2024-01-01', '2024-12-31', 2000000, 1, 1350000, 1, '2024-01-02 16:51:51');

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
(1, 3, '2024-03-19 17:24:54', 'Disable User: 32', '127.0.0.1'),
(2, 3, '2024-03-19 17:25:06', 'Enable User: 32', '127.0.0.1'),
(3, 3, '2024-03-19 17:25:18', 'Enable area: 20', '127.0.0.1'),
(4, 3, '2024-03-21 17:12:51', 'Disable Exercise: 8', '127.0.0.1'),
(5, 3, '2024-03-19 17:26:24', 'Enable Exercise: 8', '127.0.0.1'),
(6, 3, '2024-03-19 17:30:33', 'Disable budget: 29', '127.0.0.1'),
(7, 3, '2024-03-19 17:30:41', 'Enable budget: 29', '127.0.0.1'),
(8, 3, '2024-03-21 15:03:11', 'Activate exercise: 8', '127.0.0.1'),
(9, 3, '2024-03-25 06:01:33', 'Update departament: 20', '2806:103e:2d:77f2:71b4:e8b4:7d58:35bf'),
(10, 3, '2024-03-25 06:02:42', 'Add Budget', '2806:103e:2d:77f2:71b4:e8b4:7d58:35bf'),
(11, 3, '2024-03-25 06:05:57', 'Update departament: 22', '2806:103e:2d:77f2:71b4:e8b4:7d58:35bf'),
(12, 5, '2024-03-27 18:59:24', 'Create request: 8000', '2806:103e:1d:d30f:95cd:a613:6bc8:b2cf'),
(13, 5, '2024-03-30 15:45:43', 'Create request: 5000', '127.0.0.1'),
(14, 5, '2024-03-30 15:56:40', 'Create request: 5000', '127.0.0.1'),
(15, 3, '2024-03-30 16:08:48', 'Enable request: 2', '127.0.0.1'),
(16, 5, '2024-03-30 16:12:06', 'Create request: 5000', '127.0.0.1'),
(17, 5, '2024-03-30 16:58:55', 'Create request: 4000', '127.0.0.1'),
(18, 3, '2024-03-30 17:13:23', 'Denegate request: 6', '127.0.0.1'),
(19, 5, '2024-03-30 17:23:42', 'Create request: 16000', '127.0.0.1'),
(20, 5, '2024-03-30 17:27:00', 'Delete request: 6', '127.0.0.1'),
(21, 3, '2024-03-30 17:47:01', 'Enable request: 2', '127.0.0.1'),
(22, 3, '2024-03-30 18:01:23', 'Acept comprobation: 2', '127.0.0.1'),
(23, 5, '2024-03-30 18:07:48', 'Send files comprobation: folio.jpg', '127.0.0.1'),
(24, 5, '2024-03-30 18:11:21', 'Send files comprobation: ccm intensivo 2022.jpg', '127.0.0.1'),
(25, 5, '2024-03-30 18:11:58', 'Send files comprobation: Curso ordinario 2024.png', '127.0.0.1'),
(26, 5, '2024-03-30 18:13:09', 'Send files comprobation: Curso ordinario 2024.png', '127.0.0.1'),
(27, 5, '2024-03-30 18:20:08', 'Create request: 10000', '127.0.0.1'),
(28, 5, '2024-03-31 20:15:54', 'Register provider: 00324', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(29, 5, '2024-03-31 20:18:56', 'Create request: 4000', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(30, 3, '2024-03-31 20:28:53', 'Denegate comprobation: 2', '2806:103e:2d:77f2:d787:ff7b:cbb1:a479'),
(31, 3, '2024-03-31 20:28:53', 'Denegate comprobation: 2', '2806:103e:2d:77f2:d787:ff7b:cbb1:a479'),
(32, 5, '2024-03-31 20:51:55', 'Send files comprobation: {RL} 08-21-Thermomix (1).pdf', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(33, 3, '2024-03-31 20:52:40', 'Enable request: 9', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(34, 5, '2024-03-31 20:55:51', 'Send files comprobation: 15731_242F4BC5-84B3-465B-A068-C20F441C9735.pdf', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(35, 3, '2024-03-31 20:57:08', 'Acept comprobation: 9', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(36, 5, '2024-03-31 21:00:00', 'Create request: 1000', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(37, 3, '2024-03-31 21:01:44', 'Enable request: 10', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(38, 5, '2024-03-31 21:06:34', 'Send files comprobation: Proveedores (1).pdf', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(39, 5, '2024-03-31 21:06:34', 'Send files comprobation: {RL} 08-21-Thermomix (2).pdf', '2806:103e:1d:5d76:a5eb:e6c4:de45:f82b'),
(40, 3, '2024-04-01 07:12:06', 'Update departament: 20', '127.0.0.1'),
(41, 3, '2024-04-01 07:22:07', 'Create request: 666.67', '127.0.0.1'),
(42, 3, '2024-04-01 07:31:35', 'Delete request: 11', '127.0.0.1'),
(43, 3, '2024-04-01 07:36:58', 'Update departament: 20', '127.0.0.1'),
(44, 3, '2024-04-02 13:44:46', 'Send files comprobation: Cotización SW.pdf', '127.0.0.1'),
(45, 3, '2024-04-02 18:24:10', 'Add budget', '2806:103e:1d:5d76:19e1:2723:d761:1d6c'),
(46, 5, '2024-04-02 18:32:06', 'Create request: 10000', '2806:103e:1d:5d76:19e1:2723:d761:1d6c'),
(47, 3, '2024-04-02 18:34:41', 'Enable request: 12', '2806:103e:1d:5d76:19e1:2723:d761:1d6c'),
(48, 5, '2024-04-03 17:05:22', 'Create request: 100000', '127.0.0.1'),
(49, 5, '2024-04-03 17:13:25', 'Delete request: 13', '127.0.0.1'),
(50, 5, '2024-04-03 17:16:04', 'Create request: 35000', '127.0.0.1'),
(51, 5, '2024-04-03 17:16:24', 'Delete request: 14', '127.0.0.1'),
(52, 5, '2024-04-08 19:16:35', 'Delete request: 8', '168.195.206.163'),
(53, 3, '2024-04-08 19:21:06', 'Denegate comprobation: 12', '168.195.206.163'),
(54, 5, '2024-04-08 19:22:33', 'Send files comprobation: 15693_45961668-C98B-420D-9FFF-3E191972D216 (1).pdf', '168.195.206.163'),
(55, 3, '2024-04-08 19:24:00', 'Acept comprobation: 12', '168.195.206.163'),
(56, 5, '2024-04-08 19:36:28', 'Send files comprobation: Prueba.xml', '45.177.43.5'),
(57, 5, '2024-04-08 19:36:28', 'Send files comprobation: 15693_45961668-C98B-420D-9FFF-3E191972D216 (1).pdf', '45.177.43.5'),
(58, 5, '2024-04-08 19:39:45', 'Send files comprobation: 22272780-5de9-4a7f-a716-ff3184d8c97e.xml', '168.195.206.163'),
(59, 5, '2024-04-08 19:39:46', 'Send files comprobation: 15693_45961668-C98B-420D-9FFF-3E191972D216 (1).pdf', '168.195.206.163'),
(60, 3, '2024-04-08 19:42:48', 'Acept comprobation: 2', '168.195.206.163'),
(61, 3, '2024-04-08 19:42:48', 'Acept comprobation: 2', '168.195.206.163'),
(62, 3, '2024-04-08 19:42:48', 'Acept comprobation: 2', '168.195.206.163'),
(63, 3, '2024-04-08 19:42:48', 'Acept comprobation: 2', '168.195.206.163'),
(64, 3, '2024-04-08 19:42:55', 'Acept comprobation: 10', '168.195.206.163'),
(65, 3, '2024-04-08 19:43:04', 'Acept comprobation: 12', '168.195.206.163'),
(66, 5, '2024-04-08 19:44:08', 'Create request: 40000', '168.195.206.163'),
(67, 3, '2024-04-08 19:51:52', 'Denegate request: 15', '168.195.206.163'),
(68, 3, '2024-04-09 19:49:46', 'Enable request: 2', '127.0.0.1'),
(69, 3, '2024-04-09 22:18:20', 'Enable request: 2', '127.0.0.1'),
(70, 3, '2024-04-09 22:18:20', 'Enable request: 2', '127.0.0.1'),
(71, 3, '2024-04-09 22:24:56', 'Enable request: 2', '127.0.0.1'),
(72, 3, '2024-04-10 03:10:03', 'Enable request: 2', '127.0.0.1'),
(73, 3, '2024-04-10 03:13:03', 'Denegate request: 2', '127.0.0.1'),
(74, 3, '2024-04-10 03:15:41', 'Enable request: 2', '127.0.0.1'),
(75, 5, '2024-04-10 06:01:52', 'Send files comprobation: 560 (2).xml', '127.0.0.1'),
(76, 5, '2024-04-10 06:01:53', 'Send files comprobation: 560 (2).pdf', '127.0.0.1'),
(77, 5, '2024-04-10 06:03:34', 'Send files comprobation: 560 (2).pdf', '127.0.0.1'),
(78, 5, '2024-04-10 06:03:34', 'Send files comprobation: 560 (2).xml', '127.0.0.1'),
(79, 3, '2024-04-10 06:15:07', 'Acept comprobation: 2', '127.0.0.1'),
(80, 3, '2024-04-10 06:39:33', 'Denegate comprobation: 2', '127.0.0.1'),
(81, 5, '2024-04-10 07:08:43', 'Send files comprobation: 560 (2).xml', '127.0.0.1'),
(82, 5, '2024-04-10 07:08:43', 'Send files comprobation: 560 (2).pdf', '127.0.0.1'),
(83, 3, '2024-04-10 07:09:00', 'Acept comprobation: 2', '127.0.0.1'),
(84, 3, '2024-04-10 07:11:25', 'Acept comprobation: 2', '127.0.0.1'),
(85, 3, '2024-04-10 07:12:57', 'Acept comprobation: 2', '127.0.0.1'),
(86, 5, '2024-04-10 17:58:14', 'Create request: 10000', '168.195.206.163'),
(87, 3, '2024-04-10 18:00:51', 'Denegate request: 16', '168.195.206.163'),
(88, 5, '2024-04-10 18:01:51', 'Create request: 11000', '168.195.206.163'),
(89, 3, '2024-04-10 18:02:27', 'Enable request: 17', '168.195.206.163'),
(90, 5, '2024-04-10 18:10:15', 'Send files comprobation: SHE MARZO 24.xml', '168.195.206.163'),
(91, 5, '2024-04-10 18:10:15', 'Send files comprobation: CSF HECTOR 08_03_24.pdf', '168.195.206.163'),
(92, 3, '2024-04-10 18:11:22', 'Acept comprobation: 17', '168.195.206.163'),
(93, 3, '2024-04-10 18:24:00', 'Update user: henogoga@outlook.com', '168.195.206.163'),
(94, 3, '2024-04-10 18:24:08', 'Disable user: 3', '168.195.206.163'),
(95, 3, '2024-04-10 18:24:19', 'Update user: henogoga@outlook.com1', '168.195.206.163'),
(96, 3, '2024-04-10 18:24:45', 'Enable user: 3', '168.195.206.163'),
(97, 3, '2024-04-10 18:25:40', 'Delete user: 18', '168.195.206.163'),
(98, 3, '2024-04-10 18:52:46', 'Create user: henogoga@outlook.com', '168.195.206.163'),
(99, 34, '2024-04-10 18:56:08', 'Change password', '168.195.206.163'),
(100, 3, '2024-04-10 18:59:45', 'Update departament: 22', '168.195.206.163'),
(101, 3, '2024-04-10 18:59:58', 'Update departament: 22', '168.195.206.163'),
(102, 3, '2024-04-10 19:00:24', 'Update departament: 22', '168.195.206.163'),
(103, 3, '2024-04-10 19:01:06', 'Add departament', '168.195.206.163'),
(104, 3, '2024-04-10 19:02:25', 'Disable departament: 23', '168.195.206.163'),
(105, 3, '2024-04-10 19:07:40', 'Disable exercise: 1', '168.195.206.163'),
(106, 3, '2024-04-10 19:07:46', 'Enable exercise: 1', '168.195.206.163'),
(107, 3, '2024-04-10 19:08:30', 'Activate exercise: 8', '168.195.206.163'),
(108, 3, '2024-04-10 19:08:40', 'Activate exercise: 1', '168.195.206.163'),
(109, 3, '2024-04-10 19:08:54', 'Update exercise: 8', '168.195.206.163'),
(110, 3, '2024-04-10 19:10:18', 'Add exercise', '168.195.206.163'),
(111, 3, '2024-04-10 19:10:58', 'Update exercise: 11', '168.195.206.163'),
(112, 3, '2024-04-10 19:15:43', 'Activate exercise: 11', '168.195.206.163'),
(113, 3, '2024-04-10 19:16:10', 'Activate exercise: 1', '168.195.206.163'),
(114, 3, '2024-04-10 19:17:59', 'Register provider: 00424', '168.195.206.163'),
(115, 3, '2024-04-10 19:19:37', 'Disable provider: 1', '168.195.206.163'),
(116, 3, '2024-04-10 19:20:39', 'Disable provider: 3', '168.195.206.163'),
(117, 3, '2024-04-10 19:22:39', 'Disable provider: 2', '168.195.206.163'),
(118, 3, '2024-04-10 19:22:43', 'Disable provider: 4', '168.195.206.163'),
(119, 3, '2024-04-10 19:23:59', 'Create request: 10000', '168.195.206.163'),
(120, 3, '2024-04-11 01:30:34', 'Add departament', '127.0.0.1'),
(121, 3, '2024-04-11 01:30:53', 'Delete departament: 24', '127.0.0.1'),
(122, 3, '2024-04-11 01:31:20', 'Update departament: 23', '127.0.0.1'),
(123, 3, '2024-04-11 01:31:38', 'Add departament', '127.0.0.1'),
(124, 3, '2024-04-11 01:32:00', 'Add departament', '127.0.0.1'),
(125, 3, '2024-04-11 01:32:05', 'Delete departament: 26', '127.0.0.1'),
(126, 3, '2024-04-11 01:32:10', 'Delete departament: 25', '127.0.0.1'),
(127, 3, '2024-04-11 02:56:01', 'Delete user: 34', '127.0.0.1'),
(128, 3, '2024-04-11 03:05:52', 'Enable provider: 4', '127.0.0.1'),
(129, 3, '2024-04-11 03:08:37', 'Disable provider: 4', '127.0.0.1'),
(130, 3, '2024-04-11 03:08:48', 'Enable provider: 1', '127.0.0.1'),
(131, 3, '2024-04-11 03:08:53', 'Enable provider: 2', '127.0.0.1'),
(132, 3, '2024-04-28 19:57:51', 'Update exercise: 1', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(133, 3, '2024-04-28 19:59:26', 'Add exercise', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(134, 3, '2024-04-28 19:59:51', 'Update exercise: 11', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(135, 3, '2024-04-28 20:00:06', 'Delete exercise: 11', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(136, 3, '2024-04-28 20:00:10', 'Delete exercise: 12', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(137, 3, '2024-04-28 20:00:55', 'Add exercise', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(138, 3, '2024-04-28 20:01:54', 'Update exercise: 13', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(139, 3, '2024-04-28 20:02:06', 'Activate exercise: 13', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(140, 3, '2024-04-28 20:05:09', 'Add exercise', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(141, 3, '2024-04-28 20:05:19', 'Activate exercise: 14', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(142, 3, '2024-04-28 20:09:28', 'Add departament', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(143, 3, '2024-04-28 20:12:09', 'Add departament', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(144, 3, '2024-04-28 20:14:27', 'Delete departament: 27', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(145, 3, '2024-04-28 20:14:32', 'Delete departament: 28', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(146, 3, '2024-04-28 20:20:13', 'Register provider: 00524', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(147, 3, '2024-04-28 20:22:26', 'Register provider: 00624', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(148, 3, '2024-04-28 20:26:43', 'Register provider: 00724', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(149, 3, '2024-04-28 20:30:20', 'Create user: plataforma@unives.mx', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(150, 3, '2024-04-28 20:31:16', 'Create user: Error: Email duplicado', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(151, 3, '2024-04-28 20:31:35', 'Create user: henogoga@ccmmex.com', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(152, 3, '2024-04-28 20:34:55', 'Update user: plataforma@unives.mx1', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(153, 3, '2024-04-28 20:38:02', 'Update user: plataforma@unives.mx', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(154, 35, '2024-04-28 20:38:46', 'Change password', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(155, 3, '2024-04-28 20:40:54', 'Delete user: 37', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(156, 3, '2024-04-28 20:41:13', 'Update departament: 20', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(157, 3, '2024-04-28 21:03:35', 'Add budget', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(158, 35, '2024-04-28 21:04:54', 'Create request: 20000', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(159, 3, '2024-04-28 21:14:30', 'Enable request: 19', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(160, 35, '2024-04-28 21:16:23', 'Send files comprobation: 71751a5a-2f63-4bd6-bd6a-33ee4d739466.pdf', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(161, 35, '2024-04-28 21:16:23', 'Send files comprobation: 71751a5a-2f63-4bd6-bd6a-33ee4d739466.xml', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(162, 3, '2024-04-28 21:16:46', 'Acept comprobation: 19', '2806:103e:1d:bf4e:d1d2:a74f:c7dc:a7e5'),
(163, 3, '2024-04-29 02:04:07', 'Update exercise: 14', '127.0.0.1'),
(164, 3, '2024-04-29 03:19:10', 'Activate exercise: 1', '127.0.0.1'),
(165, 3, '2024-04-29 03:19:25', 'Activate exercise: 8', '127.0.0.1'),
(166, 3, '2024-04-29 03:19:40', 'Activate exercise: 14', '127.0.0.1'),
(167, 3, '2024-04-29 03:47:00', 'Delete departament: 4', '127.0.0.1'),
(168, 3, '2024-04-29 03:51:37', 'Register provider: 00824', '127.0.0.1'),
(169, 3, '2024-04-29 04:07:47', 'Delete provider: 8', '127.0.0.1'),
(170, 3, '2024-04-29 04:07:57', 'Delete provider: 7', '127.0.0.1'),
(171, 3, '2024-04-29 04:08:06', 'Delete provider: 6', '127.0.0.1'),
(172, 3, '2024-04-29 04:13:11', 'Delete provider: 5', '127.0.0.1'),
(173, 3, '2024-04-29 04:13:18', 'Delete provider: 4', '127.0.0.1'),
(174, 3, '2024-04-29 04:45:41', 'Register provider: 00424', '127.0.0.1'),
(175, 3, '2024-04-29 04:45:55', 'Delete provider: 9', '127.0.0.1'),
(176, 3, '2024-04-29 06:46:04', 'Denegate request: 16', '127.0.0.1'),
(177, 3, '2024-04-29 06:46:57', 'Denegate request: 16', '127.0.0.1'),
(178, 3, '2024-04-29 06:50:52', 'Denegate request: 16', '127.0.0.1'),
(179, 3, '2024-04-29 06:52:54', 'Denegate request: 16', '127.0.0.1'),
(180, 3, '2024-04-29 14:41:59', 'Add exercise', '168.195.206.163'),
(181, 3, '2024-04-29 14:42:07', 'Activate exercise: 15', '168.195.206.163'),
(182, 3, '2024-04-29 14:45:50', 'Add departament', '168.195.206.163'),
(183, 3, '2024-04-29 14:46:02', 'Delete departament: 29', '168.195.206.163'),
(184, 3, '2024-04-29 14:49:22', 'Add departament', '168.195.206.163'),
(185, 3, '2024-04-29 14:50:40', 'Delete departament: 30', '168.195.206.163'),
(186, 3, '2024-04-29 14:50:47', 'Delete departament: 23', '168.195.206.163'),
(187, 3, '2024-04-29 15:10:39', 'Update provider: 00324', '127.0.0.1'),
(188, 3, '2024-04-29 15:41:46', 'Disable departament: 3', '127.0.0.1'),
(189, 3, '2024-04-29 15:41:52', 'Enable departament: 3', '127.0.0.1'),
(190, 3, '2024-04-29 16:44:33', 'Delete user: 35', '45.177.43.5'),
(191, 3, '2024-04-29 16:45:11', 'Delete user: 35', '45.177.43.5'),
(192, 3, '2024-04-29 19:53:21', 'Create user: Error: Email duplicado', '190.123.11.29'),
(193, 3, '2024-04-29 19:59:42', 'Create user: henogoga@gmail1.com', '190.123.11.29'),
(194, 3, '2024-04-29 20:01:36', 'Update departament: 22', '190.123.11.29'),
(195, 3, '2024-04-29 20:03:43', 'Activate exercise: 1', '190.123.11.29'),
(196, 3, '2024-04-29 20:04:02', 'Activate exercise: 15', '190.123.11.29'),
(197, 3, '2024-04-29 20:12:26', 'Add exercise', '190.123.11.29'),
(198, 3, '2024-04-29 20:13:53', 'Add budget', '190.123.11.29'),
(199, 7, '2024-04-29 20:54:20', 'Activate exercise: 1', '190.123.11.29'),
(200, 7, '2024-04-29 20:56:23', 'Add budget', '190.123.11.29'),
(201, 3, '2024-04-30 01:01:08', 'Activate exercise: 15', '2806:2f0:5040:f3bb:393b:20d7:cc60:cae2'),
(202, 3, '2024-05-01 00:00:33', 'Create user: prueba@prueba.com', '127.0.0.1'),
(203, 3, '2024-05-07 17:50:41', 'Activate exercise: 1', '127.0.0.1'),
(204, 3, '2024-05-07 17:57:24', 'Register provider: 00424', '127.0.0.1'),
(205, 3, '2024-05-07 19:15:01', 'Delete provider: 11', '127.0.0.1'),
(206, 3, '2024-05-07 19:15:18', 'Disable provider: 2', '127.0.0.1'),
(207, 3, '2024-05-07 19:15:24', 'Enable provider: 2', '127.0.0.1'),
(208, 3, '2024-05-07 19:15:30', 'Delete provider: 3', '127.0.0.1'),
(209, 3, '2024-05-07 19:21:47', 'Send files providers: cedula', '127.0.0.1'),
(210, 3, '2024-05-07 19:21:47', 'Send files providers: caratula', '127.0.0.1'),
(211, 3, '2024-05-07 19:25:58', 'Delete provider: 13', '127.0.0.1'),
(212, 3, '2024-05-07 19:26:22', 'Send files providers: caratula.pdf', '127.0.0.1'),
(213, 3, '2024-05-07 19:26:22', 'Send files providers: cedula.pdf', '127.0.0.1'),
(214, 3, '2024-05-07 20:02:27', 'Delete provider: 14', '127.0.0.1'),
(215, 3, '2024-05-07 21:29:47', 'Disable provider: 1', '127.0.0.1'),
(216, 3, '2024-05-07 21:30:00', 'Enable provider: 1', '127.0.0.1'),
(217, 3, '2024-05-08 18:05:14', 'Enable request: 16', '45.177.43.5'),
(218, 3, '2024-05-08 18:05:24', 'Enable request: 16', '45.177.43.5'),
(219, 3, '2024-05-08 18:14:10', 'Enable request: 16', '45.177.43.5'),
(220, 3, '2024-05-08 18:17:25', 'Enable request: 16', '45.177.43.5'),
(221, 3, '2024-05-08 18:20:15', 'Enable request: 16', '45.177.43.5'),
(222, 3, '2024-05-08 18:45:19', 'Enable request: 16', '45.177.43.5'),
(223, 3, '2024-05-08 18:55:17', 'Enable request: 16', '45.177.43.5'),
(224, 3, '2024-05-08 19:00:13', 'Enable request: 16', '45.177.43.5'),
(225, 3, '2024-05-08 19:47:13', 'Enable request: 16', '45.177.43.5'),
(226, 3, '2024-05-09 21:03:11', 'Create user: prueba@example.com', '127.0.0.1'),
(227, 3, '2024-05-09 21:21:02', 'Create user: prueba@example.com', '127.0.0.1'),
(228, 3, '2024-05-10 15:27:53', 'Create user: prueba@example.com', '127.0.0.1'),
(229, 3, '2024-05-10 15:28:01', 'Delete user: 43', '127.0.0.1'),
(230, 3, '2024-05-11 06:08:15', 'Create user: Error: Email duplicado', '189.141.247.187'),
(231, 3, '2024-05-11 06:08:22', 'Create user: Error: Email duplicado', '189.141.247.187'),
(232, 3, '2024-05-11 06:40:18', 'Enable provider: 3', '189.141.247.187'),
(233, 3, '2024-05-13 00:56:54', 'Create request: 10000', '127.0.0.1'),
(234, 3, '2024-05-13 00:57:15', 'Send files comprobation: CSF HECTOR 08_03_24.pdf', '127.0.0.1'),
(235, 3, '2024-05-13 00:57:37', 'Send files comprobation: SHE MARZO 24.xml', '127.0.0.1'),
(236, 3, '2024-05-13 03:04:13', 'Send files comprobation: SHE MARZO 24.xml', '189.141.242.66'),
(237, 3, '2024-05-13 03:04:13', 'Send files comprobation: CSF HECTOR 08_03_24.pdf', '189.141.242.66'),
(238, 3, '2024-05-13 03:08:57', 'Send files comprobation: SHE MARZO 24.xml', '189.141.242.66'),
(239, 3, '2024-05-13 03:48:57', 'Enable request: 20', '189.141.242.66'),
(240, 39, '2024-05-13 04:49:23', 'Send comprobation: 20', '189.141.242.66'),
(241, 39, '2024-05-13 04:49:23', 'Send files comprobation: SHE MARZO 24.xml', '189.141.242.66'),
(242, 3, '2024-05-13 05:10:39', 'Acept comprobation: 20', '189.141.242.66'),
(243, 39, '2024-05-13 06:25:48', 'Create request: 2000', '189.141.242.66'),
(244, 3, '2024-05-13 06:28:56', 'Enable request: 21', '189.141.242.66'),
(245, 3, '2024-06-10 05:30:28', 'Update user: admin@example.com', '189.141.244.96'),
(246, 3, '2024-06-18 16:08:32', 'Create request: 2500', 'fe80::65ee:ac0f:581c:1cdc'),
(247, 3, '2024-11-08 04:49:28', 'Delete exercise: 8', '187.173.128.72'),
(248, 3, '2024-11-08 04:49:32', 'Delete exercise: 16', '187.173.128.72'),
(249, 3, '2024-11-08 04:49:37', 'Delete exercise: 15', '187.173.128.72'),
(250, 3, '2024-11-08 04:57:00', 'Delete exercise: 14', '187.173.128.72'),
(251, 3, '2024-11-08 04:57:10', 'Delete exercise: 13', '187.173.128.72'),
(252, 3, '2024-11-08 05:06:44', 'Delete request: 1', '187.173.128.72'),
(253, 3, '2024-11-14 06:01:03', 'Send files providers: cedula.pdf', '127.0.0.1'),
(254, 3, '2024-11-14 06:01:03', 'Send files providers: caratula.pdf', '127.0.0.1'),
(255, 3, '2024-11-14 06:18:36', 'Enable provider: 4', '127.0.0.1'),
(256, 3, '2024-11-14 06:18:43', 'Enable provider: 5', '127.0.0.1'),
(257, 32, '2024-11-15 06:03:33', 'Enable request: 1', '127.0.0.1'),
(258, 32, '2024-11-15 06:08:29', 'Enable request: 1', '127.0.0.1'),
(259, 3, '2024-11-15 06:15:16', 'Send comprobation: 1', '127.0.0.1'),
(260, 32, '2024-11-15 06:17:32', 'Denegate comprobation: 1', '127.0.0.1'),
(261, 32, '2024-11-15 06:17:32', 'Denegate comprobation: 1', '127.0.0.1'),
(262, 32, '2024-11-15 06:17:32', 'Denegate comprobation: 1', '127.0.0.1'),
(263, 3, '2024-11-15 06:17:57', 'Send comprobation: 1', '127.0.0.1'),
(264, 32, '2024-11-15 06:20:19', 'Acept comprobation: 1', '127.0.0.1'),
(265, 3, '2024-11-15 06:21:05', 'Send comprobation: 1', '127.0.0.1'),
(266, 3, '2024-11-15 06:22:00', 'Send comprobation: 1', '127.0.0.1'),
(267, 3, '2024-11-15 06:23:03', 'Send comprobation: 1', '127.0.0.1'),
(268, 3, '2024-11-15 07:07:17', 'Send comprobation: 1', '127.0.0.1'),
(269, 3, '2024-11-15 07:09:20', 'Send comprobation: 1', '127.0.0.1'),
(270, 3, '2024-11-15 07:09:20', 'Send files comprobation: CSF HECTOR 08_03_24.pdf', '127.0.0.1'),
(271, 3, '2024-11-15 07:09:20', 'Send files comprobation: SHE MARZO 24.xml', '127.0.0.1'),
(272, 32, '2024-11-15 08:49:03', 'Enable request: 1', '127.0.0.1'),
(273, 3, '2024-11-18 23:30:20', 'Send comprobation: 1', '127.0.0.1'),
(274, 3, '2024-11-18 23:30:20', 'Send files comprobation: SHE MARZO 24.xml', '127.0.0.1'),
(275, 3, '2024-11-18 23:30:20', 'Send files comprobation: CSF HECTOR 08_03_24.pdf', '127.0.0.1'),
(276, 32, '2024-11-19 00:55:10', 'Acept comprobation: 1', '127.0.0.1'),
(277, 32, '2024-11-19 00:55:10', 'Acept comprobation: 1', '127.0.0.1'),
(278, 32, '2024-11-19 04:43:12', 'Enable request: 1', '127.0.0.1'),
(279, 32, '2024-11-19 05:51:12', 'Enable request: 2', '127.0.0.1'),
(280, 3, '2024-11-19 06:45:17', 'Send comprobation: 2', '127.0.0.1'),
(281, 3, '2024-11-19 06:45:17', 'Send files comprobation: SHE MARZO 24.xml', '127.0.0.1'),
(282, 3, '2024-11-19 06:45:17', 'Send files comprobation: CSF HECTOR 08_03_24.pdf', '127.0.0.1'),
(283, 32, '2024-11-19 06:47:16', 'Acept comprobation: 2', '127.0.0.1');

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
(24, 1, 16666.67, 15500, NULL, 28),
(25, 2, 16666.67, 0, NULL, 28),
(26, 3, 16666.67, 0, NULL, 28),
(27, 4, 16666.67, 0, NULL, 28),
(28, 5, 16666.67, 0, NULL, 28),
(29, 6, 16666.67, 0, NULL, 28),
(30, 7, 16666.67, 0, NULL, 28),
(31, 8, 16666.67, 0, NULL, 28),
(32, 9, 16666.67, 0, NULL, 28),
(33, 10, 16666.67, 0, NULL, 28),
(34, 11, 16666.67, 0, NULL, 28),
(35, 12, 16666.67, 0, NULL, 28),
(48, 1, 10416.67, 0, NULL, 30),
(49, 2, 10416.67, 0, NULL, 30),
(50, 3, 10416.67, 0, NULL, 30),
(51, 4, 10416.67, 0, NULL, 30),
(52, 5, 10416.67, 0, NULL, 30),
(53, 6, 10416.67, 0, NULL, 30),
(54, 7, 10416.67, 0, NULL, 30),
(55, 8, 10416.67, 0, NULL, 30),
(56, 9, 10416.67, 0, NULL, 30),
(57, 10, 10416.67, 0, NULL, 30),
(58, 11, 10416.67, 0, NULL, 30),
(59, 12, 10416.67, 0, NULL, 30),
(60, 1, 4166.67, 0, NULL, 31),
(61, 2, 4166.67, 0, NULL, 31),
(62, 3, 4166.67, 0, NULL, 31),
(63, 4, 4166.67, 0, NULL, 31),
(64, 5, 4166.67, 0, NULL, 31),
(65, 6, 4166.67, 0, NULL, 31),
(66, 7, 4166.67, 0, NULL, 31),
(67, 8, 4166.67, 0, NULL, 31),
(68, 9, 4166.67, 0, NULL, 31),
(69, 10, 4166.67, 0, NULL, 31),
(70, 11, 4166.67, 0, NULL, 31),
(71, 12, 4166.67, 0, NULL, 31),
(96, 1, 4166.67, 0, NULL, 34),
(97, 2, 4166.67, 0, NULL, 34),
(98, 3, 4166.67, 0, NULL, 34),
(99, 4, 4166.67, 0, NULL, 34),
(100, 5, 4166.67, 0, NULL, 34),
(101, 6, 4166.67, 0, NULL, 34),
(102, 7, 4166.67, 0, NULL, 34),
(103, 8, 4166.67, 0, NULL, 34),
(104, 9, 4166.67, 0, NULL, 34),
(105, 10, 4166.67, 0, NULL, 34),
(106, 11, 4166.67, 0, NULL, 34),
(107, 12, 4166.67, 0, NULL, 34);

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
  `currencyType` text DEFAULT NULL,
  `provider_idUser` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_providers`
--

INSERT INTO `montrer_providers` (`idProvider`, `provider_key`, `representative_name`, `contact_phone`, `email`, `website`, `business_name`, `rfc`, `fiscal_address_street`, `fiscal_address_colonia`, `fiscal_address_municipio`, `fiscal_address_estado`, `fiscal_address_cp`, `bank_name`, `account_holder`, `account_number`, `clabe`, `description`, `extrangero`, `swiftCode`, `beneficiaryAddress`, `currencyType`, `provider_idUser`, `created_at`, `updated_at`, `status`) VALUES
(1, '00124', 'Proveedor de prueba', '4453363652', 'prueba@prueba.com', 'http://www.proveedor.com', 'Gastos de servicios', 'PRVO12345952', 'Provider Home', 'Colony', 'Morelia', 'Michoacán', '58001', 'BBVA ', 'Proveedor', '123456789', '123456789', NULL, 0, NULL, NULL, NULL, 3, '2024-01-24 07:29:25', '2024-05-07 21:30:00', 1),
(2, '00224', 'Héctor Noel González García', '4433575395', 'henogoga@outlook.com', '', 'Héctor Noel González García', 'GOGH790404PM4', 'Eucalipto 53', 'Melchor Ocampo', 'Morelia', 'Michocán', '58116', 'BBVA', 'Héctor Noel González García', '58980398', '34567789996', NULL, 0, NULL, NULL, NULL, 34, '2024-01-25 05:06:58', '2024-05-07 19:15:24', 1),
(3, '00324', 'Pedro Domínguez Pedraza', '4433575395', 'dominguez@gmailcom', NULL, 'Aparatos auditivos', 'TCA110414UV6', 'Satélites 107-301', 'Cosmos', 'Morelia', 'Michoacán', '58050', 'BBVA', 'Pedro Dominguez Pedraza', '568992790', '3440827272929', 'Venta de bocinas', 0, NULL, NULL, NULL, 3, '2024-03-31 20:15:54', '2024-05-11 06:40:18', 1),
(4, '00424', 'Jaime Gomez', '4465656565', 'jaime@example.com', '', 'UNMIFORMS S.A de C.V.', 'jago951021fg5', 'Satélites 107-301', 'test', 'Morelia', 'Michoacán', '58050', 'SANTANDER', 'Jaime Gomez', '55256352445', '5642536599652565', 'Uniformes', 1, 'ASD22', 'ASDAQQ', 'ASDAEE', 3, '2024-11-14 06:01:03', '2024-11-14 06:18:36', 1);

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
(19, 1, 1, 0),
(31, 2, 1, 0),
(32, 1, 1, 0),
(34, 2, 1, 0),
(35, 2, 1, 0),
(37, 2, 1, 0),
(39, 2, 1, 0);

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
('$2a$07$asxx54ahjppf45sd87a5auRANJyDtjQRjmwFvxjmVIouRREiD8C4y', 19),
('$2a$07$asxx54ahjppf45sd87a5au7s6XeGc8jJwTxNBlh6glb2.zW9v8BdC', 31),
('$2a$07$asxx54ahjppf45sd87a5au2.Iyqwwds4KlBdRsT4QHwDO9LNdEHvO', 37);

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
  `createDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastConection` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_users`
--

INSERT INTO `montrer_users` (`idUsers`, `firstname`, `lastname`, `email`, `password`, `createDate`, `lastConection`, `deleted`) VALUES
(3, 'HN', 'Gonzalez Garcia', 'henogoga@outlook.com1', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-01-05 04:06:44', '2024-11-18 11:15:50', 0),
(5, 'Noel', 'González García', 'henogoga@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-01-12 18:50:49', '2024-04-29 14:47:22', 0),
(7, 'Adriana', 'Cisneros Ruiz', 'acisneros@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-01-12 20:31:28', '2024-05-16 12:28:35', 0),
(19, 'Usuario', 'Administrador', 'henogoga@institutogestalt.edu.mx', '', '2024-02-22 15:44:12', '0000-00-00 00:00:00', 0),
(31, 'Raúl', 'Pérez', 'hector.gonzalez@radixeducation.org', '', '2024-02-27 15:49:17', '0000-00-00 00:00:00', 0),
(32, 'Administrador', 'General', 'admin@example.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-03-11 15:19:31', '2024-11-18 11:20:16', 0),
(34, 'Salvador', 'Pérez', 'henogoga@outlook.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-04-10 18:52:45', '2024-05-12 21:49:17', 1),
(35, 'Toby', 'González García', 'plataforma@unives.mx', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-04-28 20:30:20', '2024-04-29 09:16:47', 1),
(37, 'Dana', 'González García', 'henogoga@ccmmex.com', '', '2024-04-28 20:31:35', '0000-00-00 00:00:00', 1),
(39, 'Noel', 'González', 'henogoga@gmail1.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-04-29 19:59:42', '2024-05-12 21:51:10', 0);

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
(3, 3),
(7, 19),
(39, 22),
(39, 20);

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
(2, 19, 1000001001004),
(2, 31, 1000001001005),
(2, 32, 1000001001006),
(2, 34, 1000001001007),
(2, 35, 1000001001008),
(2, 37, 1000001001009),
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
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `montrer_budgets`
--
ALTER TABLE `montrer_budgets`
  MODIFY `idBudget` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `montrer_budget_requests`
--
ALTER TABLE `montrer_budget_requests`
  MODIFY `idRequest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `montrer_business`
--
ALTER TABLE `montrer_business`
  MODIFY `idBusiness` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `montrer_exercise`
--
ALTER TABLE `montrer_exercise`
  MODIFY `idExercise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `montrer_logs`
--
ALTER TABLE `montrer_logs`
  MODIFY `idLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT de la tabla `montrer_month_budget`
--
ALTER TABLE `montrer_month_budget`
  MODIFY `idMensualBudget` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `montrer_payment_requests`
--
ALTER TABLE `montrer_payment_requests`
  MODIFY `idPaymentRequest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `montrer_providers`
--
ALTER TABLE `montrer_providers`
  MODIFY `idProvider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `montrer_users`
--
ALTER TABLE `montrer_users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
