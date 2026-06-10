<?php
/**
 * @var string $fieldName
 * @var int|string|null $value
 * @var string|null $previewUrl
 */
$fieldName = $fieldName ?? 'media_id';
$value = $value ?? '';
$inputId = 'media-picker-' . preg_replace('/[^a-z0-9]/i', '-', $fieldName);
?>
<div class="media-picker" data-field="<?= esc($fieldName) ?>">
    <input type="hidden" name="<?= esc($fieldName) ?>" id="<?= esc($inputId) ?>" value="<?= esc((string) $value) ?>">
    <div class="d-flex align-items-center gap-3 mb-2">
        <div class="border rounded bg-light d-flex align-items-center justify-content-center" style="width:80px;height:80px" id="<?= esc($inputId) ?>-preview">
            <?php if (! empty($previewUrl)): ?>
            <img src="<?= esc($previewUrl) ?>" alt="" class="img-fluid" style="max-height:76px">
            <?php else: ?>
            <i class="bi bi-image text-muted fs-4"></i>
            <?php endif; ?>
        </div>
        <div>
            <button type="button" class="btn btn-sm btn-outline-primary media-picker-open" data-target="<?= esc($inputId) ?>">
                <i class="bi bi-folder2-open"></i> Choisir
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary media-picker-clear" data-target="<?= esc($inputId) ?>">
                Effacer
            </button>
        </div>
    </div>
</div>

<!-- Modal picker -->
<div class="modal fade" id="mediaPickerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bibliothèque média</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2" id="mediaPickerGrid"></div>
            </div>
        </div>
    </div>
</div>

<?php if (! isset($GLOBALS['media_picker_script'])): $GLOBALS['media_picker_script'] = true; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let activeTarget = null;
    const modal = document.getElementById('mediaPickerModal');
    const grid = document.getElementById('mediaPickerGrid');

    document.querySelectorAll('.media-picker-open').forEach(btn => {
        btn.addEventListener('click', async function () {
            activeTarget = this.dataset.target;
            const res = await fetch('<?= site_url('admin/media/picker') ?>?type=image');
            const data = await res.json();
            grid.innerHTML = '';
            (data.items || []).forEach(item => {
                const col = document.createElement('div');
                col.className = 'col-4 col-md-3';
                col.innerHTML = `<button type="button" class="btn btn-light w-100 p-1 border media-pick-item" data-id="${item.id}" data-url="${item.url}">
                    <img src="${item.url}" class="img-fluid" alt="">
                </button>`;
                grid.appendChild(col);
            });
            bootstrap.Modal.getOrCreateInstance(modal).show();
        });
    });

    grid?.addEventListener('click', function (e) {
        const btn = e.target.closest('.media-pick-item');
        if (!btn || !activeTarget) return;
        document.getElementById(activeTarget).value = btn.dataset.id;
        const preview = document.getElementById(activeTarget + '-preview');
        if (preview) preview.innerHTML = `<img src="${btn.dataset.url}" class="img-fluid" style="max-height:76px">`;
        bootstrap.Modal.getInstance(modal)?.hide();
    });

    document.querySelectorAll('.media-picker-clear').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.target;
            document.getElementById(target).value = '';
            const preview = document.getElementById(target + '-preview');
            if (preview) preview.innerHTML = '<i class="bi bi-image text-muted fs-4"></i>';
        });
    });
});
</script>
<?php endif; ?>
