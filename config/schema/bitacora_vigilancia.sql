-- Bitácora de Vigilancia table
CREATE TABLE IF NOT EXISTS bitacora_vigilancia (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    vigilanteID INT(11) NOT NULL,
    tipoBitacora INT(11) NOT NULL,
    fecha DATE NOT NULL,
    observaciones MEDIUMTEXT NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;