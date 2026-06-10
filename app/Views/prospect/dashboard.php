<?= $this->extend('prospect/layouts/main') ?>

<?= $this->section('content') ?>
<?php
$locale    = $locale ?? service('request')->getLocale();
$statusKey = (string) ($quote['status'] ?? 'new');
$fullName  = trim((string) ($quote['fullname'] ?? ''));
$createdAt = (string) ($quote['created_at'] ?? '');
$createdLabel = $createdAt !== ''
    ? date($locale === 'fr' ? 'd/m/Y' : 'M j, Y', strtotime($createdAt))
    : '—';

$logIcons = [
    'email_sent'       => 'bi-envelope-check',
    'email_failed'     => 'bi-envelope-x',
    'whatsapp_click'   => 'bi-whatsapp',
    'prospect_access'  => 'bi-box-arrow-in-right',
    'status_change'    => 'bi-arrow-repeat',
    'document_upload'  => 'bi-paperclip',
];
?>
<section class="prospect-hero">
    <div class="prospect-hero__content">
        <p class="prospect-hero__eyebrow"><?= esc(site_trans('prospect_portal_label', $locale)) ?></p>
        <h1 class="prospect-hero__title">
            <?= esc($fullName !== ''
                ? sprintf(site_trans('prospect_welcome', $locale), $fullName)
                : site_trans('prospect_dashboard_title', $locale)) ?>
        </h1>
        <p class="prospect-hero__lead">
            <?= esc(site_trans('prospect_quote_ref', $locale)) ?> #<?= esc((string) $quote['id']) ?>
            <span class="prospect-hero__sep" aria-hidden="true">·</span>
            <?= esc(site_trans('prospect_field_submitted', $locale)) ?> <?= esc($createdLabel) ?>
        </p>
    </div>
    <span class="prospect-status prospect-status--<?= esc($statusKey, 'attr') ?>">
        <?= esc($statusLabel) ?>
    </span>
</section>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="prospect-card prospect-card--spaced">
            <h2 class="prospect-card__title">
                <span class="prospect-card__title-icon" aria-hidden="true"><i class="bi bi-file-earmark-text"></i></span>
                <?= esc(site_trans('prospect_section_details', $locale)) ?>
            </h2>

            <div class="prospect-meta">
                <div class="prospect-meta__item">
                    <span class="prospect-meta__icon" aria-hidden="true"><i class="bi bi-chat-left-text"></i></span>
                    <div class="prospect-meta__body">
                        <span class="prospect-meta__label"><?= esc(site_trans('prospect_field_subject', $locale)) ?></span>
                        <span class="prospect-meta__value"><?= esc((string) ($quote['subject'] ?? '—')) ?></span>
                    </div>
                </div>
                <div class="prospect-meta__item">
                    <span class="prospect-meta__icon" aria-hidden="true"><i class="bi bi-grid"></i></span>
                    <div class="prospect-meta__body">
                        <span class="prospect-meta__label"><?= esc(site_trans('prospect_field_service', $locale)) ?></span>
                        <span class="prospect-meta__value"><?= esc((string) ($quote['service'] ?? '—')) ?></span>
                    </div>
                </div>
                <div class="prospect-meta__item">
                    <span class="prospect-meta__icon" aria-hidden="true"><i class="bi bi-cash-stack"></i></span>
                    <div class="prospect-meta__body">
                        <span class="prospect-meta__label"><?= esc(site_trans('prospect_field_budget', $locale)) ?></span>
                        <span class="prospect-meta__value"><?= esc((string) ($quote['budget'] ?? '—')) ?></span>
                    </div>
                </div>
                <?php if (! empty($quote['company'])): ?>
                <div class="prospect-meta__item">
                    <span class="prospect-meta__icon" aria-hidden="true"><i class="bi bi-building"></i></span>
                    <div class="prospect-meta__body">
                        <span class="prospect-meta__label"><?= esc(site_trans('prospect_field_company', $locale)) ?></span>
                        <span class="prospect-meta__value"><?= esc((string) $quote['company']) ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="prospect-card">
            <h2 class="prospect-card__title">
                <span class="prospect-card__title-icon" aria-hidden="true"><i class="bi bi-clock-history"></i></span>
                <?= esc(site_trans('prospect_timeline_title', $locale)) ?>
            </h2>

            <?php if ($logs === []): ?>
                <div class="prospect-empty">
                    <i class="bi bi-inbox" aria-hidden="true"></i>
                    <p><?= esc(site_trans('prospect_timeline_empty', $locale)) ?></p>
                </div>
            <?php else: ?>
                <ul class="prospect-timeline">
                    <?php foreach ($logs as $log): ?>
                        <?php
                        $actionType = (string) ($log['action_type'] ?? '');
                        $icon       = $logIcons[$actionType] ?? 'bi-circle';
                        $logTime    = (string) ($log['created_at'] ?? '');
                        $logTimeLabel = $logTime !== ''
                            ? date($locale === 'fr' ? 'd/m/Y H:i' : 'M j, Y g:i A', strtotime($logTime))
                            : '';
                        ?>
                        <li class="prospect-timeline__item">
                            <span class="prospect-timeline__dot" aria-hidden="true">
                                <i class="bi <?= esc($icon, 'attr') ?>"></i>
                            </span>
                            <div class="prospect-timeline__body">
                                <p class="prospect-timeline__label">
                                    <?= esc(service('quote')->translateLogAction($actionType)) ?>
                                </p>
                                <?php if (! empty($log['action_details'])): ?>
                                    <p class="prospect-timeline__detail"><?= esc((string) $log['action_details']) ?></p>
                                <?php endif; ?>
                                <?php if ($logTimeLabel !== ''): ?>
                                    <time class="prospect-timeline__time" datetime="<?= esc($logTime, 'attr') ?>">
                                        <?= esc($logTimeLabel) ?>
                                    </time>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="prospect-card prospect-card--spaced">
            <h2 class="prospect-card__title">
                <span class="prospect-card__title-icon" aria-hidden="true"><i class="bi bi-folder2-open"></i></span>
                <?= esc(site_trans('prospect_documents_title', $locale)) ?>
            </h2>

            <?php if (! empty($quote['brief_file'])): ?>
                <a href="<?= site_url('prospect/brief') ?>" class="prospect-btn prospect-btn--outline prospect-btn--block">
                    <i class="bi bi-download" aria-hidden="true"></i>
                    <?= esc(site_trans('prospect_download_brief', $locale)) ?>
                </a>
            <?php else: ?>
                <p class="prospect-muted"><?= esc(site_trans('prospect_no_brief', $locale)) ?></p>
            <?php endif; ?>

            <?php if (! empty($documents)): ?>
                <ul class="prospect-files">
                    <?php foreach ($documents as $doc): ?>
                        <li class="prospect-files__item">
                            <i class="bi bi-file-earmark" aria-hidden="true"></i>
                            <span><?= esc((string) ($doc['original_name'] ?? $doc['filename'] ?? '')) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="prospect-upload">
                <?= form_open_multipart(site_url('prospect/upload'), ['class' => 'prospect-upload__form']) ?>
                    <label class="prospect-upload__label" for="document">
                        <i class="bi bi-cloud-arrow-up" aria-hidden="true"></i>
                        <?= esc(site_trans('prospect_upload_label', $locale)) ?>
                    </label>
                    <input type="file" name="document" id="document" class="form-control prospect-upload__input"
                           accept=".pdf,.doc,.docx">
                    <button type="submit" class="prospect-btn prospect-btn--primary prospect-btn--block">
                        <i class="bi bi-upload" aria-hidden="true"></i>
                        <?= esc(site_trans('prospect_upload_btn', $locale)) ?>
                    </button>
                <?= form_close() ?>
            </div>
        </div>

        <div class="prospect-card">
            <h2 class="prospect-card__title">
                <span class="prospect-card__title-icon" aria-hidden="true"><i class="bi bi-headset"></i></span>
                <?= esc(site_trans('prospect_contact_title', $locale)) ?>
            </h2>
            <p class="prospect-muted prospect-contact__lead"><?= esc(site_trans('prospect_contact_lead', $locale)) ?></p>
            <div class="prospect-contact">
                <a href="<?= esc($whatsappUrl, 'attr') ?>" class="prospect-btn prospect-btn--whatsapp prospect-btn--block" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp" aria-hidden="true"></i>
                    <?= esc(site_trans('prospect_whatsapp_btn', $locale)) ?>
                </a>
                <a href="mailto:<?= esc($contactEmail, 'attr') ?>" class="prospect-btn prospect-btn--outline prospect-btn--block">
                    <i class="bi bi-envelope" aria-hidden="true"></i>
                    <?= esc(site_trans('prospect_email_btn', $locale)) ?>
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
