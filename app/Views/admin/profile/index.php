<?php
$userGroups = [];
if ($user !== null && method_exists($user, 'getGroups')) {
    $userGroups = $user->getGroups();
}
$roleLabel = match (true) {
    in_array('superadmin', $userGroups, true) => 'Super-administrateur',
    in_array('admin', $userGroups, true)      => 'Administrateur',
    in_array('editor', $userGroups, true)     => 'Éditeur',
    in_array('developer', $userGroups, true)  => 'Développeur',
    default                                   => 'Utilisateur',
};
$errors = session()->getFlashdata('errors') ?? [];
?>

<div class="admin-toolbar">
    <div>
        <h2 class="admin-toolbar__title">Mon profil</h2>
        <p class="text-muted small mb-0">Gérez vos informations de connexion et votre mot de passe.</p>
    </div>
    <span class="badge bg-primary"><?= esc($roleLabel) ?></span>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card__header">
                <i class="bi bi-person me-2" aria-hidden="true"></i>
                Informations du profil
            </div>
            <div class="card-body p-4">
                <form action="<?= esc($profileAction) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-3">
                        <label class="form-label" for="profile-username">Nom d'utilisateur</label>
                        <input
                            type="text"
                            id="profile-username"
                            name="username"
                            class="form-control<?= isset($errors['username']) ? ' is-invalid' : '' ?>"
                            value="<?= esc(old('username', $user->username ?? '')) ?>"
                            required
                            autocomplete="username"
                        >
                        <?php if (isset($errors['username'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['username']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="profile-email">E-mail</label>
                        <input
                            type="email"
                            id="profile-email"
                            name="email"
                            class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                            value="<?= esc(old('email', $user->email ?? '')) ?>"
                            required
                            autocomplete="email"
                        >
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1" aria-hidden="true"></i>
                        Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card__header">
                <i class="bi bi-shield-lock me-2" aria-hidden="true"></i>
                Sécurité
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-3">
                    Choisissez un mot de passe d'au moins 8 caractères, avec majuscules, minuscules et chiffres.
                </p>
                <form action="<?= esc($passwordAction) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label" for="profile-password">Nouveau mot de passe</label>
                        <input
                            type="password"
                            id="profile-password"
                            name="password"
                            class="form-control<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['password']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="profile-pass-confirm">Confirmer le mot de passe</label>
                        <input
                            type="password"
                            id="profile-pass-confirm"
                            name="pass_confirm"
                            class="form-control<?= isset($errors['pass_confirm']) ? ' is-invalid' : '' ?>"
                            required
                            autocomplete="new-password"
                        >
                        <?php if (isset($errors['pass_confirm'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['pass_confirm']) ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-key me-1" aria-hidden="true"></i>
                        Changer le mot de passe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
