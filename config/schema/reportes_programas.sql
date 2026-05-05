-- Reportes de Programas table
CREATE TABLE IF NOT EXISTS reportes_programas (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    ReporteCabinaID INT(11) NOT NULL,
    programaID INT(11) NOT NULL,
    status ENUM('V','G','S','X') DEFAULT NULL
);