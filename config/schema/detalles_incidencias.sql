-- Detalles de Incidencias table
CREATE TABLE IF NOT EXISTS detalles_incidencias (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    incidenciaID INT(11) NOT NULL,
    fire TINYINT(1) DEFAULT NULL,
    moist TINYINT(1) DEFAULT NULL,
    ventilation TINYINT(1) DEFAULT NULL,
    locks TINYINT(1) DEFAULT NULL,
    blackout TINYINT(1) DEFAULT NULL,
    lost_signal TINYINT(1) DEFAULT NULL,
    alarm_on TINYINT(1) DEFAULT NULL,
    leds TINYINT(1) DEFAULT NULL,
    burning_smell TINYINT(1) DEFAULT NULL,
    invaded TINYINT(1) DEFAULT NULL,
    walls_cracked TINYINT(1) DEFAULT NULL,
    antenna_bent TINYINT(1) DEFAULT NULL,
    antenna_lights_off TINYINT(1) DEFAULT NULL,
    antenna_anchor_bent TINYINT(1) DEFAULT NULL,
    blackout_duration INT(11) DEFAULT 0,
    lost_signal_duration INT(11) DEFAULT 0
);