<?php
// get-quote.php
require_once 'includes/functions.php';
$page_title = __('quote_title');
$page_description = __('meta_default_description');
include 'includes/head.php';
include 'includes/header.php';

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Récupération des erreurs/succès
$quote_errors       = $_SESSION['quote_errors'] ?? [];
$quote_success      = $_SESSION['quote_success'] ?? false;
$quote_email_ok     = $_SESSION['quote_email_ok'] ?? false;
$quote_whatsapp_url = $_SESSION['quote_whatsapp_url'] ?? '';
$quote_form_data    = $_SESSION['quote_form_data'] ?? [];

// Nettoyage session
unset($_SESSION['quote_errors'], $_SESSION['quote_success'], $_SESSION['quote_email_ok'], $_SESSION['quote_whatsapp_url'], $_SESSION['quote_form_data']);
?>

<main class="fix">

    <?php 
    $breadcrumb_title = __('quote_title');
    include 'components/breadcrumb.php'; 
    ?>

    <!-- quote-info-area -->
    <section class="quote-info-area pt-50 pb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="title mb-30"><?php echo __('quote_innovation_title'); ?></h3>
                    <p class="mb-30"><?php echo __('quote_innovation_desc'); ?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- quote-info-area-end -->

    <!-- Alert Messages -->
    <?php if (!empty($quote_errors)): ?>
    <section class="pb-20">
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle"></i> <?php echo ($current_lang == 'fr') ? 'Erreur !' : 'Error!'; ?></strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($quote_errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($quote_success): ?>
    <!-- SUCCESS PANEL : Email + WhatsApp -->
    <section class="pb-20">
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-check-circle"></i> <?php echo ($current_lang == 'fr') ? 'Demande envoyée !' : 'Request sent!'; ?></strong>
                <p class="mb-0 mt-2">
                    <?php if ($quote_email_ok): ?>
                        <i class="fas fa-envelope text-success"></i>
                        <?php echo ($current_lang == 'fr') ? 'Votre demande a été envoyée par email. ' : 'Your request has been sent by email. '; ?>
                    <?php else: ?>
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        <?php echo ($current_lang == 'fr') ? "L'email n'a pas pu être envoyé, mais " : 'Email could not be sent, but '; ?>
                    <?php endif; ?>
                    <?php echo ($current_lang == 'fr') ? 'cliquez ci-dessous pour ouvrir WhatsApp et finaliser votre demande.' : 'click below to open WhatsApp and finalize your request.'; ?>
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- WhatsApp Success Card -->
            <div class="whatsapp-success-card text-center">
                <div class="whatsapp-icon"><i class="fab fa-whatsapp"></i></div>
                <h4><?php echo ($current_lang == 'fr') ? 'Finalisez sur WhatsApp' : 'Finalize on WhatsApp'; ?></h4>
                <p class="mb-4">
                    <?php echo ($current_lang == 'fr')
                        ? 'Votre message est pré-rempli avec les détails de votre projet. Cliquez pour envoyer.'
                        : 'Your message is pre-filled with your project details. Click to send.'; ?>
                </p>
                <a href="<?php echo $quote_whatsapp_url; ?>" class="btn btn-whatsapp-lg btn-has-i" target="_blank" id="waBtn">
                    <?php echo btnIcon('whatsapp'); ?>
                    <?php echo ($current_lang == 'fr') ? 'Ouvrir WhatsApp' : 'Open WhatsApp'; ?>
                </a>
                <p class="auto-redirect-text mt-3">
                    <small><i class="fas fa-clock"></i>
                        <?php echo ($current_lang == 'fr') ? 'Redirection automatique dans 3 secondes...' : 'Auto-redirecting in 3 seconds...'; ?>
                    </small>
                </p>
            </div>
        </div>
    </section>

    <script>
        setTimeout(function() {
            var waBtn = document.getElementById('waBtn');
            if (waBtn) waBtn.click();
        }, 3000);
    </script>
    <?php endif; ?>

    <!-- quote-form-area -->
    <section class="quote-form-area pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="quote-wizard-wrap">
                        <div class="wizard-shell">

                            <div class="wiz-header">
                                <div class="wiz-header-top">
                                    <span class="wiz-badge"><?php echo __('quote_title'); ?></span>
                                    <span class="wiz-est"><i class="far fa-clock"></i> ~3 min</span>
                                </div>
                                <div class="steps-track">
                                    <div class="step-item active" data-step="1">
                                        <div class="step-inner">
                                            <span class="step-num">1</span>
                                            <span class="step-lbl"><?php echo __('quote_step_service'); ?></span>
                                        </div>
                                    </div>
                                    <div class="step-item" data-step="2">
                                        <div class="step-inner">
                                            <span class="step-num">2</span>
                                            <span class="step-lbl"><?php echo __('quote_step_project'); ?></span>
                                        </div>
                                    </div>
                                    <div class="step-item" data-step="3">
                                        <div class="step-inner">
                                            <span class="step-num">3</span>
                                            <span class="step-lbl"><?php echo __('quote_step_contact'); ?></span>
                                        </div>
                                    </div>
                                    <div class="step-item" data-step="4">
                                        <div class="step-inner">
                                            <span class="step-num">4</span>
                                            <span class="step-lbl"><?php echo __('quote_step_review'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="wiz-body">
                                <form action="process-quote.php" method="POST" enctype="multipart/form-data" id="quoteForm">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                                    <input type="text" name="company_website" value="" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;height:0;width:0;opacity:0" aria-hidden="true">

                                    <!-- Step 1 : Service -->
                                    <div class="step-panel active" data-step="1">
                                        <p class="step-title"><?php echo __('quote_service_label'); ?></p>
                                        <p class="step-desc"><?php echo __('quote_select_service_desc'); ?></p>

                                        <div class="field field-services">
                                            <div class="service-cards-wrap" id="fw-services">
                                                <div class="service-cards" id="svcCards">
                                            <?php
                                            $services = [
                                                ['digital-strategy', 'fa-bullseye', '#534AB7', 'rgba(83,74,183,0.1)', __('quote_svc_strategy_title'), __('quote_svc_strategy_sub')],
                                                ['web-development', 'fa-code', '#185FA5', 'rgba(56,135,221,0.1)', __('quote_svc_web_title'), __('quote_svc_web_sub')],
                                                ['branding', 'fa-palette', '#534AB7', 'rgba(83,74,183,0.1)', __('quote_svc_brand_title'), __('quote_svc_brand_sub')],
                                                ['marketing', 'fa-chart-line', '#1D9E75', 'rgba(29,158,117,0.1)', __('quote_svc_marketing_title'), __('quote_svc_marketing_sub')],
                                            ];
                                            $selected_services = [];
                                            if (!empty($quote_form_data['services'])) {
                                                $selected_services = is_array($quote_form_data['services']) ? $quote_form_data['services'] : [$quote_form_data['services']];
                                            }
                                            foreach ($services as $svc):
                                                $val = $svc[0];
                                                $isChecked = in_array($val, $selected_services) ? 'checked' : '';
                                                $sel_class = in_array($val, $selected_services) ? 'sel' : '';
                                            ?>
                                            <label class="svc-card <?php echo $sel_class; ?>">
                                                <input type="checkbox" name="services[]" value="<?php echo $val; ?>" <?php echo $isChecked; ?> class="svc-checkbox">
                                                <div class="svc-icon" style="background:<?php echo $svc[3]; ?>;color:<?php echo $svc[2]; ?>">
                                                    <i class="fas <?php echo $svc[1]; ?>"></i>
                                                </div>
                                                <div class="svc-body">
                                                    <p><?php echo $svc[4]; ?></p>
                                                    <span><?php echo $svc[5]; ?></span>
                                                </div>
                                                <i class="fas fa-check svc-check"></i>
                                            </label>
                                            <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <span class="field-err"><?php echo __('quote_validation_select_service'); ?></span>
                                        </div>

                                        <div style="margin-top:16px">
                                            <div class="field">
                                                <label><?php echo __('quote_subject_label'); ?><span class="req">*</span></label>
                                                <div class="field-wrap" id="fw-subject">
                                                    <i class="fas fa-heading"></i>
                                                    <input type="text" name="subject" id="f-subject" placeholder="<?php echo __('quote_placeholder_subject'); ?>" value="<?php echo htmlspecialchars($quote_form_data['subject'] ?? ''); ?>" required>
                                                </div>
                                                <span class="field-err"><?php echo __('quote_validation_required'); ?></span>
                                            </div>
                                        </div>

                                        <div class="step-actions">
                                            <span class="step-progress-txt"><?php echo __('quote_step_of'); ?> 1 <?php echo __('quote_step_of_total'); ?> 4</span>
                                            <div class="btns">
                                                <button type="button" class="qw-btn qw-btn-primary next-step"><?php echo __('quote_continue'); ?> <i class="fas fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 2 : Project -->
                                    <div class="step-panel" data-step="2">
                                        <p class="step-title"><?php echo __('quote_project_details_title'); ?></p>
                                        <p class="step-desc"><?php echo __('quote_project_details_desc'); ?></p>

                                        <div class="field-grid">
                                            <div class="field">
                                                <label><?php echo __('quote_type_label'); ?><span class="req">*</span></label>
                                                <div class="field-wrap" id="fw-type">
                                                    <i class="fas fa-shapes"></i>
                                                    <select name="project_type" id="f-type" required>
                                                        <option value="">-- <?php echo __('quote_type_label'); ?> --</option>
                                                        <option value="new-project" <?php echo ($quote_form_data['project_type'] ?? '') == 'new-project' ? 'selected' : ''; ?>><?php echo __('quote_type_new'); ?></option>
                                                        <option value="redesign" <?php echo ($quote_form_data['project_type'] ?? '') == 'redesign' ? 'selected' : ''; ?>><?php echo __('quote_type_redesign'); ?></option>
                                                        <option value="maintenance" <?php echo ($quote_form_data['project_type'] ?? '') == 'maintenance' ? 'selected' : ''; ?>><?php echo __('quote_type_maintenance'); ?></option>
                                                        <option value="consulting" <?php echo ($quote_form_data['project_type'] ?? '') == 'consulting' ? 'selected' : ''; ?>><?php echo __('quote_type_consulting'); ?></option>
                                                    </select>
                                                </div>
                                                <span class="field-err"><?php echo __('quote_validation_required'); ?></span>
                                            </div>
                                            <div class="field">
                                                <label><?php echo __('quote_budget_label'); ?><span class="req">*</span></label>
                                                <div class="field-wrap" id="fw-budget">
                                                    <i class="fas fa-coins"></i>
                                                    <select name="budget" id="f-budget" required>
                                                        <option value="">-- <?php echo __('quote_budget_label'); ?> --</option>
                                                        <option value="500-1000" <?php echo ($quote_form_data['budget'] ?? '') == '500-1000' ? 'selected' : ''; ?>>500 000 - 1 000 000 FCFA</option>
                                                        <option value="1000-3000" <?php echo ($quote_form_data['budget'] ?? '') == '1000-3000' ? 'selected' : ''; ?>>1 000 000 - 3 000 000 FCFA</option>
                                                        <option value="3000-5000" <?php echo ($quote_form_data['budget'] ?? '') == '3000-5000' ? 'selected' : ''; ?>>3 000 000 - 5 000 000 FCFA</option>
                                                        <option value="5000+" <?php echo ($quote_form_data['budget'] ?? '') == '5000+' ? 'selected' : ''; ?>>5 000 000+ FCFA</option>
                                                    </select>
                                                </div>
                                                <span class="field-err"><?php echo __('quote_validation_required'); ?></span>
                                            </div>
                                            <div class="field">
                                                <label><?php echo __('quote_start_label'); ?><span class="req">*</span></label>
                                                <div class="field-wrap" id="fw-start">
                                                    <i class="fas fa-calendar"></i>
                                                    <select name="start_date" id="f-start" required>
                                                        <option value="">-- <?php echo __('quote_start_label'); ?> --</option>
                                                        <option value="immediately" <?php echo ($quote_form_data['start_date'] ?? '') == 'immediately' ? 'selected' : ''; ?>><?php echo __('quote_start_immediately'); ?></option>
                                                        <option value="1-week" <?php echo ($quote_form_data['start_date'] ?? '') == '1-week' ? 'selected' : ''; ?>><?php echo __('quote_start_1_week'); ?></option>
                                                        <option value="1-month" <?php echo ($quote_form_data['start_date'] ?? '') == '1-month' ? 'selected' : ''; ?>><?php echo __('quote_start_1_month'); ?></option>
                                                        <option value="flexible" <?php echo ($quote_form_data['start_date'] ?? '') == 'flexible' ? 'selected' : ''; ?>><?php echo __('quote_start_flexible'); ?></option>
                                                    </select>
                                                </div>
                                                <span class="field-err"><?php echo __('quote_validation_required'); ?></span>
                                            </div>
                                            <div class="field">
                                                <label>Website <span class="opt">(<?php echo __('quote_optional'); ?>)</span></label>
                                                <div class="field-wrap">
                                                    <i class="fas fa-globe"></i>
                                                    <input type="url" name="website" id="f-website" placeholder="https://..." value="<?php echo htmlspecialchars($quote_form_data['website'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="field field-full">
                                                <label><?php echo __('quote_message_label'); ?> <span class="opt">(<?php echo __('quote_optional'); ?>)</span></label>
                                                <div class="field-wrap ta-wrap">
                                                    <i class="fas fa-comment"></i>
                                                    <textarea name="message" id="f-message" placeholder="<?php echo __('quote_placeholder_message'); ?>" rows="4"><?php echo htmlspecialchars($quote_form_data['message'] ?? ''); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="field field-full">
                                                <label><?php echo __('quote_brief_label'); ?> <span class="opt">(<?php echo __('quote_optional'); ?>)</span></label>
                                                <label class="file-btn-wrap" for="f-brief">
                                                    <input type="file" name="project_brief" id="f-brief" accept=".pdf,.doc,.docx">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <span class="file-name" id="brief-name"><?php echo __('quote_file_none'); ?></span>
                                                    <span class="file-badge">PDF / DOCX</span>
                                                </label>
                                                <span style="font-size:11px;color:var(--qw-sub)"><i class="fas fa-info-circle"></i> <?php echo __('quote_file_hint'); ?></span>
                                            </div>
                                        </div>

                                        <div class="step-actions">
                                            <span class="step-progress-txt"><?php echo __('quote_step_of'); ?> 2 <?php echo __('quote_step_of_total'); ?> 4</span>
                                            <div class="btns">
                                                <button type="button" class="qw-btn qw-btn-ghost prev-step"><i class="fas fa-arrow-left"></i> <?php echo __('quote_back'); ?></button>
                                                <button type="button" class="qw-btn qw-btn-primary next-step"><?php echo __('quote_continue'); ?> <i class="fas fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 3 : Contact -->
                                    <div class="step-panel" data-step="3">
                                        <p class="step-title"><?php echo __('quote_contact_details_title'); ?></p>
                                        <p class="step-desc"><?php echo __('quote_contact_details_desc'); ?></p>

                                        <div class="field-grid">
                                            <div class="field">
                                                <label><?php echo __('quote_fullname_label'); ?><span class="req">*</span></label>
                                                <div class="field-wrap" id="fw-name">
                                                    <i class="fas fa-user"></i>
                                                    <input type="text" name="fullname" id="f-name" placeholder="<?php echo __('quote_placeholder_fullname'); ?>" value="<?php echo htmlspecialchars($quote_form_data['fullname'] ?? ''); ?>" required>
                                                </div>
                                                <span class="field-err"><?php echo __('quote_validation_required'); ?></span>
                                            </div>
                                            <div class="field">
                                                <label><?php echo __('quote_company_label'); ?> <span class="opt">(<?php echo __('quote_optional'); ?>)</span></label>
                                                <div class="field-wrap">
                                                    <i class="fas fa-building"></i>
                                                    <input type="text" name="company" id="f-company" placeholder="<?php echo __('quote_placeholder_company'); ?>" value="<?php echo htmlspecialchars($quote_form_data['company'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label><?php echo __('quote_email_label'); ?><span class="req">*</span></label>
                                                <div class="field-wrap" id="fw-email">
                                                    <i class="fas fa-envelope"></i>
                                                    <input type="email" name="email" id="f-email" placeholder="<?php echo __('quote_placeholder_email'); ?>" value="<?php echo htmlspecialchars($quote_form_data['email'] ?? ''); ?>" required>
                                                </div>
                                                <span class="field-err"><?php echo __('quote_validation_email'); ?></span>
                                            </div>
                                            <div class="field">
                                                <label><?php echo __('quote_whatsapp_label'); ?><span class="req">*</span></label>
                                                <div class="field-wrap" id="fw-phone">
                                                    <i class="fab fa-whatsapp"></i>
                                                    <input type="tel" name="whatsapp" id="f-phone" placeholder="<?php echo __('quote_placeholder_whatsapp'); ?>" value="<?php echo htmlspecialchars($quote_form_data['whatsapp'] ?? ''); ?>" required>
                                                </div>
                                                <span class="field-err"><?php echo __('quote_validation_required'); ?></span>
                                            </div>
                                        </div>

                                        <div class="step-actions">
                                            <span class="step-progress-txt"><?php echo __('quote_step_of'); ?> 3 <?php echo __('quote_step_of_total'); ?> 4</span>
                                            <div class="btns">
                                                <button type="button" class="qw-btn qw-btn-ghost prev-step"><i class="fas fa-arrow-left"></i> <?php echo __('quote_back'); ?></button>
                                                <button type="button" class="qw-btn qw-btn-primary next-step"><?php echo __('quote_review_title'); ?> <i class="fas fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 4 : Review + Submit (Email + WhatsApp auto) -->
                                    <div class="step-panel" data-step="4">
                                        <p class="step-title"><?php echo __('quote_review_send_title'); ?></p>
                                        <p class="step-desc"><?php echo __('quote_review_send_desc'); ?></p>

                                        <div class="review-grid">
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fas fa-briefcase"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_service_label'); ?></p>
                                                    <p class="review-val" id="rev-service">—</p>
                                                </div>
                                            </div>
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fas fa-heading"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_subject_label'); ?></p>
                                                    <p class="review-val" id="rev-subject">—</p>
                                                </div>
                                            </div>
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fas fa-shapes"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_type_label'); ?></p>
                                                    <p class="review-val" id="rev-type">—</p>
                                                </div>
                                            </div>
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fas fa-coins"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_budget_label'); ?></p>
                                                    <p class="review-val" id="rev-budget">—</p>
                                                </div>
                                            </div>
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fas fa-calendar"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_start_label'); ?></p>
                                                    <p class="review-val" id="rev-start">—</p>
                                                </div>
                                            </div>
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fas fa-user"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_fullname_label'); ?></p>
                                                    <p class="review-val" id="rev-name">—</p>
                                                </div>
                                            </div>
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fas fa-envelope"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_email_label'); ?></p>
                                                    <p class="review-val" id="rev-email">—</p>
                                                </div>
                                            </div>
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fab fa-whatsapp"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_whatsapp_label'); ?></p>
                                                    <p class="review-val" id="rev-whatsapp">—</p>
                                                </div>
                                            </div>
                                            <div class="review-row">
                                                <div class="review-icon"><i class="fas fa-paperclip"></i></div>
                                                <div class="review-body">
                                                    <p class="review-lbl"><?php echo __('quote_brief_label'); ?></p>
                                                    <p class="review-val empty" id="rev-file"><?php echo __('quote_file_none'); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Info : les deux partent ensemble -->
                                        <div class="submit-info-box mt-4 mb-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="submit-icon"><i class="fas fa-paper-plane"></i></div>
                                                <div>
                                                    <h6 class="mb-1"><?php echo __('quote_send_both_title'); ?></h6>
                                                    <p class="mb-0 text-muted"><?php echo __('quote_send_both_desc'); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="step-actions">
                                            <span class="step-progress-txt"><?php echo __('quote_step_of'); ?> 4 <?php echo __('quote_step_of_total'); ?> 4</span>
                                            <div class="btns">
                                                <button type="button" class="qw-btn qw-btn-ghost prev-step"><i class="fas fa-arrow-left"></i> <?php echo __('quote_back'); ?></button>
                                                <button type="submit" class="qw-btn qw-btn-primary">
                                                    <i class="fas fa-paper-plane"></i> <?php echo __('quote_send_request'); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- quote-form-area-end -->

    <!-- contact-card-area -->
    <?php include 'components/contact-card.php'; ?>
    <!-- contact-card-area-end -->

    <!-- contact-map -->
    <?php include 'components/locations-map.php'; ?>
    <!-- contact-map-end -->

</main>

<?php include 'includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quoteForm');
    const I18N = {
        fileNone: <?php echo json_encode(__('quote_file_none')); ?>,
    };
    const steps = document.querySelectorAll('.step-item');
    const contents = document.querySelectorAll('.step-panel');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    let currentStep = 1;

    function showStep(n) {
        steps.forEach(s => s.classList.remove('active', 'done'));
        contents.forEach(c => c.classList.remove('active'));

        steps.forEach((s, i) => {
            if (i + 1 < n) s.classList.add('done');
            if (i + 1 === n) s.classList.add('active');
        });
        document.querySelector('.step-panel[data-step="' + n + '"]').classList.add('active');

        if (n === 4) updateReview();
        const wrap = document.querySelector('.wizard-shell');
        if (wrap) {
            const y = wrap.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({ top: y, behavior: 'smooth' });
        }
    }

    function updateReview() {
        const getVal = (name) => {
            const el = form.querySelector('[name="' + name + '"]');
            return el ? (el.value || '—') : '—';
        };
        const getSelectText = (name) => {
            const el = form.querySelector('[name="' + name + '"]');
            return el ? (el.options[el.selectedIndex].text || '—') : '—';
        };
        const getServiceText = () => {
            const checked = form.querySelectorAll('input[name="services[]"]:checked');
            if (checked.length === 0) return '—';
            const services = [];
            checked.forEach(cb => {
                const card = cb.closest('.svc-card');
                if (card) services.push(card.querySelector('.svc-body p').textContent);
            });
            return services.length > 0 ? services.join(', ') : '—';
        };

        document.getElementById('rev-service').textContent = getServiceText();
        document.getElementById('rev-subject').textContent = getVal('subject');
        document.getElementById('rev-type').textContent = getSelectText('project_type');
        document.getElementById('rev-budget').textContent = getSelectText('budget');
        document.getElementById('rev-start').textContent = getSelectText('start_date');
        document.getElementById('rev-name').textContent = getVal('fullname');
        document.getElementById('rev-email').textContent = getVal('email');
        document.getElementById('rev-whatsapp').textContent = getVal('whatsapp');

        const fileInput = form.querySelector('[name="project_brief"]');
        const revFile = document.getElementById('rev-file');
        if (fileInput && fileInput.files.length > 0) {
            revFile.textContent = fileInput.files[0].name;
            revFile.classList.remove('empty');
        } else {
            revFile.textContent = I18N.fileNone;
            revFile.classList.add('empty');
        }
    }

    function validateStep(step) {
        let valid = true;
        const panel = document.querySelector('.step-panel[data-step="' + step + '"]');
        if (!panel) return false;

        if (step === 1) {
            const checkedServices = form.querySelectorAll('input[name="services[]"]:checked');
            const servicesWrap = document.getElementById('fw-services');
            if (checkedServices.length === 0) {
                valid = false;
                if (servicesWrap) servicesWrap.classList.add('invalid');
            } else if (servicesWrap) {
                servicesWrap.classList.remove('invalid');
            }
        }

        const requiredFields = panel.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            const wrap = field.closest('.field-wrap');
            if (!field.value.trim()) {
                valid = false;
                if (wrap) wrap.classList.add('invalid');
                else field.classList.add('is-invalid');
            } else {
                if (wrap) wrap.classList.remove('invalid');
                else field.classList.remove('is-invalid');
            }
            if (field.type === 'email' && field.value.trim() && !/\S+@\S+\.\S+/.test(field.value.trim())) {
                valid = false;
                if (wrap) wrap.classList.add('invalid');
            }
        });
        return valid;
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (!validateStep(currentStep)) return;
            if (currentStep < 4) { currentStep++; showStep(currentStep); }
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep > 1) { currentStep--; showStep(currentStep); }
        });
    });

    form.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', function() {
            const wrap = this.closest('.field-wrap');
            if (wrap) wrap.classList.remove('invalid');
            this.classList.remove('is-invalid');
        });
    });

    // Service cards selection (multiselect with dynamic check icon)
    function updateCardState(card, checkbox, icon) {
        if (checkbox.checked) {
            card.classList.add('sel');
            if (icon) icon.style.display = 'block';
        } else {
            card.classList.remove('sel');
            if (icon) icon.style.display = 'none';
        }
        const servicesWrap = document.getElementById('fw-services');
        if (servicesWrap && form.querySelectorAll('input[name="services[]"]:checked').length > 0) {
            servicesWrap.classList.remove('invalid');
        }
    }

    document.querySelectorAll('.svc-card').forEach(card => {
        const checkbox = card.querySelector('input[type="checkbox"]');
        const checkIcon = card.querySelector('.svc-check');
        
        card.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            checkbox.checked = !checkbox.checked;
            updateCardState(card, checkbox, checkIcon);
        });
        
        checkbox.addEventListener('change', function(e) {
            e.stopPropagation();
            updateCardState(card, checkbox, checkIcon);
        });
        
        // Initialize check icon visibility
        if (checkIcon) checkIcon.style.display = checkbox.checked ? 'block' : 'none';
    });

    // File input label update
    document.getElementById('f-brief').addEventListener('change', function() {
        const name = this.files[0] ? this.files[0].name : I18N.fileNone;
        document.getElementById('brief-name').textContent = name;
    });

    // Locations -> Map switcher
    const mapFrame = document.getElementById('locationsMap');
    const locCards = document.querySelectorAll('.location-card');
    if (mapFrame && locCards.length) {
        locCards.forEach((btn) => {
            btn.addEventListener('click', () => {
                const src = btn.getAttribute('data-map-src');
                if (!src) return;
                locCards.forEach((b) => b.classList.remove('active'));
                btn.classList.add('active');
                mapFrame.setAttribute('src', src);
            });
        });
    }
});
</script>