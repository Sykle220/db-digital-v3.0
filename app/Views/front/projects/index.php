<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="project-area-four">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section-title-two blue-title tg-heading-subheading animation-style2">
                        <span class="sub-title tg-element-title span1"><?= esc(site_trans('projects_subtitle', $locale)) ?></span>
                    </div>
                    <div class="section-title section-title-three mb-50 tg-heading-subheading animation-style2">
                        <h2 class="title tg-element-title"><?= esc(site_trans('projects_title', $locale)) ?></h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php foreach ($projects as $proj): ?>
                <div class="col-lg-<?= (int) ($proj['col_lg'] ?? 4) ?> col-md-6">
                    <div class="project-item-four">
                        <div class="project-thumb-four">
                            <img src="<?= esc(project_image_url($proj), 'attr') ?>" alt="<?= esc(lang_field($proj, 'title', $locale)) ?>">
                            <div class="project-link"><a href="#"><img src="<?= asset_url('img/icons/plus_icon.svg') ?>" alt=""></a></div>
                        </div>
                        <div class="project-content-four">
                            <h4 class="title"><a href="#"><?= esc(lang_field($proj, 'title', $locale)) ?></a></h4>
                            <span><?= esc(lang_field($proj, 'category', $locale)) ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?= $this->include('front/partials/brand-section') ?>
</main>
<?= $this->endSection() ?>
