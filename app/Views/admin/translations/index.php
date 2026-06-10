<?php
$groupFilter = '<form method="get" class="admin-filter-bar mb-0">'
    . '<select name="group" class="form-select form-select-sm" onchange="this.form.submit()">'
    . implode('', array_map(static function (string $g) use ($currentGroup): string {
        $sel = $g === $currentGroup ? ' selected' : '';

        return '<option value="' . esc($g, 'attr') . '"' . $sel . '>' . esc($g) . '</option>';
    }, $groups ?? []))
    . '</select></form>';
?>
<?= view('admin/components/page-toolbar', [
    'title'    => 'Traductions UI',
    'subtitle' => (int) ($groupTotal ?? 0) . ' clés dans « ' . esc($currentGroup) . ' » · ' . (int) ($totalKeys ?? 0) . ' au total',
    'actions'  => $groupFilter,
]) ?>

<form action="<?= site_url('admin/translations/save') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="group" value="<?= esc($currentGroup) ?>">
    <input type="hidden" name="page" value="<?= (int) ($currentPage ?? 1) ?>">
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table admin-table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:28%">Clé</th>
                        <th>Français</th>
                        <th>English</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($keys as $key): ?>
                    <tr>
                        <td>
                            <code class="small"><?= esc($key['key']) ?></code>
                            <?php if (! empty($key['description'])): ?>
                                <div class="small text-muted mt-1"><?= esc($key['description']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <textarea name="values[<?= (int) $key['id'] ?>][fr]" class="form-control form-control-sm" rows="2"><?= esc($key['values']['fr'] ?? '') ?></textarea>
                        </td>
                        <td>
                            <textarea name="values[<?= (int) $key['id'] ?>][en]" class="form-control form-control-sm" rows="2"><?= esc($key['values']['en'] ?? '') ?></textarea>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($keys)): ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Aucune clé dans ce groupe</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= view('admin/components/pagination', ['pager' => $pager ?? null]) ?>

    <?php if (! empty($keys)): ?>
        <div class="mt-3 d-flex flex-wrap gap-2 align-items-center">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1" aria-hidden="true"></i>
                Enregistrer cette page
            </button>
            <span class="text-muted small">Seules les clés affichées sur cette page seront mises à jour.</span>
        </div>
    <?php endif; ?>
</form>
