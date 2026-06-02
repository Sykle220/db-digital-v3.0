<?php
// process-quote.php
// Traitement complet : Validation → Upload → DB → Mail / WhatsApp

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db.php';

// ============================================
// CONFIGURATION PHPMailer
// ============================================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: get-quote.php');
    exit;
}

// CSRF + honeypot
if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['quote_errors'] = [($current_lang == 'fr') ? 'Session expirée. Veuillez réessayer.' : 'Session expired. Please try again.'];
    $_SESSION['quote_form_data'] = $_POST;
    header('Location: get-quote.php');
    exit;
}
if (!empty($_POST['company_website'])) {
    // bot
    header('Location: get-quote.php');
    exit;
}

// ============================================
// 1. RÉCUPÉRATION & NETTOYAGE
// ============================================
// Services can be an array now (multiselect)
$services = is_array($_POST['services'] ?? null) ? array_map('htmlspecialchars', $_POST['services']) : [];
$services = array_map('trim', $services);
$service  = !empty($services) ? implode(', ', $services) : ''; // Join for display/storage

$subject      = trim(htmlspecialchars($_POST['subject'] ?? ''));
$project_type = trim(htmlspecialchars($_POST['project_type'] ?? ''));
$budget       = trim(htmlspecialchars($_POST['budget'] ?? ''));
$start_date   = trim(htmlspecialchars($_POST['start_date'] ?? ''));
$website      = trim(htmlspecialchars($_POST['website'] ?? ''));
$message      = trim(htmlspecialchars($_POST['message'] ?? ''));
$fullname     = trim(htmlspecialchars($_POST['fullname'] ?? ''));
$company      = trim(htmlspecialchars($_POST['company'] ?? ''));
$email        = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
$whatsapp     = trim(htmlspecialchars($_POST['whatsapp'] ?? ''));

// ============================================
// 2. VALIDATION
// ============================================
$errors = [];
if (empty($services))     $errors[] = __('quote_service_label') . ' ' . ($current_lang == 'fr' ? 'est requis' : 'is required');
if (empty($subject))      $errors[] = __('quote_subject_label') . ' ' . ($current_lang == 'fr' ? 'est requis' : 'is required');
if (empty($project_type)) $errors[] = __('quote_type_label')    . ' ' . ($current_lang == 'fr' ? 'est requis' : 'is required');
if (empty($budget))       $errors[] = __('quote_budget_label')   . ' ' . ($current_lang == 'fr' ? 'est requis' : 'is required');
if (empty($start_date))   $errors[] = __('quote_start_label')    . ' ' . ($current_lang == 'fr' ? 'est requis' : 'is required');
if (empty($fullname))     $errors[] = __('quote_fullname_label') . ' ' . ($current_lang == 'fr' ? 'est requis' : 'is required');
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = ($current_lang == 'fr' ? 'Email valide requis' : 'Valid email is required');
}
if (empty($whatsapp))     $errors[] = __('quote_whatsapp_label') . ' ' . ($current_lang == 'fr' ? 'est requis' : 'is required');

if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
    $errors[] = ($current_lang == 'fr') ? 'URL de site invalide' : 'Invalid website URL';
}

if (!empty($errors)) {
    $_SESSION['quote_errors'] = $errors;
    $_SESSION['quote_form_data'] = $_POST;
    header('Location: get-quote.php');
    exit;
}

// ============================================
// 3. GESTION FICHIER UPLOAD
// ============================================
$file_name = '';
$upload_dir = realpath(__DIR__ . '/../uploads') ?: (__DIR__ . '/../uploads');
$upload_dir = rtrim($upload_dir, '/') . '/quotes/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

if (!empty($_FILES['project_brief']['name'])) {
    $allowed = ['pdf', 'doc', 'docx'];
    $ext = strtolower(pathinfo($_FILES['project_brief']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) $errors[] = ($current_lang == 'fr' ? 'Seuls PDF/DOCX' : 'Only PDF/DOCX');
    if ($_FILES['project_brief']['size'] > 2 * 1024 * 1024) $errors[] = ($current_lang == 'fr' ? 'Fichier max 2Mo' : 'File max 2MB');
    if (!empty($_FILES['project_brief']['tmp_name']) && is_uploaded_file($_FILES['project_brief']['tmp_name'])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['project_brief']['tmp_name']);
        $allowedMimes = [
            'pdf' => ['application/pdf'],
            'doc' => ['application/msword'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'],
        ];
        if (!in_array($mime, $allowedMimes[$ext] ?? [], true)) {
            $errors[] = ($current_lang == 'fr') ? 'Type de fichier non autorisé' : 'File type not allowed';
        }
    }
    if (empty($errors)) {
        $safeBase = preg_replace('/[^a-zA-Z0-9.-]/', '_', basename($_FILES['project_brief']['name']));
        $fileDiskName = time() . '_' . $safeBase;
        $upload_path = $upload_dir . $fileDiskName;
        if (move_uploaded_file($_FILES['project_brief']['tmp_name'], $upload_path)) {
            // Stocke chemin relatif en DB, garde chemin absolu pour attachement email
            $file_name = 'uploads/quotes/' . $fileDiskName;
        } else {
            $file_name = '';
            $errors[] = ($current_lang == 'fr' ? 'Échec upload' : 'Upload failed');
        }
    }
}

if (!empty($errors)) {
    $_SESSION['quote_errors'] = $errors;
    $_SESSION['quote_form_data'] = $_POST;
    header('Location: get-quote.php');
    exit;
}

// ============================================
// 4. SAUVEGARDE EN BASE DE DONNÉES
// ============================================
try {
    $quote_id = saveQuote([
        'service' => $service,
        'services' => $services,
        'subject' => $subject,
        'project_type' => $project_type,
        'budget' => $budget, 'start_date' => $start_date, 'website' => $website,
        'message' => $message, 'brief_file' => $file_name, 'fullname' => $fullname,
        'company' => $company, 'email' => $email, 'whatsapp' => $whatsapp,
    ]);
} catch (PDOException $e) {
    error_log("Quote DB Error: " . $e->getMessage());
    $_SESSION['quote_errors'] = [__('quote_error_db')];
    $_SESSION['quote_form_data'] = $_POST;
    header('Location: get-quote.php');
    exit;
}

// ============================================
// 5. ENVOI EMAIL (toujours exécuté)
// ============================================
$email_sent = false;

// --- Option A: PHPMailer (décommentez si installé) ---

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
    $mail->addReplyTo($email, $fullname);
    if ($file_name) {
        $abs = realpath(__DIR__ . '/../' . $file_name);
        if ($abs && file_exists($abs)) $mail->addAttachment($abs);
    }
    $mail->isHTML(true);
    $mail->Subject = ($current_lang == 'fr' ? 'Nouvelle demande de devis' : 'New Quote Request') . ': ' . $subject;
    $mail->Body    = buildEmailBody(compact('service','subject','project_type','budget','start_date','website','message','fullname','company','email','whatsapp','file_name'), $current_lang);
    $mail->AltBody = strip_tags($mail->Body);
    $mail->send();
    $email_sent = true;
    logQuoteAction($quote_id, 'email_sent', 'PHPMailer OK');
} catch (Exception $e) {
    error_log("PHPMailer Error: " . $mail->ErrorInfo);
    logQuoteAction($quote_id, 'email_failed', $mail->ErrorInfo);
}

// --- Option B: mail() natif (fallback) ---
if (!$email_sent) {
    $to = ADMIN_EMAIL;
    $headers = "From: " . SMTP_FROM_EMAIL . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $email_subject = ($current_lang == 'fr' ? 'Nouvelle demande de devis' : 'New Quote Request') . ': ' . $subject;
    $email_body = buildEmailBody(compact('service','subject','project_type','budget','start_date','website','message','fullname','company','email','whatsapp','file_name'), $current_lang);
    if (mail($to, $email_subject, $email_body, $headers)) {
        $email_sent = true;
        logQuoteAction($quote_id, 'email_sent', 'mail() native OK');
    } else {
        logQuoteAction($quote_id, 'email_failed', 'mail() native failed');
    }
}

// ============================================
// 6. CONSTRUCTION URL WHATSAPP (toujours exécuté)
// ============================================
$wa_message = buildWhatsAppMessage(compact('service','subject','project_type','budget','start_date','website','message','fullname','company','email','whatsapp'), $current_lang);
$wa_url = "https://wa.me/" . WHATSAPP_NUMBER . "?text=" . urlencode($wa_message);
logQuoteAction($quote_id, 'whatsapp_click', 'URL generated');

// ============================================
// 7. REDIRECTION VERS PAGE DE SUCCÈS + WHATSAPP
// ============================================
$_SESSION['quote_success'] = true;
$_SESSION['quote_email_ok'] = $email_sent;
$_SESSION['quote_whatsapp_url'] = $wa_url;
header('Location: get-quote.php?success=1');
exit;

// ============================================
// FONCTIONS HELPER
// ============================================
function buildEmailBody($data, $lang) {
    $l = ($lang == 'fr') ? [
        'service' => 'Service', 'subject' => 'Sujet', 'type' => 'Type',
        'budget' => 'Budget', 'start' => 'Date de début', 'website' => 'Site web',
        'message' => 'Message', 'name' => 'Nom complet', 'company' => 'Entreprise',
        'email' => 'Email', 'whatsapp' => 'WhatsApp', 'file' => 'Fichier joint',
        'title' => 'Nouvelle demande de devis', 'id' => 'Devis N°'
    ] : [
        'service' => 'Service', 'subject' => 'Subject', 'type' => 'Type',
        'budget' => 'Budget', 'start' => 'Start Date', 'website' => 'Website',
        'message' => 'Message', 'name' => 'Full Name', 'company' => 'Company',
        'email' => 'Email', 'whatsapp' => 'WhatsApp', 'file' => 'Attached File',
        'title' => 'New Quote Request', 'id' => 'Quote ID'
    ];

    $rows = '';
    $fields = [
        'service' => $data['service'], 'subject' => $data['subject'], 'type' => $data['project_type'],
        'budget' => $data['budget'], 'start' => $data['start_date'], 'website' => $data['website'],
        'message' => nl2br($data['message']), 'name' => $data['fullname'], 'company' => $data['company'],
        'email' => $data['email'], 'whatsapp' => $data['whatsapp']
    ];
    foreach ($fields as $key => $value) {
        if (!empty($value)) $rows .= "<tr><td style='padding:10px;border-bottom:1px solid #eee;font-weight:bold;width:30%;'>{$l[$key]}</td><td style='padding:10px;border-bottom:1px solid #eee;'>{$value}</td></tr>";
    }
    if (!empty($data['file_name'])) {
        $rows .= "<tr><td style='padding:10px;border-bottom:1px solid #eee;font-weight:bold;'>{$l['file']}</td><td style='padding:10px;border-bottom:1px solid #eee;'>Yes (see admin panel)</td></tr>";
    }
    return "<!DOCTYPE html><html><head><meta charset='UTF-8'><style>body{font-family:Arial,sans-serif;background:#f5f5f5;padding:20px;}.container{max-width:600px;margin:0 auto;background:#fff;padding:30px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}h2{color:#1e3a5f;border-bottom:2px solid #4CAF50;padding-bottom:10px;}table{width:100%;border-collapse:collapse;}</style></head><body><div class='container'><h2>{$l['title']}</h2><table>{$rows}</table><p style='margin-top:20px;color:#666;font-size:12px;'>Sent from DB Digital Agency website</p></div></body></html>";
}

function buildWhatsAppMessage($data, $lang) {
    $intro = ($lang == 'fr') 
        ? "Bonjour DB Digital Agency, je souhaiterais un devis pour le projet suivant :" 
        : "Hello DB Digital Agency, I would like a quote for the following project:";
    $l = ($lang == 'fr') ? [
        'service' => 'Service', 'subject' => 'Sujet', 'type' => 'Type', 'budget' => 'Budget',
        'start' => 'Début', 'website' => 'Site', 'message' => 'Message', 'name' => 'Nom',
        'company' => 'Entreprise', 'email' => 'Email', 'whatsapp' => 'WhatsApp'
    ] : [
        'service' => 'Service', 'subject' => 'Subject', 'type' => 'Type', 'budget' => 'Budget',
        'start' => 'Start', 'website' => 'Website', 'message' => 'Message', 'name' => 'Name',
        'company' => 'Company', 'email' => 'Email', 'whatsapp' => 'WhatsApp'
    ];

    $lines = [$intro, ""];
    foreach (['service','subject','type','budget','start'] as $k) {
        if (!empty($data[$k])) $lines[] = "• {$l[$k]}: {$data[$k]}";
    }
    if (!empty($data['website'])) $lines[] = "• {$l['website']}: {$data['website']}";
    if (!empty($data['message'])) $lines[] = "• {$l['message']}: {$data['message']}";
    $lines[] = "";
    $lines[] = "---";
    $lines[] = "• {$l['name']}: {$data['fullname']}";
    if (!empty($data['company'])) $lines[] = "• {$l['company']}: {$data['company']}";
    $lines[] = "• {$l['email']}: {$data['email']}";
    $lines[] = "• {$l['whatsapp']}: {$data['whatsapp']}";
    return implode("\n", $lines);
}