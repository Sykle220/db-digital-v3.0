<?= view('admin/components/page-toolbar', [
    'title'   => 'Menus',
    'actions' => '<a href="' . site_url('admin/menus/create') . '" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Nouveau menu</a>',
]) ?>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table table-hover mb-0">
            <thead><tr><th>ID</th><th>Clé</th><th>Nom</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($menus as $menu): ?>
            <tr>
                <td><?= (int) $menu['id'] ?></td>
                <td><code><?= esc($menu['key']) ?></code></td>
                <td><?= esc($menu['name']) ?></td>
                <td class="text-end text-nowrap">
                    <a href="<?= site_url('admin/menus/' . $menu['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Gérer</a>
                    <form action="<?= site_url('admin/menus/' . $menu['id'] . '/delete') ?>" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce menu ?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($menus)): ?>
            <tr><td colspan="4" class="text-center text-muted py-4">Aucun menu</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
