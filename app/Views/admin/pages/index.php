<?= view('admin/components/page-toolbar', [
    'title'   => 'Pages',
    'actions' => '<a href="' . site_url('admin/pages/create') . '" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Ajouter</a>',
]) ?>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table table-hover mb-0">
            <thead><tr><th>ID</th><th>Titre FR</th><th>Titre EN</th><th>Template</th><th>Publié</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($pages as $row): ?>
            <tr>
                <td><?= (int) $row['id'] ?></td>
                <td><?= esc($row['title_fr'] ?? '') ?></td>
                <td><?= esc($row['title_en'] ?? '') ?></td>
                <td><?= esc($row['template'] ?? '') ?></td>
                <td><?= ! empty($row['is_published']) ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' ?></td>
                <td class="text-end text-nowrap">
                    <a href="<?= site_url('admin/pages/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                    <form action="<?= site_url('admin/pages/' . $row['id'] . '/delete') ?>" method="post" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($pages)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Aucun élément</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
