<?= $this->extend('prospect/layouts/auth') ?>

<?= $this->section('title') ?><?= esc(site_trans('prospect_expired_title')) ?><?= $this->endSection() ?>

<?= $this->section('main') ?>
    <header class="auth-card__head">
        <div class="prospect-auth-icon prospect-auth-icon--warning" aria-hidden="true">
            <i class="bi bi-clock-history"></i>
        </div>
        <h2 class="auth-card__title"><?= esc(site_trans('prospect_expired_title')) ?></h2>
        <p class="auth-card__subtitle"><?= esc(site_trans('prospect_expired_lead')) ?></p>
    </header>

    <?= form_open(site_url('user/login'), ['class' => 'auth-form']) ?>
        <input type="hidden" name="quote_id" value="<?= esc((string) ($quoteId ?? '')) ?>">
        <input type="hidden" name="email" value="<?= esc($email ?? '') ?>">
        <input type="hidden" name="locale" value="<?= esc(service('request')->getLocale()) ?>">

        <button type="submit" class="btn btn-primary auth-submit">
            <i class="bi bi-envelope-arrow-up" aria-hidden="true"></i>
            <?= esc(site_trans('prospect_resend_btn')) ?>
        </button>

        <p class="auth-alt">
            <a href="<?= site_url('user/login') ?>">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                <?= esc(site_trans('prospect_back_access')) ?>
            </a>
        </p>
    <?= form_close() ?>
<?= $this->endSection() ?>
