<?php
$faqs = $faqs ?? [];
if ($faqs === []) {
    $faqs = [['question_fr' => '', 'answer_fr' => '', 'question_en' => '', 'answer_en' => '']];
}
?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= esc($action) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="<?= isset($item) && $item ? 'PUT' : 'POST' ?>">

            <div class="row g-3 mb-4">
                <div class="col-md-3"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="<?= esc($item['slug'] ?? '') ?>" required></div>
                <div class="col-md-3"><label class="form-label">Icône (classe)</label><input type="text" name="icon" class="form-control" value="<?= esc($item['icon'] ?? '') ?>" placeholder="flaticon-..."></div>
                <div class="col-md-3"><label class="form-label">Image liste</label><input type="text" name="image" class="form-control" value="<?= esc($item['image'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Image détail</label><input type="text" name="detail_image" class="form-control" value="<?= esc($item['detail_image'] ?? '') ?>"></div>
                <div class="col-md-3"><label class="form-label">Quote icône</label><input type="text" name="quote_icon" class="form-control" value="<?= esc($item['quote_icon'] ?? 'fa-briefcase') ?>"></div>
                <div class="col-md-3"><label class="form-label">Quote couleur</label><input type="text" name="quote_color" class="form-control" value="<?= esc($item['quote_color'] ?? '#534AB7') ?>"></div>
                <div class="col-md-3"><label class="form-label">Quote fond</label><input type="text" name="quote_bg" class="form-control" value="<?= esc($item['quote_bg'] ?? 'rgba(83,74,183,0.1)') ?>"></div>
                <div class="col-md-2"><label class="form-label">Ordre</label><input type="number" name="sort_order" class="form-control" value="<?= esc($item['sort_order'] ?? 0) ?>"></div>
                <div class="col-md-2"><label class="form-label">Actif</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= ! empty($item['is_active']) ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= empty($item['is_active']) ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
            </div>

            <ul class="nav nav-tabs mb-3" role="tablist">
                <?php foreach (['fr' => 'Français', 'en' => 'English'] as $loc => $label): ?>
                <li class="nav-item"><button type="button" class="nav-link<?= $loc === 'fr' ? ' active' : '' ?>" data-bs-toggle="tab" data-bs-target="#svc-<?= $loc ?>"><?= esc($label) ?></button></li>
                <?php endforeach; ?>
            </ul>

            <div class="tab-content mb-4">
                <?php foreach (['fr', 'en'] as $loc): ?>
                <div class="tab-pane fade<?= $loc === 'fr' ? ' show active' : '' ?>" id="svc-<?= $loc ?>">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Titre</label><input type="text" name="translations[<?= $loc ?>][title]" class="form-control" value="<?= esc($translations[$loc]['title'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">Description courte</label><input type="text" name="translations[<?= $loc ?>][description]" class="form-control" value="<?= esc($translations[$loc]['description'] ?? '') ?>"></div>
                        <div class="col-12"><label class="form-label">Intro</label><textarea name="translations[<?= $loc ?>][intro]" class="form-control" rows="2"><?= esc($translations[$loc]['intro'] ?? '') ?></textarea></div>
                        <div class="col-12"><label class="form-label">Corps</label><textarea name="translations[<?= $loc ?>][body]" class="form-control" rows="4"><?= esc($translations[$loc]['body'] ?? '') ?></textarea></div>
                        <div class="col-md-6"><label class="form-label">Highlight titre</label><input type="text" name="translations[<?= $loc ?>][highlight_title]" class="form-control" value="<?= esc($translations[$loc]['highlight_title'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">Highlight texte</label><textarea name="translations[<?= $loc ?>][highlight_text]" class="form-control" rows="2"><?= esc($translations[$loc]['highlight_text'] ?? '') ?></textarea></div>
                        <div class="col-md-6"><label class="form-label">Objectif titre</label><input type="text" name="translations[<?= $loc ?>][goal_title]" class="form-control" value="<?= esc($translations[$loc]['goal_title'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">Objectif texte</label><textarea name="translations[<?= $loc ?>][goal_text]" class="form-control" rows="2"><?= esc($translations[$loc]['goal_text'] ?? '') ?></textarea></div>
                        <div class="col-md-6"><label class="form-label">Défi titre</label><input type="text" name="translations[<?= $loc ?>][challenge_title]" class="form-control" value="<?= esc($translations[$loc]['challenge_title'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">Défi texte</label><textarea name="translations[<?= $loc ?>][challenge_text]" class="form-control" rows="2"><?= esc($translations[$loc]['challenge_text'] ?? '') ?></textarea></div>
                        <div class="col-12"><label class="form-label">Bénéfices (un par ligne)</label><textarea name="translations[<?= $loc ?>][benefits]" class="form-control" rows="4"><?= esc($translations[$loc]['benefits'] ?? '') ?></textarea></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <h5 class="mb-3">FAQ</h5>
            <div id="faq-list">
                <?php foreach ($faqs as $i => $faq): ?>
                <div class="border rounded p-3 mb-3 faq-row">
                    <div class="row g-2">
                        <div class="col-md-6"><label class="form-label small">Question FR</label><input type="text" name="faqs[<?= $i ?>][question_fr]" class="form-control form-control-sm" value="<?= esc($faq['question_fr'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label small">Question EN</label><input type="text" name="faqs[<?= $i ?>][question_en]" class="form-control form-control-sm" value="<?= esc($faq['question_en'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label small">Réponse FR</label><textarea name="faqs[<?= $i ?>][answer_fr]" class="form-control form-control-sm" rows="2"><?= esc($faq['answer_fr'] ?? '') ?></textarea></div>
                        <div class="col-md-6"><label class="form-label small">Réponse EN</label><textarea name="faqs[<?= $i ?>][answer_en]" class="form-control form-control-sm" rows="2"><?= esc($faq['answer_en'] ?? '') ?></textarea></div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2 faq-remove">Supprimer</button>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary mb-4" id="faq-add">+ Ajouter une FAQ</button>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="<?= site_url('admin/services') ?>" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let faqIndex = <?= count($faqs) ?>;
    document.getElementById('faq-add')?.addEventListener('click', function() {
        const wrap = document.getElementById('faq-list');
        const row = document.createElement('div');
        row.className = 'border rounded p-3 mb-3 faq-row';
        row.innerHTML = `
            <div class="row g-2">
                <div class="col-md-6"><label class="form-label small">Question FR</label><input type="text" name="faqs[${faqIndex}][question_fr]" class="form-control form-control-sm"></div>
                <div class="col-md-6"><label class="form-label small">Question EN</label><input type="text" name="faqs[${faqIndex}][question_en]" class="form-control form-control-sm"></div>
                <div class="col-md-6"><label class="form-label small">Réponse FR</label><textarea name="faqs[${faqIndex}][answer_fr]" class="form-control form-control-sm" rows="2"></textarea></div>
                <div class="col-md-6"><label class="form-label small">Réponse EN</label><textarea name="faqs[${faqIndex}][answer_en]" class="form-control form-control-sm" rows="2"></textarea></div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger mt-2 faq-remove">Supprimer</button>`;
        wrap.appendChild(row);
        faqIndex++;
    });
    document.getElementById('faq-list')?.addEventListener('click', function(e) {
        if (e.target.classList.contains('faq-remove')) {
            e.target.closest('.faq-row')?.remove();
        }
    });
});
</script>
