-- Asignaciones table
CREATE TABLE IF NOT EXISTS asignaciones (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    rolID INT(11) NOT NULL,
    locutorID INT(11) NOT NULL,
    diaID INT(11) NOT NULL,
    horarioID INT(11) NOT NULL
);