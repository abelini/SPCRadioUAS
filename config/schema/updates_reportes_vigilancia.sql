-- Updates de Reportes de Vigilancia table
CREATE TABLE IF NOT EXISTS updates_reportes_vigilancia (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    incidenciaID INT(11) NOT NULL,
    userID INT(11) NOT NULL,
    observacion TEXT NOT NULL,
    `date` DATETIME NOT NULL
);