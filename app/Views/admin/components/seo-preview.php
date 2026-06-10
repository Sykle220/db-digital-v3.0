<?php
/**
 * @var string $title
 * @var string $description
 * @var string $url
 */
$title = $title ?? '';
$description = $description ?? '';
$url = $url ?? site_url('/');
?>
<div class="card bg-light border-0 mb-3">
    <div class="card-body py-3">
        <div class="small text-muted mb-1">Aperçu Google</div>
        <div class="seo-preview">
            <div class="text-primary" style="font-size:1.1rem;line-height:1.3" id="seoPreviewTitle"><?= esc($title ?: 'Titre de la page') ?></div>
            <div class="text-success small" id="seoPreviewUrl"><?= esc($url) ?></div>
            <div class="text-muted small mt-1" id="seoPreviewDesc"><?= esc($description ?: 'Description meta de la page…') ?></div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const titleInput = document.querySelector('[name="meta_title"]');
    const descInput = document.querySelector('[name="meta_description"]');
    const urlInput = document.querySelector('[name="canonical_url"]');
    const previewTitle = document.getElementById('seoPreviewTitle');
    const previewDesc = document.getElementById('seoPreviewDesc');
    const previewUrl = document.getElementById('seoPreviewUrl');

    function update() {
        if (titleInput && previewTitle) previewTitle.textContent = titleInput.value || 'Titre de la page';
        if (descInput && previewDesc) previewDesc.textContent = descInput.value || 'Description meta de la page…';
        if (urlInput && previewUrl && urlInput.value) previewUrl.textContent = urlInput.value;
    }

    [titleInput, descInput, urlInput].forEach(el => el?.addEventListener('input', update));
});
</script>
