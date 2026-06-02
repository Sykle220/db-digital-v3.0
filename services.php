<?php
// services.php
require_once 'includes/functions.php';
$page_title = __('services_page_title');
$page_description = __('meta_default_description');

// Services affichés (alignés avec DB Digital Agency)
$services = [
    [
        'id' => 1,
        'title_en' => 'Digital Strategy',
        'title_fr' => 'Stratégie Digitale',
        'image' => 'h4_services_img01.jpg',
        'icon' => 'flaticon-mission',
        'description_en' => 'Positioning, messaging, customer journey and a clear execution plan to hit growth targets.',
        'description_fr' => 'Positionnement, message, parcours client et plan d’exécution clair pour atteindre vos objectifs.',
    ],
    [
        'id' => 2,
        'title_en' => 'Web Development',
        'title_fr' => 'Développement Web',
        'image' => 'h4_services_img02.jpg',
        'icon' => 'flaticon-code',
        'description_en' => 'Fast, secure websites and web apps built for performance, SEO and conversion.',
        'description_fr' => 'Sites et applications web rapides et sécurisés, pensés performance, SEO et conversion.',
    ],
    [
        'id' => 3,
        'title_en' => 'Branding & UI/UX',
        'title_fr' => 'Branding & UI/UX',
        'image' => 'h4_services_img03.jpg',
        'icon' => 'flaticon-design',
        'description_en' => 'Brand identity and product design that build trust and make people take action.',
        'description_fr' => 'Identité de marque et design produit pour renforcer la confiance et déclencher l’action.',
    ],
    [
        'id' => 4,
        'title_en' => 'Growth Marketing',
        'title_fr' => 'Marketing d’Acquisition',
        'image' => 'h4_services_img04.jpg',
        'icon' => 'flaticon-profit',
        'description_en' => 'SEO, paid media and content systems that consistently generate qualified leads.',
        'description_fr' => 'SEO, publicité et contenus qui génèrent des prospects qualifiés de façon régulière.',
    ],
];

include 'includes/head.php';
include 'includes/header.php';
?>

<main class="fix">
    <?php 
    $breadcrumb_title = __('breadcrumb_services');
    include 'components/breadcrumb.php'; 
    ?>

    <!-- services-area (version homepage réutilisable) -->
    <section class="services-area-twelve1 fix">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="services-inner-content">
                        <div class="section-title-two blue-title mb-15 tg-heading-subheading animation-style2">
                            <span class="sub-title tg-element-title span1"><?php echo __('services_block_subtitle'); ?></span>
                            <h2 class="title tg-element-title"><?php echo __('services_block_title'); ?></h2>
                        </div>
                        <p class="p1"><?php echo __('services_page_lead'); ?></p>
                        <a href="<?php echo getPageLink('get-quote.php'); ?>" class="btn btn1 btn-three border-btn"><?php echo __('services_block_cta'); ?></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row gutter-24">
                        <?php 
                        foreach ($services as $svc):
                        ?>
                        <div class="col-md-6">
                            <div class="services-item-eight">
                                <div class="services-icon-eight">
                                    <i class="<?php echo $svc['icon']; ?>"></i>
                                </div>
                                <div class="services-content-eight">
                                    <h2 class="title"><a href="<?php echo getPageLink('get-quote.php'); ?>"><?php echo $current_lang === 'fr' ? $svc['title_fr'] : $svc['title_en']; ?></a></h2>
                                    <p><?php echo $current_lang === 'fr' ? $svc['description_fr'] : $svc['description_en']; ?></p>
                                    <a href="<?php echo getPageLink('get-quote.php'); ?>" class="link-btn"><?php echo __('services_details_cta'); ?>
                                        <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.5446 6.50759H1.41432C1.03607 6.50759 0.730469 6.22774 0.730469 5.88135C0.730469 5.53496 1.03607 5.25511 1.41432 5.25511H14.8927L10.7425 1.45463C10.4754 1.21001 10.4754 0.812736 10.7425 0.568112C11.0097 0.323487 11.4435 0.323487 11.7106 0.568112L17.0297 5.43907C17.2263 5.61911 17.284 5.88722 17.1772 6.12206C17.0703 6.35494 16.8203 6.50759 16.5446 6.50759Z" fill="currentcolor"/>
                                            <path d="M11.2191 11.3844C11.0439 11.3844 10.8686 11.3238 10.7361 11.2005C10.469 10.9558 10.469 10.5586 10.7361 10.3139L16.0616 5.43711C16.3288 5.19249 16.7626 5.19249 17.0297 5.43711C17.2969 5.68174 17.2969 6.07901 17.0297 6.32363L11.7042 11.2005C11.5696 11.3238 11.3943 11.3844 11.2191 11.3844Z" fill="currentcolor"/>
                                        </svg>
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
            <img src="<?php echo ASSETS_URL; ?>img/services/h6_services_shape01.png" alt="shape" data-aos="fade-down-left" data-aos-delay="400">
            <img src="<?php echo ASSETS_URL; ?>img/services/h6_services_shape02.png" alt="shape" data-aos="fade-up-right" data-aos-delay="400">
        </div>
    </section>

    <!-- brand-area -->
    <?php include 'components/brand-section.php'; ?>

</main>

<?php include 'includes/footer.php'; ?>