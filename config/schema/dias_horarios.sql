-- Días-Horarios table
CREATE TABLE IF NOT EXISTS dias_horarios (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    diaID INT(11) NOT NULL DEFAULT 0,
    horarioID INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (ID),
    KEY idx_diaID (diaID),
    KEY idx_horarioID (horarioID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;