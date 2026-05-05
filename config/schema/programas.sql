-- Programas table
CREATE TABLE IF NOT EXISTS programas (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    categoryID INT(11) NOT NULL,
    name VARCHAR(255) NOT NULL,
    horaInicio TIME NOT NULL,
    horaFin TIME NOT NULL,
    produccion VARCHAR(255) NOT NULL,
    conduccion VARCHAR(255) NOT NULL,
    uo TINYINT(1) NOT NULL,
    musical TINYINT(1) NOT NULL,
    reportable TINYINT(1) NOT NULL,
    outOfAir TINYINT(1) NOT NULL DEFAULT 0
);