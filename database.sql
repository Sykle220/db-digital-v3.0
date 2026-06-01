-- ============================================
-- DB DIGITAL AGENCY - QUOTE DATABASE SCHEMA
-- ============================================

CREATE DATABASE IF NOT EXISTS dbdigitalagency 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE dbdigitalagency;

-- Table des demandes de devis
CREATE TABLE IF NOT EXISTS quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Étape 1: Service
    service VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    project_type VARCHAR(100) NOT NULL,
    budget VARCHAR(50) NOT NULL,
    start_date VARCHAR(50) NOT NULL,

    -- Étape 2: Projet
    website VARCHAR(255) DEFAULT NULL,
    message TEXT DEFAULT NULL,
    brief_file VARCHAR(255) DEFAULT NULL,

    -- Étape 3: Contact
    fullname VARCHAR(255) NOT NULL,
    company VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) NOT NULL,
    whatsapp VARCHAR(50) NOT NULL,

    -- Méta
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('new', 'contacted', 'in_progress', 'completed', 'cancelled') DEFAULT 'new',
    notes TEXT DEFAULT NULL,

    -- Index pour recherche rapide
    INDEX idx_email (email),
    INDEX idx_whatsapp (whatsapp),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des logs d'envoi (mail, WhatsApp)
CREATE TABLE IF NOT EXISTS quote_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote_id INT NOT NULL,
    action_type ENUM('email_sent', 'whatsapp_click', 'email_failed') NOT NULL,
    action_details TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quote_id) REFERENCES quotes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des paramètres SMTP (optionnel, si vous préférez stocker en DB)
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion des paramètres par défaut (à modifier selon votre SMTP)
INSERT INTO settings (setting_key, setting_value) VALUES
('smtp_host', 'smtp.gmail.com'),
('smtp_port', '587'),
('smtp_username', 'votre-email@gmail.com'),
('smtp_password', 'votre-mot-de-passe-app'),
('smtp_encryption', 'tls'),
('smtp_from_email', 'noreply@dbdigitalagency.com'),
('smtp_from_name', 'DB Digital Agency'),
('admin_email', 'contact@dbdigitalagency.com'),
('whatsapp_number', '237691323249')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);