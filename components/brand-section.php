<?php
// components/brand-section.php
$brands = ['brand_img01.png', 'brand_img02.png', 'brand_img03.png', 'brand_img04.png', 'brand_img05.png'];
?>
<div class="brand-area-six pt-80 pb-80">
    <div class="container">
        <div class="row brand-active">
            <?php 
            // Duplique brand_img03 pour atteindre 6 éléments comme dans l'original
            $all_brands = array_merge($brands, ['brand_img03.png']);
            foreach ($all_brands as $brand): 
            ?>
            <div class="col-lg-12">
                <div class="brand-item">
                    <img src="<?php echo ASSETS_URL; ?>img/brand/<?php echo $brand; ?>" alt="Partner">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>