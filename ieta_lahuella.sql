-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-02-2026 a las 06:53:33
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
-- Base de datos: `ieta_lahuella`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acudientes`
--

CREATE TABLE `acudientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `celular_acudiente` varchar(255) NOT NULL,
  `direccion_acudiente` varchar(255) NOT NULL,
  `genero_acudiente` varchar(255) NOT NULL,
  `parentesco_acudiente` varchar(255) NOT NULL,
  `estado_acudiente` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `acudientes`
--

INSERT INTO `acudientes` (`id`, `user_id`, `celular_acudiente`, `direccion_acudiente`, `genero_acudiente`, `parentesco_acudiente`, `estado_acudiente`, `created_at`, `updated_at`) VALUES
(1, 144, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(2, 145, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(3, 146, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(4, 147, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(5, 148, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(6, 149, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(7, 150, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(8, 151, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(9, 152, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(10, 153, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(11, 154, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(12, 155, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(13, 156, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(14, 157, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(15, 158, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(16, 159, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(17, 160, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(18, 161, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(19, 162, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(20, 163, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(21, 164, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(22, 165, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(23, 166, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(24, 167, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(25, 168, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(26, 169, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(27, 170, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(28, 171, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(29, 172, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(30, 173, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(31, 174, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(32, 175, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(33, 176, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(34, 177, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(35, 178, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(36, 179, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(37, 180, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(38, 181, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(39, 182, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(40, 183, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(41, 184, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(42, 185, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(43, 186, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(44, 187, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(45, 188, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(46, 189, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(47, 190, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(48, 191, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(49, 192, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(50, 193, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(51, 194, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(52, 195, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(53, 196, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(54, 197, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(55, 198, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(56, 199, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(57, 200, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(58, 201, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(59, 202, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(60, 203, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(61, 204, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(62, 205, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(63, 206, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(64, 207, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(65, 208, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(66, 209, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(67, 210, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(68, 211, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(69, 212, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(70, 213, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(71, 214, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(72, 215, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(73, 216, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(74, 217, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(75, 218, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(76, 219, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(77, 220, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(78, 221, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(79, 222, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(80, 223, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(81, 224, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(82, 225, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(83, 226, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(84, 227, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(85, 228, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(86, 229, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(87, 230, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(88, 231, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(89, 232, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(90, 233, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(91, 234, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(92, 235, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(93, 236, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(94, 237, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(95, 238, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(96, 239, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(97, 240, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(98, 241, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(99, 242, '3000000000', 'Calle Falsa 123', 'M', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30'),
(100, 243, '3000000000', 'Calle Falsa 123', 'F', 'Padre', '1', '2026-02-09 03:13:30', '2026-02-09 03:13:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anho_escolar`
--

CREATE TABLE `anho_escolar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_anho_escolar` varchar(255) NOT NULL,
  `fecha_inicio_anho_escolar` date NOT NULL,
  `fecha_fin_anho_escolar` date NOT NULL,
  `estado_anho_escolar` tinyint(1) NOT NULL DEFAULT 1,
  `descripcion_anho_escolar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `anho_escolar`
--

INSERT INTO `anho_escolar` (`id`, `nombre_anho_escolar`, `fecha_inicio_anho_escolar`, `fecha_fin_anho_escolar`, `estado_anho_escolar`, `descripcion_anho_escolar`, `created_at`, `updated_at`) VALUES
(1, '2025', '2025-01-15', '2025-11-30', 1, 'Año lectivo 2025', '2026-02-09 03:14:08', '2026-02-09 03:14:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_asignatura` varchar(255) NOT NULL,
  `sede_id` bigint(20) UNSIGNED NOT NULL,
  `hilo_id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `creditos` varchar(255) NOT NULL,
  `docente_id` bigint(20) UNSIGNED NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id`, `nombre_asignatura`, `sede_id`, `hilo_id`, `descripcion`, `creditos`, `docente_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Filosofía', 1, 1, 'Asignatura del hilo Gobierno Propio', '1', 9, 'activo', '2026-02-09 04:36:23', '2026-02-09 04:36:23'),
(2, 'Química', 1, 2, 'Asignatura del hilo Uma Kiwe', '1', 12, 'activo', '2026-02-09 04:36:41', '2026-02-09 04:36:41'),
(3, 'Física', 1, 2, 'Asignatura del hilo Uma Kiwe', '1', 12, 'activo', '2026-02-09 04:36:41', '2026-02-09 04:36:41'),
(4, 'Proyectos', 1, 2, 'Asignatura del hilo Uma Kiwe', '1', 5, 'activo', '2026-02-09 04:36:41', '2026-02-09 04:36:41'),
(5, 'Agropecuarias', 1, 2, 'Asignatura del hilo Uma Kiwe', '1', 3, 'activo', '2026-02-09 04:36:41', '2026-02-09 04:36:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audits`
--

CREATE TABLE `audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) NOT NULL,
  `auditable_type` varchar(255) NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` text DEFAULT NULL,
  `new_values` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `audits`
--

INSERT INTO `audits` (`id`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'created', 'App\\Models\\Notas', 1, '[]', '{\"periodo_academico_id\":\"1\",\"grado_id\":\"1\",\"estudiante_id\":\"1\",\"asignatura_id\":\"5\",\"nota\":\"5\",\"observaciones\":\"nn\",\"updated_at\":\"2026-02-09 04:37:42\",\"created_at\":\"2026-02-09 04:37:42\",\"id\":1}', 'http://127.0.0.1:8000/home/notas', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 09:37:42', '2026-02-09 09:37:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-rector@sistema.com|127.0.0.1', 'i:1;', 1770612202),
('laravel-cache-rector@sistema.com|127.0.0.1:timer', 'i:1770612202;', 1770612202);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_curso` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre_curso`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Primero', 'Curso primero', 'activo', '2026-02-09 03:12:51', '2026-02-09 03:12:51'),
(2, 'Segundo', 'Curso segundo', 'activo', '2026-02-09 03:12:51', '2026-02-09 03:12:51'),
(3, 'Tercero', 'Curso tercero', 'activo', '2026-02-09 03:12:51', '2026-02-09 03:12:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `codigo_docente` varchar(255) NOT NULL,
  `genero_docente` varchar(255) NOT NULL,
  `foto_docente` varchar(255) NOT NULL,
  `estado_docente` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `user_id`, `codigo_docente`, `genero_docente`, `foto_docente`, `estado_docente`, `created_at`, `updated_at`) VALUES
(1, 2, 'DOC-2', 'M', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(2, 11, 'DOC-11', 'F', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(3, 12, 'DOC-12', 'M', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(4, 13, 'DOC-13', 'F', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(5, 14, 'DOC-14', 'M', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(6, 15, 'DOC-15', 'F', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(7, 16, 'DOC-16', 'M', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(8, 3, 'DOC-3', 'F', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(9, 4, 'DOC-4', 'M', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(10, 5, 'DOC-5', 'F', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(11, 6, 'DOC-6', 'M', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(12, 7, 'DOC-7', 'F', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(13, 8, 'DOC-8', 'M', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(14, 9, 'DOC-9', 'F', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37'),
(15, 10, 'DOC-10', 'M', 'docente.png', '1', '2026-02-09 03:12:37', '2026-02-09 03:12:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `codigo_estudiante` varchar(255) NOT NULL,
  `fecha_nacimiento_estudiante` date NOT NULL,
  `genero_estudiante` varchar(255) NOT NULL,
  `foto_estudiante` varchar(255) NOT NULL,
  `anho_curso_estudiante` varchar(255) NOT NULL,
  `direccion_estudiante` varchar(255) NOT NULL,
  `telefono_estudiante` varchar(255) NOT NULL,
  `email_estudiante` varchar(255) NOT NULL,
  `tipo_identificacion_estudiante` varchar(255) NOT NULL,
  `numero_identificacion_estudiante` varchar(255) NOT NULL,
  `estado_estudiante` tinyint(1) NOT NULL DEFAULT 1,
  `acudiente_id` bigint(20) UNSIGNED NOT NULL,
  `grado_academico_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `user_id`, `codigo_estudiante`, `fecha_nacimiento_estudiante`, `genero_estudiante`, `foto_estudiante`, `anho_curso_estudiante`, `direccion_estudiante`, `telefono_estudiante`, `email_estudiante`, `tipo_identificacion_estudiante`, `numero_identificacion_estudiante`, `estado_estudiante`, `acudiente_id`, `grado_academico_id`, `created_at`, `updated_at`) VALUES
(1, 17, 'EST-17', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante1@ieta.edu.co', 'TI', '10017', 1, 17, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(2, 18, 'EST-18', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante2@ieta.edu.co', 'TI', '10018', 1, 18, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(3, 19, 'EST-19', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante3@ieta.edu.co', 'TI', '10019', 1, 19, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(4, 20, 'EST-20', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante4@ieta.edu.co', 'TI', '10020', 1, 20, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(5, 21, 'EST-21', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante5@ieta.edu.co', 'TI', '10021', 1, 21, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(6, 22, 'EST-22', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante6@ieta.edu.co', 'TI', '10022', 1, 22, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(7, 23, 'EST-23', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante7@ieta.edu.co', 'TI', '10023', 1, 23, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(8, 24, 'EST-24', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante8@ieta.edu.co', 'TI', '10024', 1, 24, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(9, 25, 'EST-25', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante9@ieta.edu.co', 'TI', '10025', 1, 25, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(10, 26, 'EST-26', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante10@ieta.edu.co', 'TI', '10026', 1, 26, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(11, 27, 'EST-27', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante11@ieta.edu.co', 'TI', '10027', 1, 27, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(12, 28, 'EST-28', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante12@ieta.edu.co', 'TI', '10028', 1, 28, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(13, 29, 'EST-29', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante13@ieta.edu.co', 'TI', '10029', 1, 29, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(14, 30, 'EST-30', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante14@ieta.edu.co', 'TI', '10030', 1, 30, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(15, 31, 'EST-31', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante15@ieta.edu.co', 'TI', '10031', 1, 31, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(16, 32, 'EST-32', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante16@ieta.edu.co', 'TI', '10032', 1, 32, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(17, 33, 'EST-33', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante17@ieta.edu.co', 'TI', '10033', 1, 33, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(18, 34, 'EST-34', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante18@ieta.edu.co', 'TI', '10034', 1, 34, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(19, 35, 'EST-35', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante19@ieta.edu.co', 'TI', '10035', 1, 35, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(20, 36, 'EST-36', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante20@ieta.edu.co', 'TI', '10036', 1, 36, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(21, 37, 'EST-37', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante21@ieta.edu.co', 'TI', '10037', 1, 37, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(22, 38, 'EST-38', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante22@ieta.edu.co', 'TI', '10038', 1, 38, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(23, 39, 'EST-39', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante23@ieta.edu.co', 'TI', '10039', 1, 39, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(24, 40, 'EST-40', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante24@ieta.edu.co', 'TI', '10040', 1, 40, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(25, 41, 'EST-41', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante25@ieta.edu.co', 'TI', '10041', 1, 41, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(26, 42, 'EST-42', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante26@ieta.edu.co', 'TI', '10042', 1, 42, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(27, 43, 'EST-43', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante27@ieta.edu.co', 'TI', '10043', 1, 43, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(28, 44, 'EST-44', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante28@ieta.edu.co', 'TI', '10044', 1, 44, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(29, 45, 'EST-45', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante29@ieta.edu.co', 'TI', '10045', 1, 45, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(30, 46, 'EST-46', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante30@ieta.edu.co', 'TI', '10046', 1, 46, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(31, 47, 'EST-47', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante31@ieta.edu.co', 'TI', '10047', 1, 47, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(32, 48, 'EST-48', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante32@ieta.edu.co', 'TI', '10048', 1, 48, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(33, 49, 'EST-49', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante33@ieta.edu.co', 'TI', '10049', 1, 49, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(34, 50, 'EST-50', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante34@ieta.edu.co', 'TI', '10050', 1, 50, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(35, 51, 'EST-51', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante35@ieta.edu.co', 'TI', '10051', 1, 51, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(36, 52, 'EST-52', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante36@ieta.edu.co', 'TI', '10052', 1, 52, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(37, 53, 'EST-53', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante37@ieta.edu.co', 'TI', '10053', 1, 53, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(38, 54, 'EST-54', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante38@ieta.edu.co', 'TI', '10054', 1, 54, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(39, 55, 'EST-55', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante39@ieta.edu.co', 'TI', '10055', 1, 55, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(40, 56, 'EST-56', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante40@ieta.edu.co', 'TI', '10056', 1, 56, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(41, 57, 'EST-57', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante41@ieta.edu.co', 'TI', '10057', 1, 57, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(42, 58, 'EST-58', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante42@ieta.edu.co', 'TI', '10058', 1, 58, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(43, 59, 'EST-59', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante43@ieta.edu.co', 'TI', '10059', 1, 59, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(44, 60, 'EST-60', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante44@ieta.edu.co', 'TI', '10060', 1, 60, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(45, 61, 'EST-61', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante45@ieta.edu.co', 'TI', '10061', 1, 61, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(46, 62, 'EST-62', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante46@ieta.edu.co', 'TI', '10062', 1, 62, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(47, 63, 'EST-63', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante47@ieta.edu.co', 'TI', '10063', 1, 63, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(48, 64, 'EST-64', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante48@ieta.edu.co', 'TI', '10064', 1, 64, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(49, 65, 'EST-65', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante49@ieta.edu.co', 'TI', '10065', 1, 65, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(50, 66, 'EST-66', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante50@ieta.edu.co', 'TI', '10066', 1, 66, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(51, 67, 'EST-67', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante51@ieta.edu.co', 'TI', '10067', 1, 67, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(52, 68, 'EST-68', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante52@ieta.edu.co', 'TI', '10068', 1, 68, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(53, 69, 'EST-69', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante53@ieta.edu.co', 'TI', '10069', 1, 69, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(54, 70, 'EST-70', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante54@ieta.edu.co', 'TI', '10070', 1, 70, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(55, 71, 'EST-71', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante55@ieta.edu.co', 'TI', '10071', 1, 71, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(56, 72, 'EST-72', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante56@ieta.edu.co', 'TI', '10072', 1, 72, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(57, 73, 'EST-73', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante57@ieta.edu.co', 'TI', '10073', 1, 73, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(58, 74, 'EST-74', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante58@ieta.edu.co', 'TI', '10074', 1, 74, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(59, 75, 'EST-75', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante59@ieta.edu.co', 'TI', '10075', 1, 75, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(60, 76, 'EST-76', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante60@ieta.edu.co', 'TI', '10076', 1, 76, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(61, 77, 'EST-77', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante61@ieta.edu.co', 'TI', '10077', 1, 77, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(62, 78, 'EST-78', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante62@ieta.edu.co', 'TI', '10078', 1, 78, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(63, 79, 'EST-79', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante63@ieta.edu.co', 'TI', '10079', 1, 79, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(64, 80, 'EST-80', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante64@ieta.edu.co', 'TI', '10080', 1, 80, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(65, 81, 'EST-81', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante65@ieta.edu.co', 'TI', '10081', 1, 81, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(66, 82, 'EST-82', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante66@ieta.edu.co', 'TI', '10082', 1, 82, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(67, 83, 'EST-83', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante67@ieta.edu.co', 'TI', '10083', 1, 83, 4, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(68, 84, 'EST-84', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante68@ieta.edu.co', 'TI', '10084', 1, 84, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(69, 85, 'EST-85', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante69@ieta.edu.co', 'TI', '10085', 1, 85, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(70, 86, 'EST-86', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante70@ieta.edu.co', 'TI', '10086', 1, 86, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(71, 87, 'EST-87', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante71@ieta.edu.co', 'TI', '10087', 1, 87, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(72, 88, 'EST-88', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante72@ieta.edu.co', 'TI', '10088', 1, 88, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(73, 89, 'EST-89', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante73@ieta.edu.co', 'TI', '10089', 1, 89, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(74, 90, 'EST-90', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante74@ieta.edu.co', 'TI', '10090', 1, 90, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(75, 91, 'EST-91', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante75@ieta.edu.co', 'TI', '10091', 1, 91, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(76, 92, 'EST-92', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante76@ieta.edu.co', 'TI', '10092', 1, 92, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(77, 93, 'EST-93', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante77@ieta.edu.co', 'TI', '10093', 1, 93, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(78, 94, 'EST-94', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante78@ieta.edu.co', 'TI', '10094', 1, 94, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(79, 95, 'EST-95', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante79@ieta.edu.co', 'TI', '10095', 1, 95, 2, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(80, 96, 'EST-96', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante80@ieta.edu.co', 'TI', '10096', 1, 96, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(81, 97, 'EST-97', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante81@ieta.edu.co', 'TI', '10097', 1, 97, 6, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(82, 98, 'EST-98', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante82@ieta.edu.co', 'TI', '10098', 1, 98, 5, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(83, 99, 'EST-99', '2010-01-01', 'M', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante83@ieta.edu.co', 'TI', '10099', 1, 99, 3, '2026-02-09 03:13:52', '2026-02-09 03:13:52'),
(84, 100, 'EST-100', '2010-01-01', 'F', 'estudiante.png', '2025', 'Barrio Central', '3100000000', 'estudiante84@ieta.edu.co', 'TI', '100100', 1, 100, 1, '2026-02-09 03:13:52', '2026-02-09 03:13:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado_academicos`
--

CREATE TABLE `grado_academicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_grado` varchar(255) NOT NULL,
  `bloque` varchar(255) NOT NULL,
  `sede_id` bigint(20) UNSIGNED NOT NULL,
  `estado_grado_academico` tinyint(1) NOT NULL DEFAULT 1,
  `docente_id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED DEFAULT NULL,
  `asignatura_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grado_academicos`
--

INSERT INTO `grado_academicos` (`id`, `nombre_grado`, `bloque`, `sede_id`, `estado_grado_academico`, `docente_id`, `curso_id`, `asignatura_id`, `created_at`, `updated_at`) VALUES
(1, 'Grado 1', 'Básica', 1, 1, 10, 2, 2, '2026-02-09 03:13:11', '2026-02-09 03:13:11'),
(2, 'Grado 2', 'Básica', 1, 1, 5, 3, 3, '2026-02-09 03:13:11', '2026-02-09 03:13:11'),
(3, 'Grado 3', 'Básica', 1, 1, 3, 1, 4, '2026-02-09 03:13:11', '2026-02-09 03:13:11'),
(4, 'Grado 4', 'Básica', 1, 1, 8, 3, 4, '2026-02-09 03:13:11', '2026-02-09 03:13:11'),
(5, 'Grado 5', 'Básica', 1, 1, 6, 2, 5, '2026-02-09 03:13:11', '2026-02-09 03:13:11'),
(6, 'Grado 6', 'Básica', 1, 1, 7, 1, 2, '2026-02-09 03:13:11', '2026-02-09 03:13:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hilos`
--

CREATE TABLE `hilos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_hilo` varchar(255) NOT NULL,
  `abreviatura` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `hilos`
--

INSERT INTO `hilos` (`id`, `nombre_hilo`, `abreviatura`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Gobierno Propio', 'GP', 'activo', '2026-02-09 04:35:58', '2026-02-09 04:35:58'),
(2, 'Uma Kiwe', 'UK', 'activo', '2026-02-09 04:35:58', '2026-02-09 04:35:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucions`
--

CREATE TABLE `institucions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_institucion` varchar(255) NOT NULL,
  `descripcion_institucion` varchar(255) NOT NULL,
  `codigo_dane` varchar(255) NOT NULL,
  `ciudad_institucion` varchar(255) NOT NULL,
  `departamento_institucion` varchar(255) NOT NULL,
  `resolucion_institucion` varchar(255) NOT NULL,
  `rector_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `institucions`
--

INSERT INTO `institucions` (`id`, `nombre_institucion`, `descripcion_institucion`, `codigo_dane`, `ciudad_institucion`, `departamento_institucion`, `resolucion_institucion`, `rector_id`, `created_at`, `updated_at`) VALUES
(1, 'IETA La Huella', 'Institución Educativa Técnica Agropecuaria', '123456', 'Popayán', 'Cauca', 'RES-001', 1, '2026-02-09 03:12:09', '2026-02-09 03:12:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculados`
--

CREATE TABLE `matriculados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grado_id` bigint(20) UNSIGNED NOT NULL,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriculados`
--

INSERT INTO `matriculados` (`id`, `grado_id`, `estudiante_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(2, 4, 2, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(3, 6, 3, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(4, 1, 4, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(5, 3, 5, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(6, 2, 6, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(7, 6, 7, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(8, 3, 8, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(9, 4, 9, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(10, 4, 10, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(11, 5, 11, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(12, 6, 12, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(13, 5, 13, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(14, 3, 14, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(15, 5, 15, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(16, 1, 16, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(17, 6, 17, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(18, 5, 18, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(19, 5, 19, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(20, 2, 20, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(21, 2, 21, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(22, 1, 22, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(23, 4, 23, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(24, 6, 24, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(25, 6, 25, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(26, 6, 26, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(27, 5, 27, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(28, 4, 28, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(29, 6, 29, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(30, 6, 30, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(31, 1, 31, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(32, 2, 32, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(33, 1, 33, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(34, 6, 34, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(35, 4, 35, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(36, 6, 36, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(37, 3, 37, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(38, 6, 38, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(39, 3, 39, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(40, 4, 40, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(41, 3, 41, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(42, 3, 42, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(43, 2, 43, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(44, 4, 44, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(45, 3, 45, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(46, 6, 46, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(47, 2, 47, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(48, 3, 48, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(49, 5, 49, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(50, 2, 50, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(51, 2, 51, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(52, 1, 52, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(53, 5, 53, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(54, 5, 54, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(55, 2, 55, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(56, 5, 56, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(57, 5, 57, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(58, 4, 58, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(59, 2, 59, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(60, 1, 60, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(61, 3, 61, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(62, 4, 62, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(63, 4, 63, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(64, 3, 64, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(65, 3, 65, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(66, 2, 66, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(67, 1, 67, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(68, 1, 68, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(69, 1, 69, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(70, 6, 70, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(71, 5, 71, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(72, 4, 72, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(73, 5, 73, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(74, 4, 74, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(75, 3, 75, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(76, 6, 76, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(77, 5, 77, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(78, 1, 78, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(79, 4, 79, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(80, 1, 80, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(81, 2, 81, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(82, 1, 82, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(83, 3, 83, '2026-02-09 04:53:54', '2026-02-09 04:53:54'),
(84, 4, 84, '2026-02-09 04:53:54', '2026-02-09 04:53:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `nombre_submenu` varchar(255) DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tipo` enum('sencillo','dropdown') NOT NULL DEFAULT 'sencillo',
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `rol_id` bigint(20) UNSIGNED NOT NULL,
  `orden` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `nombre`, `nombre_submenu`, `icono`, `url`, `tipo`, `estado`, `rol_id`, `orden`, `created_at`, `updated_at`) VALUES
(1, 'Institución', 'Institución', 'fa fa-id-badge', 'admin.institucion.index', 'dropdown', 1, 1, '2', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(2, 'Institución', 'Sedes', 'fa fa-building', 'admin.sede.index', 'dropdown', 1, 1, '3', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(3, 'Institución', 'Docentes', 'fa fa-chalkboard-teacher', 'admin.docente.index', 'dropdown', 1, 1, '4', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(4, 'Institución', 'Cursos', 'fa fa-book', 'admin.curso.index', 'dropdown', 1, 1, '5', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(5, 'Institución', 'Hilos', 'fa fa-stream', 'admin.hilo.index', 'dropdown', 1, 1, '6', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(6, 'Institución', 'Asignaturas', 'fa fa-book-open', 'admin.asignatura.index', 'dropdown', 1, 1, '7', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(7, 'Institución', 'Grados Académicos', 'fa fa-graduation-cap', 'admin.gradoacademico.index', 'dropdown', 1, 1, '8', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(8, 'Acudientes', NULL, 'fa fa-user-friends', 'admin.acudiente.index', 'sencillo', 1, 1, '9', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(9, 'Estudiantes', NULL, 'fa fa-user-graduate', 'admin.estudiante.index', 'sencillo', 1, 1, '10', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(10, 'Institución', 'Año Escolar', 'fa fa-calendar-alt', 'admin.anhoescolar.index', 'dropdown', 1, 1, '11', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(11, 'Institución', 'Periodos Académicos', 'fa fa-calendar-check', 'admin.periodoacademico.index', 'dropdown', 1, 1, '12', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(12, 'Usuarios', 'Crear', 'fa fa-user-plus', 'admin.usuarios.crear', 'dropdown', 1, 1, '13', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(13, 'Usuarios', 'Asignar Rol', 'fa fa-id-badge', 'admin.usuarios.asignarRol', 'dropdown', 1, 1, '14', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(14, 'Matriculados', NULL, 'fa fa-user-check', 'admin.matriculado.index', 'sencillo', 1, 1, '15', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(15, 'Notas', NULL, 'fa fa-clipboard-list', 'admin.notas.index', 'sencillo', 1, 1, '16', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(16, 'Notas Definitivas', NULL, 'fa fa-file-contract', 'admin.notas-definitivas.index', 'sencillo', 1, 1, '17', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(17, 'Notas Periodos', NULL, 'fa fa-clipboard-list', 'estudiante.notasPeriodo', 'sencillo', 1, 2, '17', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(18, 'Solicitar Paz y Salvo', NULL, 'fa fa-clipboard-list', 'estudiante.notasPeriodo', 'sencillo', 1, 2, '17', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(19, 'Solicitar Certificado Académico', NULL, 'fa fa-file', 'estudiante.notasPeriodo', 'sencillo', 1, 2, '17', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(20, 'Horario académico', NULL, 'fa fa-calendar', 'estudiante.notasPeriodo', 'sencillo', 1, 2, '17', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(21, 'Asignaturas a Cargo', NULL, 'fa fa-clipboard-list', 'docente.dashboard', 'sencillo', 1, 4, '16', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(22, 'Cursos a Cargo', NULL, 'fa fa-clipboard-list', 'docente.dashboard', 'sencillo', 1, 4, '16', '2026-02-09 08:16:17', '2026-02-09 08:16:17'),
(23, 'Estudiantes a Cargo', NULL, 'fa fa-clipboard-list', 'docente.dashboard', 'sencillo', 1, 4, '16', '2026-02-09 08:16:17', '2026-02-09 08:16:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_26_182618_create_rols_table', 1),
(5, '2026_01_26_183027_create_rol_users_table', 1),
(6, '2026_01_26_183657_create_menus_table', 1),
(7, '2026_01_27_001134_create_institucions_table', 1),
(8, '2026_01_27_001145_create_sedes_table', 1),
(9, '2026_01_27_004224_create_docentes_table', 1),
(10, '2026_01_27_004230_create_cursos_table', 1),
(11, '2026_01_27_004231_create_hilos_table', 1),
(12, '2026_01_27_004238_create_asignaturas_table', 1),
(13, '2026_01_27_005449_create_grado_academicos_table', 1),
(14, '2026_01_27_005450_create_acudientes_table', 1),
(15, '2026_01_27_005840_create_estudiantes_table', 1),
(16, '2026_01_27_010927_create_anho_escolars_table', 1),
(17, '2026_01_29_231122_create_periodo_academicos_table', 1),
(18, '2026_01_29_231133_create_notas_table', 1),
(19, '2026_01_29_231152_create_matriculados_table', 1),
(20, '2026_01_29_231208_create_notas_definitivas_table', 1),
(21, '2026_02_01_222653_update_grado_academicos_table', 1),
(22, '2026_02_03_005402_create_audits_table', 1),
(23, '2026_02_03_011420_add_audit_menu_item', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `periodo_academico_id` bigint(20) UNSIGNED NOT NULL,
  `grado_id` bigint(20) UNSIGNED NOT NULL,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `nota` decimal(5,2) NOT NULL,
  `observaciones` varchar(255) NOT NULL,
  `asignatura_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id`, `periodo_academico_id`, `grado_id`, `estudiante_id`, `nota`, `observaciones`, `asignatura_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 5.00, 'nn', 5, '2026-02-09 09:37:42', '2026-02-09 09:37:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas_definitivas`
--

CREATE TABLE `notas_definitivas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `documento_estudiante` varchar(255) NOT NULL,
  `nombre_estudiante` varchar(255) NOT NULL,
  `grado_aprobado` varchar(255) NOT NULL,
  `nota_per1` decimal(5,2) NOT NULL,
  `nota_per2` decimal(5,2) NOT NULL,
  `nota_per3` decimal(5,2) NOT NULL,
  `nota_per4` decimal(5,2) NOT NULL,
  `nota_definitiva` decimal(5,2) NOT NULL,
  `nombre_asignatura` varchar(255) NOT NULL,
  `curso` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numeros`
--

CREATE TABLE `numeros` (
  `n` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `numeros`
--

INSERT INTO `numeros` (`n`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(45),
(46),
(47),
(48),
(49),
(50),
(51),
(52),
(53),
(54),
(55),
(56),
(57),
(58),
(59),
(60),
(61),
(62),
(63),
(64),
(65),
(66),
(67),
(68),
(69),
(70),
(71),
(72),
(73),
(74),
(75),
(76),
(77),
(78),
(79),
(80),
(81),
(82),
(83),
(84),
(85),
(86),
(87),
(88),
(89),
(90),
(91),
(92),
(93),
(94),
(95),
(96),
(97),
(98),
(99),
(100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_academicos`
--

CREATE TABLE `periodo_academicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `año_escolar_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_periodo` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `porcentaje_periodo` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `periodo_academicos`
--

INSERT INTO `periodo_academicos` (`id`, `año_escolar_id`, `nombre_periodo`, `fecha_inicio`, `fecha_fin`, `porcentaje_periodo`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Periodo 1', '2025-01-15', '2025-03-30', '25', 'activo', '2026-02-09 03:14:27', '2026-02-09 03:14:27'),
(2, 1, 'Periodo 2', '2025-04-01', '2025-06-15', '25', 'activo', '2026-02-09 03:14:27', '2026-02-09 03:14:27'),
(3, 1, 'Periodo 3', '2025-07-01', '2025-09-15', '25', 'activo', '2026-02-09 03:14:27', '2026-02-09 03:14:27'),
(4, 1, 'Periodo 4', '2025-09-20', '2025-11-30', '25', 'activo', '2026-02-09 03:14:27', '2026-02-09 03:14:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'SUPERADMIN', 'Acceso total', 1, '2026-02-09 03:06:15', '2026-02-09 03:06:15'),
(2, 'ESTUDIANTE', 'Gestión institucional', 1, '2026-02-09 03:06:15', '2026-02-09 03:06:15'),
(3, 'RECTOR', 'Gestión académica', 1, '2026-02-09 03:06:15', '2026-02-09 03:06:15'),
(4, 'DOCENTE', 'Consulta de notas', 1, '2026-02-09 03:06:15', '2026-02-09 03:06:15'),
(5, 'Acudiente', 'Seguimiento académico', 1, '2026-02-09 03:06:15', '2026-02-09 03:06:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_user`
--

CREATE TABLE `rol_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rol_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol_user`
--

INSERT INTO `rol_user` (`id`, `rol_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(2, 4, 2, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(3, 4, 11, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(4, 4, 12, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(5, 4, 13, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(6, 4, 14, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(7, 4, 15, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(8, 4, 16, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(9, 4, 3, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(10, 4, 4, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(11, 4, 5, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(12, 4, 6, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(13, 4, 7, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(14, 4, 8, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(15, 4, 9, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(16, 4, 10, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(17, 2, 17, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(18, 2, 26, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(19, 2, 116, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(20, 2, 27, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(21, 2, 28, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(22, 2, 29, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(23, 2, 30, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(24, 2, 31, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(25, 2, 32, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(26, 2, 33, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(27, 2, 34, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(28, 2, 35, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(29, 2, 18, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(30, 2, 36, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(31, 2, 37, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(32, 2, 38, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(33, 2, 39, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(34, 2, 40, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(35, 2, 41, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(36, 2, 42, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(37, 2, 43, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(38, 2, 44, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(39, 2, 45, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(40, 2, 19, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(41, 2, 46, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(42, 2, 47, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(43, 2, 48, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(44, 2, 49, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(45, 2, 50, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(46, 2, 51, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(47, 2, 52, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(48, 2, 53, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(49, 2, 54, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(50, 2, 55, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(51, 2, 20, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(52, 2, 56, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(53, 2, 57, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(54, 2, 58, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(55, 2, 59, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(56, 2, 60, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(57, 2, 61, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(58, 2, 62, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(59, 2, 63, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(60, 2, 64, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(61, 2, 65, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(62, 2, 21, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(63, 2, 66, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(64, 2, 67, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(65, 2, 68, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(66, 2, 69, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(67, 2, 70, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(68, 2, 71, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(69, 2, 72, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(70, 2, 73, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(71, 2, 74, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(72, 2, 75, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(73, 2, 22, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(74, 2, 76, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(75, 2, 77, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(76, 2, 78, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(77, 2, 79, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(78, 2, 80, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(79, 2, 81, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(80, 2, 82, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(81, 2, 83, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(82, 2, 84, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(83, 2, 85, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(84, 2, 23, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(85, 2, 86, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(86, 2, 87, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(87, 2, 88, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(88, 2, 89, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(89, 2, 90, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(90, 2, 91, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(91, 2, 92, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(92, 2, 93, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(93, 2, 94, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(94, 2, 95, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(95, 2, 24, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(96, 2, 96, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(97, 2, 97, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(98, 2, 98, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(99, 2, 99, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(100, 2, 100, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(101, 2, 101, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(102, 2, 102, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(103, 2, 103, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(104, 2, 104, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(105, 2, 105, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(106, 2, 25, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(107, 2, 106, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(108, 2, 107, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(109, 2, 108, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(110, 2, 109, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(111, 2, 110, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(112, 2, 111, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(113, 2, 112, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(114, 2, 113, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(115, 2, 114, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(116, 2, 115, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(144, 5, 144, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(145, 5, 153, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(146, 5, 243, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(147, 5, 154, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(148, 5, 155, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(149, 5, 156, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(150, 5, 157, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(151, 5, 158, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(152, 5, 159, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(153, 5, 160, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(154, 5, 161, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(155, 5, 162, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(156, 5, 145, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(157, 5, 163, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(158, 5, 164, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(159, 5, 165, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(160, 5, 166, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(161, 5, 167, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(162, 5, 168, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(163, 5, 169, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(164, 5, 170, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(165, 5, 171, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(166, 5, 172, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(167, 5, 146, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(168, 5, 173, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(169, 5, 174, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(170, 5, 175, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(171, 5, 176, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(172, 5, 177, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(173, 5, 178, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(174, 5, 179, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(175, 5, 180, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(176, 5, 181, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(177, 5, 182, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(178, 5, 147, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(179, 5, 183, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(180, 5, 184, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(181, 5, 185, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(182, 5, 186, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(183, 5, 187, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(184, 5, 188, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(185, 5, 189, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(186, 5, 190, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(187, 5, 191, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(188, 5, 192, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(189, 5, 148, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(190, 5, 193, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(191, 5, 194, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(192, 5, 195, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(193, 5, 196, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(194, 5, 197, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(195, 5, 198, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(196, 5, 199, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(197, 5, 200, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(198, 5, 201, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(199, 5, 202, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(200, 5, 149, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(201, 5, 203, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(202, 5, 204, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(203, 5, 205, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(204, 5, 206, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(205, 5, 207, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(206, 5, 208, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(207, 5, 209, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(208, 5, 210, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(209, 5, 211, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(210, 5, 212, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(211, 5, 150, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(212, 5, 213, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(213, 5, 214, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(214, 5, 215, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(215, 5, 216, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(216, 5, 217, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(217, 5, 218, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(218, 5, 219, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(219, 5, 220, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(220, 5, 221, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(221, 5, 222, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(222, 5, 151, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(223, 5, 223, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(224, 5, 224, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(225, 5, 225, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(226, 5, 226, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(227, 5, 227, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(228, 5, 228, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(229, 5, 229, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(230, 5, 230, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(231, 5, 231, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(232, 5, 232, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(233, 5, 152, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(234, 5, 233, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(235, 5, 234, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(236, 5, 235, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(237, 5, 236, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(238, 5, 237, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(239, 5, 238, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(240, 5, 239, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(241, 5, 240, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(242, 5, 241, '2026-02-09 03:11:52', '2026-02-09 03:11:52'),
(243, 5, 242, '2026-02-09 03:11:52', '2026-02-09 03:11:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_sede` varchar(255) NOT NULL,
  `descripcion_sede` varchar(255) NOT NULL,
  `codigo_dane_sede` varchar(255) NOT NULL,
  `resolucion_sede` varchar(255) NOT NULL,
  `institucion_id` bigint(20) UNSIGNED NOT NULL,
  `estado_sede` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id`, `nombre_sede`, `descripcion_sede`, `codigo_dane_sede`, `resolucion_sede`, `institucion_id`, `estado_sede`, `created_at`, `updated_at`) VALUES
(1, 'Sede Principal', 'Sede urbana', '123456-01', 'RES-SP', 1, 1, '2026-02-09 03:12:24', '2026-02-09 03:12:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kQHKrTmhZRDmJjC53aFv7khwfzFhr7ide6dkzIkX', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiamk0b2VPZjVtQUJJb0JXT3JzelJtSlNQNzA1eTdTTThIaDlGR2VpQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kb2NlbnRlL2FzaWduYXR1cmFfZG9jZW50ZSI7czo1OiJyb3V0ZSI7czoxNzoiZG9jZW50ZS5kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc3MDYxNTk5ODt9fQ==', 1770616279);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `genero`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rector Principal', 'M', 'rector@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:07:50', '2026-02-09 03:07:50'),
(2, 'Docente 1', 'M', 'docente1@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(3, 'Docente 2', 'F', 'docente2@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(4, 'Docente 3', 'M', 'docente3@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(5, 'Docente 4', 'F', 'docente4@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(6, 'Docente 5', 'M', 'docente5@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(7, 'Docente 6', 'F', 'docente6@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(8, 'Docente 7', 'M', 'docente7@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(9, 'Docente 8', 'F', 'docente8@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(10, 'Docente 9', 'M', 'docente9@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(11, 'Docente 10', 'F', 'docente10@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(12, 'Docente 11', 'M', 'docente11@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(13, 'Docente 12', 'F', 'docente12@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(14, 'Docente 13', 'M', 'docente13@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(15, 'Docente 14', 'F', 'docente14@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(16, 'Docente 15', 'M', 'docente15@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:10:31', '2026-02-09 03:10:31'),
(17, 'Estudiante 1', 'M', 'estudiante1@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(18, 'Estudiante 2', 'F', 'estudiante2@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(19, 'Estudiante 3', 'M', 'estudiante3@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(20, 'Estudiante 4', 'F', 'estudiante4@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(21, 'Estudiante 5', 'M', 'estudiante5@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(22, 'Estudiante 6', 'F', 'estudiante6@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(23, 'Estudiante 7', 'M', 'estudiante7@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(24, 'Estudiante 8', 'F', 'estudiante8@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(25, 'Estudiante 9', 'M', 'estudiante9@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(26, 'Estudiante 10', 'F', 'estudiante10@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(27, 'Estudiante 11', 'M', 'estudiante11@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(28, 'Estudiante 12', 'F', 'estudiante12@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(29, 'Estudiante 13', 'M', 'estudiante13@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(30, 'Estudiante 14', 'F', 'estudiante14@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(31, 'Estudiante 15', 'M', 'estudiante15@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(32, 'Estudiante 16', 'F', 'estudiante16@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(33, 'Estudiante 17', 'M', 'estudiante17@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(34, 'Estudiante 18', 'F', 'estudiante18@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(35, 'Estudiante 19', 'M', 'estudiante19@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(36, 'Estudiante 20', 'F', 'estudiante20@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(37, 'Estudiante 21', 'M', 'estudiante21@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(38, 'Estudiante 22', 'F', 'estudiante22@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(39, 'Estudiante 23', 'M', 'estudiante23@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(40, 'Estudiante 24', 'F', 'estudiante24@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(41, 'Estudiante 25', 'M', 'estudiante25@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(42, 'Estudiante 26', 'F', 'estudiante26@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(43, 'Estudiante 27', 'M', 'estudiante27@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(44, 'Estudiante 28', 'F', 'estudiante28@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(45, 'Estudiante 29', 'M', 'estudiante29@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(46, 'Estudiante 30', 'F', 'estudiante30@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(47, 'Estudiante 31', 'M', 'estudiante31@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(48, 'Estudiante 32', 'F', 'estudiante32@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(49, 'Estudiante 33', 'M', 'estudiante33@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(50, 'Estudiante 34', 'F', 'estudiante34@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(51, 'Estudiante 35', 'M', 'estudiante35@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(52, 'Estudiante 36', 'F', 'estudiante36@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(53, 'Estudiante 37', 'M', 'estudiante37@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(54, 'Estudiante 38', 'F', 'estudiante38@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(55, 'Estudiante 39', 'M', 'estudiante39@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(56, 'Estudiante 40', 'F', 'estudiante40@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(57, 'Estudiante 41', 'M', 'estudiante41@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(58, 'Estudiante 42', 'F', 'estudiante42@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(59, 'Estudiante 43', 'M', 'estudiante43@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(60, 'Estudiante 44', 'F', 'estudiante44@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(61, 'Estudiante 45', 'M', 'estudiante45@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(62, 'Estudiante 46', 'F', 'estudiante46@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(63, 'Estudiante 47', 'M', 'estudiante47@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(64, 'Estudiante 48', 'F', 'estudiante48@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(65, 'Estudiante 49', 'M', 'estudiante49@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(66, 'Estudiante 50', 'F', 'estudiante50@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(67, 'Estudiante 51', 'M', 'estudiante51@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(68, 'Estudiante 52', 'F', 'estudiante52@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(69, 'Estudiante 53', 'M', 'estudiante53@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(70, 'Estudiante 54', 'F', 'estudiante54@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(71, 'Estudiante 55', 'M', 'estudiante55@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(72, 'Estudiante 56', 'F', 'estudiante56@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(73, 'Estudiante 57', 'M', 'estudiante57@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(74, 'Estudiante 58', 'F', 'estudiante58@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(75, 'Estudiante 59', 'M', 'estudiante59@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(76, 'Estudiante 60', 'F', 'estudiante60@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(77, 'Estudiante 61', 'M', 'estudiante61@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(78, 'Estudiante 62', 'F', 'estudiante62@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(79, 'Estudiante 63', 'M', 'estudiante63@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(80, 'Estudiante 64', 'F', 'estudiante64@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(81, 'Estudiante 65', 'M', 'estudiante65@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(82, 'Estudiante 66', 'F', 'estudiante66@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(83, 'Estudiante 67', 'M', 'estudiante67@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(84, 'Estudiante 68', 'F', 'estudiante68@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(85, 'Estudiante 69', 'M', 'estudiante69@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(86, 'Estudiante 70', 'F', 'estudiante70@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(87, 'Estudiante 71', 'M', 'estudiante71@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(88, 'Estudiante 72', 'F', 'estudiante72@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(89, 'Estudiante 73', 'M', 'estudiante73@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(90, 'Estudiante 74', 'F', 'estudiante74@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(91, 'Estudiante 75', 'M', 'estudiante75@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(92, 'Estudiante 76', 'F', 'estudiante76@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(93, 'Estudiante 77', 'M', 'estudiante77@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(94, 'Estudiante 78', 'F', 'estudiante78@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(95, 'Estudiante 79', 'M', 'estudiante79@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(96, 'Estudiante 80', 'F', 'estudiante80@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(97, 'Estudiante 81', 'M', 'estudiante81@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(98, 'Estudiante 82', 'F', 'estudiante82@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(99, 'Estudiante 83', 'M', 'estudiante83@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(100, 'Estudiante 84', 'F', 'estudiante84@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(101, 'Estudiante 85', 'M', 'estudiante85@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(102, 'Estudiante 86', 'F', 'estudiante86@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(103, 'Estudiante 87', 'M', 'estudiante87@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(104, 'Estudiante 88', 'F', 'estudiante88@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(105, 'Estudiante 89', 'M', 'estudiante89@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(106, 'Estudiante 90', 'F', 'estudiante90@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(107, 'Estudiante 91', 'M', 'estudiante91@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(108, 'Estudiante 92', 'F', 'estudiante92@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(109, 'Estudiante 93', 'M', 'estudiante93@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(110, 'Estudiante 94', 'F', 'estudiante94@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(111, 'Estudiante 95', 'M', 'estudiante95@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(112, 'Estudiante 96', 'F', 'estudiante96@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(113, 'Estudiante 97', 'M', 'estudiante97@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(114, 'Estudiante 98', 'F', 'estudiante98@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(115, 'Estudiante 99', 'M', 'estudiante99@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(116, 'Estudiante 100', 'F', 'estudiante100@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:01', '2026-02-09 03:11:01'),
(144, 'Acudiente 1', 'M', 'acudiente1@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(145, 'Acudiente 2', 'F', 'acudiente2@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(146, 'Acudiente 3', 'M', 'acudiente3@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(147, 'Acudiente 4', 'F', 'acudiente4@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(148, 'Acudiente 5', 'M', 'acudiente5@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(149, 'Acudiente 6', 'F', 'acudiente6@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(150, 'Acudiente 7', 'M', 'acudiente7@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(151, 'Acudiente 8', 'F', 'acudiente8@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(152, 'Acudiente 9', 'M', 'acudiente9@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(153, 'Acudiente 10', 'F', 'acudiente10@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(154, 'Acudiente 11', 'M', 'acudiente11@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(155, 'Acudiente 12', 'F', 'acudiente12@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(156, 'Acudiente 13', 'M', 'acudiente13@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(157, 'Acudiente 14', 'F', 'acudiente14@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(158, 'Acudiente 15', 'M', 'acudiente15@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(159, 'Acudiente 16', 'F', 'acudiente16@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(160, 'Acudiente 17', 'M', 'acudiente17@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(161, 'Acudiente 18', 'F', 'acudiente18@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(162, 'Acudiente 19', 'M', 'acudiente19@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(163, 'Acudiente 20', 'F', 'acudiente20@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(164, 'Acudiente 21', 'M', 'acudiente21@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(165, 'Acudiente 22', 'F', 'acudiente22@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(166, 'Acudiente 23', 'M', 'acudiente23@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(167, 'Acudiente 24', 'F', 'acudiente24@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(168, 'Acudiente 25', 'M', 'acudiente25@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(169, 'Acudiente 26', 'F', 'acudiente26@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(170, 'Acudiente 27', 'M', 'acudiente27@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(171, 'Acudiente 28', 'F', 'acudiente28@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(172, 'Acudiente 29', 'M', 'acudiente29@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(173, 'Acudiente 30', 'F', 'acudiente30@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(174, 'Acudiente 31', 'M', 'acudiente31@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(175, 'Acudiente 32', 'F', 'acudiente32@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(176, 'Acudiente 33', 'M', 'acudiente33@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(177, 'Acudiente 34', 'F', 'acudiente34@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(178, 'Acudiente 35', 'M', 'acudiente35@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(179, 'Acudiente 36', 'F', 'acudiente36@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(180, 'Acudiente 37', 'M', 'acudiente37@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(181, 'Acudiente 38', 'F', 'acudiente38@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(182, 'Acudiente 39', 'M', 'acudiente39@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(183, 'Acudiente 40', 'F', 'acudiente40@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(184, 'Acudiente 41', 'M', 'acudiente41@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(185, 'Acudiente 42', 'F', 'acudiente42@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(186, 'Acudiente 43', 'M', 'acudiente43@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(187, 'Acudiente 44', 'F', 'acudiente44@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(188, 'Acudiente 45', 'M', 'acudiente45@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(189, 'Acudiente 46', 'F', 'acudiente46@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(190, 'Acudiente 47', 'M', 'acudiente47@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(191, 'Acudiente 48', 'F', 'acudiente48@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(192, 'Acudiente 49', 'M', 'acudiente49@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(193, 'Acudiente 50', 'F', 'acudiente50@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(194, 'Acudiente 51', 'M', 'acudiente51@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(195, 'Acudiente 52', 'F', 'acudiente52@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(196, 'Acudiente 53', 'M', 'acudiente53@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(197, 'Acudiente 54', 'F', 'acudiente54@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(198, 'Acudiente 55', 'M', 'acudiente55@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(199, 'Acudiente 56', 'F', 'acudiente56@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(200, 'Super Admin', 'M', 'superadmin@sistema.com', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 08:22:56'),
(201, 'Acudiente 58', 'F', 'acudiente58@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(202, 'Acudiente 59', 'M', 'acudiente59@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(203, 'Acudiente 60', 'F', 'acudiente60@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(204, 'Acudiente 61', 'M', 'acudiente61@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(205, 'Acudiente 62', 'F', 'acudiente62@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(206, 'Acudiente 63', 'M', 'acudiente63@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(207, 'Acudiente 64', 'F', 'acudiente64@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(208, 'Acudiente 65', 'M', 'acudiente65@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(209, 'Acudiente 66', 'F', 'acudiente66@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(210, 'Acudiente 67', 'M', 'acudiente67@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(211, 'Acudiente 68', 'F', 'acudiente68@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(212, 'Acudiente 69', 'M', 'acudiente69@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(213, 'Acudiente 70', 'F', 'acudiente70@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(214, 'Acudiente 71', 'M', 'acudiente71@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(215, 'Acudiente 72', 'F', 'acudiente72@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(216, 'Acudiente 73', 'M', 'acudiente73@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(217, 'Acudiente 74', 'F', 'acudiente74@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(218, 'Acudiente 75', 'M', 'acudiente75@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(219, 'Acudiente 76', 'F', 'acudiente76@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(220, 'Acudiente 77', 'M', 'acudiente77@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(221, 'Acudiente 78', 'F', 'acudiente78@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(222, 'Acudiente 79', 'M', 'acudiente79@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(223, 'Acudiente 80', 'F', 'acudiente80@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(224, 'Acudiente 81', 'M', 'acudiente81@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(225, 'Acudiente 82', 'F', 'acudiente82@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(226, 'Acudiente 83', 'M', 'acudiente83@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(227, 'Acudiente 84', 'F', 'acudiente84@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(228, 'Acudiente 85', 'M', 'acudiente85@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(229, 'Acudiente 86', 'F', 'acudiente86@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(230, 'Acudiente 87', 'M', 'acudiente87@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(231, 'Acudiente 88', 'F', 'acudiente88@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(232, 'Acudiente 89', 'M', 'acudiente89@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(233, 'Acudiente 90', 'F', 'acudiente90@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(234, 'Acudiente 91', 'M', 'acudiente91@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(235, 'Acudiente 92', 'F', 'acudiente92@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(236, 'Acudiente 93', 'M', 'acudiente93@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(237, 'Acudiente 94', 'F', 'acudiente94@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(238, 'Acudiente 95', 'M', 'acudiente95@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(239, 'Acudiente 96', 'F', 'acudiente96@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(240, 'Acudiente 97', 'M', 'acudiente97@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(241, 'Acudiente 98', 'F', 'acudiente98@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(242, 'Acudiente 99', 'M', 'acudiente99@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29'),
(243, 'Acudiente 100', 'F', 'acudiente100@ieta.edu.co', NULL, '$2y$12$5PCrhXT5.xW9qy08r0mYzOisNJMXglMnZ1trKYBB1ploH5fq1P1s.', NULL, '2026-02-09 03:11:29', '2026-02-09 03:11:29');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acudientes`
--
ALTER TABLE `acudientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acudientes_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `anho_escolar`
--
ALTER TABLE `anho_escolar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignaturas_sede_id_foreign` (`sede_id`),
  ADD KEY `asignaturas_hilo_id_foreign` (`hilo_id`),
  ADD KEY `asignaturas_docente_id_foreign` (`docente_id`);

--
-- Indices de la tabla `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docentes_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiantes_user_id_foreign` (`user_id`),
  ADD KEY `estudiantes_acudiente_id_foreign` (`acudiente_id`),
  ADD KEY `estudiantes_grado_academico_id_foreign` (`grado_academico_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `grado_academicos`
--
ALTER TABLE `grado_academicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grado_academicos_sede_id_foreign` (`sede_id`),
  ADD KEY `grado_academicos_docente_id_foreign` (`docente_id`),
  ADD KEY `grado_academicos_curso_id_foreign` (`curso_id`),
  ADD KEY `grado_academicos_asignatura_id_foreign` (`asignatura_id`);

--
-- Indices de la tabla `hilos`
--
ALTER TABLE `hilos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `institucions`
--
ALTER TABLE `institucions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institucions_rector_id_foreign` (`rector_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `matriculados`
--
ALTER TABLE `matriculados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matriculados_grado_id_foreign` (`grado_id`),
  ADD KEY `matriculados_estudiante_id_foreign` (`estudiante_id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_rol_id_foreign` (`rol_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notas_periodo_academico_id_foreign` (`periodo_academico_id`),
  ADD KEY `notas_grado_id_foreign` (`grado_id`),
  ADD KEY `notas_estudiante_id_foreign` (`estudiante_id`),
  ADD KEY `notas_asignatura_id_foreign` (`asignatura_id`);

--
-- Indices de la tabla `notas_definitivas`
--
ALTER TABLE `notas_definitivas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `numeros`
--
ALTER TABLE `numeros`
  ADD PRIMARY KEY (`n`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `periodo_academicos`
--
ALTER TABLE `periodo_academicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periodo_academicos_año_escolar_id_foreign` (`año_escolar_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol_user`
--
ALTER TABLE `rol_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol_user_rol_id_foreign` (`rol_id`),
  ADD KEY `rol_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sedes_institucion_id_foreign` (`institucion_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acudientes`
--
ALTER TABLE `acudientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT de la tabla `anho_escolar`
--
ALTER TABLE `anho_escolar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grado_academicos`
--
ALTER TABLE `grado_academicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `hilos`
--
ALTER TABLE `hilos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `institucions`
--
ALTER TABLE `institucions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `matriculados`
--
ALTER TABLE `matriculados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notas_definitivas`
--
ALTER TABLE `notas_definitivas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodo_academicos`
--
ALTER TABLE `periodo_academicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rol_user`
--
ALTER TABLE `rol_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acudientes`
--
ALTER TABLE `acudientes`
  ADD CONSTRAINT `acudientes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `asignaturas_docente_id_foreign` FOREIGN KEY (`docente_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaturas_hilo_id_foreign` FOREIGN KEY (`hilo_id`) REFERENCES `hilos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaturas_sede_id_foreign` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_acudiente_id_foreign` FOREIGN KEY (`acudiente_id`) REFERENCES `acudientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estudiantes_grado_academico_id_foreign` FOREIGN KEY (`grado_academico_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `estudiantes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `grado_academicos`
--
ALTER TABLE `grado_academicos`
  ADD CONSTRAINT `grado_academicos_asignatura_id_foreign` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `grado_academicos_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `grado_academicos_docente_id_foreign` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grado_academicos_sede_id_foreign` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `institucions`
--
ALTER TABLE `institucions`
  ADD CONSTRAINT `institucions_rector_id_foreign` FOREIGN KEY (`rector_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matriculados`
--
ALTER TABLE `matriculados`
  ADD CONSTRAINT `matriculados_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriculados_grado_id_foreign` FOREIGN KEY (`grado_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_asignatura_id_foreign` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notas_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notas_grado_id_foreign` FOREIGN KEY (`grado_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notas_periodo_academico_id_foreign` FOREIGN KEY (`periodo_academico_id`) REFERENCES `periodo_academicos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `periodo_academicos`
--
ALTER TABLE `periodo_academicos`
  ADD CONSTRAINT `periodo_academicos_año_escolar_id_foreign` FOREIGN KEY (`año_escolar_id`) REFERENCES `anho_escolar` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rol_user`
--
ALTER TABLE `rol_user`
  ADD CONSTRAINT `rol_user_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rol_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD CONSTRAINT `sedes_institucion_id_foreign` FOREIGN KEY (`institucion_id`) REFERENCES `institucions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
