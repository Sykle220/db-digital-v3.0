<?= view('admin/components/page-toolbar', [
    'title'   => 'Bureaux',
    'actions' => '<a href="' . site_url('admin/offices/create') . '" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Ajouter</a>',
]) ?>
<div class="admin-card"><div class="table-responsive"><table class="table admin-table table-hover mb-0">
<thead><tr>
<th>ID</th><th>Bureau (FR)</th><th>Téléphone</th><th>Actif</th><th></th>
</tr></thead><tbody>
<?php foreach ($items ?? [] as $row): ?>
<tr>
<td><?= esc($row['id'] ?? '') ?></td>
<td><?= esc($row['name_fr'] ?? '') ?></td>
<td><?= esc($row['phone'] ?? '') ?></td>
<td><?= ! empty($row['is_active']) ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' ?></td>
<td class="text-end text-nowrap">
<a href="<?= site_url('admin/offices/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
<form action="<?= site_url('admin/offices/' . $row['id'] . '/delete') ?>" method="post" class="d-inline" onsubmit="return confirm('Supprimer ?')">
<?= csrf_field() ?><input type="hidden" name="_method" value="DELETE"><button class="btn btn-sm btn-outline-danger">Supprimer</button></form>
</td></tr><?php endforeach; ?>
<?php if (empty($items ?? [])): ?><tr><td colspan="5" class="text-center text-muted py-4">Aucun élément</td></tr><?php endif; ?>
</tbody></table></div></div>
