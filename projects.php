<?php
// projects.php
require_once 'includes/functions.php';
$page_title = __('breadcrumb_projects');
$page_description = __('meta_default_description');
include 'includes/head.php';
include 'includes/header.php';
?>

<main class="fix">
    <?php 
    $breadcrumb_title = __('breadcrumb_projects');
    include 'components/breadcrumb.php'; 
    ?>

    <!-- projects-area -->
    <section class="project-area-four">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section-title-two blue-title tg-heading-subheading animation-style2">
                        <span class="sub-title tg-element-title span1"><?php echo __('projects_subtitle'); ?></span>
                    </div>
                    <div class="section-title section-title-three mb-50 tg-heading-subheading animation-style2">
                        <h2 class="title tg-element-title"><?php echo __('projects_title'); ?></h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php 
                foreach ($homepage_projects as $proj):
                ?>
                <div class="col-lg-<?php echo (int) $proj['col_lg']; ?> col-md-6">
                    <div class="project-item-four">
                        <div class="project-thumb-four">
                            <img src="<?php echo ASSETS_URL; ?>img/project/<?php echo htmlspecialchars($proj['img']); ?>" alt="<?php echo htmlspecialchars(getProjectField($proj, 'title')); ?>">
                            <div class="project-link"><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><img src="<?php echo ASSETS_URL; ?>img/icons/plus_icon.svg" alt=""></a></div>
                        </div>
                        <div class="project-content-four">
                            <h4 class="title"><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo htmlspecialchars(getProjectField($proj, 'title')); ?></a></h4>
                            <span><?php echo htmlspecialchars(getProjectField($proj, 'category')); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- brand-area -->
    <?php include 'components/brand-section.php'; ?>
    <!-- brand-area-end -->
</main>

<?php include 'includes/footer.php'; ?>