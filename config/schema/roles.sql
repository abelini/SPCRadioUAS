-- Roles table
CREATE TABLE IF NOT EXISTS roles (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    fechaInicio DATE NOT NULL,
    fechaFin DATE NOT NULL,
    turnoID INT(11) NOT NULL DEFAULT 1,
    PRIMARY KEY (ID),
    KEY idx_turnoID (turnoID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;