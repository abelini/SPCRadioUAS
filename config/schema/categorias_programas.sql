-- Categorías de Programas table
CREATE TABLE IF NOT EXISTS categorias_programas (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    icon VARCHAR(128) NOT NULL
);