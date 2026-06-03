<?php
// includes/process-contact.php — Traitement AJAX du formulaire de contact

require_once __DIR__ . '/functions.php';

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
    echo ($current_lang === 'fr') ? 'Merci ! Votre message a été envoyé.' : 'Thank you! Your message has been sent.';
    exit;
}

$name    = trim(strip_tags((string) ($_POST['name'] ?? '')));
$phone   = trim(strip_tags((string) ($_POST['phone'] ?? '')));
$email   = trim(filter_var((string) ($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL));
$message = trim(strip_tags((string) ($_POST['message'] ?? '')));

$errors = [];
if ($name === '') {
    $errors[] = ($current_lang === 'fr') ? 'Le nom est requis.' : 'Name is required.';
}
if ($phone === '') {
    $errors[] = ($current_lang === 'fr') ? 'Le téléphone est requis.' : 'Phone is required.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = ($current_lang === 'fr') ? 'Email valide requis.' : 'Valid email is required.';
}
if ($message === '') {
    $errors[] = ($current_lang === 'fr') ? 'Le message est requis.' : 'Message is required.';
}

if (!empty($errors)) {
    http_response_code(400);
    echo implode(' ', $errors);
    exit;
}

$subject = ($current_lang === 'fr' ? 'Nouveau message contact' : 'New contact message') . ' — ' . $name;

$body = '<html><body style="font-family:sans-serif;color:#1c4380;">'
    . '<h2>' . htmlspecialchars($subject) . '</h2>'
    . '<p><strong>' . ($current_lang === 'fr' ? 'Nom' : 'Name') . ':</strong> ' . htmlspecialchars($name) . '</p>'
    . '<p><strong>' . ($current_lang === 'fr' ? 'Téléphone' : 'Phone') . ':</strong> ' . htmlspecialchars($phone) . '</p>'
    . '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>'
    . '<p><strong>' . ($current_lang === 'fr' ? 'Message' : 'Message') . ':</strong><br>' . nl2br(htmlspecialchars($message)) . '</p>'
    . '</body></html>';

$email_sent = false;

if (class_exists(\PHPMailer\PHPMailer\PHPMailer::class) && file_exists(__DIR__ . '/../vendor/autoload.php')) {
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port       = SMTP_PORT;
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress(ADMIN_EMAIL);
        $mail->addReplyTo($email, $name);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $body));
        $mail->send();
        $email_sent = true;
    } catch (Exception $e) {
        error_log('Contact PHPMailer: ' . $e->getMessage());
    }
}

if (!$email_sent) {
    $headers = "From: " . SMTP_FROM_EMAIL . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $email_sent = mail(ADMIN_EMAIL, $subject, $body, $headers);
}

if (!$email_sent) {
    http_response_code(500);
    echo ($current_lang === 'fr')
        ? 'Impossible d\'envoyer le message pour le moment. Réessayez ou contactez-nous par téléphone.'
        : 'Unable to send your message right now. Please try again or call us.';
    exit;
}

echo ($current_lang === 'fr')
    ? 'Merci ! Votre message a été envoyé. Nous vous répondrons très bientôt.'
    : 'Thank you! Your message has been sent. We will get back to you shortly.';
