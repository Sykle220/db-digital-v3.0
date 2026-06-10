<?php
$page        = $page ?? [];
$locale      = $locale ?? service('request')->getLocale();
$integrations = $integrations ?? service('siteSettings')->integrations();
$legalType   = (string) ($legalType ?? 'legal');
$isPrivacy   = $legalType === 'privacy';

$legalSlug   = $locale === 'fr' ? ($integrations['legal_page_slug_fr'] ?? 'mentions-legales') : ($integrations['legal_page_slug_en'] ?? 'legal-notice');
$privacySlug = $locale === 'fr' ? ($integrations['privacy_page_slug_fr'] ?? 'politique-confidentialite') : ($integrations['privacy_page_slug_en'] ?? 'privacy-policy');

$relatedUrl   = $isPrivacy
    ? site_url($locale . '/' . ltrim($legalSlug, '/'))
    : site_url($locale . '/' . ltrim($privacySlug, '/'));
$relatedLabel = $isPrivacy
    ? ($locale === 'fr' ? 'Mentions légales' : 'Legal notice')
    : ($locale === 'fr' ? 'Politique de confidentialité' : 'Privacy policy');

$content = (string) ($page['content'] ?? '');
$excerpt = (string) ($page['excerpt'] ?? '');
$updated = ! empty($page['published_at'])
    ? date($locale === 'fr' ? 'd/m/Y' : 'M j, Y', strtotime((string) $page['published_at']))
    : date($locale === 'fr' ? 'd/m/Y' : 'M j, Y');
?>
<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="legal-page pt-50 pb-80">
        <div class="container">
            <div class="row justify-content-center mb-40">
                <div class="col-lg-10">
                    <div class="section-title-two text-center tg-heading-subheading animation-style2">
                        <span class="sub-title tg-element-title span1">
                            <?= esc($locale === 'fr' ? 'Informations légales' : 'Legal information') ?>
                        </span>
                        <h1 class="title tg-element-title mb-3"><?= esc((string) ($page['title'] ?? '')) ?></h1>
                        <?php if ($excerpt !== ''): ?>
                        <p class="legal-page__lead"><?= esc($excerpt) ?></p>
                        <?php endif; ?>
                        <p class="legal-page__updated">
                            <i class="far fa-clock" aria-hidden="true"></i>
                            <?= esc($locale === 'fr' ? 'Mis à jour le ' : 'Updated on ') ?><?= esc($updated) ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-lg-10">
                    <div class="legal-page__card">
                        <article class="legal-prose cms-page-content">
                            <?= $content ?>
                        </article>

                        <aside class="legal-page__aside" aria-label="<?= esc($locale === 'fr' ? 'Documents associés' : 'Related documents') ?>">
                            <div class="legal-page__related">
                                <h2 class="legal-page__related-title">
                                    <?= esc($locale === 'fr' ? 'Voir aussi' : 'See also') ?>
                                </h2>
                                <a href="<?= esc($relatedUrl, 'attr') ?>" class="legal-page__related-link">
                                    <i class="fas fa-file-alt" aria-hidden="true"></i>
                                    <?= esc($relatedLabel) ?>
                                </a>
                                <a href="<?= page_url('contact', $locale) ?>" class="legal-page__related-link">
                                    <i class="fas fa-envelope" aria-hidden="true"></i>
                                    <?= esc($locale === 'fr' ? 'Nous contacter' : 'Contact us') ?>
                                </a>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>
