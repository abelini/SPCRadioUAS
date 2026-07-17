-- Reportes de Cabina table
CREATE TABLE IF NOT EXISTS reportes_cabinas (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    bitacoraID INT(11) NOT NULL,
    locutorID INT(11) NOT NULL,
    horaInicio TIME NOT NULL,
    horaFin TIME NOT NULL,
    reporte TEXT DEFAULT NULL,
    controles INT(11) NOT NULL DEFAULT 0,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (ID),
    KEY idx_bitacoraID (bitacoraID),
    KEY idx_locutorID (locutorID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;