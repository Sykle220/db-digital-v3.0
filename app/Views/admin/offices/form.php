<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="<?= isset($item) && $item ? 'PUT' : 'POST' ?>">
            <div class="row g-3 mb-3">
                <div class="col-md-3"><label class="form-label">E-mail</label><input type="email" name="email" class="form-control" value="<?= esc($item['email'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Téléphone</label><input type="text" name="phone" class="form-control" value="<?= esc($item['phone'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Lat</label><input type="text" name="lat" class="form-control" value="<?= esc($item['lat'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Lng</label><input type="text" name="lng" class="form-control" value="<?= esc($item['lng'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Actif</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= ! empty($item['is_active']) ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= empty($item['is_active']) ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
            </div>
            <?= view('admin/components/locale-tabs', [
                'translations' => $translations,
                'fields' => ['city' => 'Ville', 'label' => 'Libellé', 'address' => 'Adresse'],
            ]) ?>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= site_url('admin/offices') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
