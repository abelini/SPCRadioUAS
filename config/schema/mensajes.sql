-- Mensajes table
CREATE TABLE IF NOT EXISTS mensajes (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    message TEXT NOT NULL,
    visible TINYINT(1) NOT NULL
);