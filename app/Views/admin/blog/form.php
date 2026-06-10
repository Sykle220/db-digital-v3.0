<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="<?= isset($item) && $item ? 'PUT' : 'POST' ?>">
            <div class="row g-3 mb-3">
                <div class="col-md-4"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="<?= esc($item['slug'] ?? '') ?>" required></div>
                <div class="col-md-4"><label class="form-label">Auteur</label><input type="text" name="author" class="form-control" value="<?= esc($item['author'] ?? '') ?>"></div>
                <div class="col-md-4">
                    <label class="form-label">Image</label>
                    <input type="text" name="image" id="blog-image" class="form-control" value="<?= esc($item['image'] ?? '') ?>">
                    <?= view('admin/components/media-picker', [
                        'fieldName'  => 'image_media_id',
                        'value'      => '',
                        'previewUrl' => ! empty($item['image']) ? upload_url('media/' . $item['image']) : null,
                    ]) ?>
                </div>
                <div class="col-md-2"><label class="form-label">Ordre</label><input type="number" name="sort_order" class="form-control" value="<?= esc($item['sort_order'] ?? 0) ?>"></div>
                <div class="col-md-2"><label class="form-label">Catégorie ID</label><input type="number" name="category_id" class="form-control" value="<?= esc($item['category_id'] ?? '') ?>" placeholder="Optionnel"></div>
                <div class="col-md-4"><label class="form-label">Publié</label>
                    <select name="is_published" class="form-select">
                        <option value="1" <?= ! empty($item['is_published']) ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= empty($item['is_published']) ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
            </div>
            <?= view('admin/components/locale-tabs', [
                'translations' => $translations,
                'fields' => ['title' => 'Titre', 'excerpt' => 'Extrait', 'content' => 'Contenu'],
            ]) ?>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= site_url('admin/blog') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
<?= view('admin/components/tinymce') ?>
