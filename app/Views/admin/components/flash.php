<?php if (session()->getFlashdata('success')): ?>
<div class="admin-alert admin-alert--success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill admin-alert__icon" aria-hidden="true"></i>
    <div class="flex-grow-1"><?= esc(session()->getFlashdata('success')) ?></div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="admin-alert admin-alert--error alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill admin-alert__icon" aria-hidden="true"></i>
    <div class="flex-grow-1"><?= esc(session()->getFlashdata('error')) ?></div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
<?php endif; ?>

<?php $errors = session()->getFlashdata('errors'); ?>
<?php if (is_array($errors) && $errors !== []): ?>
<div class="admin-alert admin-alert--error alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill admin-alert__icon" aria-hidden="true"></i>
    <div class="flex-grow-1">
        <ul class="mb-0 ps-3">
            <?php foreach ($errors as $err): ?>
            <li><?= esc(is_array($err) ? implode(', ', $err) : $err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
</div>
<?php endif; ?>
