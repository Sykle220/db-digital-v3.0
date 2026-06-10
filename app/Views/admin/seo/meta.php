<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-3 mb-3">
                <div class="col-md-3"><label class="form-label">Type d'entité</label>
                    <input type="text" name="entity_type" class="form-control" value="<?= esc($entityType) ?>" required>
                </div>
                <div class="col-md-3"><label class="form-label">ID entité</label>
                    <input type="number" name="entity_id" class="form-control" value="<?= (int) $entityId ?>" required>
                </div>
                <div class="col-md-3"><label class="form-label">Locale</label>
                    <select name="locale" class="form-select">
                        <option value="fr" <?= $locale === 'fr' ? 'selected' : '' ?>>FR</option>
                        <option value="en" <?= $locale === 'en' ? 'selected' : '' ?>>EN</option>
                    </select>
                </div>
            </div>

            <?= view('admin/components/seo-preview', [
                'title' => $meta['meta_title'] ?? '',
                'description' => $meta['meta_description'] ?? '',
                'url' => $meta['canonical_url'] ?? site_url('/'),
            ]) ?>

            <div class="mb-3"><label class="form-label">Titre meta</label><input type="text" name="meta_title" class="form-control" value="<?= esc($meta['meta_title'] ?? '') ?>"></div>
            <div class="mb-3"><label class="form-label">Description meta</label><textarea name="meta_description" class="form-control" rows="3"><?= esc($meta['meta_description'] ?? '') ?></textarea></div>
            <div class="mb-3"><label class="form-label">Mots-clés</label><input type="text" name="meta_keywords" class="form-control" value="<?= esc($meta['meta_keywords'] ?? '') ?>"></div>
            <div class="mb-3"><label class="form-label">URL canonique</label><input type="url" name="canonical_url" class="form-control" value="<?= esc($meta['canonical_url'] ?? '') ?>"></div>
            <div class="mb-3"><label class="form-label">Robots</label><input type="text" name="robots" class="form-control" value="<?= esc($meta['robots'] ?? 'index,follow') ?>" placeholder="index,follow"></div>
            <div class="row g-3 mb-3">
                <div class="col-md-6"><label class="form-label">OG Title</label><input type="text" name="og_title" class="form-control" value="<?= esc($meta['og_title'] ?? '') ?>"></div>
                <div class="col-md-6"><label class="form-label">OG Image ID</label><input type="number" name="og_image_id" class="form-control" value="<?= esc($meta['og_image_id'] ?? '') ?>"></div>
            </div>
            <div class="mb-3"><label class="form-label">OG Description</label><textarea name="og_description" class="form-control" rows="2"><?= esc($meta['og_description'] ?? '') ?></textarea></div>
            <div class="mb-3"><label class="form-label">Schema JSON-LD</label><textarea name="schema_json" class="form-control font-monospace" rows="4"><?= esc($meta['schema_json'] ?? '') ?></textarea></div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="<?= site_url('admin/seo') ?>" class="btn btn-outline-secondary">Retour</a>
        </form>
    </div>
</div>
