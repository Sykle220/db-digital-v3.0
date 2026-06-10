<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>Lien magique<?= $this->endSection() ?>

<?= $this->section('main') ?>
    <header class="auth-card__head">
        <h2 class="auth-card__title">Lien magique</h2>
        <p class="auth-card__subtitle">Recevez un lien de connexion par e-mail</p>
    </header>

    <?php if (session('error') !== null) : ?>
        <div class="auth-alert auth-alert--error" role="alert">
            <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
            <span><?= esc(session('error')) ?></span>
        </div>
    <?php elseif (session('errors') !== null) : ?>
        <div class="auth-alert auth-alert--error" role="alert">
            <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
            <span>
                <?php if (is_array(session('errors'))) : ?>
                    <?php foreach (session('errors') as $error) : ?>
                        <?= esc($error) ?><br>
                    <?php endforeach ?>
                <?php else : ?>
                    <?= esc(session('errors')) ?>
                <?php endif ?>
            </span>
        </div>
    <?php endif ?>

    <form action="<?= url_to('magic-link') ?>" method="post" class="auth-form" novalidate>
        <?= csrf_field() ?>

        <div class="auth-field">
            <label class="auth-label" for="magic-email">Adresse e-mail</label>
            <div class="auth-input-wrap">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <input
                    type="email"
                    class="form-control"
                    id="magic-email"
                    name="email"
                    autocomplete="email"
                    placeholder="vous@exemple.com"
                    value="<?= esc(old('email', auth()->user()->email ?? '')) ?>"
                    required
                >
            </div>
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <i class="bi bi-send" aria-hidden="true"></i>
            Envoyer le lien
        </button>

        <p class="auth-alt">
            <a href="<?= url_to('login') ?>"><i class="bi bi-arrow-left" aria-hidden="true"></i> Retour à la connexion</a>
        </p>
    </form>
<?= $this->endSection() ?>
