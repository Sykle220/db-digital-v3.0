<?php
// about.php
require_once 'includes/functions.php';
$page_title = 'About Us';
$page_description = 'Learn more about DB Digital Agency, your digital solution provider in Cameroon.';
include 'includes/head.php';
include 'includes/header.php';
?>

<main class="fix">
    <?php 
    $breadcrumb_title = __('breadcrumb_about');
    include 'components/breadcrumb.php'; 
    ?>

    <!-- about-area-eleven -->
    <section class="about-area-eleven">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-9 order-0 order-lg-2">
                    <div class="about-img-wrap-eleven">
                        <img src="<?php echo ASSETS_URL; ?>img/images/inner_about_img05.png" alt="">
                        <img src="<?php echo ASSETS_URL; ?>img/images/inner_about_shape01.png" alt="" class="shape-one">
                        <img src="<?php echo ASSETS_URL; ?>img/images/inner_about_shape02.png" alt="" class="shape-two">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-eleven">
                        <div class="section-title-two blue1-title mb-15 tg-heading-subheading animation-style2">
                            <span class="sub-title tg-element-title span1"><?php echo __('about_page_subtitle'); ?></span>
                            <h2 class="title tg-element-title"><?php echo __('about_page_title'); ?><br></h2>
                        </div>
                        <p><?php echo __('about_page_desc'); ?></p>
                        <div class="about-list-two">
                            <ul class="list-wrap">
                                <li><i class="fas fa-arrow-right"></i><?php echo __('about_company_type_1'); ?></li>
                                <li><i class="fas fa-arrow-right"></i><?php echo __('about_company_type_2'); ?></li>
                                <li><i class="fas fa-arrow-right"></i><?php echo __('about_company_type_3'); ?></li>
                            </ul>
                        </div>
                        <a href="<?php echo getPageLink('get-quote.php'); ?>" class="btn btn-three"><?php echo __('about_service_btn'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- about-area-six -->
    <section class="about-area-six about-area-twelve">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="about-img-six about-img-twelve">
                        <img src="<?php echo ASSETS_URL; ?>img/images/h5_about_img.png" alt="">
                        <img src="<?php echo ASSETS_URL; ?>img/images/inner_about_shape03.png" alt="">
                        <img src="<?php echo ASSETS_URL; ?>img/images/h5_about_shape02.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-six">
                        <div class="section-title-two blue1-title mb-15 tg-heading-subheading animation-style2">
                            <span class="sub-title tg-element-title span1"><?php echo __('about_expertise_subtitle'); ?></span>
                            <h2 class="title tg-element-title"><?php echo __('about_expertise_title'); ?></h2>
                        </div>
                        <p><?php echo __('about_expertise_desc'); ?></p>
                        <div class="progress-wrap">
                            <div class="progress-item">
                                <h6 class="title"><?php echo __('about_skill_strategy'); ?></h6>
                                <div class="progress" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar wow slideInLeft" data-wow-delay=".1s" style="width: 90%"><span>90%</span></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <h6 class="title"><?php echo __('about_skill_brand'); ?></h6>
                                <div class="progress" role="progressbar" aria-valuenow="76" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar wow slideInLeft" data-wow-delay=".2s" style="width: 76%"><span>76%</span></div>
                                </div>
                            </div>
                            <div class="progress-item">
                                <h6 class="title"><?php echo __('about_skill_growth'); ?></h6>
                                <div class="progress" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar wow slideInLeft" data-wow-delay=".3s" style="width: 85%"><span>85%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA (composant réutilisable) -->
    <?php include 'components/cta-section.php'; ?>

    <!-- Team (composant réutilisable) -->
    <?php include 'components/team-section.php'; ?>

</main>

<?php include 'includes/footer.php'; ?>