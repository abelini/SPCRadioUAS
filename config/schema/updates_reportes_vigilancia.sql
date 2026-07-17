-- Updates de Reportes de Vigilancia table
CREATE TABLE IF NOT EXISTS updates_reportes_vigilancia (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    incidenciaID INT(11) NOT NULL,
    userID INT(11) NOT NULL,
    observacion TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (ID),
    KEY idx_incidenciaID (incidenciaID),
    KEY idx_userID (userID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;