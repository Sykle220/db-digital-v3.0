<?php
$statusFilter = '<form method="get" class="admin-filter-bar mb-0"><select name="status" class="form-select form-select-sm" onchange="this.form.submit()">'
    . '<option value="">Tous les statuts</option>';
foreach (['new', 'contacted', 'in_progress', 'completed', 'cancelled'] as $s) {
    $statusFilter .= '<option value="' . esc($s, 'attr') . '"' . (($status ?? '') === $s ? ' selected' : '') . '>' . esc($s) . '</option>';
}
$statusFilter .= '</select></form>';
?>
<?= view('admin/components/page-toolbar', [
    'title'   => 'Demandes de devis',
    'actions' => $statusFilter,
]) ?>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table table-hover mb-0">
            <thead><tr><th>ID</th><th>Client</th><th>Sujet</th><th>E-mail</th><th>Statut</th><th>Date</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($quotes as $q): ?>
            <tr>
                <td><?= (int) $q['id'] ?></td>
                <td><?= esc($q['fullname'] ?? '') ?></td>
                <td><?= esc($q['subject'] ?? '') ?></td>
                <td><?= esc($q['email'] ?? '') ?></td>
                <td><span class="badge bg-secondary"><?= esc($q['status'] ?? '') ?></span></td>
                <td class="small text-muted"><?= esc($q['created_at'] ?? '') ?></td>
                <td><a href="<?= site_url('admin/quotes/' . $q['id']) ?>" class="btn btn-sm btn-outline-primary">Voir</a></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($quotes)): ?>
            <tr><td colspan="7" class="text-center text-muted py-4">Aucune demande</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if (isset($pager)): ?><div class="mt-3"><?= $pager->links() ?></div><?php endif; ?>
