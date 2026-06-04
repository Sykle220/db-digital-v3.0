<?php
/**
 * components/contact-form.php
 * Formulaire de contact — carte premium, champs avec icônes, envoi AJAX.
 */
$csrf_token = $_SESSION['csrf_token'];
?>

<div class="contact-form-pro contact-form">
    <div class="cf-card">
        <header class="cf-header">
            <span class="cf-eyebrow"><?php echo __('contact_form_eyebrow'); ?></span>
            <h3 class="cf-title"><?php echo __('contact_form_title'); ?></h3>
            <p class="cf-lead"><?php echo __('contact_form_subtitle'); ?></p>
        </header>

        <form id="contact-form" action="includes/process-contact.php" method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <input type="text" name="company_website" class="cf-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">

            <div class="cf-grid">
                <div class="cf-field">
                    <label class="cf-label" for="cf-name"><?php echo __('contact_form_name_label'); ?></label>
                    <div class="cf-input-wrap">
                        <i class="fas fa-user" aria-hidden="true"></i>
                        <input type="text" id="cf-name" name="name" placeholder="<?php echo __('contact_form_name_placeholder'); ?>" required autocomplete="name">
                    </div>
                </div>
                <div class="cf-field">
                    <label class="cf-label" for="cf-phone"><?php echo __('contact_form_phone_label'); ?></label>
                    <div class="cf-input-wrap">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <input type="tel" id="cf-phone" name="phone" placeholder="<?php echo __('contact_form_phone_placeholder'); ?>" required autocomplete="tel">
                    </div>
                </div>
                <div class="cf-field cf-field--full">
                    <label class="cf-label" for="cf-email"><?php echo __('contact_form_email_label'); ?></label>
                    <div class="cf-input-wrap">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <input type="email" id="cf-email" name="email" placeholder="<?php echo __('contact_form_email_placeholder'); ?>" required autocomplete="email">
                    </div>
                </div>
                <div class="cf-field cf-field--full">
                    <label class="cf-label" for="cf-message"><?php echo __('contact_form_message_label'); ?></label>
                    <div class="cf-input-wrap cf-input-wrap--textarea">
                        <i class="fas fa-comment-dots" aria-hidden="true"></i>
                        <textarea id="cf-message" name="message" rows="5" placeholder="<?php echo __('contact_form_message_placeholder'); ?>" required></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="cf-submit">
                <span><?php echo __('contact_form_submit'); ?></span>
                <?php echo btnIcon('send'); ?>
            </button>

            <ul class="cf-trust" aria-label="<?php echo $current_lang === 'fr' ? 'Engagements' : 'Commitments'; ?>">
                <li><i class="fas fa-bolt" aria-hidden="true"></i> <?php echo __('contact_form_trust_response'); ?></li>
                <li><i class="fas fa-shield-alt" aria-hidden="true"></i> <?php echo __('footer_no_spam'); ?></li>
            </ul>

            <div class="ajax-response" role="status" aria-live="polite"></div>
        </form>
    </div>
</div>
