<?= view('admin/components/page-toolbar', [
    'title'    => 'Branding',
    'subtitle' => 'Logos, favicon et image Open Graph par défaut.',
]) ?>

<div class="admin-card mb-4">
    <div class="admin-card__header">
        <i class="bi bi-globe2 me-2" aria-hidden="true"></i>
        Site public
    </div>
    <div class="admin-card__body">
        <form action="<?= site_url('admin/branding') ?>" method="post" id="branding-form">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="row g-4">
                <?php
                $publicFields = [
                    'logo_light_id'       => 'Logo clair',
                    'logo_dark_id'        => 'Logo sombre',
                    'logo_mobile_id'      => 'Logo mobile',
                    'favicon_id'          => 'Favicon',
                    'apple_touch_icon_id' => 'Apple Touch Icon',
                    'og_default_image_id' => 'Image OG par défaut',
                ];
                foreach ($publicFields as $field => $label):
                    $urlKey = str_replace('_id', '', $field);
                    if ($field === 'og_default_image_id') {
                        $urlKey = 'og_default_image';
                    }
                ?>
                <div class="col-md-6">
                    <label class="form-label"><?= esc($label) ?></label>
                    <?= view('admin/components/media-picker', [
                        'fieldName'  => $field,
                        'value'      => $branding[$field] ?? '',
                        'previewUrl' => $urls[$urlKey] ?? null,
                    ]) ?>
                </div>
                <?php endforeach; ?>
            </div>

            <hr class="my-4">

            <div class="admin-card__header px-0 pt-0 border-0 bg-transparent mb-3">
                <i class="bi bi-shield-lock me-2" aria-hidden="true"></i>
                Panel administration
            </div>
            <p class="text-muted small mb-3">
                Logo affiché dans la barre latérale et favicon de l’espace admin / page de connexion.
                Si non renseignés, le favicon du site public est utilisé pour l’icône d’onglet.
            </p>
            <div class="row g-4">
                <?php
                $adminFields = [
                    'admin_logo_id'    => 'Logo admin (sidebar)',
                    'admin_favicon_id' => 'Favicon admin',
                ];
                foreach ($adminFields as $field => $label):
                    $urlKey = str_replace('_id', '', $field);
                ?>
                <div class="col-md-6">
                    <label class="form-label"><?= esc($label) ?></label>
                    <?= view('admin/components/media-picker', [
                        'fieldName'  => $field,
                        'value'      => $branding[$field] ?? '',
                        'previewUrl' => $urls[$urlKey] ?? null,
                    ]) ?>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i>
                    Enregistrer le branding
                </button>
            </div>
        </form>
    </div>
</div>
