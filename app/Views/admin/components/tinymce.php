<?php
$tinymceKey = trim((string) service('siteSettings')->get('tinymce_api_key', ''));
$canConfigure = auth()->user()?->can('admin.settings') || auth()->user()?->inGroup('superadmin');
?>
<?php if ($tinymceKey === ''): ?>
<div class="alert alert-warning d-flex align-items-start gap-2 mb-3" role="alert">
    <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
    <div>
        <strong>Éditeur de texte indisponible.</strong>
        Une clé API TinyMCE valide est requise pour l’éditeur enrichi.
        <?php if ($canConfigure): ?>
            <a href="<?= site_url('admin/integrations') ?>">Configurer la clé dans Intégrations</a>
            (section « Éditeur de contenu »).
        <?php else: ?>
            Contactez un administrateur pour configurer la clé API TinyMCE.
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<script src="https://cdn.tiny.cloud/1/<?= esc($tinymceKey, 'attr') ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce === 'undefined') return;
    tinymce.init({
        selector: 'textarea.wysiwyg-editor',
        height: 360,
        menubar: false,
        plugins: 'lists link code',
        toolbar: 'undo redo | bold italic | bullist numlist | link | code',
    });
});
</script>
<?php endif; ?>
