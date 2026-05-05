-- Reportes de Cabina table
CREATE TABLE IF NOT EXISTS reportes_cabinas (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    bitacoraID INT(11) NOT NULL,
    locutorID INT(11) NOT NULL,
    horaInicio TIME NOT NULL,
    horaFin TIME NOT NULL,
    reporte TEXT DEFAULT NULL,
    controles INT(11) NOT NULL DEFAULT 0,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);