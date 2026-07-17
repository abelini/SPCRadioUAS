-- Permisos-Usuarios table
CREATE TABLE IF NOT EXISTS permisos_usuarios (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    usuarioID INT(11) NOT NULL DEFAULT 0,
    permisoID INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (ID),
    KEY idx_usuarioID (usuarioID),
    KEY idx_permisoID (permisoID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;