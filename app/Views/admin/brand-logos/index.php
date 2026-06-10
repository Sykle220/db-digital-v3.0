<?= view('admin/components/page-toolbar', [
    'title'   => 'Logos partenaires',
    'actions' => '<a href="' . site_url('admin/brand-logos/create') . '" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Ajouter</a>',
]) ?>
<div class="admin-card"><div class="table-responsive"><table class="table admin-table table-hover mb-0">
<thead><tr>
<th>ID</th><th>Nom</th><th>Fichier</th><th>Actif</th><th></th>
</tr></thead><tbody>
<?php foreach ($items ?? [] as $row): ?>
<tr>
<td><?= esc($row['id'] ?? '') ?></td>
<td><?= esc($row['name'] ?? '') ?></td>
<td><?= esc($row['filename'] ?? '') ?></td>
<td><?= ! empty($row['is_active']) ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' ?></td>
<td class="text-end text-nowrap">
<a href="<?= site_url('admin/brand-logos/' . $row['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
<form action="<?= site_url('admin/brand-logos/' . $row['id'] . '/delete') ?>" method="post" class="d-inline" onsubmit="return confirm('Supprimer ?')">
<?= csrf_field() ?><input type="hidden" name="_method" value="DELETE"><button class="btn btn-sm btn-outline-danger">Supprimer</button></form>
</td></tr><?php endforeach; ?>
<?php if (empty($items ?? [])): ?><tr><td colspan="5" class="text-center text-muted py-4">Aucun élément</td></tr><?php endif; ?>
</tbody></table></div></div>
