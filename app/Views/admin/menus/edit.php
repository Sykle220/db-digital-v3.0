<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="row g-3 mb-3">
                <div class="col-md-4"><label class="form-label">Clé</label><input type="text" name="key" class="form-control" value="<?= esc($menu['key']) ?>" required></div>
                <div class="col-md-4"><label class="form-label">Nom</label><input type="text" name="name" class="form-control" value="<?= esc($menu['name']) ?>" required></div>
            </div>

            <h3 class="h6">Éléments du menu</h3>
            <div id="menuItems">
                <?php foreach ($items as $i => $item): ?>
                <div class="border rounded p-3 mb-2 menu-item-row">
                    <input type="hidden" name="items[<?= $i ?>][id]" value="<?= (int) $item['id'] ?>">
                    <div class="row g-2">
                        <div class="col-md-2"><label class="form-label small">Type</label>
                            <select name="items[<?= $i ?>][type]" class="form-select form-select-sm">
                                <option value="url" <?= ($item['type'] ?? '') === 'url' ? 'selected' : '' ?>>URL</option>
                                <option value="page" <?= ($item['type'] ?? '') === 'page' ? 'selected' : '' ?>>Page</option>
                                <option value="route" <?= ($item['type'] ?? '') === 'route' ? 'selected' : '' ?>>Route</option>
                            </select>
                        </div>
                        <div class="col-md-3"><label class="form-label small">URL / Route</label><input type="text" name="items[<?= $i ?>][url]" class="form-control form-control-sm" value="<?= esc($item['url'] ?? '') ?>"></div>
                        <div class="col-md-2"><label class="form-label small">Label FR</label><input type="text" name="items[<?= $i ?>][labels][fr]" class="form-control form-control-sm" value="<?= esc($item['labels']['fr'] ?? '') ?>"></div>
                        <div class="col-md-2"><label class="form-label small">Label EN</label><input type="text" name="items[<?= $i ?>][labels][en]" class="form-control form-control-sm" value="<?= esc($item['labels']['en'] ?? '') ?>"></div>
                        <div class="col-md-1"><label class="form-label small">Ordre</label><input type="number" name="items[<?= $i ?>][sort_order]" class="form-control form-control-sm" value="<?= esc($item['sort_order'] ?? 0) ?>"></div>
                        <div class="col-md-1"><label class="form-label small">Actif</label>
                            <select name="items[<?= $i ?>][is_active]" class="form-select form-select-sm">
                                <option value="1" <?= ! empty($item['is_active']) ? 'selected' : '' ?>>Oui</option>
                                <option value="0" <?= empty($item['is_active']) ? 'selected' : '' ?>>Non</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary mb-3" onclick="addMenuItem()">+ Ajouter un élément</button>
            <div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= site_url('admin/menus') ?>" class="btn btn-outline-secondary">Retour</a>
            </div>
        </form>
    </div>
</div>
<script>
let menuItemIndex = <?= count($items) ?>;
function addMenuItem() {
    const html = `<div class="border rounded p-3 mb-2 menu-item-row"><div class="row g-2">
        <div class="col-md-2"><label class="form-label small">Type</label><select name="items[${menuItemIndex}][type]" class="form-select form-select-sm"><option value="url">URL</option><option value="page">Page</option><option value="route">Route</option></select></div>
        <div class="col-md-3"><label class="form-label small">URL</label><input type="text" name="items[${menuItemIndex}][url]" class="form-control form-control-sm"></div>
        <div class="col-md-2"><label class="form-label small">Label FR</label><input type="text" name="items[${menuItemIndex}][labels][fr]" class="form-control form-control-sm"></div>
        <div class="col-md-2"><label class="form-label small">Label EN</label><input type="text" name="items[${menuItemIndex}][labels][en]" class="form-control form-control-sm"></div>
        <div class="col-md-1"><label class="form-label small">Ordre</label><input type="number" name="items[${menuItemIndex}][sort_order]" class="form-control form-control-sm" value="0"></div>
        <div class="col-md-1"><label class="form-label small">Actif</label><select name="items[${menuItemIndex}][is_active]" class="form-select form-select-sm"><option value="1">Oui</option><option value="0">Non</option></select></div>
    </div></div>`;
    document.getElementById('menuItems').insertAdjacentHTML('beforeend', html);
    menuItemIndex++;
}
</script>
