<?= view('admin/components/page-toolbar', [
    'title'    => 'Paramètres',
    'subtitle' => 'Contact, réseaux sociaux et configuration SMTP.',
]) ?>

<div class="admin-card">
    <div class="admin-card__body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <h3 class="admin-section-title">Contact</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-4"><label class="form-label">E-mail admin</label><input type="email" name="admin_email" class="form-control" value="<?= esc($settings['admin_email'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Téléphone</label><input type="text" name="contact_phone" class="form-control" value="<?= esc($settings['contact_phone'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Adresse</label><input type="text" name="contact_address" class="form-control" value="<?= esc($settings['contact_address'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">WhatsApp</label><input type="text" name="whatsapp_number" class="form-control" value="<?= esc($settings['whatsapp_number'] ?? '') ?>"></div>
            </div>

            <h3 class="admin-section-title">Réseaux sociaux</h3>
            <div class="row g-3 mb-4">
                <?php foreach (['facebook_url', 'linkedin_url', 'youtube_url', 'tiktok_url'] as $key): ?>
                <div class="col-md-6"><label class="form-label"><?= esc(ucfirst(str_replace(['_url', 'tiktok'], ['', 'TikTok'], $key))) ?></label><input type="url" name="<?= $key ?>" class="form-control" value="<?= esc($settings[$key] ?? '') ?>"></div>
                <?php endforeach; ?>
            </div>

            <h3 class="admin-section-title">SMTP</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-4"><label class="form-label">Hôte</label><input type="text" name="smtp_host" class="form-control" value="<?= esc($settings['smtp_host'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Port</label><input type="text" name="smtp_port" class="form-control" value="<?= esc($settings['smtp_port'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Utilisateur</label><input type="text" name="smtp_username" class="form-control" value="<?= esc($settings['smtp_username'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Mot de passe</label><input type="password" name="smtp_password" class="form-control" value="<?= esc($settings['smtp_password'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Chiffrement</label><input type="text" name="smtp_encryption" class="form-control" value="<?= esc($settings['smtp_encryption'] ?? 'tls') ?>"></div>
                <div class="col-md-4"><label class="form-label">E-mail expéditeur</label><input type="email" name="smtp_from_email" class="form-control" value="<?= esc($settings['smtp_from_email'] ?? '') ?>"></div>
                <div class="col-md-4"><label class="form-label">Nom expéditeur</label><input type="text" name="smtp_from_name" class="form-control" value="<?= esc($settings['smtp_from_name'] ?? '') ?>"></div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1" aria-hidden="true"></i>
                Enregistrer les paramètres
            </button>
        </form>
    </div>
</div>
