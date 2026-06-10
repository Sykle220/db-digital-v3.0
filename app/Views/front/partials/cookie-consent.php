<?php if (! ($integrations['cookie_banner_enabled'] ?? false)): ?>
<?php return; ?>
<?php endif; ?>
<?php
$text = $locale === 'fr'
    ? ($integrations['cookie_policy_text_fr'] ?? 'Nous utilisons des cookies pour améliorer votre expérience et mesurer l\'audience.')
    : ($integrations['cookie_policy_text_en'] ?? 'We use cookies to improve your experience and measure traffic.');
if ($text === '') {
    $text = $locale === 'fr'
        ? 'Nous utilisons des cookies pour améliorer votre expérience et mesurer l\'audience.'
        : 'We use cookies to improve your experience and measure traffic.';
}
$privacySlug = $locale === 'fr'
    ? ($integrations['privacy_page_slug_fr'] ?? 'politique-confidentialite')
    : ($integrations['privacy_page_slug_en'] ?? 'privacy-policy');
$privacyUrl = site_url($locale . '/' . ltrim($privacySlug, '/'));
$title = $locale === 'fr' ? 'Nous respectons votre vie privée' : 'We respect your privacy';
?>
<div id="cookie-consent" class="cookie-consent" role="dialog" aria-labelledby="cookie-consent-title" aria-describedby="cookie-consent-desc" hidden>
    <div class="cookie-consent__bar">
        <div class="container custom-container-seven">
            <div class="cookie-consent__inner">
                <div class="cookie-consent__content">
                    <span class="cookie-consent__icon" aria-hidden="true"><i class="fas fa-cookie-bite"></i></span>
                    <div class="cookie-consent__copy">
                        <p id="cookie-consent-title" class="cookie-consent__title"><?= esc($title) ?></p>
                        <p id="cookie-consent-desc" class="cookie-consent__text">
                            <?= esc($text) ?>
                            <a href="<?= esc($privacyUrl, 'attr') ?>"><?= esc($locale === 'fr' ? 'En savoir plus' : 'Learn more') ?></a>
                        </p>
                    </div>
                </div>
                <div class="cookie-consent__actions">
                    <button type="button" class="btn transparent-btn-two cookie-consent__btn" data-consent="reject">
                        <?= esc($locale === 'fr' ? 'Refuser' : 'Reject') ?>
                    </button>
                    <button type="button" class="btn btn-three cookie-consent__btn" data-consent="accept">
                        <?= esc($locale === 'fr' ? 'Accepter' : 'Accept') ?>
                    </button>
                </div>
                <button type="button" class="cookie-consent__close" data-consent="dismiss" aria-label="<?= esc($locale === 'fr' ? 'Fermer' : 'Close') ?>">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>
