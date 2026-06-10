<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Clé</label><input type="text" name="key" class="form-control" value="<?= esc(old('key')) ?>" required placeholder="main"></div>
                <div class="col-md-6"><label class="form-label">Nom</label><input type="text" name="name" class="form-control" value="<?= esc(old('name')) ?>" required></div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Créer</button>
                <a href="<?= site_url('admin/menus') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
