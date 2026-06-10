<script>
window.SITE_TRACKING = <?= json_encode([
    'enabled'    => (bool) ($integrations['tracking_enabled'] ?? false),
    'gtm'        => (string) ($integrations['gtm_container_id'] ?? ''),
    'ga4'        => (string) ($integrations['ga4_measurement_id'] ?? ''),
    'metaPixel'  => (string) ($integrations['meta_pixel_id'] ?? ''),
    'linkedin'   => (string) ($integrations['linkedin_partner_id'] ?? ''),
    'hotjar'     => (string) ($integrations['hotjar_site_id'] ?? ''),
    'clarity'    => (string) ($integrations['clarity_project_id'] ?? ''),
    'locale'     => $locale ?? 'fr',
], JSON_UNESCAPED_UNICODE) ?>;
window.RECAPTCHA_SITE_KEY = <?= json_encode($recaptchaOn ? ($recaptchaSiteKey ?? '') : '') ?>;
</script>
<?php if (! empty($recaptchaOn) && ! empty($recaptchaSiteKey)): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= esc($recaptchaSiteKey, 'attr') ?>" defer></script>
<?php endif; ?>
