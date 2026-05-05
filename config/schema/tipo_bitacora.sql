-- Tipo de Bitácora table
CREATE TABLE IF NOT EXISTS tipo_bitacora (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    name TINYTEXT NOT NULL,
    turnos LONGTEXT NOT NULL
);