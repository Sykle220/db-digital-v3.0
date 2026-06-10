<?= view('admin/components/page-toolbar', [
    'title'    => 'SEO & Redirections',
    'subtitle' => 'Redirections 301 et configuration du sitemap.',
    'actions'  => '<a href="' . site_url('admin/seo/redirects/create') . '" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Ajouter une redirection</a>',
]) ?>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="admin-card">
            <div class="admin-card__header">Redirections</div>
            <div class="table-responsive">
                <table class="table admin-table table-sm mb-0">
                    <thead><tr><th>De</th><th>Vers</th><th>Code</th><th>Actif</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($redirects as $r): ?>
                    <tr>
                        <td><code class="small"><?= esc($r['from_path']) ?></code></td>
                        <td><code class="small"><?= esc($r['to_path']) ?></code></td>
                        <td><?= (int) $r['status_code'] ?></td>
                        <td><?= ! empty($r['is_active']) ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' ?></td>
                        <td class="text-end text-nowrap">
                            <a href="<?= site_url('admin/seo/redirects/' . $r['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="<?= site_url('admin/seo/redirects/' . $r['id'] . '/delete') ?>" method="post" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                                <?= csrf_field() ?>
                                <button class="btn btn-sm btn-outline-danger">×</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($redirects)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">Aucune redirection</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="admin-card mt-4">
            <div class="admin-card__header d-flex justify-content-between align-items-center">
                <span>Méta SEO par page</span>
                <a href="<?= site_url('admin/seo/meta') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Nouvelle entrée
                </a>
            </div>
            <div class="table-responsive">
                <table class="table admin-table table-sm mb-0">
                    <thead><tr><th>Type</th><th>ID</th><th>Langue</th><th>Titre</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($metaRows ?? [] as $m): ?>
                    <tr>
                        <td><code class="small"><?= esc($m['entity_type']) ?></code></td>
                        <td><?= (int) $m['entity_id'] ?></td>
                        <td><?= esc(strtoupper((string) $m['locale'])) ?></td>
                        <td class="text-truncate" style="max-width:220px"><?= esc($m['meta_title'] ?? '') ?></td>
                        <td class="text-end">
                            <a href="<?= site_url('admin/seo/meta?' . http_build_query([
                                'entity_type' => $m['entity_type'],
                                'entity_id'   => $m['entity_id'],
                                'locale'      => $m['locale'],
                            ])) ?>" class="btn btn-sm btn-outline-secondary">Modifier</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($metaRows)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">Aucune méta — lancez <code>php spark db:seed SeoMetaSeeder</code></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="admin-card__header">Configuration sitemap</div>
            <div class="admin-card__body">
                <form action="<?= site_url('admin/seo/sitemap') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Sitemap activé</label>
                        <select name="sitemap_enabled" class="form-select">
                            <option value="1" <?= ($sitemap['sitemap_enabled'] ?? '') === '1' ? 'selected' : '' ?>>Oui</option>
                            <option value="0" <?= ($sitemap['sitemap_enabled'] ?? '') !== '1' ? 'selected' : '' ?>>Non</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Changefreq par défaut</label>
                        <select name="sitemap_changefreq" class="form-select">
                            <?php foreach (['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly'] as $freq): ?>
                            <option value="<?= $freq ?>" <?= ($sitemap['sitemap_changefreq'] ?? '') === $freq ? 'selected' : '' ?>><?= $freq ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priorité par défaut</label>
                        <input type="text" name="sitemap_priority" class="form-control" value="<?= esc($sitemap['sitemap_priority'] ?? '0.8') ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
