<?= view('admin/components/page-toolbar', [
    'title'    => 'Intégrations',
    'subtitle' => 'Analytics, conformité, sécurité des formulaires et performance.',
]) ?>

<div class="admin-card">
    <div class="admin-card__body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <h3 class="admin-section-title"><i class="bi bi-graph-up-arrow me-2"></i>Analytics & suivi</h3>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="tracking_enabled" id="tracking_enabled" value="1"<?= ($settings['tracking_enabled'] ?? '1') === '1' ? ' checked' : '' ?>>
                <label class="form-check-label" for="tracking_enabled">Activer le chargement des scripts (après consentement cookies)</label>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6"><label class="form-label">Google Tag Manager (GTM-…)</label><input type="text" name="gtm_container_id" class="form-control" value="<?= esc($settings['gtm_container_id'] ?? '') ?>" placeholder="GTM-XXXXXXX"></div>
                <div class="col-md-6"><label class="form-label">GA4 Measurement ID</label><input type="text" name="ga4_measurement_id" class="form-control" value="<?= esc($settings['ga4_measurement_id'] ?? '') ?>" placeholder="G-XXXXXXXX"></div>
                <div class="col-md-6"><label class="form-label">Meta Pixel ID</label><input type="text" name="meta_pixel_id" class="form-control" value="<?= esc($settings['meta_pixel_id'] ?? '') ?>"></div>
                <div class="col-md-6"><label class="form-label">LinkedIn Partner ID</label><input type="text" name="linkedin_partner_id" class="form-control" value="<?= esc($settings['linkedin_partner_id'] ?? '') ?>"></div>
                <div class="col-md-6"><label class="form-label">Hotjar Site ID</label><input type="text" name="hotjar_site_id" class="form-control" value="<?= esc($settings['hotjar_site_id'] ?? '') ?>"></div>
                <div class="col-md-6"><label class="form-label">Microsoft Clarity Project ID</label><input type="text" name="clarity_project_id" class="form-control" value="<?= esc($settings['clarity_project_id'] ?? '') ?>"></div>
            </div>

            <h3 class="admin-section-title"><i class="bi bi-shield-check me-2"></i>Conformité & confiance</h3>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="cookie_banner_enabled" id="cookie_banner_enabled" value="1"<?= ($settings['cookie_banner_enabled'] ?? '1') === '1' ? ' checked' : '' ?>>
                <label class="form-check-label" for="cookie_banner_enabled">Bandeau cookies</label>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6"><label class="form-label">Texte bandeau (FR)</label><textarea name="cookie_policy_text_fr" class="form-control" rows="2"><?= esc($settings['cookie_policy_text_fr'] ?? '') ?></textarea></div>
                <div class="col-md-6"><label class="form-label">Texte bandeau (EN)</label><textarea name="cookie_policy_text_en" class="form-control" rows="2"><?= esc($settings['cookie_policy_text_en'] ?? '') ?></textarea></div>
                <div class="col-md-6"><label class="form-label">Slug page confidentialité (FR)</label><input type="text" name="privacy_page_slug_fr" class="form-control" value="<?= esc($settings['privacy_page_slug_fr'] ?? 'politique-confidentialite') ?>"></div>
                <div class="col-md-6"><label class="form-label">Slug page confidentialité (EN)</label><input type="text" name="privacy_page_slug_en" class="form-control" value="<?= esc($settings['privacy_page_slug_en'] ?? 'privacy-policy') ?>"></div>
                <div class="col-md-6"><label class="form-label">Slug mentions légales (FR)</label><input type="text" name="legal_page_slug_fr" class="form-control" value="<?= esc($settings['legal_page_slug_fr'] ?? 'mentions-legales') ?>"></div>
                <div class="col-md-6"><label class="form-label">Slug legal notice (EN)</label><input type="text" name="legal_page_slug_en" class="form-control" value="<?= esc($settings['legal_page_slug_en'] ?? 'legal-notice') ?>"></div>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="recaptcha_enabled" id="recaptcha_enabled" value="1"<?= ($settings['recaptcha_enabled'] ?? '0') === '1' ? ' checked' : '' ?>>
                <label class="form-check-label" for="recaptcha_enabled">reCAPTCHA v3 sur les formulaires</label>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6"><label class="form-label">reCAPTCHA Site Key</label><input type="text" name="recaptcha_site_key" class="form-control" value="<?= esc($settings['recaptcha_site_key'] ?? '') ?>"></div>
                <div class="col-md-6"><label class="form-label text-muted">Secret Key</label><input type="text" class="form-control" value="RECAPTCHA_SECRET_KEY dans .env" disabled></div>
                <div class="col-md-4"><label class="form-label">Rate limit (soumissions)</label><input type="number" name="form_rate_limit_max" class="form-control" min="1" value="<?= esc($settings['form_rate_limit_max'] ?? '8') ?>"></div>
                <div class="col-md-4"><label class="form-label">Fenêtre (minutes)</label><input type="number" name="form_rate_limit_minutes" class="form-control" min="1" value="<?= esc($settings['form_rate_limit_minutes'] ?? '15') ?>"></div>
            </div>

            <h3 class="admin-section-title"><i class="bi bi-pencil-square me-2"></i>Éditeur de contenu</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <label class="form-label" for="tinymce_api_key">Clé API TinyMCE</label>
                    <input
                        type="text"
                        name="tinymce_api_key"
                        id="tinymce_api_key"
                        class="form-control font-monospace"
                        value="<?= esc($settings['tinymce_api_key'] ?? '') ?>"
                        placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                        autocomplete="off"
                    >
                    <p class="form-text mb-0">
                        Requise pour l’éditeur enrichi (blog, pages). Obtenez une clé gratuite sur
                        <a href="https://www.tiny.cloud/auth/signup/" target="_blank" rel="noopener">tiny.cloud</a>,
                        puis ajoutez le domaine de ce site dans
                        <a href="https://www.tiny.cloud/my-account/integrations/" target="_blank" rel="noopener">vos intégrations TinyMCE</a>.
                    </p>
                </div>
            </div>

            <h3 class="admin-section-title"><i class="bi bi-lightning-charge me-2"></i>Performance</h3>
            <?php if (! empty($buildInfo)): ?>
            <div class="alert alert-success py-2 small mb-3">
                <i class="bi bi-check-circle me-1"></i>
                Dernier build : <strong><?= esc($buildInfo['count'] ?? 0) ?> fichiers</strong>
                <?php if (! empty($buildInfo['built_at'])): ?>
                — <?= esc(date('d/m/Y H:i', strtotime($buildInfo['built_at']))) ?>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-warning py-2 small mb-3">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Aucun build détecté. Exécutez <code>php spark assets:build</code> sur le serveur avant d’activer les assets minifiés.
            </div>
            <?php endif; ?>
            <div class="admin-card bg-light border-0 mb-4">
                <div class="admin-card__body py-3">
                    <p class="small fw-semibold mb-2">Déploiement production (minification)</p>
                    <ol class="small text-muted mb-0 ps-3">
                        <li>Node.js 18+ installé sur le serveur ou en CI</li>
                        <li><code>php spark assets:build</code> (ou <code>npm ci && npm run build</code>)</li>
                        <li>Activer « Assets minifiés » ci-dessous (ou <code>ASSETS_MINIFIED=true</code> dans <code>.env</code>)</li>
                        <li>Optionnel : URL CDN pointant vers <code>/assets/</code> (inclure le dossier <code>build/</code>)</li>
                    </ol>
                </div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6"><label class="form-label">CDN assets (URL base)</label><input type="url" name="cdn_assets_url" class="form-control" value="<?= esc($settings['cdn_assets_url'] ?? '') ?>" placeholder="https://cdn.example.com"></div>
                <div class="col-md-6 d-flex flex-column gap-2 justify-content-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="assets_minified" id="assets_minified" value="1"<?= ($settings['assets_minified'] ?? '0') === '1' ? ' checked' : '' ?>>
                        <label class="form-check-label" for="assets_minified">Servir les assets minifiés (<code>assets/build/</code>)</label>
                    </div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" name="defer_scripts" id="defer_scripts" value="1"<?= ($settings['defer_scripts'] ?? '1') === '1' ? ' checked' : '' ?>><label class="form-check-label" for="defer_scripts">Scripts defer</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" name="lazy_images" id="lazy_images" value="1"<?= ($settings['lazy_images'] ?? '1') === '1' ? ' checked' : '' ?>><label class="form-check-label" for="lazy_images">Lazy loading images par défaut</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" name="preload_fonts" id="preload_fonts" value="1"<?= ($settings['preload_fonts'] ?? '1') === '1' ? ' checked' : '' ?>><label class="form-check-label" for="preload_fonts">Preconnect polices Google</label></div>
                    <p class="small text-muted mb-0">WebP : placez un fichier <code>.webp</code> à côté du JPG/PNG — <code>responsive_img()</code> le détecte automatiquement.</p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i> Enregistrer
            </button>
        </form>
    </div>
</div>
