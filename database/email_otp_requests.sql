CREATE TABLE email_otp_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(191) NOT NULL,
    purpose VARCHAR(50) NOT NULL DEFAULT 'password_reset',
    otp_hash VARCHAR(255) NOT NULL,
    requested_at DATETIME NOT NULL,
    expires_at DATETIME NOT NULL,
    verified_at DATETIME NULL,
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    request_ip VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    INDEX idx_email_purpose_requested (email, purpose, requested_at),
    INDEX idx_expires_at (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
