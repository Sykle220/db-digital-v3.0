<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="error-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="error-content">
                        <h1 class="error-404" aria-hidden="true">4<span>0</span>4</h1>
                        <h2 class="title"><?= esc(site_trans('error_404_heading', $locale)) ?></h2>
                        <p><?= esc(site_trans('error_404_text', $locale)) ?></p>

                        <?php if (! empty($debugMessage)): ?>
                            <p class="error-debug"><code><?= esc($debugMessage) ?></code></p>
                        <?php endif; ?>

                        <div class="error-actions">
                            <a href="<?= page_url('home', $locale) ?>" class="btn btn-three btn-has-i">
                                <?= btn_icon('home') ?><?= esc(site_trans('error_404_home', $locale)) ?>
                            </a>
                            <a href="<?= page_url('contact', $locale) ?>" class="btn btn-three border-btn btn-has-i">
                                <?= btn_icon('contact') ?><?= esc(site_trans('error_404_contact', $locale)) ?>
                            </a>
                        </div>

                        <nav class="error-quick-links" aria-label="<?= esc(site_trans('error_404_quick_nav', $locale), 'attr') ?>">
                            <span class="error-quick-links__label"><?= esc(site_trans('error_404_quick_nav', $locale)) ?></span>
                            <ul class="list-wrap">
                                <li><a href="<?= page_url('services', $locale) ?>"><?= esc(site_trans('nav_services', $locale)) ?></a></li>
                                <li><a href="<?= page_url('projects', $locale) ?>"><?= esc(site_trans('nav_projects', $locale)) ?></a></li>
                                <li><a href="<?= page_url('blog', $locale) ?>"><?= esc(site_trans('nav_blog', $locale)) ?></a></li>
                                <li><a href="<?= page_url('get-quote', $locale) ?>"><?= esc(site_trans('btn_quote', $locale)) ?></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= $this->include('front/partials/cta-section') ?>
</main>
<?= $this->endSection() ?>
