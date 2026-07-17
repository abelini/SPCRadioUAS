-- StreamHits table for tracking audience
CREATE TABLE IF NOT EXISTS stream_hits (
    ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    format ENUM('mp3','hls') NOT NULL DEFAULT 'mp3',
    referer VARCHAR(255) NOT NULL DEFAULT '',
    refererType ENUM('domain','app','unknown') NOT NULL DEFAULT 'unknown',
    ip VARCHAR(45) NOT NULL DEFAULT '',
    userAgent VARCHAR(512) NOT NULL DEFAULT '',
    country VARCHAR(100) NOT NULL DEFAULT '',
    countryCode VARCHAR(2) NOT NULL DEFAULT '',
    city VARCHAR(100) NOT NULL DEFAULT '',
    zip VARCHAR(20) NOT NULL DEFAULT '',
    lat DECIMAL(10,7) DEFAULT NULL,
    lon DECIMAL(10,7) DEFAULT NULL,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID),
    KEY idx_stream_hits_created (created),
    KEY idx_stream_hits_refererType (refererType),
    KEY idx_stream_hits_format (format),
    KEY idx_stream_hits_ip (ip),
    KEY idx_stream_hits_referer (referer)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;