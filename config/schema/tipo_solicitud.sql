-- Tipo de Solicitud table
CREATE TABLE IF NOT EXISTS tipo_solicitud (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    icon VARCHAR(64) NOT NULL
);