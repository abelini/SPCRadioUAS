-- Permisos-Usuarios table
CREATE TABLE IF NOT EXISTS permisos_usuarios (
    ID INT(11) PRIMARY KEY AUTOINCREMENT,
    usuarioID INT(11) NOT NULL DEFAULT 0,
    permisoID INT(11) NOT NULL DEFAULT 0
);