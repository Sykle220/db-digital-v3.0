<?= view('admin/components/page-toolbar', [
    'title'   => 'Administrateurs',
    'actions' => '<a href="' . site_url('admin/users/create') . '" class="btn btn-primary btn-sm"><i class="bi bi-person-plus me-1"></i> Nouvel admin</a>',
]) ?>
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table table-hover mb-0">
            <thead><tr><th>ID</th><th>Utilisateur</th><th>E-mail</th><th>Groupes</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= (int) $user->id ?></td>
                <td><?= esc($user->username) ?></td>
                <td><?= esc($user->email) ?></td>
                <td><span class="badge bg-primary"><?= esc(implode(', ', $user->getGroups())) ?></span></td>
                <td class="text-end text-nowrap">
                    <a href="<?= site_url('admin/users/' . $user->id . '/edit') ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($users)): ?>
            <tr><td colspan="5" class="text-center text-muted py-4">Aucun utilisateur</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
