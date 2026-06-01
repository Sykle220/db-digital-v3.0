<?php
// includes/db.php
// Connexion PDO MySQL pour DB Digital Agency

require_once __DIR__ . '/config.php';


try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    error_log("DB Connection failed: " . $e->getMessage());
    die("Database connection error. Please try again later.");
}

// ============================================
// FONCTIONS HELPER DB
// ============================================

/**
 * Insère une nouvelle demande de devis
 */
function saveQuote($data) {
    global $pdo;

    $sql = "INSERT INTO quotes 
        (service, subject, project_type, budget, start_date, website, message, brief_file, fullname, company, email, whatsapp, ip_address, user_agent) 
        VALUES 
        (:service, :subject, :project_type, :budget, :start_date, :website, :message, :brief_file, :fullname, :company, :email, :whatsapp, :ip_address, :user_agent)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':service'      => $data['service'],
        ':subject'      => $data['subject'],
        ':project_type' => $data['project_type'],
        ':budget'       => $data['budget'],
        ':start_date'   => $data['start_date'],
        ':website'      => $data['website'] ?: null,
        ':message'      => $data['message'] ?: null,
        ':brief_file'   => $data['brief_file'] ?: null,
        ':fullname'     => $data['fullname'],
        ':company'      => $data['company'] ?: null,
        ':email'        => $data['email'],
        ':whatsapp'     => $data['whatsapp'],
        ':ip_address'   => $_SERVER['REMOTE_ADDR'] ?? null,
        ':user_agent'   => $_SERVER['HTTP_USER_AGENT'] ?? null,
    ]);

    return $pdo->lastInsertId();
}

/**
 * Log une action (mail, WhatsApp, etc.)
 */
function logQuoteAction($quote_id, $action_type, $details = '') {
    global $pdo;
    $sql = "INSERT INTO quote_logs (quote_id, action_type, action_details) VALUES (:quote_id, :action_type, :details)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':quote_id'    => $quote_id,
        ':action_type' => $action_type,
        ':details'     => $details
    ]);
}

/**
 * Récupère une quote par ID
 */
function getQuoteById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM quotes WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

/**
 * Récupère tous les paramètres settings
 */
function getSettings() {
    global $pdo;
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

/**
 * Met à jour un paramètre
 */
function updateSetting($key, $value) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE setting_value = :value");
    $stmt->execute([':key' => $key, ':value' => $value]);
}