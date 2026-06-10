<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="<?= isset($redirect) && $redirect ? 'PUT' : 'POST' ?>">
            <div class="mb-3"><label class="form-label">Chemin source</label><input type="text" name="from_path" class="form-control" value="<?= esc($redirect['from_path'] ?? old('from_path')) ?>" required placeholder="/ancienne-page"></div>
            <div class="mb-3"><label class="form-label">Chemin destination</label><input type="text" name="to_path" class="form-control" value="<?= esc($redirect['to_path'] ?? old('to_path')) ?>" required placeholder="/nouvelle-page"></div>
            <div class="row g-3 mb-3">
                <div class="col-md-4"><label class="form-label">Code HTTP</label>
                    <select name="status_code" class="form-select">
                        <?php foreach ([301, 302, 307, 308] as $code): ?>
                        <option value="<?= $code ?>" <?= (int) ($redirect['status_code'] ?? 301) === $code ? 'selected' : '' ?>><?= $code ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Actif</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= ! isset($redirect) || ! empty($redirect['is_active']) ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= isset($redirect) && empty($redirect['is_active']) ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="<?= site_url('admin/seo') ?>" class="btn btn-outline-secondary">Annuler</a>
        </form>
    </div>
</div>
