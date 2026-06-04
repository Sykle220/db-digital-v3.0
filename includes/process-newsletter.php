<?php
// includes/process-newsletter.php — Inscription newsletter (footer)

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db.php';

header('Content-Type: text/plain; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo ($current_lang === 'fr') ? 'Méthode non autorisée.' : 'Method not allowed.';
    exit;
}

if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    http_response_code(403);
    echo ($current_lang === 'fr') ? 'Session expirée. Rechargez la page et réessayez.' : 'Session expired. Reload the page and try again.';
    exit;
}

if (!empty($_POST['company_website'])) {
    http_response_code(200);
    echo __('newsletter_success');
    exit;
}

$email = trim(filter_var((string) ($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL));

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo __('newsletter_error_email');
    exit;
}

try {
    $result = saveNewsletterSubscriber($email, $current_lang);
} catch (PDOException $e) {
    error_log('Newsletter DB Error: ' . $e->getMessage());
    http_response_code(500);
    echo __('newsletter_error_db');
    exit;
}

if (!empty($result['already_active'])) {
    echo __('newsletter_already_subscribed');
    exit;
}

if (!empty($result['reactivated'])) {
    echo __('newsletter_reactivated');
    exit;
}

echo __('newsletter_success');
