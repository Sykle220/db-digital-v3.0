<?php
// components/brand-section.php
$brands = ['brand_img01.png', 'brand_img02.png', 'brand_img05.png', 'brand_img03.png', 'brand_img04.png'];
$is_home = basename($_SERVER['PHP_SELF'] ?? '') === 'index.php';
$is_services = basename($_SERVER['PHP_SELF'] ?? '') === 'services.php';
$is_projects = basename($_SERVER['PHP_SELF'] ?? '') === 'projects.php';
?>
<section class="brand-area-six brand-area-pro <?php echo $is_home || $is_services || $is_projects ? 'pt-80 pb-80' : 'pt-40 pb-40 brand-compact'; ?>" aria-label="<?php echo __('brand_title'); ?>">
    <div class="container">
        <?php if ($is_home || $is_services || $is_projects): ?>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-title-two text-center mb-35 tg-heading-subheading animation-style2">
                        <span class="sub-title tg-element-title span1"><?php echo __('brand_title'); ?></span>
                        <h2 class="title tg-element-title"><?php echo __('brand_title'); ?></h2>
                        <p class="mt-10"><?php echo __('brand_subtitle'); ?></p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="brand-compact-head">
                <span class="brand-compact-label"><?php echo __('brand_title'); ?></span>
            </div>
        <?php endif; ?>

        <div class="">
            <div class="row brand-active brand-grid justify-content-center">
                <?php 
                // Duplique brand_img03 pour atteindre 6 éléments comme dans l'original
                $all_brands = array_merge($brands, ['brand_img03.png']);
                foreach ($all_brands as $brand): 
                ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="brand-item brand-item-pro">
                        <img
                            src="<?php echo ASSETS_URL; ?>img/brand/<?php echo $brand; ?>"
                            alt="<?php echo SITE_NAME; ?> partner logo"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>