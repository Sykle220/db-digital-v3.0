<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>Connexion<?= $this->endSection() ?>

<?= $this->section('main') ?>
    <header class="auth-card__head">
        <h2 class="auth-card__title">Connexion</h2>
        <p class="auth-card__subtitle">Accédez à l’espace d’administration</p>
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

    <?php if (session('message') !== null) : ?>
        <div class="auth-alert auth-alert--success" role="alert">
            <i class="bi bi-check-circle" aria-hidden="true"></i>
            <span><?= esc(session('message')) ?></span>
        </div>
    <?php endif ?>

    <form action="<?= url_to('login') ?>" method="post" class="auth-form" novalidate>
        <?= csrf_field() ?>

        <div class="auth-field">
            <label class="auth-label" for="login-email">Adresse e-mail</label>
            <div class="auth-input-wrap">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <input
                    type="email"
                    class="form-control"
                    id="login-email"
                    name="email"
                    inputmode="email"
                    autocomplete="email"
                    placeholder="vous@exemple.com"
                    value="<?= esc(old('email')) ?>"
                    required
                >
            </div>
        </div>

        <div class="auth-field">
            <label class="auth-label" for="login-password">Mot de passe</label>
            <div class="auth-input-wrap">
                <i class="bi bi-lock" aria-hidden="true"></i>
                <input
                    type="password"
                    class="form-control"
                    id="login-password"
                    name="password"
                    autocomplete="current-password"
                    placeholder="••••••••"
                    required
                >
            </div>
        </div>

        <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
            <label class="auth-remember">
                <input type="checkbox" name="remember" value="1"<?= old('remember') ? ' checked' : '' ?>>
                <span>Se souvenir de moi</span>
            </label>
        <?php endif ?>

        <button type="submit" class="btn btn-primary auth-submit">
            <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i>
            Se connecter
        </button>
    </form>
<?= $this->endSection() ?>
