-- Temas de Programas table
CREATE TABLE IF NOT EXISTS temas_programas (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    programaID INT(11) NOT NULL,
    tema VARCHAR(255) DEFAULT NULL,
    invitados VARCHAR(255) DEFAULT NULL,
    tags VARCHAR(255) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);