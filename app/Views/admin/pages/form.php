<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="<?= isset($page) && $page ? 'PUT' : 'POST' ?>">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Template</label>
                    <input type="text" name="template" class="form-control" value="<?= esc($page['template'] ?? old('template')) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= esc($page['sort_order'] ?? old('sort_order', 0)) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Publié</label>
                    <select name="is_published" class="form-select">
                        <option value="1" <?= ! empty($page['is_published']) ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= empty($page['is_published']) ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
            </div>
            <?= view('admin/components/locale-tabs', [
                'translations' => $translations,
                'fields' => ['title' => 'Titre', 'slug' => 'Slug', 'excerpt' => 'Extrait', 'content' => 'Contenu'],
            ]) ?>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= site_url('admin/pages') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
<?= view('admin/components/tinymce') ?>
