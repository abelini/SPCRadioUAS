-- Días-Control de Programas table
CREATE TABLE IF NOT EXISTS dias_programas (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    diaID INT(11) NOT NULL,
    programaID INT(11) NOT NULL,
    PRIMARY KEY (ID),
    KEY idx_diaID (diaID),
    KEY idx_programaID (programaID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;