<?= view('admin/components/page-toolbar', [
    'title'    => "Page d'accueil",
    'subtitle' => 'Features, compteurs et bloc leadership.',
]) ?>

<div class="admin-card">
    <div class="admin-card__body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <h3 class="admin-section-title">Features</h3>
            <div id="features-list" class="mb-4">
                <?php foreach ($features as $i => $feature): ?>
                <div class="row g-2 mb-2 feature-row">
                    <div class="col-md-2"><input type="text" name="features[<?= $i ?>][icon]" class="form-control form-control-sm" placeholder="Icône" value="<?= esc($feature['icon'] ?? '') ?>"></div>
                    <div class="col-md-3"><input type="text" name="features[<?= $i ?>][title_key]" class="form-control form-control-sm" placeholder="Clé titre" value="<?= esc($feature['title_key'] ?? '') ?>"></div>
                    <div class="col-md-3"><input type="text" name="features[<?= $i ?>][desc_fr]" class="form-control form-control-sm" placeholder="Desc. FR" value="<?= esc($feature['desc'] ?? $feature['desc_fr'] ?? '') ?>"></div>
                    <div class="col-md-3"><input type="text" name="features[<?= $i ?>][desc_en]" class="form-control form-control-sm" placeholder="Desc. EN" value="<?= esc($feature['desc_en'] ?? '') ?>"></div>
                </div>
                <?php endforeach; ?>
            </div>

            <h3 class="admin-section-title">Compteurs</h3>
            <div class="mb-4">
                <?php foreach ($counters as $i => $counter): ?>
                <div class="row g-2 mb-2">
                    <div class="col-md-3"><input type="text" name="counters[<?= $i ?>][icon]" class="form-control form-control-sm" placeholder="Icône" value="<?= esc($counter['icon'] ?? '') ?>"></div>
                    <div class="col-md-4"><input type="text" name="counters[<?= $i ?>][label_key]" class="form-control form-control-sm" placeholder="Clé label" value="<?= esc($counter['label_key'] ?? '') ?>"></div>
                    <div class="col-md-2"><input type="number" name="counters[<?= $i ?>][count]" class="form-control form-control-sm" placeholder="Valeur" value="<?= esc((string) ($counter['count'] ?? '')) ?>"></div>
                </div>
                <?php endforeach; ?>
            </div>

            <h3 class="admin-section-title">Leadership</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-6"><label class="form-label">Nom CEO</label><input type="text" name="ceo_name" class="form-control" value="<?= esc($leader['ceo_name'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Image CEO</label><input type="text" name="ceo_image" class="form-control" value="<?= esc($leader['ceo_image'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Signature</label><input type="text" name="signature_image" class="form-control" value="<?= esc($leader['signature_image'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Années exp.</label><input type="text" name="experience_years" class="form-control" value="<?= esc($leader['experience_years'] ?? '') ?>"></div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1" aria-hidden="true"></i>
                Enregistrer
            </button>
        </form>
    </div>
</div>
