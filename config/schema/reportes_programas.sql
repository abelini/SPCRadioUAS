-- Reportes de Programas table
CREATE TABLE IF NOT EXISTS reportes_programas (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    ReporteCabinaID INT(11) NOT NULL,
    programaID INT(11) NOT NULL,
    status ENUM('V','G','S','X') DEFAULT NULL,
    PRIMARY KEY (ID),
    KEY idx_ReporteCabinaID (ReporteCabinaID),
    KEY idx_programaID (programaID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;