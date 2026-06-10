<?php
$brandLogos = $brandLogos ?? [];
$allBrands = [];
foreach ($brandLogos as $brand) {
    $allBrands[] = is_array($brand) ? ($brand['url'] ?? asset_url('img/brand/' . ($brand['filename'] ?? ''))) : asset_url('img/brand/' . $brand);
}
if ($allBrands === []) {
    foreach (['brand_img01.png','brand_img02.png','brand_img05.png','brand_img03.png','brand_img04.png'] as $f) {
        $allBrands[] = asset_url('img/brand/' . $f);
    }
}
?>
<section class="brand-area-six brand-area-pro pt-80 pb-80" aria-label="<?= esc(site_trans('brand_title', $locale ?? null)) ?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="section-title-two text-center mb-35 tg-heading-subheading animation-style2">
                    <span class="sub-title tg-element-title span1"><?= esc(site_trans('brand_title', $locale ?? null)) ?></span>
                    <h2 class="title tg-element-title"><?= esc(site_trans('brand_title', $locale ?? null)) ?></h2>
                    <p class="mt-10"><?= esc(site_trans('brand_subtitle', $locale ?? null)) ?></p>
                </div>
            </div>
        </div>
        <div class="row brand-active brand-grid justify-content-center">
            <?php foreach ($allBrands as $brandUrl): ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="brand-item brand-item-pro">
                    <img src="<?= esc($brandUrl, 'attr') ?>" alt="<?= esc($siteName ?? 'DB Digital Agency') ?> partner logo" loading="lazy" decoding="async">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
