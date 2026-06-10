<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="<?= isset($item) && $item ? 'PUT' : 'POST' ?>">
            <div class="row g-3 mb-3">
                <div class="col-md-4"><label class="form-label">Image</label><input type="text" name="image" class="form-control" value="<?= esc($item['image'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Note</label><input type="number" name="rating" min="1" max="5" class="form-control" value="<?= esc($item['rating'] ?? 5) ?>"></div>
                <div class="col-md-3"><label class="form-label">Ordre</label><input type="number" name="sort_order" class="form-control" value="<?= esc($item['sort_order'] ?? 0) ?>"></div>
                <div class="col-md-3"><label class="form-label">Actif</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= ! empty($item['is_active']) ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= empty($item['is_active']) ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
            </div>
            <?= view('admin/components/locale-tabs', [
                'translations' => $translations,
                'fields' => ['author' => 'Nom', 'role' => 'Rôle', 'quote' => 'Témoignage'],
            ]) ?>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= site_url('admin/testimonials') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
