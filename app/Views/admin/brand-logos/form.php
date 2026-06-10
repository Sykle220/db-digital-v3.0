<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="<?= isset($item) && $item ? 'PUT' : 'POST' ?>">
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label class="form-label">Nom</label><input type="text" name="name" class="form-control" value="<?= esc($item['name'] ?? '') ?>" required></div>
                <div class="col-md-6"><label class="form-label">Fichier</label><input type="text" name="filename" class="form-control" value="<?= esc($item['filename'] ?? '') ?>" required></div>
                <div class="col-md-4"><label class="form-label">Ordre</label><input type="number" name="sort_order" class="form-control" value="<?= esc($item['sort_order'] ?? 0) ?>"></div>
                <div class="col-md-4"><label class="form-label">Actif</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= ! empty($item['is_active']) ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= empty($item['is_active']) ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="<?= site_url('admin/brand-logos') ?>" class="btn btn-outline-secondary">Annuler</a>
        </form>
    </div>
</div>
