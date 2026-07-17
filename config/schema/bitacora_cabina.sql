-- Bitácora de Cabina table
CREATE TABLE IF NOT EXISTS bitacora_cabina (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    fecha DATE NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (ID),
    UNIQUE KEY uk_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;