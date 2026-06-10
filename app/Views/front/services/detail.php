<?php
$accordionId = 'serviceFaq-' . preg_replace('/[^a-z0-9-]/', '', (string) ($service['slug'] ?? 'service'));
$detailImage = (string) ($service['detail_image'] ?? $service['image'] ?? 'services_details01.jpg');
?>
<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix svc-detail-page">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="svc-detail-area" aria-labelledby="svc-detail-title">
        <div class="container">
            <header class="svc-detail-head">
                <a href="<?= page_url('services', $locale) ?>" class="svc-detail-back">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    <?= esc(site_trans('services_details_back', $locale)) ?>
                </a>
                <span class="svc-detail-eyebrow"><?= esc(site_trans('services_block_subtitle', $locale)) ?></span>
                <div class="svc-detail-head-row">
                    <div class="svc-detail-icon" aria-hidden="true"><i class="<?= esc($service['icon'] ?? '', 'attr') ?>"></i></div>
                    <div class="svc-detail-head-copy">
                        <h1 id="svc-detail-title" class="svc-detail-title"><?= esc(lang_field($service, 'title', $locale)) ?></h1>
                        <p class="svc-detail-lead"><?= esc(lang_field($service, 'intro', $locale)) ?></p>
                    </div>
                </div>
            </header>

            <div class="svc-detail-grid" id="svcDetailGrid">
                <article class="svc-detail-main">
                    <div class="svc-detail-card">
                        <figure class="svc-detail-figure">
                            <img src="<?= asset_url('img/services/' . ltrim($detailImage, '/')) ?>" alt="<?= esc(lang_field($service, 'title', $locale)) ?>" loading="lazy" decoding="async">
                        </figure>
                        <div class="svc-detail-body">
                            <p><?= esc(lang_field($service, 'body', $locale)) ?></p>
                        </div>
                        <div class="svc-detail-callout">
                            <h2 class="svc-detail-callout-title"><?= esc(lang_field($service, 'highlight_title', $locale)) ?></h2>
                            <p><?= esc(lang_field($service, 'highlight_text', $locale)) ?></p>
                        </div>
                        <div class="svc-detail-duo">
                            <div class="svc-detail-panel">
                                <span class="svc-detail-panel-label"><?= esc(lang_field($service, 'goal_title', $locale)) ?></span>
                                <p><?= esc(lang_field($service, 'goal_text', $locale)) ?></p>
                            </div>
                            <div class="svc-detail-panel svc-detail-panel--accent">
                                <span class="svc-detail-panel-label"><?= esc(lang_field($service, 'challenge_title', $locale)) ?></span>
                                <p><?= esc(lang_field($service, 'challenge_text', $locale)) ?></p>
                            </div>
                        </div>

                        <?php if (! empty($benefits)): ?>
                        <div class="svc-detail-benefits">
                            <h2 class="svc-detail-benefits-title"><?= esc(site_trans('services_details_benefits', $locale)) ?></h2>
                            <ul class="svc-detail-benefits-list">
                                <?php foreach ($benefits as $benefit): ?>
                                <li>
                                    <span class="svc-detail-benefits-check" aria-hidden="true"><i class="fas fa-check"></i></span>
                                    <span><?= esc(is_string($benefit) ? $benefit : (string) ($benefit['text'] ?? '')) ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <?php if (! empty($faqItems)): ?>
                        <div class="svc-detail-faq">
                            <h2 class="svc-detail-faq-title"><?= esc(site_trans('services_details_faq_title', $locale)) ?></h2>
                            <div class="svc-detail-accordion accordion" id="<?= esc($accordionId, 'attr') ?>">
                                <?php foreach ($faqItems as $i => $item): ?>
                                <?php
                                    $collapseId = $accordionId . '-item-' . $i;
                                    $isFirst = $i === 0;
                                    $q = $locale === 'fr' ? ($item['q_fr'] ?? $item['q_en'] ?? '') : ($item['q_en'] ?? $item['q_fr'] ?? '');
                                    $a = $locale === 'fr' ? ($item['a_fr'] ?? $item['a_en'] ?? '') : ($item['a_en'] ?? $item['a_fr'] ?? '');
                                ?>
                                <div class="accordion-item svc-detail-accordion-item">
                                    <h3 class="accordion-header">
                                        <button class="accordion-button<?= $isFirst ? '' : ' collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc($collapseId, 'attr') ?>" aria-expanded="<?= $isFirst ? 'true' : 'false' ?>" aria-controls="<?= esc($collapseId, 'attr') ?>">
                                            <?= esc($q) ?>
                                        </button>
                                    </h3>
                                    <div id="<?= esc($collapseId, 'attr') ?>" class="accordion-collapse collapse<?= $isFirst ? ' show' : '' ?>" data-bs-parent="#<?= esc($accordionId, 'attr') ?>">
                                        <div class="accordion-body"><p><?= esc($a) ?></p></div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="svc-detail-mobile-cta">
                            <a href="<?= page_url('get-quote', $locale) ?>" class="svc-detail-btn svc-detail-btn--primary btn-has-i">
                                <?= btn_icon('quote') ?><?= esc(site_trans('services_details_cta', $locale)) ?>
                            </a>
                        </div>
                    </div>
                </article>

                <aside class="svc-detail-aside" aria-label="<?= esc(site_trans('services_details_all_services', $locale)) ?>">
                    <div class="svc-detail-aside-fixed" id="svcDetailAside">
                        <nav class="svc-detail-nav">
                            <p class="svc-detail-nav-title"><?= esc(site_trans('services_details_all_services', $locale)) ?></p>
                            <ul class="svc-detail-nav-list">
                                <?php foreach ($services as $svc): ?>
                                <li>
                                    <a href="<?= service_url((string) ($svc['slug'] ?? ''), $locale) ?>" class="svc-detail-nav-link<?= ($svc['slug'] ?? '') === ($service['slug'] ?? '') ? ' is-active' : '' ?>" <?= ($svc['slug'] ?? '') === ($service['slug'] ?? '') ? 'aria-current="page"' : '' ?>>
                                        <span class="svc-detail-nav-icon" aria-hidden="true"><i class="<?= esc($svc['icon'] ?? '', 'attr') ?>"></i></span>
                                        <span class="svc-detail-nav-label"><?= esc(lang_field($svc, 'title', $locale)) ?></span>
                                        <i class="fas fa-chevron-right svc-detail-nav-chev" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                        <div class="svc-detail-aside-card svc-detail-aside-card--phone">
                            <div class="svc-detail-aside-icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <p class="svc-detail-aside-label"><?= esc(site_trans('services_details_sidebar_help', $locale)) ?></p>
                                <a href="tel:<?= esc(preg_replace('/\s+/', '', (string) ($contactPhone1 ?? '')), 'attr') ?>" class="svc-detail-phone"><?= esc($contactPhone1 ?? '') ?></a>
                            </div>
                        </div>
                        <div class="svc-detail-aside-card svc-detail-aside-card--cta">
                            <p class="svc-detail-aside-label"><?= esc(site_trans('services_details_sidebar_quote', $locale)) ?></p>
                            <p class="svc-detail-aside-lead"><?= esc(site_trans('services_details_sidebar_quote_lead', $locale)) ?></p>
                            <div class="svc-detail-aside-actions">
                                <a href="<?= page_url('get-quote', $locale) ?>" class="svc-detail-btn svc-detail-btn--primary btn-has-i"><?= btn_icon('quote') ?><?= esc(site_trans('services_details_cta', $locale)) ?></a>
                                <a href="<?= page_url('contact', $locale) ?>" class="svc-detail-btn svc-detail-btn--secondary btn-has-i"><?= btn_icon('contact') ?><?= esc(site_trans('btn_contact', $locale)) ?></a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <?= $this->include('front/partials/brand-section') ?>
</main>
<?= $this->endSection() ?>
