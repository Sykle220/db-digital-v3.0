<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="pb-80 pt-50">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-7">
                    <p class="text-uppercase small text-muted mb-2"><?= esc($locale === 'fr' ? 'SEO local' : 'Local SEO') ?></p>
                    <h1 class="mb-3"><?= esc($locale === 'fr' ? 'Agence digitale à ' . $cityName : 'Digital agency in ' . $cityName) ?></h1>
                    <p class="lead text-muted">
                        <?= esc($locale === 'fr'
                            ? 'Stratégie digitale, création web, branding et acquisition pour les entreprises de ' . $cityName . ' et ses environs.'
                            : 'Digital strategy, web development, branding and acquisition for businesses in ' . $cityName . ' and surrounding areas.') ?>
                    </p>

                    <?php if (! empty($office['address'])): ?>
                    <div class="mt-4 p-4 rounded-3" style="background:#f4f8ff;border:1px solid rgba(28,67,128,.1);">
                        <h2 class="h5 mb-3"><?= esc($locale === 'fr' ? 'Notre bureau' : 'Our office') ?></h2>
                        <p class="mb-1"><i class="fas fa-map-marker-alt text-primary me-2"></i><?= esc((string) $office['address']) ?></p>
                        <?php if (! empty($office['phone'])): ?>
                        <p class="mb-1"><i class="fas fa-phone text-primary me-2"></i><a href="tel:<?= esc(preg_replace('/\s+/', '', (string) $office['phone']), 'attr') ?>"><?= esc((string) $office['phone']) ?></a></p>
                        <?php endif; ?>
                        <?php if (! empty($office['email'])): ?>
                        <p class="mb-0"><i class="fas fa-envelope text-primary me-2"></i><a href="mailto:<?= esc((string) $office['email'], 'attr') ?>"><?= esc((string) $office['email']) ?></a></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-5">
                    <div class="p-4 rounded-3 text-center" style="background:linear-gradient(135deg,#111f38,#1c4380);color:#fff;">
                        <h2 class="h5 text-white"><?= esc($locale === 'fr' ? 'Lancez votre projet' : 'Start your project') ?></h2>
                        <p class="small opacity-75"><?= esc($locale === 'fr' ? 'Devis gratuit et accompagnement sur mesure.' : 'Free quote and tailored support.') ?></p>
                        <a href="<?= page_url('get-quote', $locale) ?>" class="btn btn-primary mt-2"><?= esc(site_trans('btn_quote', $locale)) ?></a>
                        <a href="<?= page_url('contact', $locale) ?>" class="btn btn-outline-light mt-2 ms-0 ms-lg-2"><?= esc(site_trans('breadcrumb_contact', $locale)) ?></a>
                    </div>

                    <?php if (! empty($services)): ?>
                    <div class="mt-4">
                        <h2 class="h6"><?= esc($locale === 'fr' ? 'Nos services' : 'Our services') ?></h2>
                        <ul class="list-unstyled mb-0">
                            <?php foreach (array_slice($services, 0, 5) as $svc): ?>
                            <li class="mb-2">
                                <a href="<?= esc(service_url((string) ($svc['slug'] ?? ''), $locale), 'attr') ?>">
                                    <?= esc(lang_field($svc, 'title', $locale)) ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php $this->setData(['locations' => [$office], 'locations_show_header' => false, 'map_embedded' => true]); ?>
    <?= $this->include('front/partials/locations-map') ?>
</main>
<?= $this->endSection() ?>
