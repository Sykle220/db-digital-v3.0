<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="services-area-twelve1 fix">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="services-inner-content">
                        <div class="section-title-two blue-title mb-15 tg-heading-subheading animation-style2">
                            <span class="sub-title tg-element-title span1"><?= esc(site_trans('services_block_subtitle', $locale)) ?></span>
                            <h2 class="title tg-element-title"><?= esc(site_trans('services_block_title', $locale)) ?></h2>
                        </div>
                        <p class="p1"><?= esc(site_trans('services_page_lead', $locale)) ?></p>
                        <a href="<?= page_url('get-quote', $locale) ?>" class="btn btn1 btn-three border-btn btn-has-i"><?= btn_icon('quote') ?><?= esc(site_trans('services_block_cta', $locale)) ?></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row gutter-24">
                        <?php foreach ($services as $svc): ?>
                        <div class="col-md-6">
                            <div class="services-item-eight">
                                <div class="services-icon-eight"><i class="<?= esc($svc['icon'] ?? '', 'attr') ?>"></i></div>
                                <div class="services-content-eight">
                                    <h2 class="title"><a href="<?= service_url((string) ($svc['slug'] ?? ''), $locale) ?>"><?= esc(lang_field($svc, 'title', $locale)) ?></a></h2>
                                    <p><?= esc(lang_field($svc, 'description', $locale)) ?></p>
                                    <a href="<?= service_url((string) ($svc['slug'] ?? ''), $locale) ?>" class="link-btn link-btn-has-i"><?= esc(site_trans('services_see_details', $locale)) ?>
                                        <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.5446 6.50759H1.41432C1.03607 6.50759 0.730469 6.22774 0.730469 5.88135C0.730469 5.53496 1.03607 5.25511 1.41432 5.25511H14.8927L10.7425 1.45463C10.4754 1.21001 10.4754 0.812736 10.7425 0.568112C11.0097 0.323487 11.4435 0.323487 11.7106 0.568112L17.0297 5.43907C17.2263 5.61911 17.284 5.88722 17.1772 6.12206C17.0703 6.35494 16.8203 6.50759 16.5446 6.50759Z" fill="currentcolor"/><path d="M11.2191 11.3844C11.0439 11.3844 10.8686 11.3238 10.7361 11.2005C10.469 10.9558 10.469 10.5586 10.7361 10.3139L16.0616 5.43711C16.3288 5.19249 16.7626 5.19249 17.0297 5.43711C17.2969 5.68174 17.2969 6.07901 17.0297 6.32363L11.7042 11.2005C11.5696 11.3238 11.3943 11.3844 11.2191 11.3844Z" fill="currentcolor"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="services-shape-wrap">
            <img src="<?= asset_url('img/services/h6_services_shape01.png') ?>" alt="shape" data-aos="fade-down-left" data-aos-delay="400">
            <img src="<?= asset_url('img/services/h6_services_shape02.png') ?>" alt="shape" data-aos="fade-up-right" data-aos-delay="400">
        </div>
    </section>

    <?= $this->include('front/partials/brand-section') ?>
</main>
<?= $this->endSection() ?>
