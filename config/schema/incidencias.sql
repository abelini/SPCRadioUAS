-- Incidencias table
CREATE TABLE IF NOT EXISTS incidencias (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    areaID INT(11) NOT NULL,
    tipoBitacora INT(11) NOT NULL,
    fecha DATE NOT NULL,
    observaciones MEDIUMTEXT NOT NULL,
    attachment VARCHAR(128) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    closed TINYINT(1) NOT NULL DEFAULT 0
);