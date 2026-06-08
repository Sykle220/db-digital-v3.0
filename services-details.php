<?php
// services-details.php
require_once 'includes/functions.php';

$slug = trim((string) ($_GET['service'] ?? ''));
$service = $slug !== '' ? getServiceBySlug($slug) : null;

if ($service === null) {
    $service = $agency_services[0] ?? null;
    if ($service !== null) {
        header('Location: ' . getServiceLink($service['slug']), true, 302);
        exit;
    }
}

$page_title = getServiceField($service, 'title');
$page_description = getServiceField($service, 'description');
include 'includes/head.php';
include 'includes/header.php';

$benefits = getServiceField($service, 'benefits');
if (!is_array($benefits)) {
    $benefits = [];
}
$faq_items = $service['faq'] ?? [];
$accordion_id = 'serviceFaq-' . preg_replace('/[^a-z0-9-]/', '', $service['slug']);
?>

<main class="fix svc-detail-page">
    <?php
    $breadcrumb_title = getServiceField($service, 'title');
    include 'components/breadcrumb.php';
    ?>

    <section class="svc-detail-area" aria-labelledby="svc-detail-title">
        <div class="container">
            <header class="svc-detail-head">
                <a href="<?php echo getPageLink('services.php'); ?>" class="svc-detail-back">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    <?php echo __('services_details_back'); ?>
                </a>
                <span class="svc-detail-eyebrow"><?php echo __('services_block_subtitle'); ?></span>
                <div class="svc-detail-head-row">
                    <div class="svc-detail-icon" aria-hidden="true">
                        <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                    </div>
                    <div class="svc-detail-head-copy">
                        <h1 id="svc-detail-title" class="svc-detail-title"><?php echo htmlspecialchars(getServiceField($service, 'title')); ?></h1>
                        <p class="svc-detail-lead"><?php echo htmlspecialchars(getServiceField($service, 'intro')); ?></p>
                    </div>
                </div>
            </header>

            <div class="svc-detail-grid" id="svcDetailGrid">
                <article class="svc-detail-main">
                    <div class="svc-detail-card">
                        <figure class="svc-detail-figure">
                            <img
                                src="<?php echo ASSETS_URL; ?>img/services/<?php echo htmlspecialchars($service['detail_image']); ?>"
                                alt="<?php echo htmlspecialchars(getServiceField($service, 'title')); ?>"
                                loading="lazy"
                                decoding="async"
                            >
                        </figure>

                        <div class="svc-detail-body">
                            <p><?php echo htmlspecialchars(getServiceField($service, 'body')); ?></p>
                        </div>

                        <div class="svc-detail-callout">
                            <h2 class="svc-detail-callout-title"><?php echo htmlspecialchars(getServiceField($service, 'highlight_title')); ?></h2>
                            <p><?php echo htmlspecialchars(getServiceField($service, 'highlight_text')); ?></p>
                        </div>

                        <div class="svc-detail-duo">
                            <div class="svc-detail-panel">
                                <span class="svc-detail-panel-label"><?php echo htmlspecialchars(getServiceField($service, 'goal_title')); ?></span>
                                <p><?php echo htmlspecialchars(getServiceField($service, 'goal_text')); ?></p>
                            </div>
                            <div class="svc-detail-panel svc-detail-panel--accent">
                                <span class="svc-detail-panel-label"><?php echo htmlspecialchars(getServiceField($service, 'challenge_title')); ?></span>
                                <p><?php echo htmlspecialchars(getServiceField($service, 'challenge_text')); ?></p>
                            </div>
                        </div>

                        <?php if (!empty($benefits)): ?>
                        <div class="svc-detail-benefits">
                            <h2 class="svc-detail-benefits-title"><?php echo __('services_details_benefits'); ?></h2>
                            <ul class="svc-detail-benefits-list">
                                <?php foreach ($benefits as $benefit): ?>
                                <li>
                                    <span class="svc-detail-benefits-check" aria-hidden="true"><i class="fas fa-check"></i></span>
                                    <span><?php echo htmlspecialchars($benefit); ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($faq_items)): ?>
                        <div class="svc-detail-faq">
                            <h2 class="svc-detail-faq-title"><?php echo __('services_details_faq_title'); ?></h2>
                            <div class="svc-detail-accordion accordion" id="<?php echo htmlspecialchars($accordion_id); ?>">
                                <?php foreach ($faq_items as $i => $item): ?>
                                <?php
                                    $collapse_id = $accordion_id . '-item-' . $i;
                                    $is_first = $i === 0;
                                    $q = $current_lang === 'fr' ? ($item['q_fr'] ?? $item['q_en'] ?? '') : ($item['q_en'] ?? '');
                                    $a = $current_lang === 'fr' ? ($item['a_fr'] ?? $item['a_en'] ?? '') : ($item['a_en'] ?? '');
                                ?>
                                <div class="accordion-item svc-detail-accordion-item">
                                    <h3 class="accordion-header">
                                        <button
                                            class="accordion-button<?php echo $is_first ? '' : ' collapsed'; ?>"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#<?php echo $collapse_id; ?>"
                                            aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
                                            aria-controls="<?php echo $collapse_id; ?>"
                                        >
                                            <?php echo htmlspecialchars($q); ?>
                                        </button>
                                    </h3>
                                    <div
                                        id="<?php echo $collapse_id; ?>"
                                        class="accordion-collapse collapse<?php echo $is_first ? ' show' : ''; ?>"
                                        data-bs-parent="#<?php echo htmlspecialchars($accordion_id); ?>"
                                    >
                                        <div class="accordion-body">
                                            <p><?php echo htmlspecialchars($a); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="svc-detail-mobile-cta">
                            <a href="<?php echo getPageLink('get-quote.php'); ?>" class="svc-detail-btn svc-detail-btn--primary btn-has-i">
                                <?php echo btnIcon('quote'); ?><?php echo __('services_details_cta'); ?>
                            </a>
                        </div>
                    </div>
                </article>

                <aside class="svc-detail-aside" aria-label="<?php echo htmlspecialchars(__('services_details_all_services')); ?>">
                    <div class="svc-detail-aside-fixed" id="svcDetailAside">
                        <nav class="svc-detail-nav">
                            <p class="svc-detail-nav-title"><?php echo __('services_details_all_services'); ?></p>
                            <ul class="svc-detail-nav-list">
                                <?php foreach ($agency_services as $svc): ?>
                                <li>
                                    <a
                                        href="<?php echo getServiceLink($svc['slug']); ?>"
                                        class="svc-detail-nav-link<?php echo ($svc['slug'] === $service['slug']) ? ' is-active' : ''; ?>"
                                        <?php echo ($svc['slug'] === $service['slug']) ? 'aria-current="page"' : ''; ?>
                                    >
                                        <span class="svc-detail-nav-icon" aria-hidden="true"><i class="<?php echo htmlspecialchars($svc['icon']); ?>"></i></span>
                                        <span class="svc-detail-nav-label"><?php echo htmlspecialchars(getServiceField($svc, 'title')); ?></span>
                                        <i class="fas fa-chevron-right svc-detail-nav-chev" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>

                        <div class="svc-detail-aside-card svc-detail-aside-card--phone">
                            <div class="svc-detail-aside-icon" aria-hidden="true"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <p class="svc-detail-aside-label"><?php echo __('services_details_sidebar_help'); ?></p>
                                <a href="tel:<?php echo preg_replace('/\s+/', '', CONTACT_PHONE_1); ?>" class="svc-detail-phone">
                                    <?php echo htmlspecialchars(CONTACT_PHONE_1); ?>
                                </a>
                            </div>
                        </div>

                        <div class="svc-detail-aside-card svc-detail-aside-card--cta">
                            <p class="svc-detail-aside-label"><?php echo __('services_details_sidebar_quote'); ?></p>
                            <p class="svc-detail-aside-lead"><?php echo __('services_details_sidebar_quote_lead'); ?></p>
                            <div class="svc-detail-aside-actions">
                                <a href="<?php echo getPageLink('get-quote.php'); ?>" class="svc-detail-btn svc-detail-btn--primary btn-has-i">
                                    <?php echo btnIcon('quote'); ?><?php echo __('services_details_cta'); ?>
                                </a>
                                <a href="<?php echo getPageLink('contact.php'); ?>" class="svc-detail-btn svc-detail-btn--secondary btn-has-i">
                                    <?php echo btnIcon('contact'); ?><?php echo __('btn_contact'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <?php include 'components/brand-section.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>
