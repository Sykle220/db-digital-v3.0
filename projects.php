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
                $projects_home = [
                    ['img' => 'h5_project_img01.jpg', 'title_en' => 'Illustration Design', 'title_fr' => 'Design d\'Illustration', 'category_en' => 'Creative Work', 'category_fr' => 'Travail Créatif'],
                    ['img' => 'h5_project_img02.jpg', 'title_en' => 'Design & Development', 'title_fr' => 'Design & Développement', 'category_en' => 'Planing', 'category_fr' => 'Planification'],
                    ['img' => 'h5_project_img03.jpg', 'title_en' => 'Marketing Consultancy', 'title_fr' => 'Conseil en Marketing', 'category_en' => 'Development', 'category_fr' => 'Développement'],
                    ['img' => 'h5_project_img04.jpg', 'title_en' => 'Digital Marketing', 'title_fr' => 'Marketing Digital', 'category_en' => 'Skill Development', 'category_fr' => 'Développement de Compétences'],
                    ['img' => 'h5_project_img05.jpg', 'title_en' => 'Strategic Planning', 'title_fr' => 'Planification Stratégique', 'category_en' => 'Marketing', 'category_fr' => 'Marketing'],
                ];
                foreach ($projects_home as $proj):
                ?>
                <div class="col-lg-<?php echo ($proj['title_en'] === 'Illustration Design' || $proj['title_en'] === 'Design & Development') ? '6' : '4'; ?> col-md-6">
                    <div class="project-item-four">
                        <div class="project-thumb-four">
                            <img src="<?php echo ASSETS_URL; ?>img/project/<?php echo $proj['img']; ?>" alt="<?php echo $current_lang === 'fr' ? $proj['title_fr'] : $proj['title_en']; ?>">
                            <div class="project-link"><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><img src="<?php echo ASSETS_URL; ?>img/icons/plus_icon.svg" alt=""></a></div>
                        </div>
                        <div class="project-content-four">
                            <h4 class="title"><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo $current_lang === 'fr' ? $proj['title_fr'] : $proj['title_en']; ?></a></h4>
                            <span><?php echo $current_lang === 'fr' ? $proj['category_fr'] : $proj['category_en']; ?></span>
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