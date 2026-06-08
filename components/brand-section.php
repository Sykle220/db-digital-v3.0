<?php
// components/brand-section.php
$all_brands = getBrandLogosDisplay();
?>
<section class="brand-area-six brand-area-pro pt-80 pb-80" aria-label="<?php echo __('brand_title'); ?>">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="section-title-two text-center mb-35 tg-heading-subheading animation-style2">
                    <span class="sub-title tg-element-title span1"><?php echo __('brand_title'); ?></span>
                    <h2 class="title tg-element-title"><?php echo __('brand_title'); ?></h2>
                    <p class="mt-10"><?php echo __('brand_subtitle'); ?></p>
                </div>
            </div>
        </div>

        <div class="">
            <div class="row brand-active brand-grid justify-content-center">
                <?php foreach ($all_brands as $brand): ?>
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