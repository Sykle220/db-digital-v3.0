<?php
/**
 * @var array<string, array<string, string>> $translations
 * @var array<string, string> $fields  field => label
 * @var string $prefix  name prefix, default translations
 */
$prefix = $prefix ?? 'translations';
$locales = ['fr' => 'Français', 'en' => 'English'];
?>
<ul class="nav nav-tabs mb-3" role="tablist">
    <?php $i = 0; foreach ($locales as $code => $label): ?>
    <li class="nav-item">
        <button class="nav-link <?= $i === 0 ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-<?= esc($code) ?>" type="button"><?= esc($label) ?></button>
    </li>
    <?php $i++; endforeach; ?>
</ul>
<div class="tab-content border rounded p-3 bg-white mb-3">
    <?php $i = 0; foreach ($locales as $code => $label): ?>
    <div class="tab-pane fade <?= $i === 0 ? 'show active' : '' ?>" id="tab-<?= esc($code) ?>">
        <?php foreach ($fields as $field => $fieldLabel): ?>
        <div class="mb-3">
            <label class="form-label"><?= esc($fieldLabel) ?> (<?= strtoupper($code) ?>)</label>
            <?php if (in_array($field, ['content', 'bio', 'description', 'short_description', 'excerpt'], true)): ?>
            <?php $extraClass = $field === 'content' ? ' wysiwyg-editor' : ''; ?>
            <textarea class="form-control<?= $extraClass ?>" name="<?= esc($prefix) ?>[<?= esc($code) ?>][<?= esc($field) ?>]" rows="4"><?= esc($translations[$code][$field] ?? '') ?></textarea>
            <?php else: ?>
            <input type="text" class="form-control" name="<?= esc($prefix) ?>[<?= esc($code) ?>][<?= esc($field) ?>]" value="<?= esc($translations[$code][$field] ?? '') ?>">
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php $i++; endforeach; ?>
</div>
