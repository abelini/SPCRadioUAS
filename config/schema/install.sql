-- ============================================================================
-- SPC (Sistema de Producción y Cabina) — Database Installation Script
-- Target: MySQL / MariaDB
-- Generated from: Entity/Table definitions + Migrations + Fixtures
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `radiouas_servicios`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE `radiouas_servicios`;

-- ============================================================================
-- 1. areas
-- ============================================================================
CREATE TABLE IF NOT EXISTS `areas` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128) NOT NULL,
    `icon` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 2. asignaciones
-- ============================================================================
CREATE TABLE IF NOT EXISTS `asignaciones` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `rolID` INT(11) NOT NULL,
    `locutorID` INT(11) NOT NULL,
    `diaID` INT(11) NOT NULL,
    `horarioID` INT(11) NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_rolID` (`rolID`),
    KEY `idx_locutorID` (`locutorID`),
    KEY `idx_diaID` (`diaID`),
    KEY `idx_horarioID` (`horarioID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 3. bitacora_cabina
-- ============================================================================
CREATE TABLE IF NOT EXISTS `bitacora_cabina` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `fecha` DATE NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    PRIMARY KEY (`ID`),
    UNIQUE KEY `uk_fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 4. bitacora_vigilancia
-- ============================================================================
CREATE TABLE IF NOT EXISTS `bitacora_vigilancia` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `vigilanteID` INT(11) NOT NULL,
    `tipoBitacora` INT(11) NOT NULL,
    `fecha` DATE NOT NULL,
    `observaciones` MEDIUMTEXT NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 5. categorias_programas
-- ============================================================================
CREATE TABLE IF NOT EXISTS `categorias_programas` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `icon` VARCHAR(128) NOT NULL DEFAULT '',
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 6. detalles_incidencias
-- ============================================================================
CREATE TABLE IF NOT EXISTS `detalles_incidencias` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `incidenciaID` INT(11) NOT NULL,
    `fire` TINYINT(1) DEFAULT NULL,
    `moist` TINYINT(1) DEFAULT NULL,
    `ventilation` TINYINT(1) DEFAULT NULL,
    `locks` TINYINT(1) DEFAULT NULL,
    `blackout` TINYINT(1) DEFAULT NULL,
    `lost_signal` TINYINT(1) DEFAULT NULL,
    `alarm_on` TINYINT(1) DEFAULT NULL,
    `leds` TINYINT(1) DEFAULT NULL,
    `burning_smell` TINYINT(1) DEFAULT NULL,
    `invaded` TINYINT(1) DEFAULT NULL,
    `walls_cracked` TINYINT(1) DEFAULT NULL,
    `antenna_bent` TINYINT(1) DEFAULT NULL,
    `antenna_lights_off` TINYINT(1) DEFAULT NULL,
    `antenna_anchor_bent` TINYINT(1) DEFAULT NULL,
    `blackout_duration` INT(11) DEFAULT 0,
    `lost_signal_duration` INT(11) DEFAULT 0,
    PRIMARY KEY (`ID`),
    KEY `idx_incidenciaID` (`incidenciaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 7. dias
-- ============================================================================
CREATE TABLE IF NOT EXISTS `dias` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 8. dias_horarios
-- ============================================================================
CREATE TABLE IF NOT EXISTS `dias_horarios` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `diaID` INT(11) NOT NULL DEFAULT 0,
    `horarioID` INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`ID`),
    KEY `idx_diaID` (`diaID`),
    KEY `idx_horarioID` (`horarioID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 9. dias_programas
-- ============================================================================
CREATE TABLE IF NOT EXISTS `dias_programas` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `diaID` INT(11) NOT NULL,
    `programaID` INT(11) NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_diaID` (`diaID`),
    KEY `idx_programaID` (`programaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 10. horarios
-- ============================================================================
CREATE TABLE IF NOT EXISTS `horarios` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `horaInicio` TIME NOT NULL DEFAULT '00:00:00',
    `horaFin` TIME NOT NULL DEFAULT '00:00:00',
    `turnoID` INT(11) NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_turnoID` (`turnoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 11. i18n
-- ============================================================================
CREATE TABLE IF NOT EXISTS `i18n` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `locale` VARCHAR(6) NOT NULL,
    `model` VARCHAR(255) NOT NULL,
    `foreign_key` INT(10) NOT NULL,
    `field` VARCHAR(255) NOT NULL,
    `content` TEXT,
    PRIMARY KEY (`id`),
    UNIQUE KEY `I18N_LOCALE_FIELD` (`locale`, `model`, `foreign_key`, `field`),
    KEY `I18N_FIELD` (`model`, `foreign_key`, `field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 12. incidencias
-- ============================================================================
CREATE TABLE IF NOT EXISTS `incidencias` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `areaID` INT(11) NOT NULL,
    `tipoBitacora` INT(11) NOT NULL,
    `fecha` DATE NOT NULL,
    `observaciones` MEDIUMTEXT NOT NULL,
    `attachment` VARCHAR(128) NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    `closed` TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`ID`),
    KEY `idx_areaID` (`areaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 13. mensajes
-- ============================================================================
CREATE TABLE IF NOT EXISTS `mensajes` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `message` TEXT NOT NULL,
    `visible` TINYINT(1) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 14. permisos
-- ============================================================================
CREATE TABLE IF NOT EXISTS `permisos` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `plural` VARCHAR(128) NOT NULL,
    `singular` VARCHAR(255) NOT NULL,
    `icon` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 15. permisos_usuarios
-- ============================================================================
CREATE TABLE IF NOT EXISTS `permisos_usuarios` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `usuarioID` INT(11) NOT NULL DEFAULT 0,
    `permisoID` INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`ID`),
    KEY `idx_usuarioID` (`usuarioID`),
    KEY `idx_permisoID` (`permisoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 16. programas
-- ============================================================================
CREATE TABLE IF NOT EXISTS `programas` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `categoryID` INT(11) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `horaInicio` TIME NOT NULL,
    `horaFin` TIME NOT NULL,
    `produccion` VARCHAR(255) NOT NULL,
    `conduccion` VARCHAR(255) NOT NULL,
    `uo` TINYINT(1) NOT NULL,
    `musical` TINYINT(1) NOT NULL,
    `reportable` TINYINT(1) NOT NULL,
    `outOfAir` TINYINT(1) NOT NULL DEFAULT 0,
    `image` VARCHAR(255) DEFAULT NULL,
    `pty` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `ptn` VARCHAR(8) NOT NULL DEFAULT '',
    PRIMARY KEY (`ID`),
    KEY `idx_categoryID` (`categoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 17. reportes_cabinas
-- ============================================================================
CREATE TABLE IF NOT EXISTS `reportes_cabinas` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `bitacoraID` INT(11) NOT NULL,
    `locutorID` INT(11) NOT NULL,
    `horaInicio` TIME NOT NULL,
    `horaFin` TIME NOT NULL,
    `reporte` TEXT DEFAULT NULL,
    `controles` INT(11) NOT NULL DEFAULT 0,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_bitacoraID` (`bitacoraID`),
    KEY `idx_locutorID` (`locutorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 18. reportes_programas
-- ============================================================================
CREATE TABLE IF NOT EXISTS `reportes_programas` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `ReporteCabinaID` INT(11) NOT NULL,
    `programaID` INT(11) NOT NULL,
    `status` ENUM('V','G','S','X') DEFAULT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_ReporteCabinaID` (`ReporteCabinaID`),
    KEY `idx_programaID` (`programaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 19. reportes_vigilancia
-- ============================================================================
CREATE TABLE IF NOT EXISTS `reportes_vigilancia` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `bitacoraID` INT(11) NOT NULL,
    `fire` TINYINT(1) DEFAULT NULL,
    `moist` TINYINT(1) DEFAULT NULL,
    `ventilation` TINYINT(1) DEFAULT NULL,
    `locks` TINYINT(1) DEFAULT NULL,
    `blackout` TINYINT(1) DEFAULT NULL,
    `lost_signal` TINYINT(1) DEFAULT NULL,
    `alarm_on` TINYINT(1) DEFAULT NULL,
    `leds` TINYINT(1) DEFAULT NULL,
    `burning_smell` TINYINT(1) DEFAULT NULL,
    `invaded` TINYINT(1) DEFAULT NULL,
    `walls_cracked` TINYINT(1) DEFAULT NULL,
    `antenna_bent` TINYINT(1) DEFAULT NULL,
    `antenna_lights_off` TINYINT(1) DEFAULT NULL,
    `antenna_anchor_bent` TINYINT(1) DEFAULT NULL,
    `blackout_duration` INT(11) DEFAULT 0,
    `lost_signal_duration` INT(11) DEFAULT 0,
    PRIMARY KEY (`ID`),
    KEY `idx_bitacoraID` (`bitacoraID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 20. roles
-- ============================================================================
CREATE TABLE IF NOT EXISTS `roles` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `fechaInicio` DATE NOT NULL,
    `fechaFin` DATE NOT NULL,
    `turnoID` INT(11) NOT NULL DEFAULT 1,
    PRIMARY KEY (`ID`),
    KEY `idx_turnoID` (`turnoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 21. sessions
-- ============================================================================
CREATE TABLE IF NOT EXISTS `sessions` (
    `id` CHAR(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `data` BLOB DEFAULT NULL,
    `expires` INT(10) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 22. solicitudes
-- ============================================================================
CREATE TABLE IF NOT EXISTS `solicitudes` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `tipoSolicitudID` INT(11) NOT NULL DEFAULT 0,
    `solicitante` VARCHAR(255) NOT NULL,
    `evento` TEXT NOT NULL,
    `observaciones` TEXT DEFAULT NULL,
    `fecha` DATETIME NOT NULL,
    `status` INT(11) NOT NULL DEFAULT 0,
    `primerAsignadoID` INT(11) DEFAULT 0,
    `segundoAsignadoID` INT(11) DEFAULT 0,
    `autorizanteID` INT(11) DEFAULT 0,
    `productorID` INT(11) DEFAULT 0,
    `aceptado` TINYINT(1) NOT NULL,
    `reporteGrabacion` TEXT DEFAULT NULL,
    `reporteProgramacion` TEXT DEFAULT NULL,
    `preasignado` TINYINT(1) DEFAULT NULL,
    `cancelado` TINYINT(1) NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_tipoSolicitudID` (`tipoSolicitudID`),
    KEY `idx_primerAsignadoID` (`primerAsignadoID`),
    KEY `idx_segundoAsignadoID` (`segundoAsignadoID`),
    KEY `idx_autorizanteID` (`autorizanteID`),
    KEY `idx_productorID` (`productorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 23. stream_hits
-- ============================================================================
CREATE TABLE IF NOT EXISTS `stream_hits` (
    `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `format` ENUM('mp3','hls') NOT NULL DEFAULT 'mp3',
    `referer` VARCHAR(255) NOT NULL DEFAULT '',
    `refererType` ENUM('domain','app','unknown') NOT NULL DEFAULT 'unknown',
    `ip` VARCHAR(45) NOT NULL DEFAULT '',
    `userAgent` VARCHAR(512) NOT NULL DEFAULT '',
    `country` VARCHAR(100) NOT NULL DEFAULT '',
    `countryCode` VARCHAR(2) NOT NULL DEFAULT '',
    `city` VARCHAR(100) NOT NULL DEFAULT '',
    `zip` VARCHAR(20) NOT NULL DEFAULT '',
    `lat` DECIMAL(10,7) DEFAULT NULL,
    `lon` DECIMAL(10,7) DEFAULT NULL,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`),
    KEY `idx_stream_hits_created` (`created`),
    KEY `idx_stream_hits_refererType` (`refererType`),
    KEY `idx_stream_hits_format` (`format`),
    KEY `idx_stream_hits_ip` (`ip`),
    KEY `idx_stream_hits_referer` (`referer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 24. temas_programas
-- ============================================================================
CREATE TABLE IF NOT EXISTS `temas_programas` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `programaID` INT(11) NOT NULL,
    `tema` VARCHAR(255) DEFAULT NULL,
    `invitados` VARCHAR(255) DEFAULT NULL,
    `tags` VARCHAR(255) NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_programaID` (`programaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 25. tickets_bitacoras_v
-- ============================================================================
CREATE TABLE IF NOT EXISTS `tickets_bitacoras_v` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `bitacoraID` INT(11) NOT NULL,
    `userID` INT(11) NOT NULL,
    `report` TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_bitacoraID` (`bitacoraID`),
    KEY `idx_userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 26. tipo_bitacora
-- ============================================================================
CREATE TABLE IF NOT EXISTS `tipo_bitacora` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `name` TINYTEXT NOT NULL,
    `turnos` LONGTEXT NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 27. tipo_solicitud
-- ============================================================================
CREATE TABLE IF NOT EXISTS `tipo_solicitud` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `imagen` VARCHAR(255) NOT NULL,
    `icon` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 28. turnos
-- ============================================================================
CREATE TABLE IF NOT EXISTS `turnos` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 29. updates_reportes_vigilancia
-- ============================================================================
CREATE TABLE IF NOT EXISTS `updates_reportes_vigilancia` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `incidenciaID` INT(11) NOT NULL,
    `userID` INT(11) NOT NULL,
    `observacion` TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `idx_incidenciaID` (`incidenciaID`),
    KEY `idx_userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================================
-- 30. usuarios
-- ============================================================================
CREATE TABLE IF NOT EXISTS `usuarios` (
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `empleado` INT(11) NOT NULL,
    `username` VARCHAR(30) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `fullname` VARCHAR(255) NOT NULL,
    `email` VARCHAR(64) NOT NULL,
    `base` TINYINT(1) NOT NULL DEFAULT 0,
    `photo` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`ID`),
    UNIQUE KEY `uk_username` (`username`),
    UNIQUE KEY `uk_empleado` (`empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
