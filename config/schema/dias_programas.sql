-- Días-Control de Programas table
CREATE TABLE IF NOT EXISTS dias_programas (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    diaID INT(11) NOT NULL,
    programaID INT(11) NOT NULL
);