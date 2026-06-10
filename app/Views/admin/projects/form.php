<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="<?= isset($item) && $item ? 'PUT' : 'POST' ?>">
            <div class="row g-3 mb-3">
                <div class="col-md-4"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="<?= esc($item['slug'] ?? '') ?>" required></div>
                <div class="col-md-4"><label class="form-label">Image</label><input type="text" name="image" class="form-control" value="<?= esc($item['image'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Col LG</label><input type="number" name="col_lg" class="form-control" value="<?= esc($item['col_lg'] ?? 4) ?>"></div>
                <div class="col-md-2"><label class="form-label">Actif</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= ! empty($item['is_active']) ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= empty($item['is_active']) ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
            </div>
            <?= view('admin/components/locale-tabs', [
                'translations' => $translations,
                'fields' => ['title' => 'Titre', 'description' => 'Description', 'category' => 'Catégorie', 'client' => 'Client'],
            ]) ?>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= site_url('admin/projects') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
