<?php
$folderFilter = '<form method="get" class="admin-filter-bar mb-0">'
    . '<select name="folder" class="form-select form-select-sm" onchange="this.form.submit()">'
    . '<option value="">Tous les dossiers</option>';
foreach ($folders ?? [] as $f) {
    $folderFilter .= '<option value="' . esc($f, 'attr') . '"' . (($folder ?? '') === $f ? ' selected' : '') . '>' . esc($f) . '</option>';
}
$folderFilter .= '</select></form>';
?>
<?= view('admin/components/page-toolbar', [
    'title'    => 'Bibliothèque média',
    'subtitle' => ((int) ($totalMedia ?? 0)) . ' fichier(s)' . (($folder ?? '') !== '' ? ' · dossier « ' . esc($folder) . ' »' : ''),
    'actions'  => $folderFilter,
]) ?>

<div class="admin-card mb-4">
    <div class="admin-card__header">
        <i class="bi bi-cloud-upload me-2" aria-hidden="true"></i>
        Téléverser un fichier
    </div>
    <div class="admin-card__body">
        <form action="<?= site_url('admin/media') ?>" method="post" enctype="multipart/form-data" class="row g-3 align-items-end">
            <?= csrf_field() ?>
            <?php if (($folder ?? '') !== ''): ?>
                <input type="hidden" name="redirect_folder" value="<?= esc($folder, 'attr') ?>">
            <?php endif; ?>
            <div class="col-md-5">
                <label class="form-label">Fichier</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Dossier</label>
                <input type="text" name="folder" class="form-control" value="<?= esc($folder ?? 'general') ?>" placeholder="general, branding, team…">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-upload me-1" aria-hidden="true"></i>
                    Téléverser
                </button>
            </div>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card__header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span><i class="bi bi-images me-2" aria-hidden="true"></i>Fichiers</span>
        <?php if (isset($pager) && ($pager->getTotal() ?? 0) > 0): ?>
            <span class="badge bg-primary">
                <?= (int) $pager->getPerPageStart() ?>–<?= (int) $pager->getPerPageEnd() ?> / <?= (int) $pager->getTotal() ?>
            </span>
        <?php endif; ?>
    </div>
    <div class="admin-card__body">
        <?php if (empty($media)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-image fs-1 d-block mb-2 opacity-50" aria-hidden="true"></i>
                Aucun média<?= ($folder ?? '') !== '' ? ' dans ce dossier' : '' ?>.
            </div>
        <?php else: ?>
            <div class="admin-media-grid">
                <?php foreach ($media as $item): ?>
                <div class="admin-media-item">
                    <div class="admin-media-item__preview">
                        <?php if (str_starts_with((string) ($item['mime_type'] ?? ''), 'image/')): ?>
                            <img src="<?= esc($item['url'] ?? upload_url($item['filename'])) ?>" alt="">
                        <?php else: ?>
                            <i class="bi bi-file-earmark fs-1 text-muted" aria-hidden="true"></i>
                        <?php endif; ?>
                    </div>
                    <div class="admin-media-item__body">
                        <div class="admin-media-item__name" title="<?= esc($item['original_name'] ?? '') ?>">
                            <?= esc($item['original_name'] ?? '') ?>
                        </div>
                        <div class="admin-media-item__meta"><?= esc($item['folder'] ?? '') ?></div>
                        <form action="<?= site_url('admin/media/' . $item['id'] . '/delete') ?>" method="post" class="mt-2" onsubmit="return confirm('Supprimer ce média ?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Supprimer</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= view('admin/components/pagination', ['pager' => $pager ?? null]) ?>
