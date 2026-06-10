<div class="admin-stat-grid">
    <div class="admin-stat admin-stat--primary">
        <div class="admin-stat__icon"><i class="bi bi-file-earmark-medical" aria-hidden="true"></i></div>
        <div class="admin-stat__label">Nouveaux devis</div>
        <div class="admin-stat__value"><?= (int) ($kpis['new_quotes'] ?? 0) ?></div>
    </div>
    <div class="admin-stat admin-stat--warning">
        <div class="admin-stat__icon"><i class="bi bi-envelope-exclamation" aria-hidden="true"></i></div>
        <div class="admin-stat__label">Contacts non lus</div>
        <div class="admin-stat__value"><?= (int) ($kpis['unread_contacts'] ?? 0) ?></div>
    </div>
    <div class="admin-stat admin-stat--success">
        <div class="admin-stat__icon"><i class="bi bi-people" aria-hidden="true"></i></div>
        <div class="admin-stat__label">Abonnés newsletter</div>
        <div class="admin-stat__value"><?= (int) ($kpis['newsletter'] ?? 0) ?></div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card__header d-flex align-items-center justify-content-between">
                <span>Derniers devis</span>
                <a href="<?= site_url('admin/quotes') ?>" class="btn btn-sm btn-outline-primary">Tout voir</a>
            </div>
            <div class="table-responsive">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr><th>Client</th><th>Sujet</th><th>Statut</th><th></th></tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recentQuotes as $q): ?>
                    <tr>
                        <td class="fw-semibold"><?= esc($q['fullname'] ?? '') ?></td>
                        <td><?= esc($q['subject'] ?? '') ?></td>
                        <td><span class="badge bg-secondary"><?= esc($q['status'] ?? '') ?></span></td>
                        <td class="text-end"><a href="<?= site_url('admin/quotes/' . $q['id']) ?>" class="btn btn-sm btn-link">Voir</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recentQuotes)): ?>
                    <tr><td colspan="4" class="text-muted text-center py-4">Aucun devis pour le moment</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card__header d-flex align-items-center justify-content-between">
                <span>Derniers contacts</span>
                <a href="<?= site_url('admin/contacts') ?>" class="btn btn-sm btn-outline-primary">Tout voir</a>
            </div>
            <div class="table-responsive">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr><th>Nom</th><th>E-mail</th><th>Statut</th><th></th></tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recentContacts as $c): ?>
                    <tr>
                        <td class="fw-semibold"><?= esc($c['name'] ?? '') ?></td>
                        <td><?= esc($c['email'] ?? '') ?></td>
                        <td><span class="badge bg-secondary"><?= esc($c['status'] ?? '') ?></span></td>
                        <td class="text-end"><a href="<?= site_url('admin/contacts/' . $c['id']) ?>" class="btn btn-sm btn-link">Voir</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recentContacts)): ?>
                    <tr><td colspan="4" class="text-muted text-center py-4">Aucun message pour le moment</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card__header">Activité récente</div>
            <div class="table-responsive">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr><th>Action</th><th>Entité</th><th>Détails</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recentActivity as $a): ?>
                    <tr>
                        <td><span class="badge bg-primary"><?= esc($a['action'] ?? '') ?></span></td>
                        <td><?= esc(($a['entity_type'] ?? '') . ($a['entity_id'] ? ' #' . $a['entity_id'] : '')) ?></td>
                        <td class="text-muted"><?= esc($a['details'] ?? '') ?></td>
                        <td class="text-muted small text-nowrap"><?= esc($a['created_at'] ?? '') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recentActivity)): ?>
                    <tr><td colspan="4" class="text-muted text-center py-4">Aucune activité enregistrée</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
