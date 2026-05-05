-- Solicitudes table
CREATE TABLE IF NOT EXISTS solicitudes (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    tipoSolicitudID INT(11) NOT NULL DEFAULT 0,
    solicitante VARCHAR(255) NOT NULL,
    evento TEXT NOT NULL,
    observaciones TEXT DEFAULT NULL,
    fecha DATETIME NOT NULL,
    status INT(11) NOT NULL DEFAULT 0,
    primerAsignadoID INT(11) DEFAULT 0,
    segundoAsignadoID INT(11) DEFAULT 0,
    autorizanteID INT(11) DEFAULT 0,
    productorID INT(11) DEFAULT 0,
    aceptado TINYINT(1) NOT NULL,
    reporteGrabacion TEXT DEFAULT NULL,
    reporteProgramacion TEXT DEFAULT NULL,
    cancelado TINYINT(1) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);