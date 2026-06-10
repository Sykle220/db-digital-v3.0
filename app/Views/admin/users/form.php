<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nom d'utilisateur</label><input type="text" name="username" class="form-control" value="<?= esc(old('username')) ?>" required></div>
                <div class="col-md-6"><label class="form-label">E-mail</label><input type="email" name="email" class="form-control" value="<?= esc(old('email')) ?>" required></div>
                <div class="col-md-6"><label class="form-label">Mot de passe</label><input type="password" name="password" class="form-control" required minlength="8"></div>
                <div class="col-md-6"><label class="form-label">Groupe</label>
                    <select name="group" class="form-select">
                        <option value="admin">Admin</option>
                        <option value="editor">Éditeur</option>
                        <option value="developer">Développeur</option>
                        <option value="superadmin">Super Admin</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Créer</button>
                <a href="<?= site_url('admin/users') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
