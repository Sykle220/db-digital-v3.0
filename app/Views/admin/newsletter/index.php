<?= view('admin/components/page-toolbar', [
    'title'   => 'Abonnés newsletter',
    'actions' => '<a href="' . site_url('admin/newsletter/export') . '" class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i> Exporter CSV</a>',
]) ?>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table table-hover mb-0">
            <thead><tr><th>E-mail</th><th>Langue</th><th>Statut</th><th>Inscrit le</th></tr></thead>
            <tbody>
            <?php foreach ($subscribers as $s): ?>
            <tr>
                <td><?= esc($s['email']) ?></td>
                <td><?= esc($s['lang'] ?? 'fr') ?></td>
                <td><span class="badge bg-<?= ($s['status'] ?? '') === 'active' ? 'success' : 'secondary' ?>"><?= esc($s['status']) ?></span></td>
                <td class="small text-muted"><?= esc($s['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($subscribers)): ?>
            <tr><td colspan="4" class="text-center text-muted py-4">Aucun abonné</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if (isset($pager)): ?><div class="mt-3"><?= $pager->links() ?></div><?php endif; ?>
