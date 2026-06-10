<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="services-area-twelve1 contact-area fix">
        <div class="container mb-40">
            <div class="section-title-two text-center mb-40 tg-heading-subheading animation-style2">
                <span class="sub-title tg-element-title span1"><?= esc(site_trans('contact_page_eyebrow', $locale)) ?></span>
                <h2 class="title tg-element-title"><?= esc(site_trans('contact_page_title', $locale)) ?></h2>
                <p class="mt-10 contact-page-lead"><?= esc(site_trans('contact_page_lead', $locale)) ?></p>
            </div>

            <div class="contact-split-shell">
                <div class="contact-split-grid">
                    <div class="contact-split-form">
                        <div class="contact-form-pro contact-form">
                            <div class="cf-card">
                                <header class="cf-header">
                                    <span class="cf-eyebrow"><?= esc(site_trans('contact_form_eyebrow', $locale)) ?></span>
                                    <h3 class="cf-title"><?= esc(site_trans('contact_form_title', $locale)) ?></h3>
                                    <p class="cf-lead"><?= esc(site_trans('contact_form_subtitle', $locale)) ?></p>
                                </header>
                                <form id="contact-form" action="<?= site_url($locale . '/contact/submit') ?>" method="post" novalidate>
                                    <?= csrf_field() ?>
                                    <input type="text" name="company_website" class="cf-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
                                    <div class="cf-grid">
                                        <div class="cf-field">
                                            <label class="cf-label" for="cf-name"><?= esc(site_trans('contact_form_name_label', $locale)) ?></label>
                                            <div class="cf-input-wrap"><i class="fas fa-user" aria-hidden="true"></i><input type="text" id="cf-name" name="name" placeholder="<?= esc(site_trans('contact_form_name_placeholder', $locale)) ?>" required autocomplete="name"></div>
                                        </div>
                                        <div class="cf-field">
                                            <label class="cf-label" for="cf-phone"><?= esc(site_trans('contact_form_phone_label', $locale)) ?></label>
                                            <div class="cf-input-wrap"><i class="fas fa-phone" aria-hidden="true"></i><input type="tel" id="cf-phone" name="phone" placeholder="<?= esc(site_trans('contact_form_phone_placeholder', $locale)) ?>" required autocomplete="tel"></div>
                                        </div>
                                        <div class="cf-field cf-field--full">
                                            <label class="cf-label" for="cf-email"><?= esc(site_trans('contact_form_email_label', $locale)) ?></label>
                                            <div class="cf-input-wrap"><i class="fas fa-envelope" aria-hidden="true"></i><input type="email" id="cf-email" name="email" placeholder="<?= esc(site_trans('contact_form_email_placeholder', $locale)) ?>" required autocomplete="email"></div>
                                        </div>
                                        <div class="cf-field cf-field--full">
                                            <label class="cf-label" for="cf-message"><?= esc(site_trans('contact_form_message_label', $locale)) ?></label>
                                            <div class="cf-input-wrap cf-input-wrap--textarea"><i class="fas fa-comment-dots" aria-hidden="true"></i><textarea id="cf-message" name="message" rows="5" placeholder="<?= esc(site_trans('contact_form_message_placeholder', $locale)) ?>" required></textarea></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="cf-submit"><span><?= esc(site_trans('contact_form_submit', $locale)) ?></span><?= btn_icon('send') ?></button>
                                    <ul class="cf-trust">
                                        <li><i class="fas fa-bolt" aria-hidden="true"></i> <?= esc(site_trans('contact_form_trust_response', $locale)) ?></li>
                                        <li><i class="fas fa-shield-alt" aria-hidden="true"></i> <?= esc(site_trans('footer_no_spam', $locale)) ?></li>
                                    </ul>
                                    <div class="ajax-response" role="status" aria-live="polite"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="contact-split-map">
                        <?php $this->setData(['map_embedded' => true, 'locations' => $offices ?? []]); ?>
                        <?= $this->include('front/partials/contact-map') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="preview-wrap">
            <div class="cards-row">
                <?php foreach ($contactDepartments as $dept): ?>
                <div class="contact-card">
                    <div class="icon-wrap"><i class="fas <?= esc($dept['icon'] ?? '', 'attr') ?>" aria-hidden="true"></i></div>
                    <div class="body">
                        <p class="card-title"><?= esc(site_trans((string) ($dept['title_key'] ?? ''), $locale)) ?></p>
                        <p class="card-email"><?= esc((string) ($dept['email'] ?? '')) ?></p>
                        <p class="card-subtitle"><?= esc(site_trans((string) ($dept['desc_key'] ?? ''), $locale)) ?></p>
                    </div>
                    <span class="chev"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection() ?>
