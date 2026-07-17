-- Tickets de Bitácoras de Vigilancia table
CREATE TABLE IF NOT EXISTS tickets_bitacoras_v (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    bitacoraID INT(11) NOT NULL,
    userID INT(11) NOT NULL,
    report TEXT NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (ID),
    KEY idx_bitacoraID (bitacoraID),
    KEY idx_userID (userID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;