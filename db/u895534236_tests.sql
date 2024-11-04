-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-11-2024 a las 23:07:42
-- Versión del servidor: 10.11.9-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u895534236_tests`
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
(26, 3, 250000, 8, 1),
(28, 3, 200000, 1, 1),
(30, 20, 125000, 1, 1),
(31, 22, 50000, 1, 1),
(32, 20, 100000, 14, 1),
(33, 20, 600000, 15, 1),
(34, 19, 50000, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_budget_requests`
--

CREATE TABLE `montrer_budget_requests` (
  `idRequest` int(11) NOT NULL,
  `folio` text NOT NULL,
  `idArea` int(11) NOT NULL,
  `idBudget` int(11) NOT NULL,
  `idProvider` int(11) NOT NULL,
  `requestedAmount` double NOT NULL,
  `description` text DEFAULT NULL,
  `requestDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUser` int(11) NOT NULL,
  `idAdmin` int(11) DEFAULT NULL,
  `approvedAmount` double DEFAULT NULL,
  `responseDate` timestamp NULL DEFAULT NULL,
  `eventDate` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT 'Status values:\r\n0: No respondido\r\n1: Aprobado\r\n2: Envió de comprobante\r\n3: rechazado\r\n4: Denegado el comprobante\r\n5: Aprobado el comprobante',
  `active` tinyint(1) DEFAULT NULL,
  `pagado` int(11) NOT NULL DEFAULT 0,
  `paymentDate` date DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `conceptoPago` text NOT NULL,
  `pagoCon` varchar(13) NOT NULL,
  `chequeNombre` text NOT NULL,
  `subPartida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_budget_requests`
--

INSERT INTO `montrer_budget_requests` (`idRequest`, `folio`, `idArea`, `idBudget`, `idProvider`, `requestedAmount`, `description`, `requestDate`, `idUser`, `idAdmin`, `approvedAmount`, `responseDate`, `eventDate`, `status`, `active`, `pagado`, `paymentDate`, `comentarios`, `conceptoPago`, `pagoCon`, `chequeNombre`, `subPartida`) VALUES
(1, '01BDG240308', 3, 28, 2, 50000.01, 'Presupuesto solicitado para tambores y trompetas nuevas', '2024-04-15 17:21:51', 3, NULL, NULL, NULL, '2024-03-25', 0, NULL, 0, '2024-03-29', '', '', '', '', 0),
(2, '02PLA240327', 20, 30, 3, 8000, 'Servidor dedicado XXL Ionos', '2024-04-09 12:59:24', 5, 5, 8030, '2024-04-09 22:17:17', '2024-04-05', 5, 1, 1, '2024-04-12', 'Comentario', '', '', '', 0),
(16, '3PLA240410', 20, 30, 3, 11000, 'Renta de servidor dedicado', '2024-04-10 11:58:14', 5, 39, 11000, '2024-05-11 00:42:10', '2024-04-11', 1, 1, 1, '2024-04-11', 'No se puede aceptar', '', '', '', 0),
(17, '17PLA240410', 20, 30, 3, 11000, 'Servidor 1', '2024-04-10 12:01:51', 5, 5, 11000, '2024-04-10 12:03:31', '2024-04-11', 5, 0, 1, '2024-04-11', 'prueba de comentario', '', '', '', 0),
(18, '18BDG240410', 3, 28, 3, 10000, 'GOLPES', '2024-04-10 13:23:59', 3, NULL, NULL, NULL, '2024-04-11', 0, NULL, 0, '2024-04-19', NULL, '', '', '', 0),
(19, '19PLA240428', 20, 32, 5, 23000, 'Puesta a punto de servidor', '2024-04-28 15:04:54', 35, 35, 23000, '2024-04-28 15:15:04', '2024-05-03', 5, 0, 1, '2024-05-10', NULL, '', '', '', 0),
(20, '20BDG240512', 20, 28, 3, 10000, 'prueba', '2024-05-12 18:56:33', 39, 39, 10000, '2024-05-12 21:49:03', '2024-05-13', 1, NULL, 0, '2024-05-17', NULL, '', '', '', 0),
(21, '21PLA240513', 20, 30, 3, 2000, 'asd', '2024-05-13 06:25:48', 39, 3, 2000, '2024-05-13 00:28:56', '2024-05-23', 1, 1, 0, '2024-05-17', NULL, '', '', '', 0),
(22, '22BDG240618', 3, 28, 1, 2500, 'baquetas', '2024-06-18 16:08:32', 3, NULL, NULL, NULL, '2024-06-19', 0, NULL, 0, '2024-06-21', NULL, 'cheque. Gastos de servicios-Banda de guerra-16/9-baquetas', 'cheque', 'HN', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_company`
--

CREATE TABLE `montrer_company` (
  `idCompany` int(11) NOT NULL,
  `name` text NOT NULL,
  `logo` text NOT NULL,
  `colors` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_company`
--

INSERT INTO `montrer_company` (`idCompany`, `name`, `logo`, `colors`, `description`) VALUES
(2, 'api', '2165022.png', '{\"primary\":\"#3498db\",\"secondary\":\"#e74c3c\",\"accent\":\"#2ecc71\",\"background1\":\"#ecf0f1\",\"background2\":\"#ffffff\"}', 'icono de la api');

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
(1, 'Ejercicio 2024', '2024-01-01', '2024-12-31', 2000000, 1, 1350000, 1, '2024-01-02 16:51:51'),
(8, 'Ejercicio 2025', '2025-02-06', '2025-12-31', 3150000, 0, 2150000, 1, '2024-01-17 20:59:35'),
(13, 'Ejercicio 2026', '2026-01-01', '2026-12-31', 4000000, 0, 3000000, 1, '2024-04-28 20:00:55'),
(14, 'Ejercicio 2027', '2027-01-01', '2027-12-31', 3000000, 0, 4000000, 1, '2024-04-28 20:05:09'),
(15, 'Ejercicio 2028', '2028-01-01', '2028-12-31', 5000000, 0, 3, 1, '2024-04-29 14:41:59'),
(16, 'Ejercicio 2029', '2029-01-29', '2029-12-31', 10000000, 0, 3, 1, '2024-04-29 20:12:26');

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
(246, 3, '2024-06-18 16:08:32', 'Create request: 2500', 'fe80::65ee:ac0f:581c:1cdc');

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
(1, 2, 22727.27, 0, NULL, 26),
(2, 3, 22727.27, 0, NULL, 26),
(3, 4, 22727.27, 0, NULL, 26),
(4, 5, 22727.27, 0, NULL, 26),
(5, 6, 22727.27, 0, NULL, 26),
(6, 7, 22727.27, 0, NULL, 26),
(7, 8, 22727.27, 0, NULL, 26),
(8, 9, 22727.27, 0, NULL, 26),
(9, 10, 22727.27, 0, NULL, 26),
(10, 11, 22727.27, 0, NULL, 26),
(11, 12, 22727.27, 0, NULL, 26),
(24, 1, 16666.67, 0, NULL, 28),
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
(48, 1, 10416.67, 10416.67, NULL, 30),
(49, 2, 10416.67, 10416.67, NULL, 30),
(50, 3, 10416.67, 10416.67, NULL, 30),
(51, 4, 10416.67, 10416.67, NULL, 30),
(52, 5, 10416.67, 10416.67, NULL, 30),
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
(72, 1, 8333.33, 8333.33, NULL, 32),
(73, 2, 8333.33, 8333.33, NULL, 32),
(74, 3, 8333.33, 6333.34, NULL, 32),
(75, 4, 8333.33, 0, NULL, 32),
(76, 5, 8333.33, 0, NULL, 32),
(77, 6, 8333.33, 0, NULL, 32),
(78, 7, 8333.33, 0, NULL, 32),
(79, 8, 8333.33, 0, NULL, 32),
(80, 9, 8333.33, 0, NULL, 32),
(81, 10, 8333.33, 0, NULL, 32),
(82, 11, 8333.33, 0, NULL, 32),
(83, 12, 8333.33, 0, NULL, 32),
(84, 1, 50000, 0, NULL, 33),
(85, 2, 50000, 0, NULL, 33),
(86, 3, 50000, 0, NULL, 33),
(87, 4, 50000, 0, NULL, 33),
(88, 5, 50000, 0, NULL, 33),
(89, 6, 50000, 0, NULL, 33),
(90, 7, 50000, 0, NULL, 33),
(91, 8, 50000, 0, NULL, 33),
(92, 9, 50000, 0, NULL, 33),
(93, 10, 50000, 0, NULL, 33),
(94, 11, 50000, 0, NULL, 33),
(95, 12, 50000, 0, NULL, 33),
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
(12, 'Noel González García', '2024-04-09', 1, 20, 8030, 'ocho mil treinta pesos', 'Proveedor de prueba', 'BBVA ', 'Servidor dedicado XXL Ionos', 2, 5, '2024-04-10 06:03:34', 1),
(13, 'Noel González García', '2024-04-09', 1, 20, 8030, 'ocho mil treinta pesos', 'Proveedor de prueba', 'BBVA ', 'Servidor dedicado XXL Ionos', 2, 5, '2024-04-10 07:08:42', 1),
(14, 'Noel González García', '2024-04-10', 3, 20, 11000, 'once mil  pesos', 'Pedro Domínguez Pedraza', 'BBVA', 'Servidor 1', 17, 5, '2024-04-10 18:10:15', 1),
(15, 'Toby González García', '2024-04-28', 5, 20, 23000, 'veinte tres mil  pesos', 'hector gonzález garcía', '1234', 'Puesta a punto de servidor', 19, 35, '2024-04-28 21:16:23', 1),
(16, 'Noel González', '2024-05-12', 3, 20, 10000, 'diez mil  pesos', 'Pedro Domínguez Pedraza', 'BBVA', 'prueba', 20, 39, '2024-05-13 04:49:23', 1);

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
  `provider_idUser` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `montrer_providers`
--

INSERT INTO `montrer_providers` (`idProvider`, `provider_key`, `representative_name`, `contact_phone`, `email`, `website`, `business_name`, `rfc`, `fiscal_address_street`, `fiscal_address_colonia`, `fiscal_address_municipio`, `fiscal_address_estado`, `fiscal_address_cp`, `bank_name`, `account_holder`, `account_number`, `clabe`, `description`, `provider_idUser`, `created_at`, `updated_at`, `status`) VALUES
(1, '00124', 'Proveedor de prueba', '4453363652', 'prueba@prueba.com', 'http://www.proveedor.com', 'Gastos de servicios', 'PRVO12345952', 'Provider Home', 'Colony', 'Morelia', 'Michoacán', '58001', 'BBVA ', 'Proveedor', '123456789', '123456789', NULL, 3, '2024-01-24 07:29:25', '2024-05-07 21:30:00', 1),
(2, '00224', 'Héctor Noel González García', '4433575395', 'henogoga@outlook.com', '', 'Héctor Noel González García', 'GOGH790404PM4', 'Eucalipto 53', 'Melchor Ocampo', 'Morelia', 'Michocán', '58116', 'BBVA', 'Héctor Noel González García', '58980398', '34567789996', NULL, 34, '2024-01-25 05:06:58', '2024-05-07 19:15:24', 1),
(3, '00324', 'Pedro Domínguez Pedraza', '4433575395', 'dominguez@gmailcom', NULL, 'Aparatos auditivos', 'TCA110414UV6', 'Satélites 107-301', 'Cosmos', 'Morelia', 'Michoacán', '58050', 'BBVA', 'Pedro Dominguez Pedraza', '568992790', '3440827272929', 'Venta de bocinas', 3, '2024-03-31 20:15:54', '2024-05-11 06:40:18', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montrer_roots`
--

CREATE TABLE `montrer_roots` (
  `idRoot` int(11) NOT NULL,
  `firstname` int(11) NOT NULL,
  `lastname` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `password` int(11) NOT NULL,
  `createdDate` int(11) NOT NULL,
  `lastConection` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(39, 2, 1, 0),
(40, 0, 1, 0),
(43, 2, 1, 0);

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
('$2a$07$asxx54ahjppf45sd87a5au2.Iyqwwds4KlBdRsT4QHwDO9LNdEHvO', 37),
('$2a$07$asxx54ahjppf45sd87a5auVhBlRfaCyJ.wf9TO2a4XEnNLD1BQZs.', 43);

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
(3, 'HN', 'Gonzalez Garcia', 'henogoga@outlook.com1', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-01-05 04:06:44', '2024-06-18 09:42:18', 0),
(5, 'Noel', 'González García', 'henogoga@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-01-12 18:50:49', '2024-04-29 14:47:22', 0),
(7, 'Adriana', 'Cisneros Ruiz', 'acisneros@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-01-12 20:31:28', '2024-05-16 12:28:35', 0),
(19, 'Usuario', 'Administrador', 'henogoga@institutogestalt.edu.mx', '', '2024-02-22 15:44:12', '0000-00-00 00:00:00', 0),
(31, 'Raúl', 'Pérez', 'hector.gonzalez@radixeducation.org', '', '2024-02-27 15:49:17', '0000-00-00 00:00:00', 0),
(32, 'Administrador', 'General', 'admin@example.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-03-11 15:19:31', '2024-04-02 07:45:10', 0),
(34, 'Salvador', 'Pérez', 'henogoga@outlook.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-04-10 18:52:45', '2024-05-12 21:49:17', 1),
(35, 'Toby', 'González García', 'plataforma@unives.mx', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-04-28 20:30:20', '2024-04-29 09:16:47', 1),
(37, 'Dana', 'González García', 'henogoga@ccmmex.com', '', '2024-04-28 20:31:35', '0000-00-00 00:00:00', 1),
(39, 'Noel', 'González', 'henogoga@gmail1.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-04-29 19:59:42', '2024-05-12 21:51:10', 0),
(40, 'prueba', 'prueba', 'prueba@prueba.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', '2024-05-01 00:00:30', '2024-05-23 17:46:15', 0),
(43, 'prueba', 'prueba', 'prueba@example.com', '', '2024-05-10 15:27:50', '0000-00-00 00:00:00', 0);

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
(39, 20),
(43, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_areas`
--

CREATE TABLE `servicios_areas` (
  `idArea` int(11) NOT NULL,
  `nameArea` text NOT NULL,
  `area_idZones` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `statusArea` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_areas`
--

INSERT INTO `servicios_areas` (`idArea`, `nameArea`, `area_idZones`, `dateCreated`, `statusArea`) VALUES
(1, 'Recepción', 1, '2024-04-26 17:20:12', 1),
(2, 'Area de espera', 1, '2024-04-26 17:20:12', 1),
(3, 'Dirección de preparatoria', 1, '2024-04-26 17:20:13', 1),
(4, 'Recepción', 2, '2024-04-26 17:20:14', 1),
(5, 'Area de espera', 2, '2024-04-26 17:20:15', 1),
(6, 'Dirección de universidad', 2, '2024-04-26 17:20:15', 1),
(7, 'Recepción', 3, '2024-04-26 17:21:39', 1),
(8, 'Area de espera', 3, '2024-04-26 17:21:40', 1),
(9, 'Dirección de prepa', 3, '2024-04-26 17:21:40', 1),
(10, 'Recepción', 4, '2024-04-26 17:21:41', 1),
(11, 'Area de espera', 4, '2024-04-26 17:21:42', 1),
(12, 'Dirección de universidad', 4, '2024-04-26 17:21:43', 1),
(13, 'Recepción', 5, '2024-04-26 18:10:24', 1),
(14, 'Area de espera', 5, '2024-04-26 18:10:24', 1),
(15, 'Dirección de prepa', 5, '2024-04-26 18:10:25', 1),
(16, 'Recepción', 6, '2024-04-26 18:10:26', 1),
(17, 'Area de espera', 6, '2024-04-26 18:10:27', 1),
(18, 'Dirección de universidad', 6, '2024-04-26 18:10:28', 0),
(19, 'Dirección de prepa', 4, '2024-04-29 17:47:31', 1),
(20, 'Aula 1', 4, '2024-04-29 17:57:12', 1),
(21, 'Aula 2', 4, '2024-04-29 17:57:13', 1),
(22, 'Aula 3', 4, '2024-04-29 17:57:13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_incidentes`
--

CREATE TABLE `servicios_incidentes` (
  `idIncidente` int(11) NOT NULL,
  `nPedido` varchar(10) NOT NULL,
  `estado` text NOT NULL,
  `description` text NOT NULL,
  `importancia` varchar(11) NOT NULL,
  `incidente_idObject` int(11) NOT NULL,
  `files` text DEFAULT NULL,
  `detallesCorregidos` text DEFAULT NULL,
  `compra` tinyint(1) DEFAULT NULL,
  `detalleCompra` text DEFAULT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `solutionDate` datetime DEFAULT NULL,
  `posponerRazon` text DEFAULT NULL,
  `fechaAsignada` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_incidentes`
--

INSERT INTO `servicios_incidentes` (`idIncidente`, `nPedido`, `estado`, `description`, `importancia`, `incidente_idObject`, `files`, `detallesCorregidos`, `compra`, `detalleCompra`, `dateCreated`, `solutionDate`, `posponerRazon`, `fechaAsignada`, `status`) VALUES
(1, 'LC001', '2', 'asd', 'Urgente', 7, NULL, NULL, NULL, NULL, '2024-07-02 16:58:22', NULL, 'Se llamo al carpintero', '2024-07-05', 2),
(2, 'LC002', '2', 'Escritorio roto', 'Urgente', 7, NULL, 'Se contrato un carpintero y reparo la pata', 1, 'Pago carpintero', '2024-07-02 17:36:09', '2024-07-02 17:47:05', NULL, NULL, 1),
(3, 'LC003', '2', 'Roto', 'Urgente', 7, '[{\"name\":\"UNIMO logotipo 2019 (1).png\",\"type\":\"image\\/png\"}]', NULL, NULL, NULL, '2024-07-03 21:08:25', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_notify`
--

CREATE TABLE `servicios_notify` (
  `idNotify` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `url` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_notify`
--

INSERT INTO `servicios_notify` (`idNotify`, `title`, `body`, `url`, `status`) VALUES
(1, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'http://127.0.0.1/UNIMOSG/school&idSchool=1', 1),
(2, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'http://127.0.0.1/UNIMOSG/school&idSchool=1', 1),
(3, 'Nueva incidencia (INMEDIATA)', 'Hay una nueva incidencia en Lazaro Cardenas', 'http://127.0.0.1/UNIMOSG/school&idSchool=1', 1),
(4, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'http://127.0.0.1/UNIMOSG/school&idSchool=1', 1),
(5, 'Nueva incidencia (PENDIENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 1),
(6, 'Nueva incidencia (PENDIENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 1),
(7, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(8, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(9, 'Nueva incidencia (INMEDIATA)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(10, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(11, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(12, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(13, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(14, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(15, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(16, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(17, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(18, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(19, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(20, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(21, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(22, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(23, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(24, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(25, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(26, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(27, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0),
(28, 'Nueva incidencia (URGENTE)', 'Hay una nueva incidencia en Lazaro Cardenas', 'https://unimosg.contreras-flota.click/school&idSchool=1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_objects`
--

CREATE TABLE `servicios_objects` (
  `idObject` int(11) NOT NULL,
  `nameObject` text NOT NULL,
  `cantidad` int(11) NOT NULL,
  `objects_idArea` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `statusObject` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_objects`
--

INSERT INTO `servicios_objects` (`idObject`, `nameObject`, `cantidad`, `objects_idArea`, `dateCreated`, `statusObject`) VALUES
(1, 'Ventana', 2, 2, '2024-04-29 19:21:14', 1),
(2, 'Puerta de ingreso', 1, 2, '2024-04-29 19:21:14', 1),
(3, 'Escritorio', 1, 2, '2024-04-29 19:21:15', 1),
(4, 'Focos', 3, 2, '2024-04-29 19:21:16', 1),
(5, 'Ventanas', 3, 1, '2024-04-29 19:22:04', 1),
(6, 'Puerta de acceso', 1, 1, '2024-04-29 19:22:05', 1),
(7, 'Escritorio derecho', 1, 1, '2024-04-29 19:22:05', 1),
(8, 'Focos', 2, 1, '2024-04-29 19:22:06', 1),
(9, 'Taza del baño', 1, 1, '2024-05-31 15:52:07', 1),
(10, 'Puerta del baño', 1, 1, '2024-05-31 15:52:07', 1),
(11, 'lavamanos', 1, 1, '2024-05-31 15:52:08', 1),
(12, 'Jabón de manos', 1, 1, '2024-05-31 15:52:09', 1),
(13, 'Puerta de acceso', 1, 3, '2024-05-31 15:59:36', 1),
(14, 'Ventanal', 1, 3, '2024-05-31 15:59:37', 1),
(15, 'Escritorio 1', 1, 3, '2024-05-31 15:59:37', 1),
(16, 'Escritorio 2', 1, 3, '2024-05-31 15:59:38', 1),
(17, 'Escritorio 3', 1, 3, '2024-05-31 15:59:39', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_plan`
--

CREATE TABLE `servicios_plan` (
  `idPlan` int(11) NOT NULL,
  `idSchool` int(11) NOT NULL,
  `idZone` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `idSupervisor` int(11) NOT NULL,
  `datePlan` date NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_plan`
--

INSERT INTO `servicios_plan` (`idPlan`, `idSchool`, `idZone`, `idArea`, `idSupervisor`, `datePlan`, `dateCreated`, `status`) VALUES
(26, 1, 1, 1, 3, '2024-07-10', '2024-07-04 21:08:11', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_schools`
--

CREATE TABLE `servicios_schools` (
  `idSchool` int(11) NOT NULL,
  `nameSchool` text NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_schools`
--

INSERT INTO `servicios_schools` (`idSchool`, `nameSchool`, `dateCreated`, `status`) VALUES
(1, 'Lazaro Cardenas', '2024-04-18 15:35:52', 1),
(2, 'Jesús del Monte', '2024-04-18 15:42:00', 1),
(3, 'Los Reyes', '2024-04-18 19:31:59', 1),
(6, 'Uruapan', '2024-07-02 19:52:30', 1),
(7, 'Apatzingan', '2024-07-02 19:57:27', 1),
(8, 'prueba', '2024-07-02 19:57:55', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_supervision_days`
--

CREATE TABLE `servicios_supervision_days` (
  `idSupervisionDays` int(11) NOT NULL,
  `idSchool` int(11) NOT NULL,
  `idZone` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `idSupervisor` int(11) NOT NULL,
  `createDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_supervision_days`
--

INSERT INTO `servicios_supervision_days` (`idSupervisionDays`, `idSchool`, `idZone`, `idArea`, `day`, `idSupervisor`, `createDate`) VALUES
(17, 1, 1, 1, 2, 3, '2024-07-04 22:22:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_users`
--

CREATE TABLE `servicios_users` (
  `idUsers` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `level` tinyint(4) NOT NULL,
  `dateCreate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_users`
--

INSERT INTO `servicios_users` (`idUsers`, `name`, `email`, `password`, `status`, `level`, `dateCreate`) VALUES
(1, 'Oscar Rafael Contreras Flota', 'oscarcontrerasf91@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', 1, 1, '2024-04-12 21:16:31'),
(2, 'Director SG', 'directorsg@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 1, 1, '2024-04-25 15:59:10'),
(3, 'Supervisor', 'supervisor@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 1, 2, '2024-04-25 16:02:38'),
(4, 'Administrador', 'administrador@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 1, 0, '2024-05-28 21:26:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_zones`
--

CREATE TABLE `servicios_zones` (
  `idZone` int(11) NOT NULL,
  `nameZone` text NOT NULL,
  `zone_idSchool` int(11) NOT NULL,
  `dateCreate` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_zones`
--

INSERT INTO `servicios_zones` (`idZone`, `nameZone`, `zone_idSchool`, `dateCreate`, `status`) VALUES
(1, 'Edificio 1', 1, '2024-04-26 16:26:21', 1),
(2, 'Edificio 2', 1, '2024-04-26 16:26:22', 1),
(3, 'Edificio 1', 3, '2024-04-26 16:45:33', 1),
(4, 'Edificio 2', 3, '2024-04-26 16:45:35', 1),
(5, 'Edificio 1', 2, '2024-04-26 18:10:23', 1),
(6, 'Edificio 2', 2, '2024-04-26 18:10:26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unimo_events`
--

CREATE TABLE `unimo_events` (
  `idEvent` int(11) NOT NULL,
  `nameEvent` text NOT NULL,
  `dateEvent` datetime NOT NULL,
  `statusEvent` tinyint(1) NOT NULL DEFAULT 0,
  `dateCreate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unimo_events`
--

INSERT INTO `unimo_events` (`idEvent`, `nameEvent`, `dateEvent`, `statusEvent`, `dateCreate`) VALUES
(1, 'Acto a la bandera', '2024-04-22 08:00:00', 2, '2024-02-29 19:56:34'),
(2, 'Aniversario UNIMO 2024', '2024-04-26 10:30:00', 1, '2024-02-29 20:02:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unimo_invitados`
--

CREATE TABLE `unimo_invitados` (
  `idInvitado` int(11) NOT NULL,
  `idEvent` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text DEFAULT NULL,
  `anfitrion` text DEFAULT NULL,
  `institucion` text DEFAULT NULL,
  `puesto` text DEFAULT NULL,
  `color` text DEFAULT NULL,
  `invitados` int(11) DEFAULT NULL,
  `estacionamiento` text NOT NULL,
  `statusInvitado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unimo_invitados`
--

INSERT INTO `unimo_invitados` (`idInvitado`, `idEvent`, `firstname`, `lastname`, `anfitrion`, `institucion`, `puesto`, `color`, `invitados`, `estacionamiento`, `statusInvitado`) VALUES
(1, 1, 'Oscar', 'Contreras', 'Aaron', 'UNIMO', 'Programador', '0', 1, 'Estacionamiento 1', 1),
(2, 1, 'Marín', 'Leticia', 'Eduardo García', 'Instituto Tecnológico de Estudios Superiores de Monterrey', 'Coordinadora de Innovación Educativa', '0', 1, 'Estacionamiento 1', 1),
(5, 1, 'Quiroga', 'Esteban', 'Oscar Contreras', 'Universidad Politécnica de Valencia', 'Director de Relaciones Internacionales', '2', 3, 'Estacionamiento 2', 1),
(6, 1, 'Fernández', 'Carla', 'Eduardo García', 'Universidad de Buenos Aires', 'Jefa de Departamento de Investigación en Ciencias Sociales', '1', 1, 'Estacionamiento 1', 1),
(15, 2, 'DR. LAZARO CORTES RANGEL ', ' ', 'SECRETARIO GOB. ESTATAL Y FEDERAL', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'SECRETARIO DE SALUD DEL ESTADO DE MICHOACAN', '1A FILA SECCION A', NULL, 'Estacionamiento 1', 0),
(16, 2, 'MTRO. JESÚS VIVANCO RODRÍGUEZ', ' ', 'RECTORES', 'INSTITUCIONES EDUCATIVAS', 'RECTOR UNIVERSIDAD LATINA DE AMÉRICA ', '1a FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(17, 2, 'DR. JESÚS VÁZQUEZ ESTUPIÑÁN ', ' ', 'RECTORES', 'INSTITUCIONES EDUCATIVAS', 'RECTOR UNIVERSIDAD LA SALLE MORELIA ', '1a FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(18, 2, 'DR. VICTOR HUGO MERCADO GOMEZ', ' ', 'RECTORES', 'INSTITUCIONES EDUCATIVAS', 'DIRECTOR FACULTAD DE MEDICINA DR. IGNACIO CHAVEZ UMSNH', '1a FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(19, 2, 'L.A.E. LUIS NAVARRO GARCÍA', ' ', 'PRESIDIUM', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'SECRETARIO DE FINANZAS Y ADMINISTRACIÓN', '1A FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(20, 2, 'ALONDRA GONZALEZ HERNANDEZ', ' ', 'FAMILIA RECTOR', ' ', ' ', '1a FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(21, 2, 'ROBERTO SANTILLAN FERREYRA', ' ', 'PRESIDIUM', 'CÁMARAS EMPRESARIALES, ASOCIACIONES Y EMPRESARIOS ', 'PRESIDENTE CONSEJO COORDINADOR EMPRESARIAL DEL ESTADO DE MICHOACÁN CCEEM', '1A FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(22, 2, 'L. EN ECOL. TITO LIVIO VALLE TAVERA', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', ' ', '1a FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(23, 2, 'JUAN PABLO VALLE GONZÁLEZ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', ' ', '1a FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(24, 2, 'BLANCA PALOMA GONZALEZ HERRERA', ' ', 'RECONOCIMIENTO UNIMO', ' ', ' ', '1a FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(25, 2, 'CARLOS GONZALEZ HERRERA', ' ', 'RECONOCIMIENTO UNIMO', ' ', ' ', '1a FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(26, 2, 'NOE ALONSO GONZALEZ HERRERA', ' ', 'RECONOCIMIENTO UNIMO', ' ', ' ', '1a FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(27, 2, 'VICTOR HUGO GONZALEZ HERNANDEZ', ' ', 'FAMILIA RECTOR', ' ', ' ', '1a FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(28, 2, 'J. NOE GONZALEZ GOMEZ', ' ', 'FAMILIA RECTOR', ' ', ' ', '1a FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(29, 2, 'MARCO ANTONIO VIRGEN MARTINEZ', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', ' ', '1A FILA SECCION D', NULL, 'Estacionamiento 1', 0),
(30, 2, 'JORGE CASTAÑEDA', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', ' ', '2A FILA SECCION D', NULL, 'Estacionamiento 1', 0),
(31, 2, 'RIGOBERTO GONZALEZ', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', ' ', '2A FILA SECCION D', NULL, 'Estacionamiento 1', 0),
(32, 2, 'MONSERRAT HERNANDEZ', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', ' ', '2A FILA SECCION D', NULL, 'Estacionamiento 1', 0),
(33, 2, 'SILVIA ARIAS CONSTANTINO', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', ' ', '2A FILA SECCION D', NULL, 'Estacionamiento 1', 0),
(34, 2, 'JUAN ANTONIO OCHOA', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', 'LOS REYES', '2A FILA SECCION D', NULL, 'Estacionamiento 1', 0),
(35, 2, 'LILIANA FERNANDEZ', ' ', 'INVITADOS RECTOR FUNDADOR', 'PERSONAL UNIMO', ' ', '2A FILA SECCION D', NULL, 'Estacionamiento 1', 0),
(36, 2, 'LIC. CLAUDIO MÉNDEZ FERNÁNDEZ EN REPRESENTACIÓN MTRA. SOFÍA BELTRAN PACHECO', ' ', 'SECRETARIO GOB. ESTATAL Y FEDERAL', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'SECRETARIO DE DESARROLLO ECONÓMICO', '2A FILA SECCION A', NULL, 'Estacionamiento 1', 0),
(37, 2, 'MTRO. ADRIÁN LÓPEZ SOLÍS EN REPRESENTACIÓN EL DR JAIME MENDOZA GUZMAN', ' ', 'SECRETARIO GOB. ESTATAL Y FEDERAL', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'FISCAL GENERAL FISCALÍA GENERAL DEL ESTADO DE MICHOACÁN', '2A FILA SECCION A', NULL, 'Estacionamiento 1', 0),
(38, 2, 'M.D.I. MANUEL ARTURO CHÁVEZ CARMONA ', ' ', 'SECRETARIO GOB. ESTATAL Y FEDERAL', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'PROCURADOR DE PROTECCIÓN AL MEDIO AMBIENTE', '2A FILA SECCION A', NULL, 'Estacionamiento 1', 0),
(39, 2, 'ARQ. GLADYZ BUTANDA MACÍAS', ' ', 'SECRETARIO GOB. ESTATAL Y FEDERAL', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'SECREATARIA DE DESARROLLO URBANO Y MOVILIDAD ', '2A FILA SECCION A', NULL, 'Estacionamiento 1', 0),
(40, 2, 'YANKEL ALFREDO BENÍTEZ SILVA ASISTEN CON LIC. DAYANA DIAZ MONAREZ', ' ', 'H. AYUNTAMIENTO MORELIA', 'H. AYUNTAMIENTO DE MORELIA ', 'SECRETARIO H. AYUNTAMIENTO DE MORELIA', '2A FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(41, 2, 'LIC. THELMA AQUIQUE ARRIETA Y MARIANA ALVARADO GUZMAN', ' ', 'H. AYUNTAMIENTO MORELIA', 'H. AYUNTAMIENTO DE MORELIA', 'SECRETARIA DE TURISMO H. AYUNTAMIENTO DE MORELIA', '2A FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(42, 2, 'JOHANNA MORENO MANZO', ' ', 'H. AYUNTAMIENTO MORELIA', 'SECRETARIA DE DESARROLLO URBANO Y MOVILIDAD H AYUNTAMIENTO', ' ', '2A FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(43, 2, 'RUBEN PEREZ GALLARDO', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', 'NOTARIO', '2A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(44, 2, 'ALFONSO VACA (ESPOSAO DE TELMA AQUIQUE)', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', 'NOTARIO', '2A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(45, 2, 'Notario Lic. Juan Carlos Bolaños Abraham', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', 'NOTARIO', '2A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(46, 2, 'Notario Lic. Octavio Peña Torres Notario Lic. Ocatvio Peña Miguel', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', 'NOTARIO', '2A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(47, 2, 'DANTE AGATON LOMBERA', ' ', 'RECTORES', 'INSTITUCIONES EDUCATIVAS', 'RECTOR UNIVERSIDAD NOVA SPANIA', '3A FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(48, 2, 'LIC. ABRIL DOMINGUEZ', ' ', 'BANCOS', 'BANCOS', 'BBVA BANCO DE MEXICO', '4A FILA  SECCION C', NULL, 'Estacionamiento 1', 0),
(49, 2, 'LIC. MIRIAM SANCHEZ', ' ', 'BANCOS', 'BANCOS', 'DIRECTOR BANCA DE EMPRESAS MORELIABANCO SANTANDER ', '4A FILA  SECCION C', NULL, 'Estacionamiento 1', 0),
(50, 2, 'HEIDI VANESSA BERMUDEZ GONZALEZ', ' ', 'BANCOS', 'BANCOS', 'DIRECTOR DE ZONA BANCO SANTANDER', '4A FILA  SECCION C', NULL, 'Estacionamiento 1', 0),
(51, 2, 'RENE ZAMORA TORRES', ' ', 'BANCOS', 'BANCOS', 'DIRECTOR REGIONAL BANCO SANTANDER ', '4A FILA  SECCION C', NULL, 'Estacionamiento 1', 0),
(52, 2, 'CRISTINA GONZALEZ CONTRERAS', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'BUSSINESS WOMAN ', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(53, 2, 'LIC. DERECHO JUAN ANTONIO MAGAÑA DE LA MORA', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'MAGISTRADO 4a SALA PENAL SUPREMO TRIBUNAL DE JUSTICIA DEL ESTADO DE MICHOACAN', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(54, 2, 'DR. ADMINISTRACION VICTOR MANUEL TORRES ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'CATEDRATICO IPADE', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(55, 2, 'LIC. JUAN PABLO ARRIAGA DIEZ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'DIRECTOR GENERAL AUTOS Y CAMIONES SOL DE MICHOACAN', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(56, 2, 'MAESTRO NEGOCIOS EDUARDO MARTINEZ COGHLAN', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'DIRECTOR GENERAL CLUBES Y CAMPOS DE GOLF GRUPO ALTOZANO', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(57, 2, 'LIC. MONICA HERNANDEZ SADURNI ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'DIRECTOR GENERAL ECLECTICA DISEÑO', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(58, 2, 'LIC. JUAN JOSE VALDES TORRES ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'DIRECTOR GENERAL HAIFA MEXICO SA DE CV', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(59, 2, 'LIC. ISACC DIAZ GONZALEZ ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'CEO AKAMBA SA DE CV ', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(60, 2, 'M.A. GERARDO SALVADOR BUSTOS PINEDA ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'DIRECTOR CONSTRUMUNDO PRESIDENTE CANIRAC', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(61, 2, 'CARLOS ENRIQUEZ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'PRESIDENTE AHIEMAC', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(62, 2, 'ALONDRA VILLASEÑOR ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'PRESIDENTA CANACO', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(63, 2, 'EFRAIN MACIAS ', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', 'PRESIDENTE GRUPO MICHOACAN', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(64, 2, 'DR. SERGIO TORRES', ' ', 'INVITADOS SOCIOS', 'INVITADO SOCIO', '  ', '5A, 6A, 6A, 8A, 9A, FILA  SECCION D', NULL, 'Estacionamiento 1', 0),
(65, 2, 'MTRO. HECTOR ESTRADA', ' ', 'PREPARATORIAS Y SECUNDARIAS', 'INSTITUCIONES EDUCATIVAS', 'DIRECTOR GENERAL COLEGIO CUMBRES Y ANAHUAC', '6A FILA  SECCION A', NULL, 'Estacionamiento 1', 0),
(66, 2, 'DRA. C. EDUC. MA.GUADALUPE ABRAHAM GOMEZ Y ANA PAULA VIVEROS', ' ', 'PREPARATORIAS Y SECUNDARIAS', 'INSTITUCIONES EDUCATIVAS', 'DIRECTORA GENERAL COLEGIO HERBART', '6A FILA  SECCION A', NULL, 'Estacionamiento 1', 0),
(67, 2, 'M.C. JAFET MAGAÑA DIAZ', ' ', 'PREPARATORIAS Y SECUNDARIAS', 'INSTITUCIONES EDUCATIVAS', 'SUBDIRECTOR Y SECRETARIO TECNICO PREFECO MELCHOR OCAMPO', '6A FILA  SECCION A', NULL, 'Estacionamiento 1', 0),
(68, 2, 'C.P. JOSE LUIS AYALA PEREZ', ' ', 'PREPARATORIAS Y SECUNDARIAS', 'INSTITUCIONES EDUCATIVAS', 'DIRECTOR PREFECO MELCHOR OCAMPO', '6A FILA  SECCION A', NULL, 'Estacionamiento 1', 0),
(69, 2, 'L.C.C. JULIO CESAR HERNANDEZ GRANADOS', ' ', 'MEDIOS DE COMUNICACIÓN', 'MEDIOS DE COMUNICACIÓN', 'DIRECTOR VOX RADIO ', '6A Y 7A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(70, 2, 'LIC. VICTOR AMERICANO ', ' ', 'MEDIOS DE COMUNICACIÓN', 'MEDIOS DE COMUNICACIÓN', 'DIRECTOR AMERICANO NOTICIAS ', '6A Y 7A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(71, 2, 'LIC. ISLLALI BELMONTE ROSALES ', ' ', 'MEDIOS DE COMUNICACIÓN', 'MEDIOS DE COMUNICACIÓN', 'PRESIDENTAGRUPO CB ', '6A Y 7A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(72, 2, 'LIC CESAR OSUNA BELMONTE', ' ', 'MEDIOS DE COMUNICACIÓN', 'MEDIOS DE COMUNICACIÓN', 'DIRECTOR GRUPO CB TELEVISIÓN ', '6A Y 7A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(73, 2, 'LIC. YANELI OSUNA BELMONTE ', ' ', 'MEDIOS DE COMUNICACIÓN', 'MEDIOS DE COMUNICACIÓN', 'DIRECTOR GRUPO CB RADIO', '6A Y 7A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(74, 2, 'RAFAEL CORTÉS ', ' ', 'MEDIOS DE COMUNICACIÓN', 'MEDIOS DE COMUNICACIÓN', 'DIRECTOR RADIO TELE ', '6A Y 7A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(75, 2, 'L.M. YVES ALAN ORTEGA MORÁN', ' ', 'MEDIOS DE COMUNICACIÓN', 'MEDIOS DE COMUNICACIÓN', 'DIRECTOR GRUPO ACIR ', '6A Y 7A FILA SECCION C', NULL, 'Estacionamiento 1', 0),
(76, 2, 'DR. ARTURO BUCIO IBARRA', ' ', 'PROVEEDORES ', 'PROVEEDORES ', 'ASESOR LEGAL EXTERNO', '7A Y 8A FILA SECCION B', NULL, 'Estacionamiento 1', 0),
(77, 2, 'JORGE RESENDIZ GARCÍA EN REPRESENTACIÓN EL MTRO. EMMANUEL ROA ORTIZ', ' ', 'PRESIDIUM', 'SUPREMO TRIBUNAL DE JUSTICIA', 'PRESIDENTE ', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(78, 2, 'GENERAL DE BRIGADA DIPLOMADO DE ESTADO MAYOR FERNANDO COLCHADO GÓMEZ', ' ', 'PRESIDIUM', 'XXI ZONA MILITAR ', 'COMANDANTE XXI ZONA MILITAR ', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(79, 2, 'LIC. ALFREDO RAMIREZ BEDOLLA ', ' ', 'PRESIDIUM', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'GOBERNANDOR CONSTITUCIONAL DEL ESTADO DE MICHOACÁN ', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(80, 2, 'DRA. GABRIELA DESIREÉ MOLINA AGUILAR ', ' ', 'PRESIDIUM', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'SECREATARIA DE EDUCACIÓN ', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(81, 2, 'MTRA. MARIANA SOSA OLMEDA ', ' ', 'PRESIDIUM', 'GOBIERNO DEL ESTADO DE MICHOACAN', 'DIRECTORA GENERAL INSTITITUTO DE DE EDUCACIÓN MEDIA SUPERIOR Y SUPERIOR', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(82, 2, 'ALFONSO MARTÍNEZ ALCAZAR ', ' ', 'PRESIDIUM', 'H. AYUNTAMIENTO DE MORELIA ', 'PRESIDENTE MUNICIPAL H. AYUNTAMIENTO DE MORELIA ', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(83, 2, 'DRA. YARABÍ ÁVILA GONZÁLEZ ', ' ', 'PRESIDIUM', 'INSTITUCIONES EDUCATIVAS', 'RECTORA UNIVERSIDAD MIHOACANA DE SAN NICOLÁS DE HIDALGO', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(84, 2, 'LIC. MARIA FERNANDA ARJONA GONZÁLEZ ', ' ', 'PRESIDIUM', 'COORDINADORA DE COMUNICACIÓN SOCIAL INE MICHOACÁN', 'EX ALUMNA', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(85, 2, 'SUSAN MELISSA VÁSQUEZ PÉREZ', ' ', 'PRESIDIUM', 'SINDICO MUNICIPAL H. AYUTNAMIENTO DE MORELIA', 'H. AYUNTAMIENTO', 'NO APLICA', NULL, 'Estacionamiento 1', 0),
(86, 2, 'LUIS GONZALEZ GOMEZ', ' ', 'INVITADOS RECTOR FUNDADOR', 'INVITADO SOCIO', 'FAMILIA', ' ', NULL, 'Estacionamiento 1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unimo_users`
--

CREATE TABLE `unimo_users` (
  `idUser` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `level` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unimo_users`
--

INSERT INTO `unimo_users` (`idUser`, `name`, `email`, `password`, `level`, `status`, `dateCreated`) VALUES
(1, 'Oscar Rafael Contreras Flota', 'oscarcontrerasf91@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', 1, 1, '2024-03-07 18:11:41'),
(5, 'Unimo', 'unimo@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auRHz5VyvxsgbNKYyggXQtOKy0VNwnILK', 2, 1, '2024-03-08 15:40:37'),
(7, 'LILIA RIVERA ORTIZ', 'vicerrectoriaunimo@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auwzKvW0VF92d7fUVxAV8Pp6SI9b33lpC', 1, 1, '2024-03-11 22:22:57'),
(8, 'OSCAR LOPEZ GARCIA', 'admonynegocios@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auwzKvW0VF92d7fUVxAV8Pp6SI9b33lpC', 2, 1, '2024-03-11 22:26:18'),
(9, 'Saul Rico', 'sricog@unimontrer.edu.mx', '$2a$07$asxx54ahjppf45sd87a5auRajNP0zeqOkB9Qda.dSiTb2/n.wAC/2', 2, 1, '2024-04-16 17:59:15');

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
-- Indices de la tabla `montrer_company`
--
ALTER TABLE `montrer_company`
  ADD PRIMARY KEY (`idCompany`);

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
-- Indices de la tabla `montrer_roots`
--
ALTER TABLE `montrer_roots`
  ADD PRIMARY KEY (`idRoot`),
  ADD KEY `email` (`email`);

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
-- Indices de la tabla `servicios_areas`
--
ALTER TABLE `servicios_areas`
  ADD PRIMARY KEY (`idArea`),
  ADD KEY `area_idZones` (`area_idZones`);

--
-- Indices de la tabla `servicios_incidentes`
--
ALTER TABLE `servicios_incidentes`
  ADD PRIMARY KEY (`idIncidente`),
  ADD KEY `incidente_idObject` (`incidente_idObject`);

--
-- Indices de la tabla `servicios_notify`
--
ALTER TABLE `servicios_notify`
  ADD PRIMARY KEY (`idNotify`);

--
-- Indices de la tabla `servicios_objects`
--
ALTER TABLE `servicios_objects`
  ADD PRIMARY KEY (`idObject`),
  ADD KEY `idArea` (`objects_idArea`);

--
-- Indices de la tabla `servicios_plan`
--
ALTER TABLE `servicios_plan`
  ADD PRIMARY KEY (`idPlan`),
  ADD KEY `idSupervisor` (`idSupervisor`,`idSchool`,`idZone`,`idArea`),
  ADD KEY `plan_idSchool` (`idSchool`),
  ADD KEY `plan_idZone` (`idZone`),
  ADD KEY `plan_idArea` (`idArea`);

--
-- Indices de la tabla `servicios_schools`
--
ALTER TABLE `servicios_schools`
  ADD PRIMARY KEY (`idSchool`);

--
-- Indices de la tabla `servicios_supervision_days`
--
ALTER TABLE `servicios_supervision_days`
  ADD PRIMARY KEY (`idSupervisionDays`),
  ADD KEY `idSchool` (`idSchool`),
  ADD KEY `idZone` (`idZone`),
  ADD KEY `idArea` (`idArea`),
  ADD KEY `idSupervisor` (`idSupervisor`);

--
-- Indices de la tabla `servicios_users`
--
ALTER TABLE `servicios_users`
  ADD PRIMARY KEY (`idUsers`);

--
-- Indices de la tabla `servicios_zones`
--
ALTER TABLE `servicios_zones`
  ADD PRIMARY KEY (`idZone`),
  ADD KEY `zone_idSchool` (`zone_idSchool`);

--
-- Indices de la tabla `unimo_events`
--
ALTER TABLE `unimo_events`
  ADD PRIMARY KEY (`idEvent`);

--
-- Indices de la tabla `unimo_invitados`
--
ALTER TABLE `unimo_invitados`
  ADD PRIMARY KEY (`idInvitado`),
  ADD KEY `idEvent` (`idEvent`);

--
-- Indices de la tabla `unimo_users`
--
ALTER TABLE `unimo_users`
  ADD PRIMARY KEY (`idUser`);

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
  MODIFY `idRequest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `montrer_company`
--
ALTER TABLE `montrer_company`
  MODIFY `idCompany` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `montrer_exercise`
--
ALTER TABLE `montrer_exercise`
  MODIFY `idExercise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `montrer_logs`
--
ALTER TABLE `montrer_logs`
  MODIFY `idLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de la tabla `montrer_month_budget`
--
ALTER TABLE `montrer_month_budget`
  MODIFY `idMensualBudget` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `montrer_payment_requests`
--
ALTER TABLE `montrer_payment_requests`
  MODIFY `idPaymentRequest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `montrer_providers`
--
ALTER TABLE `montrer_providers`
  MODIFY `idProvider` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `montrer_roots`
--
ALTER TABLE `montrer_roots`
  MODIFY `idRoot` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `montrer_users`
--
ALTER TABLE `montrer_users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `servicios_areas`
--
ALTER TABLE `servicios_areas`
  MODIFY `idArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `servicios_incidentes`
--
ALTER TABLE `servicios_incidentes`
  MODIFY `idIncidente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios_notify`
--
ALTER TABLE `servicios_notify`
  MODIFY `idNotify` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `servicios_objects`
--
ALTER TABLE `servicios_objects`
  MODIFY `idObject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `servicios_plan`
--
ALTER TABLE `servicios_plan`
  MODIFY `idPlan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `servicios_schools`
--
ALTER TABLE `servicios_schools`
  MODIFY `idSchool` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `servicios_supervision_days`
--
ALTER TABLE `servicios_supervision_days`
  MODIFY `idSupervisionDays` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `servicios_users`
--
ALTER TABLE `servicios_users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicios_zones`
--
ALTER TABLE `servicios_zones`
  MODIFY `idZone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `unimo_events`
--
ALTER TABLE `unimo_events`
  MODIFY `idEvent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `unimo_invitados`
--
ALTER TABLE `unimo_invitados`
  MODIFY `idInvitado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `unimo_users`
--
ALTER TABLE `unimo_users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- Filtros para la tabla `servicios_plan`
--
ALTER TABLE `servicios_plan`
  ADD CONSTRAINT `plan_idArea` FOREIGN KEY (`idArea`) REFERENCES `servicios_areas` (`idArea`),
  ADD CONSTRAINT `plan_idSchool` FOREIGN KEY (`idSchool`) REFERENCES `servicios_schools` (`idSchool`),
  ADD CONSTRAINT `plan_idSupervisor` FOREIGN KEY (`idSupervisor`) REFERENCES `servicios_users` (`idUsers`),
  ADD CONSTRAINT `plan_idZone` FOREIGN KEY (`idZone`) REFERENCES `servicios_zones` (`idZone`);

--
-- Filtros para la tabla `servicios_zones`
--
ALTER TABLE `servicios_zones`
  ADD CONSTRAINT `zone_idSchool` FOREIGN KEY (`zone_idSchool`) REFERENCES `servicios_zones` (`idZone`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `unimo_invitados`
--
ALTER TABLE `unimo_invitados`
  ADD CONSTRAINT `idEvents_invitados` FOREIGN KEY (`idEvent`) REFERENCES `unimo_events` (`idEvent`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
