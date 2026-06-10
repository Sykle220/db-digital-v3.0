<?php
$quoteFormData = $quoteFormData ?? [];
$selectedServices = is_array($quoteFormData['services'] ?? null) ? $quoteFormData['services'] : (isset($quoteFormData['services']) ? [$quoteFormData['services']] : []);
$briefMaxMb = $quoteBriefMaxMb ?? 2;
?>
<?= $this->extend('front/layouts/main') ?>

<?= $this->section('content') ?>
<main class="fix">
    <?= $this->include('front/partials/breadcrumb') ?>

    <section class="quote-info-area pt-50 pb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="title mb-30"><?= esc(site_trans('quote_innovation_title', $locale)) ?></h3>
                    <p class="mb-30"><?= esc(site_trans('quote_innovation_desc', $locale)) ?></p>
                </div>
            </div>
        </div>
    </section>

    <?php if (! empty($quoteErrors)): ?>
    <section class="pb-20">
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle"></i> <?= $locale === 'fr' ? 'Erreur !' : 'Error!' ?></strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($quoteErrors as $error): ?>
                    <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="quote-form-area pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="quote-wizard-wrap">
                        <div class="wizard-shell">
                            <div class="wiz-header">
                                <div class="wiz-header-top">
                                    <span class="wiz-badge"><?= esc(site_trans('quote_title', $locale)) ?></span>
                                    <span class="wiz-est"><i class="far fa-clock"></i> ~3 min</span>
                                </div>
                                <div class="steps-track">
                                    <?php foreach ([1 => 'quote_step_service', 2 => 'quote_step_project', 3 => 'quote_step_contact', 4 => 'quote_step_review'] as $n => $key): ?>
                                    <div class="step-item<?= $n === 1 ? ' active' : '' ?>" data-step="<?= $n ?>">
                                        <div class="step-inner">
                                            <span class="step-num"><?= $n ?></span>
                                            <span class="step-lbl"><?= esc(site_trans($key, $locale)) ?></span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="wiz-body">
                                <form action="<?= quote_submit_url($locale) ?>" method="POST" enctype="multipart/form-data" id="quoteForm" class="js-recaptcha-form">
                                    <?= csrf_field() ?>
                                    <input type="text" name="company_website" value="" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;height:0;width:0;opacity:0" aria-hidden="true">

                                    <div class="step-panel active" data-step="1">
                                        <p class="step-title"><?= esc(site_trans('quote_service_label', $locale)) ?></p>
                                        <p class="step-desc"><?= esc(site_trans('quote_select_service_desc', $locale)) ?></p>
                                        <div class="field field-services">
                                            <div class="service-cards-wrap" id="fw-services">
                                                <div class="service-cards" id="svcCards">
                                                    <?php foreach ($services as $svc):
                                                        $val = (string) ($svc['slug'] ?? '');
                                                        $isChecked = in_array($val, $selectedServices, true);
                                                    ?>
                                                    <label class="svc-card <?= $isChecked ? 'sel' : '' ?>">
                                                        <input type="checkbox" name="services[]" value="<?= esc($val, 'attr') ?>" <?= $isChecked ? 'checked' : '' ?> class="svc-checkbox">
                                                        <div class="svc-icon" style="background:<?= esc($svc['quote_bg'] ?? 'rgba(83,74,183,0.1)', 'attr') ?>;color:<?= esc($svc['quote_color'] ?? '#534AB7', 'attr') ?>">
                                                            <i class="fas <?= esc($svc['quote_icon'] ?? 'fa-briefcase', 'attr') ?>"></i>
                                                        </div>
                                                        <div class="svc-body">
                                                            <p><?= esc(site_trans((string) ($svc['quote_title_key'] ?? 'quote_svc_strategy_title'), $locale)) ?></p>
                                                            <span><?= esc(site_trans((string) ($svc['quote_sub_key'] ?? 'quote_svc_strategy_sub'), $locale)) ?></span>
                                                        </div>
                                                        <i class="fas fa-check svc-check"></i>
                                                    </label>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <span class="field-err"><?= esc(site_trans('quote_validation_select_service', $locale)) ?></span>
                                        </div>
                                        <div style="margin-top:16px">
                                            <div class="field">
                                                <label><?= esc(site_trans('quote_subject_label', $locale)) ?><span class="req">*</span></label>
                                                <div class="field-wrap" id="fw-subject">
                                                    <i class="fas fa-heading"></i>
                                                    <input type="text" name="subject" id="f-subject" placeholder="<?= esc(site_trans('quote_placeholder_subject', $locale)) ?>" value="<?= esc($quoteFormData['subject'] ?? '') ?>" required>
                                                </div>
                                                <span class="field-err"><?= esc(site_trans('quote_validation_required', $locale)) ?></span>
                                            </div>
                                        </div>
                                        <div class="step-actions">
                                            <span class="step-progress-txt"><?= esc(site_trans('quote_step_of', $locale)) ?> 1 <?= esc(site_trans('quote_step_of_total', $locale)) ?> 4</span>
                                            <div class="btns"><button type="button" class="qw-btn qw-btn-primary next-step"><?= esc(site_trans('quote_continue', $locale)) ?> <i class="fas fa-arrow-right"></i></button></div>
                                        </div>
                                    </div>

                                    <div class="step-panel" data-step="2">
                                        <p class="step-title"><?= esc(site_trans('quote_project_details_title', $locale)) ?></p>
                                        <p class="step-desc"><?= esc(site_trans('quote_project_details_desc', $locale)) ?></p>
                                        <div class="field-grid">
                                            <div class="field">
                                                <label><?= esc(site_trans('quote_type_label', $locale)) ?><span class="req">*</span></label>
                                                <div class="field-wrap"><i class="fas fa-shapes"></i>
                                                    <select name="project_type" required>
                                                        <option value="">-- <?= esc(site_trans('quote_type_label', $locale)) ?> --</option>
                                                        <?php foreach (['new-project' => 'quote_type_new', 'redesign' => 'quote_type_redesign', 'maintenance' => 'quote_type_maintenance', 'consulting' => 'quote_type_consulting'] as $v => $k): ?>
                                                        <option value="<?= esc($v, 'attr') ?>" <?= ($quoteFormData['project_type'] ?? '') === $v ? 'selected' : '' ?>><?= esc(site_trans($k, $locale)) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label><?= esc(site_trans('quote_budget_label', $locale)) ?><span class="req">*</span></label>
                                                <div class="field-wrap"><i class="fas fa-coins"></i>
                                                    <select name="budget" required>
                                                        <option value="">-- <?= esc(site_trans('quote_budget_label', $locale)) ?> --</option>
                                                        <?php foreach (['500-1000','1000-3000','3000-5000','5000+'] as $b): ?>
                                                        <option value="<?= esc($b, 'attr') ?>" <?= ($quoteFormData['budget'] ?? '') === $b ? 'selected' : '' ?>><?= esc($b) ?> FCFA</option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label><?= esc(site_trans('quote_start_label', $locale)) ?><span class="req">*</span></label>
                                                <div class="field-wrap"><i class="fas fa-calendar"></i>
                                                    <select name="start_date" required>
                                                        <option value="">-- <?= esc(site_trans('quote_start_label', $locale)) ?> --</option>
                                                        <?php foreach (['immediately' => 'quote_start_immediately', '1-week' => 'quote_start_1_week', '1-month' => 'quote_start_1_month', 'flexible' => 'quote_start_flexible'] as $v => $k): ?>
                                                        <option value="<?= esc($v, 'attr') ?>" <?= ($quoteFormData['start_date'] ?? '') === $v ? 'selected' : '' ?>><?= esc(site_trans($k, $locale)) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label>Website <span class="opt">(<?= esc(site_trans('quote_optional', $locale)) ?>)</span></label>
                                                <div class="field-wrap"><i class="fas fa-globe"></i><input type="url" name="website" placeholder="https://..." value="<?= esc($quoteFormData['website'] ?? '') ?>"></div>
                                            </div>
                                            <div class="field field-full">
                                                <label><?= esc(site_trans('quote_message_label', $locale)) ?> <span class="opt">(<?= esc(site_trans('quote_optional', $locale)) ?>)</span></label>
                                                <div class="field-wrap ta-wrap"><i class="fas fa-comment"></i><textarea name="message" rows="4" placeholder="<?= esc(site_trans('quote_placeholder_message', $locale)) ?>"><?= esc($quoteFormData['message'] ?? '') ?></textarea></div>
                                            </div>
                                            <div class="field field-full">
                                                <label><?= esc(site_trans('quote_brief_label', $locale)) ?> <span class="opt">(<?= esc(site_trans('quote_optional', $locale)) ?>)</span></label>
                                                <div class="file-field-wrap" id="fw-brief">
                                                    <label class="file-btn-wrap" for="f-brief">
                                                        <input type="file" name="project_brief" id="f-brief" accept=".pdf,.doc,.docx">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <span class="file-name" id="brief-name"><?= esc(site_trans('quote_file_none', $locale)) ?></span>
                                                        <span class="file-badge">PDF / DOCX · <?= sprintf(esc(site_trans('quote_file_max_label', $locale)), $briefMaxMb) ?></span>
                                                    </label>
                                                </div>
                                                <span class="field-err field-err-file"><?= sprintf(esc(site_trans('quote_validation_file_size', $locale)), $briefMaxMb) ?></span>
                                            </div>
                                        </div>
                                        <div class="step-actions">
                                            <span class="step-progress-txt"><?= esc(site_trans('quote_step_of', $locale)) ?> 2 <?= esc(site_trans('quote_step_of_total', $locale)) ?> 4</span>
                                            <div class="btns">
                                                <button type="button" class="qw-btn qw-btn-ghost prev-step"><i class="fas fa-arrow-left"></i> <?= esc(site_trans('quote_back', $locale)) ?></button>
                                                <button type="button" class="qw-btn qw-btn-primary next-step"><?= esc(site_trans('quote_continue', $locale)) ?> <i class="fas fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step-panel" data-step="3">
                                        <p class="step-title"><?= esc(site_trans('quote_contact_details_title', $locale)) ?></p>
                                        <p class="step-desc"><?= esc(site_trans('quote_contact_details_desc', $locale)) ?></p>
                                        <div class="field-grid">
                                            <div class="field">
                                                <label><?= esc(site_trans('quote_fullname_label', $locale)) ?><span class="req">*</span></label>
                                                <div class="field-wrap"><i class="fas fa-user"></i><input type="text" name="fullname" required value="<?= esc($quoteFormData['fullname'] ?? '') ?>" placeholder="<?= esc(site_trans('quote_placeholder_fullname', $locale)) ?>"></div>
                                            </div>
                                            <div class="field">
                                                <label><?= esc(site_trans('quote_company_label', $locale)) ?> <span class="opt">(<?= esc(site_trans('quote_optional', $locale)) ?>)</span></label>
                                                <div class="field-wrap"><i class="fas fa-building"></i><input type="text" name="company" value="<?= esc($quoteFormData['company'] ?? '') ?>"></div>
                                            </div>
                                            <div class="field">
                                                <label><?= esc(site_trans('quote_email_label', $locale)) ?><span class="req">*</span></label>
                                                <div class="field-wrap"><i class="fas fa-envelope"></i><input type="email" name="email" required value="<?= esc($quoteFormData['email'] ?? '') ?>"></div>
                                            </div>
                                            <div class="field">
                                                <label><?= esc(site_trans('quote_whatsapp_label', $locale)) ?><span class="req">*</span></label>
                                                <div class="field-wrap"><i class="fab fa-whatsapp"></i><input type="tel" name="whatsapp" required value="<?= esc($quoteFormData['whatsapp'] ?? '') ?>"></div>
                                            </div>
                                        </div>
                                        <div class="step-actions">
                                            <span class="step-progress-txt"><?= esc(site_trans('quote_step_of', $locale)) ?> 3 <?= esc(site_trans('quote_step_of_total', $locale)) ?> 4</span>
                                            <div class="btns">
                                                <button type="button" class="qw-btn qw-btn-ghost prev-step"><i class="fas fa-arrow-left"></i> <?= esc(site_trans('quote_back', $locale)) ?></button>
                                                <button type="button" class="qw-btn qw-btn-primary next-step"><?= esc(site_trans('quote_review_title', $locale)) ?> <i class="fas fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step-panel" data-step="4">
                                        <p class="step-title"><?= esc(site_trans('quote_review_send_title', $locale)) ?></p>
                                        <p class="step-desc"><?= esc(site_trans('quote_review_send_desc', $locale)) ?></p>
                                        <div class="review-grid">
                                            <div class="review-row"><div class="review-icon"><i class="fas fa-briefcase"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_service_label', $locale)) ?></p><p class="review-val" id="rev-service">—</p></div></div>
                                            <div class="review-row"><div class="review-icon"><i class="fas fa-heading"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_subject_label', $locale)) ?></p><p class="review-val" id="rev-subject">—</p></div></div>
                                            <div class="review-row"><div class="review-icon"><i class="fas fa-shapes"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_type_label', $locale)) ?></p><p class="review-val" id="rev-type">—</p></div></div>
                                            <div class="review-row"><div class="review-icon"><i class="fas fa-coins"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_budget_label', $locale)) ?></p><p class="review-val" id="rev-budget">—</p></div></div>
                                            <div class="review-row"><div class="review-icon"><i class="fas fa-calendar"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_start_label', $locale)) ?></p><p class="review-val" id="rev-start">—</p></div></div>
                                            <div class="review-row"><div class="review-icon"><i class="fas fa-user"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_fullname_label', $locale)) ?></p><p class="review-val" id="rev-name">—</p></div></div>
                                            <div class="review-row"><div class="review-icon"><i class="fas fa-envelope"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_email_label', $locale)) ?></p><p class="review-val" id="rev-email">—</p></div></div>
                                            <div class="review-row"><div class="review-icon"><i class="fab fa-whatsapp"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_whatsapp_label', $locale)) ?></p><p class="review-val" id="rev-whatsapp">—</p></div></div>
                                            <div class="review-row"><div class="review-icon"><i class="fas fa-paperclip"></i></div><div class="review-body"><p class="review-lbl"><?= esc(site_trans('quote_brief_label', $locale)) ?></p><p class="review-val empty" id="rev-file"><?= esc(site_trans('quote_file_none', $locale)) ?></p></div></div>
                                        </div>
                                        <div class="submit-info-box mt-4 mb-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="submit-icon"><i class="fas fa-paper-plane"></i></div>
                                                <div>
                                                    <h6 class="mb-1"><?= esc(site_trans('quote_send_both_title', $locale)) ?></h6>
                                                    <p class="mb-0 text-muted"><?= esc(site_trans('quote_send_both_desc', $locale)) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="step-actions">
                                            <span class="step-progress-txt"><?= esc(site_trans('quote_step_of', $locale)) ?> 4 <?= esc(site_trans('quote_step_of_total', $locale)) ?> 4</span>
                                            <div class="btns">
                                                <button type="button" class="qw-btn qw-btn-ghost prev-step"><i class="fas fa-arrow-left"></i> <?= esc(site_trans('quote_back', $locale)) ?></button>
                                                <button type="submit" class="qw-btn qw-btn-primary"><i class="fas fa-paper-plane"></i> <?= esc(site_trans('quote_send_request', $locale)) ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="preview-wrap">
        <div class="cards-row">
            <?php foreach ($contactDepartments as $dept): ?>
            <div class="contact-card">
                <div class="icon-wrap"><i class="fas <?= esc($dept['icon'] ?? '', 'attr') ?>"></i></div>
                <div class="body">
                    <p class="card-title"><?= esc(site_trans((string) ($dept['title_key'] ?? ''), $locale)) ?></p>
                    <p class="card-email"><?= esc((string) ($dept['email'] ?? '')) ?></p>
                    <p class="card-subtitle"><?= esc(site_trans((string) ($dept['desc_key'] ?? ''), $locale)) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php $this->setData(['locations' => $offices ?? [], 'locations_show_header' => true, 'map_embedded' => false]); ?>
    <?= $this->include('front/partials/locations-map') ?>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quoteForm');
    if (!form) return;

    const I18N = {
        fileNone: <?= json_encode(site_trans('quote_file_none', $locale)) ?>,
        fileTooLarge: <?= json_encode(sprintf(site_trans('quote_validation_file_size', $locale), $briefMaxMb)) ?>,
    };
    const BRIEF_MAX_BYTES = <?= (int) ($quoteBriefMaxBytes ?? ($briefMaxMb * 1024 * 1024)) ?>;

    const steps = document.querySelectorAll('.step-item');
    const contents = document.querySelectorAll('.step-panel');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    let currentStep = 1;

    function showStep(n) {
        steps.forEach(s => s.classList.remove('active', 'done'));
        contents.forEach(c => c.classList.remove('active'));
        steps.forEach((s, i) => {
            if (i + 1 < n) s.classList.add('done');
            if (i + 1 === n) s.classList.add('active');
        });
        document.querySelector('.step-panel[data-step="' + n + '"]')?.classList.add('active');
        if (n === 4) updateReview();
        const wrap = document.querySelector('.wizard-shell');
        if (wrap) {
            const y = wrap.getBoundingClientRect().top + window.pageYOffset - 80;
            window.scrollTo({ top: y, behavior: 'smooth' });
        }
    }

    function updateReview() {
        const getVal = (name) => {
            const el = form.querySelector('[name="' + name + '"]');
            return el ? (el.value || '—') : '—';
        };
        const getSelectText = (name) => {
            const el = form.querySelector('[name="' + name + '"]');
            return el && el.options ? (el.options[el.selectedIndex].text || '—') : '—';
        };
        const getServiceText = () => {
            const checked = form.querySelectorAll('input[name="services[]"]:checked');
            if (checked.length === 0) return '—';
            const services = [];
            checked.forEach(cb => {
                const card = cb.closest('.svc-card');
                if (card) {
                    const label = card.querySelector('.svc-body p');
                    if (label) services.push(label.textContent);
                }
            });
            return services.length ? services.join(', ') : '—';
        };

        document.getElementById('rev-service').textContent = getServiceText();
        document.getElementById('rev-subject').textContent = getVal('subject');
        document.getElementById('rev-type').textContent = getSelectText('project_type');
        document.getElementById('rev-budget').textContent = getSelectText('budget');
        document.getElementById('rev-start').textContent = getSelectText('start_date');
        document.getElementById('rev-name').textContent = getVal('fullname');
        document.getElementById('rev-email').textContent = getVal('email');
        document.getElementById('rev-whatsapp').textContent = getVal('whatsapp');

        const fileInput = form.querySelector('[name="project_brief"]');
        const revFile = document.getElementById('rev-file');
        if (fileInput && revFile) {
            if (fileInput.files.length > 0) {
                revFile.textContent = fileInput.files[0].name;
                revFile.classList.remove('empty');
            } else {
                revFile.textContent = I18N.fileNone;
                revFile.classList.add('empty');
            }
        }
    }

    function validateStep(step) {
        let valid = true;
        const panel = document.querySelector('.step-panel[data-step="' + step + '"]');
        if (!panel) return false;

        if (step === 1) {
            const checkedServices = form.querySelectorAll('input[name="services[]"]:checked');
            const servicesWrap = document.getElementById('fw-services');
            if (checkedServices.length === 0) {
                valid = false;
                servicesWrap?.classList.add('invalid');
            } else {
                servicesWrap?.classList.remove('invalid');
            }
        }

        if (step === 2) {
            const briefInput = document.getElementById('f-brief');
            const briefWrap = document.getElementById('fw-brief');
            if (briefInput && briefInput.files.length && briefInput.files[0].size > BRIEF_MAX_BYTES) {
                valid = false;
                briefWrap?.classList.add('invalid');
            } else {
                briefWrap?.classList.remove('invalid');
            }
        }

        panel.querySelectorAll('[required]').forEach(field => {
            const wrap = field.closest('.field-wrap');
            if (!field.value.trim()) {
                valid = false;
                wrap?.classList.add('invalid');
                field.classList.add('is-invalid');
            } else {
                wrap?.classList.remove('invalid');
                field.classList.remove('is-invalid');
            }
            if (field.type === 'email' && field.value.trim() && !/\S+@\S+\.\S+/.test(field.value.trim())) {
                valid = false;
                wrap?.classList.add('invalid');
            }
        });

        return valid;
    }

    nextBtns.forEach(btn => btn.addEventListener('click', () => {
        if (!validateStep(currentStep)) return;
        if (currentStep < 4) { currentStep++; showStep(currentStep); }
    }));
    prevBtns.forEach(btn => btn.addEventListener('click', () => {
        if (currentStep > 1) { currentStep--; showStep(currentStep); }
    }));

    form.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', function() {
            this.closest('.field-wrap')?.classList.remove('invalid');
            this.classList.remove('is-invalid');
        });
    });

    function updateCardState(card, checkbox, icon) {
        card.classList.toggle('sel', checkbox.checked);
        if (icon) icon.style.display = checkbox.checked ? 'block' : 'none';
        if (form.querySelectorAll('input[name="services[]"]:checked').length > 0) {
            document.getElementById('fw-services')?.classList.remove('invalid');
        }
    }

    document.querySelectorAll('.svc-card').forEach(card => {
        const checkbox = card.querySelector('.svc-checkbox');
        const checkIcon = card.querySelector('.svc-check');
        card.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                updateCardState(card, checkbox, checkIcon);
            }
        });
        checkbox?.addEventListener('change', function(e) {
            e.stopPropagation();
            updateCardState(card, checkbox, checkIcon);
        });
        if (checkIcon && checkbox) checkIcon.style.display = checkbox.checked ? 'block' : 'none';
    });

    const briefInput = document.getElementById('f-brief');
    const briefWrap = document.getElementById('fw-brief');
    const briefName = document.getElementById('brief-name');

    briefInput?.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) {
            if (briefName) briefName.textContent = I18N.fileNone;
            briefWrap?.classList.remove('invalid');
            return;
        }
        if (file.size > BRIEF_MAX_BYTES) {
            this.value = '';
            if (briefName) briefName.textContent = I18N.fileNone;
            briefWrap?.classList.add('invalid');
            return;
        }
        briefWrap?.classList.remove('invalid');
        if (briefName) briefName.textContent = file.name;
    });
});
</script>
<?= $this->endSection() ?>
