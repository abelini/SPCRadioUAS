-- Asignaciones table
CREATE TABLE IF NOT EXISTS asignaciones (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    rolID INT(11) NOT NULL,
    locutorID INT(11) NOT NULL,
    diaID INT(11) NOT NULL,
    horarioID INT(11) NOT NULL,
    PRIMARY KEY (ID),
    KEY idx_rolID (rolID),
    KEY idx_locutorID (locutorID),
    KEY idx_diaID (diaID),
    KEY idx_horarioID (horarioID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;