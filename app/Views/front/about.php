<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="about-area-eleven">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-9 order-0 order-lg-2">
                    <div class="about-img-wrap-eleven">
                        <img src="<?= asset_url('img/images/inner_about_img05.png') ?>" alt="">
                        <img src="<?= asset_url('img/images/inner_about_shape01.png') ?>" alt="" class="shape-one">
                        <img src="<?= asset_url('img/images/inner_about_shape02.png') ?>" alt="" class="shape-two">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-eleven">
                        <div class="section-title-two blue1-title mb-15 tg-heading-subheading animation-style2">
                            <span class="sub-title tg-element-title span1"><?= esc(site_trans('about_page_subtitle', $locale)) ?></span>
                            <h2 class="title tg-element-title"><?= esc(site_trans('about_page_title', $locale)) ?><br></h2>
                        </div>
                        <p><?= esc(site_trans('about_page_desc', $locale)) ?></p>
                        <div class="about-list-two">
                            <ul class="list-wrap">
                                <li><i class="fas fa-arrow-right"></i><?= esc(site_trans('about_company_type_1', $locale)) ?></li>
                                <li><i class="fas fa-arrow-right"></i><?= esc(site_trans('about_company_type_2', $locale)) ?></li>
                                <li><i class="fas fa-arrow-right"></i><?= esc(site_trans('about_company_type_3', $locale)) ?></li>
                            </ul>
                        </div>
                        <a href="<?= page_url('get-quote', $locale) ?>" class="btn btn-three btn-has-i"><?= btn_icon('quote') ?><?= esc(site_trans('about_service_btn', $locale)) ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-area-six about-area-twelve">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="about-img-six about-img-twelve">
                        <img src="<?= asset_url('img/images/h5_about_img.png') ?>" alt="">
                        <img src="<?= asset_url('img/images/inner_about_shape03.png') ?>" alt="">
                        <img src="<?= asset_url('img/images/h5_about_shape02.png') ?>" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-six">
                        <div class="section-title-two blue1-title mb-15 tg-heading-subheading animation-style2">
                            <span class="sub-title tg-element-title span1"><?= esc(site_trans('about_expertise_subtitle', $locale)) ?></span>
                            <h2 class="title tg-element-title"><?= esc(site_trans('about_expertise_title', $locale)) ?></h2>
                        </div>
                        <p><?= esc(site_trans('about_expertise_desc', $locale)) ?></p>
                        <div class="progress-wrap">
                            <?php foreach ($aboutSkills as $skill): ?>
                            <div class="progress-item">
                                <h6 class="title"><?= esc(site_trans((string) ($skill['label_key'] ?? ''), $locale)) ?></h6>
                                <div class="progress" role="progressbar" aria-valuenow="<?= (int) ($skill['percent'] ?? 0) ?>" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar wow slideInLeft" data-wow-delay="<?= esc($skill['delay'] ?? '.1s', 'attr') ?>" style="width: <?= (int) ($skill['percent'] ?? 0) ?>%"><span><?= (int) ($skill['percent'] ?? 0) ?>%</span></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= $this->include('front/partials/cta-section') ?>
    <?= $this->include('front/partials/team-section') ?>
</main>
<?= $this->endSection() ?>
