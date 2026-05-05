-- Bitácora de Cabina table
CREATE TABLE IF NOT EXISTS bitacora_cabina (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    fecha DATE NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);