<?php
/**
 * @var string      $title
 * @var string|null $subtitle
 * @var string|null $actions  HTML pour les boutons à droite
 */
?>
<div class="admin-toolbar">
    <div>
        <h2 class="admin-toolbar__title"><?= esc($title) ?></h2>
        <?php if (! empty($subtitle)): ?>
            <p class="text-muted small mb-0"><?= esc($subtitle) ?></p>
        <?php endif; ?>
    </div>
    <?php if (! empty($actions)): ?>
        <div class="d-flex flex-wrap gap-2"><?= $actions ?></div>
    <?php endif; ?>
</div>
