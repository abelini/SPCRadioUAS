-- StreamHits table for tracking audience
CREATE TABLE IF NOT EXISTS stream_hits (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    format VARCHAR(50) NOT NULL,
    referer VARCHAR(255) NOT NULL,
    refererType VARCHAR(50) NOT NULL DEFAULT 'app',
    ip VARCHAR(45) NOT NULL,
    userAgent VARCHAR(512) NOT NULL,
    country VARCHAR(64) DEFAULT NULL,
    countryCode VARCHAR(2) DEFAULT NULL,
    city VARCHAR(64) DEFAULT NULL,
    zip VARCHAR(10) DEFAULT NULL,
    lat DECIMAL(10, 7) DEFAULT NULL,
    lon DECIMAL(10, 7) DEFAULT NULL,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_stream_hits_created ON stream_hits(created);
CREATE INDEX IF NOT EXISTS idx_stream_hits_refererType ON stream_hits(refererType);
CREATE INDEX IF NOT EXISTS idx_stream_hits_format ON stream_hits(format);