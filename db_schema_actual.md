### Table: acudientes
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=534 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| user_id | bigint unsigned | NO | MUL | NULL |  |
| id_documento | varchar(15) | YES |  | NULL |  |
| celular_acudiente | varchar(255) | NO |  | NULL |  |
| direccion_acudiente | varchar(255) | NO |  | NULL |  |
| genero_acudiente | varchar(255) | NO |  | NULL |  |
| parentesco_acudiente | varchar(255) | NO |  | NULL |  |
| estado_acudiente | varchar(255) | NO |  | 1 |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: anho_escolar
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre_anho_escolar | varchar(255) | NO |  | NULL |  |
| fecha_inicio_anho_escolar | date | NO |  | NULL |  |
| fecha_fin_anho_escolar | date | NO |  | NULL |  |
| estado_anho_escolar | tinyint(1) | NO |  | 1 |  |
| descripcion_anho_escolar | text | NO |  | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: asignatura_grado_docente
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| asignatura_id | bigint unsigned | NO | MUL | NULL |  |
| grado_academico_id | bigint unsigned | NO | MUL | NULL |  |
| docente_id | bigint unsigned | YES | MUL | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: asignaturas
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre_asignatura | varchar(255) | NO |  | NULL |  |
| nivel_educativo | enum('primaria','secundaria') | NO |  | primaria |  |
| hilo_id | bigint unsigned | NO | MUL | NULL |  |
| estado | enum('activo','inactivo') | NO |  | activo |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: audits
```sql
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| user_id | bigint unsigned | YES |  | NULL |  |
| event | varchar(255) | NO |  | NULL |  |
| auditable_type | varchar(255) | NO |  | NULL |  |
| auditable_id | bigint unsigned | NO |  | NULL |  |
| old_values | text | YES |  | NULL |  |
| new_values | text | YES |  | NULL |  |
| url | varchar(255) | YES |  | NULL |  |
| ip_address | varchar(45) | YES |  | NULL |  |
| user_agent | varchar(255) | YES |  | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: cache
```sql
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| key | varchar(255) | NO | PRI | NULL |  |
| value | mediumtext | NO |  | NULL |  |
| expiration | int | NO | MUL | NULL |  |


### Table: cache_locks
```sql
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| key | varchar(255) | NO | PRI | NULL |  |
| owner | varchar(255) | NO |  | NULL |  |
| expiration | int | NO | MUL | NULL |  |


### Table: cursos
```sql
CREATE TABLE `cursos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_curso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre_curso | varchar(255) | NO |  | NULL |  |
| descripcion | varchar(255) | NO |  | NULL |  |
| estado | enum('activo','inactivo') | NO |  | activo |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: docentes
```sql
CREATE TABLE `docentes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `codigo_docente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genero_docente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_docente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_docente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `docentes_user_id_foreign` (`user_id`),
  CONSTRAINT `docentes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| user_id | bigint unsigned | NO | MUL | NULL |  |
| codigo_docente | varchar(255) | NO |  | NULL |  |
| genero_docente | varchar(255) | NO |  | NULL |  |
| foto_docente | varchar(255) | NO |  | NULL |  |
| estado_docente | varchar(255) | NO |  | 1 |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: estudiantes
```sql
CREATE TABLE `estudiantes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `codigo_estudiante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nacimiento_estudiante` date NOT NULL,
  `genero_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_estudiante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anho_curso_estudiante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_identificacion_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_identificacion_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4751 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| user_id | bigint unsigned | NO | MUL | NULL |  |
| codigo_estudiante | varchar(255) | YES |  | NULL |  |
| fecha_nacimiento_estudiante | date | NO |  | NULL |  |
| genero_estudiante | varchar(255) | NO |  | NULL |  |
| foto_estudiante | varchar(255) | YES |  | NULL |  |
| anho_curso_estudiante | varchar(255) | YES |  | NULL |  |
| direccion_estudiante | varchar(255) | NO |  | NULL |  |
| telefono_estudiante | varchar(255) | NO |  | NULL |  |
| email_estudiante | varchar(255) | NO |  | NULL |  |
| tipo_identificacion_estudiante | varchar(255) | NO |  | NULL |  |
| numero_identificacion_estudiante | varchar(255) | NO |  | NULL |  |
| estado_estudiante | tinyint(1) | NO |  | 1 |  |
| acudiente_id | bigint unsigned | YES | MUL | NULL |  |
| grado_academico_id | bigint unsigned | YES | MUL | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: failed_jobs
```sql
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| uuid | varchar(255) | NO | UNI | NULL |  |
| connection | text | NO |  | NULL |  |
| queue | text | NO |  | NULL |  |
| payload | longtext | NO |  | NULL |  |
| exception | longtext | NO |  | NULL |  |
| failed_at | timestamp | NO |  | CURRENT_TIMESTAMP | DEFAULT_GENERATED |


### Table: grado_academicos
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre_grado | varchar(255) | NO |  | NULL |  |
| bloque | varchar(255) | YES |  | NULL |  |
| sede_id | bigint unsigned | YES | MUL | NULL |  |
| curso_id | bigint unsigned | YES |  | NULL |  |
| asignatura_id | bigint unsigned | YES |  | NULL |  |
| estado_grado_academico | tinyint(1) | NO |  | 1 |  |
| docente_id | bigint unsigned | YES | MUL | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: hilos
```sql
CREATE TABLE `hilos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_hilo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre_hilo | varchar(255) | NO |  | NULL |  |
| abreviatura | varchar(255) | NO |  | NULL |  |
| estado | enum('activo','inactivo') | NO |  | activo |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: institucions
```sql
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
  PRIMARY KEY (`id`),
  KEY `institucions_rector_id_foreign` (`rector_id`),
  CONSTRAINT `institucions_rector_id_foreign` FOREIGN KEY (`rector_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre_institucion | varchar(255) | NO |  | NULL |  |
| descripcion_institucion | varchar(255) | NO |  | NULL |  |
| codigo_dane | varchar(255) | NO |  | NULL |  |
| ciudad_institucion | varchar(255) | NO |  | NULL |  |
| departamento_institucion | varchar(255) | NO |  | NULL |  |
| resolucion_institucion | varchar(255) | NO |  | NULL |  |
| rector_id | bigint unsigned | NO | MUL | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: job_batches
```sql
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | varchar(255) | NO | PRI | NULL |  |
| name | varchar(255) | NO |  | NULL |  |
| total_jobs | int | NO |  | NULL |  |
| pending_jobs | int | NO |  | NULL |  |
| failed_jobs | int | NO |  | NULL |  |
| failed_job_ids | longtext | NO |  | NULL |  |
| options | mediumtext | YES |  | NULL |  |
| cancelled_at | int | YES |  | NULL |  |
| created_at | int | NO |  | NULL |  |
| finished_at | int | YES |  | NULL |  |


### Table: jobs
```sql
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| queue | varchar(255) | NO | MUL | NULL |  |
| payload | longtext | NO |  | NULL |  |
| attempts | tinyint unsigned | NO |  | NULL |  |
| reserved_at | int unsigned | YES |  | NULL |  |
| available_at | int unsigned | NO |  | NULL |  |
| created_at | int unsigned | NO |  | NULL |  |


### Table: matricula_finals
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=7541 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| documento_estudiante | varchar(255) | NO |  | NULL |  |
| id_sede | bigint unsigned | NO | MUL | NULL |  |
| id_grado | bigint unsigned | NO | MUL | NULL |  |
| curso | varchar(255) | NO |  | NULL |  |
| ano_lectivo | varchar(255) | NO |  | NULL |  |
| fecha | date | NO |  | NULL |  |
| estado | varchar(255) | NO |  | NULL |  |
| id_profesor | bigint unsigned | NO | MUL | NULL |  |
| documento_acudiente | varchar(255) | NO |  | NULL |  |
| parentezco_acudiente | varchar(255) | NO |  | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: matriculados
```sql
CREATE TABLE `matriculados` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `grado_id` bigint unsigned NOT NULL,
  `anho_escolar_id` bigint unsigned NOT NULL,
  `estado` enum('activo','inactivo','retirado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `fecha_matricula` date NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `estudiante_id` bigint unsigned NOT NULL,
  `asignatura_id` bigint unsigned NOT NULL,
  `acudiente_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_matricula` (`estudiante_id`,`asignatura_id`,`anho_escolar_id`),
  KEY `matriculados_grado_id_foreign` (`grado_id`),
  KEY `matriculados_asignatura_id_foreign` (`asignatura_id`),
  KEY `matriculados_acudiente_id_foreign` (`acudiente_id`),
  KEY `matriculados_anho_escolar_id_foreign` (`anho_escolar_id`),
  CONSTRAINT `matriculados_acudiente_id_foreign` FOREIGN KEY (`acudiente_id`) REFERENCES `acudientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matriculados_anho_escolar_id_foreign` FOREIGN KEY (`anho_escolar_id`) REFERENCES `anho_escolar` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matriculados_asignatura_id_foreign` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matriculados_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `matriculados_grado_id_foreign` FOREIGN KEY (`grado_id`) REFERENCES `grado_academicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| grado_id | bigint unsigned | NO | MUL | NULL |  |
| anho_escolar_id | bigint unsigned | NO | MUL | NULL |  |
| estado | enum('activo','inactivo','retirado') | NO |  | activo |  |
| fecha_matricula | date | NO |  | NULL |  |
| observaciones | text | YES |  | NULL |  |
| estudiante_id | bigint unsigned | NO | MUL | NULL |  |
| asignatura_id | bigint unsigned | NO | MUL | NULL |  |
| acudiente_id | bigint unsigned | NO | MUL | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: matriculafinal
```sql
CREATE TABLE `matriculafinal` (
  `id_matricula` int NOT NULL AUTO_INCREMENT,
  `id_documento` bigint unsigned NOT NULL,
  `id_sede` bigint unsigned NOT NULL,
  `id_grado` bigint unsigned NOT NULL,
  `curso` int NOT NULL,
  `ano_lectivo` int NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_profesor` bigint unsigned NOT NULL,
  `documento` bigint unsigned NOT NULL,
  `parentesco` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_matricula`),
  KEY `FK_matriculafinal_estudiantes` (`id_documento`),
  CONSTRAINT `FK_matriculafinal_estudiantes` FOREIGN KEY (`id_documento`) REFERENCES `estudiantes` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7541 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id_matricula | int | NO | PRI | NULL | auto_increment |
| id_documento | bigint unsigned | NO | MUL | NULL |  |
| id_sede | bigint unsigned | NO |  | NULL |  |
| id_grado | bigint unsigned | NO |  | NULL |  |
| curso | int | NO |  | NULL |  |
| ano_lectivo | int | NO |  | NULL |  |
| fecha | date | NO |  | NULL |  |
| estado | varchar(20) | NO |  | NULL |  |
| id_profesor | bigint unsigned | NO |  | NULL |  |
| documento | bigint unsigned | NO |  | NULL |  |
| parentesco | varchar(20) | NO |  | NULL |  |


### Table: menu
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre | varchar(255) | NO |  | NULL |  |
| nombre_submenu | varchar(255) | YES |  | NULL |  |
| icono | varchar(255) | YES |  | NULL |  |
| url | varchar(255) | YES |  | NULL |  |
| tipo | enum('sencillo','dropdown') | NO |  | sencillo |  |
| estado | tinyint(1) | NO |  | 1 |  |
| rol_id | bigint unsigned | NO | MUL | NULL |  |
| orden | varchar(255) | NO |  | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: migrations
```sql
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | int unsigned | NO | PRI | NULL | auto_increment |
| migration | varchar(255) | NO |  | NULL |  |
| batch | int | NO |  | NULL |  |


### Table: notas
```sql
CREATE TABLE `notas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `matriculado_id` bigint unsigned DEFAULT NULL,
  `periodo_academico_id` bigint unsigned DEFAULT NULL,
  `grado_id` bigint unsigned DEFAULT NULL,
  `estudiante_id` bigint unsigned DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| matriculado_id | bigint unsigned | YES | MUL | NULL |  |
| periodo_academico_id | bigint unsigned | YES | MUL | NULL |  |
| grado_id | bigint unsigned | YES | MUL | NULL |  |
| estudiante_id | bigint unsigned | YES | MUL | NULL |  |
| nota | decimal(5,2) | YES |  | NULL |  |
| observaciones | varchar(255) | NO |  | NULL |  |
| asignatura_id | bigint unsigned | NO | MUL | NULL |  |
| nota1 | decimal(5,2) | YES |  | NULL |  |
| nota2 | decimal(5,2) | YES |  | NULL |  |
| nota3 | decimal(5,2) | YES |  | NULL |  |
| nota4 | decimal(5,2) | YES |  | NULL |  |
| nota_definitiva | decimal(5,2) | YES |  | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: notas_definitivas
```sql
CREATE TABLE `notas_definitivas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `documento_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_estudiante` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grado_aprobado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota_per1` decimal(5,2) NOT NULL,
  `nota_per2` decimal(5,2) NOT NULL,
  `nota_per3` decimal(5,2) NOT NULL,
  `nota_per4` decimal(5,2) NOT NULL,
  `nota_definitiva` decimal(5,2) NOT NULL,
  `nombre_asignatura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `curso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| documento_estudiante | varchar(255) | NO |  | NULL |  |
| nombre_estudiante | varchar(255) | NO |  | NULL |  |
| grado_aprobado | varchar(255) | NO |  | NULL |  |
| nota_per1 | decimal(5,2) | NO |  | NULL |  |
| nota_per2 | decimal(5,2) | NO |  | NULL |  |
| nota_per3 | decimal(5,2) | NO |  | NULL |  |
| nota_per4 | decimal(5,2) | NO |  | NULL |  |
| nota_definitiva | decimal(5,2) | NO |  | NULL |  |
| nombre_asignatura | varchar(255) | NO |  | NULL |  |
| curso | varchar(255) | NO |  | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: password_reset_tokens
```sql
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| email | varchar(255) | NO | PRI | NULL |  |
| token | varchar(255) | NO |  | NULL |  |
| created_at | timestamp | YES |  | NULL |  |


### Table: periodo_academicos
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| año_escolar_id | bigint unsigned | NO | MUL | NULL |  |
| nombre_periodo | varchar(255) | NO |  | NULL |  |
| fecha_inicio | date | NO |  | NULL |  |
| fecha_fin | date | NO |  | NULL |  |
| porcentaje_periodo | varchar(255) | NO |  | NULL |  |
| estado | enum('activo','inactivo') | NO |  | activo |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: rol
```sql
CREATE TABLE `rol` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre | varchar(255) | NO |  | NULL |  |
| descripcion | varchar(255) | NO |  | NULL |  |
| estado | tinyint(1) | NO |  | 1 |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: rol_user
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=1451 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| rol_id | bigint unsigned | NO | MUL | NULL |  |
| user_id | bigint unsigned | NO | MUL | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: sedes
```sql
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
  PRIMARY KEY (`id`),
  KEY `sedes_institucion_id_foreign` (`institucion_id`),
  CONSTRAINT `sedes_institucion_id_foreign` FOREIGN KEY (`institucion_id`) REFERENCES `institucions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| nombre_sede | varchar(255) | NO |  | NULL |  |
| descripcion_sede | varchar(255) | NO |  | NULL |  |
| codigo_dane_sede | varchar(255) | NO |  | NULL |  |
| resolucion_sede | varchar(255) | NO |  | NULL |  |
| institucion_id | bigint unsigned | NO | MUL | NULL |  |
| estado_sede | tinyint(1) | NO |  | 1 |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


### Table: sessions
```sql
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | varchar(255) | NO | PRI | NULL |  |
| user_id | bigint unsigned | YES | MUL | NULL |  |
| ip_address | varchar(45) | YES |  | NULL |  |
| user_agent | text | YES |  | NULL |  |
| payload | longtext | NO |  | NULL |  |
| last_activity | int | NO | MUL | NULL |  |


### Table: users
```sql
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
) ENGINE=InnoDB AUTO_INCREMENT=1921 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

| Field | Type | Null | Key | Default | Extra |
|-------|------|------|-----|---------|-------|
| id | bigint unsigned | NO | PRI | NULL | auto_increment |
| name | varchar(255) | NO |  | NULL |  |
| genero | varchar(255) | YES |  | NULL |  |
| email | varchar(255) | NO | UNI | NULL |  |
| email_verified_at | timestamp | YES |  | NULL |  |
| password | varchar(255) | YES |  | NULL |  |
| remember_token | varchar(100) | YES |  | NULL |  |
| created_at | timestamp | YES |  | NULL |  |
| updated_at | timestamp | YES |  | NULL |  |


