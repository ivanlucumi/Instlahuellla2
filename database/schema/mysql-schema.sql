/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `acudientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acudientes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `id_documento` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular_acudiente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion_acudiente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero_acudiente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parentesco_acudiente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_acudiente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acudientes_user_id_foreign` (`user_id`),
  CONSTRAINT `acudientes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `anho_escolar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anho_escolar` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_anho_escolar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio_anho_escolar` date NOT NULL,
  `fecha_fin_anho_escolar` date NOT NULL,
  `estado_anho_escolar` tinyint(1) NOT NULL DEFAULT '1',
  `descripcion_anho_escolar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `asignatura_grado_docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignatura_grado_docente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `asignatura_id` bigint unsigned NOT NULL,
  `grado_academico_id` bigint unsigned NOT NULL,
  `docente_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asignatura_grado_docente_asignatura_id_foreign` (`asignatura_id`),
  KEY `asignatura_grado_docente_grado_academico_id_foreign` (`grado_academico_id`),
  KEY `asignatura_grado_docente_docente_id_foreign` (`docente_id`),
  CONSTRAINT `asignatura_grado_docente_asignatura_id_foreign` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asignatura_grado_docente_docente_id_foreign` FOREIGN KEY (`docente_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `asignatura_grado_docente_grado_academico_id_foreign` FOREIGN KEY (`grado_academico_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `asignaturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignaturas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_asignatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel_educativo` enum('primaria','secundaria') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'primaria',
  `hilo_id` bigint unsigned NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asignaturas_hilo_id_foreign` (`hilo_id`),
  CONSTRAINT `asignaturas_hilo_id_foreign` FOREIGN KEY (`hilo_id`) REFERENCES `hilos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint unsigned NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `calificaciones_grado_cero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificaciones_grado_cero` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `estudiante_id` bigint unsigned NOT NULL,
  `criterio_id` bigint unsigned NOT NULL,
  `grado_academico_id` bigint unsigned NOT NULL,
  `periodo_id` bigint unsigned NOT NULL,
  `anho_escolar_id` bigint unsigned NOT NULL,
  `valor` enum('SIEMPRE','ALGUNAS_VECES','NUNCA') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calificaciones_grado_cero_estudiante_id_foreign` (`estudiante_id`),
  KEY `calificaciones_grado_cero_criterio_id_foreign` (`criterio_id`),
  KEY `calificaciones_grado_cero_grado_academico_id_foreign` (`grado_academico_id`),
  KEY `calificaciones_grado_cero_periodo_id_foreign` (`periodo_id`),
  KEY `calificaciones_grado_cero_anho_escolar_id_foreign` (`anho_escolar_id`),
  CONSTRAINT `calificaciones_grado_cero_anho_escolar_id_foreign` FOREIGN KEY (`anho_escolar_id`) REFERENCES `anho_escolar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calificaciones_grado_cero_criterio_id_foreign` FOREIGN KEY (`criterio_id`) REFERENCES `criterios_grado_cero` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calificaciones_grado_cero_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calificaciones_grado_cero_grado_academico_id_foreign` FOREIGN KEY (`grado_academico_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calificaciones_grado_cero_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `periodo_academicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `criterios_grado_cero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `criterios_grado_cero` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `asignatura_id` bigint unsigned NOT NULL,
  `nombre_criterio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `criterios_grado_cero_asignatura_id_foreign` (`asignatura_id`),
  CONSTRAINT `criterios_grado_cero_asignatura_id_foreign` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cursos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_curso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `docentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docentes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `codigo_docente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genero_docente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_docente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_docente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `docentes_user_id_foreign` (`user_id`),
  CONSTRAINT `docentes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `estudiantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiantes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `codigo_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nacimiento_estudiante` date DEFAULT NULL,
  `genero_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anho_curso_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_identificacion_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_identificacion_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_estudiante` tinyint(1) NOT NULL DEFAULT '1',
  `acudiente_id` bigint unsigned DEFAULT NULL,
  `grado_academico_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `estudiantes_user_id_foreign` (`user_id`),
  KEY `estudiantes_acudiente_id_foreign` (`acudiente_id`),
  KEY `estudiantes_grado_academico_id_foreign` (`grado_academico_id`),
  CONSTRAINT `estudiantes_acudiente_id_foreign` FOREIGN KEY (`acudiente_id`) REFERENCES `acudientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `estudiantes_grado_academico_id_foreign` FOREIGN KEY (`grado_academico_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `estudiantes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `grado_academicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grado_academicos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_grado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bloque` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sede_id` bigint unsigned DEFAULT NULL,
  `curso_id` bigint unsigned DEFAULT NULL,
  `asignatura_id` bigint unsigned DEFAULT NULL,
  `estado_grado_academico` tinyint(1) NOT NULL DEFAULT '1',
  `docente_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grado_academicos_sede_id_foreign` (`sede_id`),
  KEY `grado_academicos_docente_id_foreign` (`docente_id`),
  CONSTRAINT `grado_academicos_docente_id_foreign` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grado_academicos_sede_id_foreign` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `hilos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hilos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_hilo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `institucions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `institucions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_institucion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_institucion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_dane` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad_institucion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departamento_institucion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resolucion_institucion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rector_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jerarquia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'CALOTO',
  `calendario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'A',
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'OFICIAL',
  `modelo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'ETNOEDUCACIÓN',
  `jornada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'MAÑANA',
  PRIMARY KEY (`id`),
  KEY `institucions_rector_id_foreign` (`rector_id`),
  CONSTRAINT `institucions_rector_id_foreign` FOREIGN KEY (`rector_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `matricula_finals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matricula_finals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `documento_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_sede` bigint unsigned NOT NULL,
  `id_grado` bigint unsigned NOT NULL,
  `curso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ano_lectivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_profesor` bigint unsigned NOT NULL,
  `documento_acudiente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parentezco_acudiente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matricula_finals_id_sede_foreign` (`id_sede`),
  KEY `matricula_finals_id_grado_foreign` (`id_grado`),
  KEY `id_profesor` (`id_profesor`),
  CONSTRAINT `matricula_finals_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `docentes` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `matricula_finals_id_grado_foreign` FOREIGN KEY (`id_grado`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matricula_finals_id_sede_foreign` FOREIGN KEY (`id_sede`) REFERENCES `sedes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_submenu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('sencillo','dropdown') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sencillo',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `rol_id` bigint unsigned NOT NULL,
  `orden` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_rol_id_foreign` (`rol_id`),
  CONSTRAINT `menu_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `matriculado_id` bigint unsigned NOT NULL,
  `periodo_academico_id` bigint unsigned NOT NULL,
  `grado_id` bigint unsigned NOT NULL,
  `estudiante_id` bigint unsigned NOT NULL,
  `nota` decimal(5,2) DEFAULT NULL,
  `observaciones` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asignatura_id` bigint unsigned NOT NULL,
  `nota1` decimal(5,2) DEFAULT NULL,
  `nota2` decimal(5,2) DEFAULT NULL,
  `nota3` decimal(5,2) DEFAULT NULL,
  `nota4` decimal(5,2) DEFAULT NULL,
  `nota_definitiva` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notas_periodo_academico_id_foreign` (`periodo_academico_id`),
  KEY `notas_grado_id_foreign` (`grado_id`),
  KEY `notas_estudiante_id_foreign` (`estudiante_id`),
  KEY `notas_asignatura_id_foreign` (`asignatura_id`),
  KEY `notas_matriculado_id_foreign` (`matriculado_id`),
  CONSTRAINT `notas_asignatura_id_foreign` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notas_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notas_grado_id_foreign` FOREIGN KEY (`grado_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notas_matriculado_id_foreign` FOREIGN KEY (`matriculado_id`) REFERENCES `matriculados` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notas_periodo_academico_id_foreign` FOREIGN KEY (`periodo_academico_id`) REFERENCES `periodo_academicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notas_definitivas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas_definitivas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_matricula` bigint unsigned DEFAULT NULL,
  `documento_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grado_aprobado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota_per1` decimal(5,2) NOT NULL,
  `nota_per2` decimal(5,2) NOT NULL,
  `nota_per3` decimal(5,2) NOT NULL,
  `nota_per4` decimal(5,2) NOT NULL,
  `nota_definitiva` decimal(5,2) NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `nombre_asignatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asignatura_id` bigint unsigned DEFAULT NULL,
  `curso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_matricula` (`id_matricula`),
  KEY `notas_definitivas_asignatura_id_foreign` (`asignatura_id`),
  CONSTRAINT `notas_definitivas_asignatura_id_foreign` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `notas_definitivas_ibfk_1` FOREIGN KEY (`id_matricula`) REFERENCES `matricula_finals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `observaciones_grado_cero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `observaciones_grado_cero` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `estudiante_id` bigint unsigned NOT NULL,
  `grado_academico_id` bigint unsigned NOT NULL,
  `periodo_id` bigint unsigned NOT NULL,
  `anho_escolar_id` bigint unsigned NOT NULL,
  `observacion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `observaciones_grado_cero_estudiante_id_foreign` (`estudiante_id`),
  KEY `observaciones_grado_cero_grado_academico_id_foreign` (`grado_academico_id`),
  KEY `observaciones_grado_cero_periodo_id_foreign` (`periodo_id`),
  KEY `observaciones_grado_cero_anho_escolar_id_foreign` (`anho_escolar_id`),
  CONSTRAINT `observaciones_grado_cero_anho_escolar_id_foreign` FOREIGN KEY (`anho_escolar_id`) REFERENCES `anho_escolar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `observaciones_grado_cero_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `observaciones_grado_cero_grado_academico_id_foreign` FOREIGN KEY (`grado_academico_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `observaciones_grado_cero_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `periodo_academicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `periodo_academicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periodo_academicos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `año_escolar_id` bigint unsigned NOT NULL,
  `nombre_periodo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `porcentaje_periodo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `periodo_academicos_año_escolar_id_foreign` (`año_escolar_id`),
  CONSTRAINT `periodo_academicos_año_escolar_id_foreign` FOREIGN KEY (`año_escolar_id`) REFERENCES `anho_escolar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rol_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rol_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rol_user_rol_id_foreign` (`rol_id`),
  KEY `rol_user_user_id_foreign` (`user_id`),
  CONSTRAINT `rol_user_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rol_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sedes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sedes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_sede` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_sede` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_dane_sede` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resolucion_sede` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institucion_id` bigint unsigned NOT NULL,
  `estado_sede` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `zona_sede` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'RURAL',
  `jornada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'MAÑANA',
  PRIMARY KEY (`id`),
  KEY `sedes_institucion_id_foreign` (`institucion_id`),
  CONSTRAINT `sedes_institucion_id_foreign` FOREIGN KEY (`institucion_id`) REFERENCES `institucions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2026_01_26_182618_create_rols_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2026_01_26_183027_create_rol_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2026_01_26_183657_create_menus_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2026_01_27_001134_create_institucions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2026_01_27_001145_create_sedes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2026_01_27_004224_create_docentes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2026_01_27_004230_create_cursos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2026_01_27_004231_create_hilos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2026_01_27_004238_create_asignaturas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2026_01_27_005449_create_grado_academicos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2026_01_27_005450_create_acudientes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2026_01_27_005840_create_estudiantes_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2026_01_27_010927_create_anho_escolars_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2026_01_29_231122_create_periodo_academicos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2026_01_29_231133_create_notas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2026_01_29_231152_create_matriculados_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2026_01_29_231208_create_notas_definitivas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2026_02_01_222653_update_grado_academicos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2026_02_03_005402_create_audits_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2026_02_03_011420_add_audit_menu_item',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2026_02_08_221923_add_nivel_educativo_to_asignaturas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2026_02_08_234721_add_certificado_menu_item',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2026_02_13_040916_create_matricula_finals_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2026_02_13_041551_update_notas_table_structure',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2026_02_13_050052_add_grado_id_to_asignaturas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2026_02_14_020315_remove_asignatura_id_from_grado_academicos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2026_02_14_020323_remove_asignatura_id_from_grado_academicos_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2026_02_14_021240_create_asignatura_grado_docente_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2026_02_14_021256_make_grado_academicos_fields_nullable',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2026_02_14_021328_drop_grado_id_from_asignaturas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2026_02_14_024931_enhance_academic_structure_v2',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2026_02_14_024935_add_periodos_to_grado_academicos',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2026_02_14_131710_update_asignaturas_table_remove_columns',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2026_02_14_205034_remove_curso_id_and_periodos_from_grado_academicos_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2026_02_15_015044_remove_curso_id_and_periodos_from_grado_academicos_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2026_03_08_032510_enforce_notas_table_constraints',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2026_03_08_231718_add_asignatura_id_to_notas_definitivas_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2026_03_19_011029_make_profile_fields_nullable',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2026_02_08_223057_add_fields_to_matriculados_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2026_03_19_025538_add_missing_fields_to_institucion_and_sede_tables',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2026_03_21_000001_create_criterios_grado_cero_table',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2026_03_21_000002_create_calificaciones_grado_cero_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2026_03_21_000003_create_observaciones_grado_cero_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2026_03_23_223453_add_observaciones_to_notas_definitivas',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2026_03_29_203713_add_secretario_role',12);
