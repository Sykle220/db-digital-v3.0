<?php
$statusFilter = '<form method="get" class="admin-filter-bar mb-0"><select name="status" class="form-select form-select-sm" onchange="this.form.submit()">'
    . '<option value="">Tous</option>';
foreach (['new', 'read', 'replied', 'archived'] as $s) {
    $statusFilter .= '<option value="' . esc($s, 'attr') . '"' . (($status ?? '') === $s ? ' selected' : '') . '>' . esc($s) . '</option>';
}
$statusFilter .= '</select></form>';
?>
<?= view('admin/components/page-toolbar', [
    'title'   => 'Messages de contact',
    'actions' => $statusFilter,
]) ?>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table table-hover mb-0">
            <thead><tr><th>Nom</th><th>E-mail</th><th>Téléphone</th><th>Statut</th><th>Date</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($contacts as $c): ?>
            <tr>
                <td><?= esc($c['name']) ?></td>
                <td><?= esc($c['email']) ?></td>
                <td><?= esc($c['phone']) ?></td>
                <td><span class="badge bg-<?= ($c['status'] ?? '') === 'new' ? 'warning' : 'secondary' ?>"><?= esc($c['status']) ?></span></td>
                <td class="small text-muted"><?= esc($c['created_at']) ?></td>
                <td><a href="<?= site_url('admin/contacts/' . $c['id']) ?>" class="btn btn-sm btn-outline-primary">Lire</a></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($contacts)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Aucun message</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if (isset($pager)): ?><div class="mt-3"><?= $pager->links() ?></div><?php endif; ?>
