<?php
// contact.php
require_once 'includes/functions.php';
$page_title = __('breadcrumb_contact');
$page_description = __('meta_default_description');
include 'includes/head.php';
include 'includes/header.php';
?>

<main class="fix">
    <?php 
    $breadcrumb_title = __('breadcrumb_contact');
    include 'components/breadcrumb.php'; 
    ?>

    <!-- contact-area -->
    <section class="services-area-twelve1 contact-area fix">
        <div class="container mb-40">
            <div class="section-title-two text-center mb-40 tg-heading-subheading animation-style2">
                <span class="sub-title tg-element-title span1"><?php echo __('contact_page_eyebrow'); ?></span>
                <h2 class="title tg-element-title"><?php echo __('contact_page_title'); ?></h2>
                <p class="mt-10 contact-page-lead"><?php echo __('contact_page_lead'); ?></p>
            </div>

            <div class="contact-split-shell">
                <div class="contact-split-grid">
                    <div class="contact-split-form">
                        <?php include 'components/contact-form.php'; ?>
                    </div>
                    <div class="contact-split-map">
                        <?php
                        $map_embedded = true;
                        include 'components/contact-map.php';
                        unset($map_embedded);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- contact-card-area -->
        <?php include 'components/contact-card.php'; ?>
        <!-- contact-card-area-end -->
    </section>
    <!-- contact-area-end -->
</main>

<?php include 'includes/footer.php'; ?>