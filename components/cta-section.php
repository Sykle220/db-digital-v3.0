<?php
// components/cta-section.php
// Section Call-to-Action réutilisable : consultation gratuite + téléphone
?>
<section class="cta-area-five">
    <div class="container">
        <div class="cta-inner-wrap-two" data-background="<?php echo ASSETS_URL; ?>img/bg/cta_bg02.jpg">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <div class="cta-content">
                        <div class="cta-info-wrap">
                            <div class="icon">
                                <i class="flaticon-phone-call"></i>
                            </div>
                            <div class="content">
                                <span><?php echo __('call_for_more_info'); ?></span>
                                <a href="tel:<?php echo preg_replace('/\s+/', '', CONTACT_PHONE_1); ?>">
                                    <?php echo CONTACT_PHONE_1; ?>
                                </a>
                            </div>
                        </div>
                        <h2 class="title"><?php echo __('call_desc'); ?></h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="cta-btn text-end">
                        <a href="get-quote.php" class="btn btn-three"><?php echo __('btn_quote'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>