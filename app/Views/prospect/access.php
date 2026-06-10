<?= $this->extend('prospect/layouts/auth') ?>

<?= $this->section('title') ?><?= esc(site_trans('prospect_access_title')) ?><?= $this->endSection() ?>

<?= $this->section('main') ?>
    <header class="auth-card__head">
        <div class="prospect-auth-icon" aria-hidden="true">
            <i class="bi bi-envelope-paper"></i>
        </div>
        <h2 class="auth-card__title"><?= esc(site_trans('prospect_access_title')) ?></h2>
        <p class="auth-card__subtitle"><?= esc(site_trans('prospect_access_lead')) ?></p>
    </header>

    <?php if (session('error') !== null) : ?>
        <div class="auth-alert auth-alert--error" role="alert">
            <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
            <span><?= esc(session('error')) ?></span>
        </div>
    <?php endif ?>

    <?php if (session('success') !== null) : ?>
        <div class="auth-alert auth-alert--success" role="alert">
            <i class="bi bi-check-circle" aria-hidden="true"></i>
            <span><?= esc(session('success')) ?></span>
        </div>
    <?php endif ?>

    <?php if ($errors = session()->getFlashdata('errors')) : ?>
        <div class="auth-alert auth-alert--error" role="alert">
            <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
            <span>
                <?php foreach ((array) $errors as $error) : ?>
                    <?= esc($error) ?><br>
                <?php endforeach ?>
            </span>
        </div>
    <?php endif ?>

    <?= form_open(site_url('user/login'), ['class' => 'auth-form', 'novalidate' => true]) ?>
        <div class="auth-field">
            <label class="auth-label" for="email"><?= esc(site_trans('prospect_email_label')) ?></label>
            <div class="auth-input-wrap">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    value="<?= esc(old('email')) ?>"
                    required
                    autocomplete="email"
                    inputmode="email"
                    placeholder="<?= esc(site_trans('prospect_email_placeholder')) ?>"
                >
            </div>
        </div>

        <input type="hidden" name="locale" value="<?= esc(service('request')->getLocale()) ?>">

        <button type="submit" class="btn btn-primary auth-submit">
            <i class="bi bi-send" aria-hidden="true"></i>
            <?= esc(site_trans('prospect_resend_btn')) ?>
        </button>
    <?= form_close() ?>

    <p class="prospect-auth-hint"><?= esc(site_trans('prospect_access_hint')) ?></p>
<?= $this->endSection() ?>
