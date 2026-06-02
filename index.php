<?php
// index.php
require_once 'includes/functions.php';
$page_title = $current_lang === 'fr' ? 'Accueil' : 'Home';
$page_description = $current_lang === 'fr' 
    ? __('meta_default_description') 
    : __('meta_default_description');
include 'includes/head.php';
include 'includes/header.php';
?>

<main class="fix">

    <!-- banner-area -->
    <section class="banner-area-nine banner-bg-nine" data-background="<?php echo ASSETS_URL; ?>img/banner/h_hero_bg.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="banner-content-nine">
                        <h2 class="title wow" data-aos="fade-up" data-aos-delay="200"><?php echo __('hero_title'); ?></h2>
                        <p data-aos="fade-up" data-aos-delay="400"><?php echo __('hero_desc'); ?></p>
                        <div class="banner-btn-nine" data-aos="fade-up" data-aos-delay="600">
                            <a href="<?php echo getPageLink('about.php'); ?>" class="btn btn-three btn-four"><?php echo __('btn_read_more'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-shape-wrap-nine">
            <img src="<?php echo ASSETS_URL; ?>img/banner/h10_hero_shape01.png" alt="shape" data-aos="fade-down-right" data-aos-delay="600">
            <img src="<?php echo ASSETS_URL; ?>img/banner/h10_hero_shape02.png" alt="shape" data-aos="fade-up-left" data-aos-delay="600">
            <img src="<?php echo ASSETS_URL; ?>img/banner/h10_hero_shape03.png" alt="shape" data-aos="fade-up-left" data-aos-delay="800">
        </div>
    </section>
    <!-- banner-area-end -->

    <!-- features-area -->
    <section class="features-area-two pt-80">
        <div class="container">
            <div class="features-item-wrap">
                <div class="row justify-content-center">
                    <?php 
                    $features = [
                        ['icon' => 'flaticon-layers', 'title_key' => 'features_growing', 'desc_en' => 'Strategy and journeys built to convert.', 'desc_fr' => 'Stratégie et parcours pensés conversion.'],
                        ['icon' => 'flaticon-mission', 'title_key' => 'features_finance', 'desc_en' => 'Acquisition systems optimized for ROI.', 'desc_fr' => 'Acquisition optimisée pour le ROI.'],
                        ['icon' => 'flaticon-profit', 'title_key' => 'features_tax', 'desc_en' => 'Brand and UX that build trust fast.', 'desc_fr' => 'Marque et UX qui rassurent vite.'],
                    ];
                    foreach ($features as $f):
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="features-item-two">
                            <div class="features-icon-two">
                                <i class="<?php echo $f['icon']; ?>"></i>
                            </div>
                            <div class="features-content-two">
                                <h4 class="title"><?php echo __($f['title_key']); ?></h4>
                                <p><?php echo $current_lang === 'fr' ? $f['desc_fr'] : $f['desc_en']; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- features-area-end -->

    <!-- about-area -->
    <section class="about-area-three">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-9">
                    <div class="about-img-wrap-three">
                        <img src="<?php echo ASSETS_URL; ?>img/images/h_about_img01.png" alt="" data-aos="fade-down-right" data-aos-delay="0">
                        <img src="<?php echo ASSETS_URL; ?>img/images/h_about_img02.png" alt="" data-aos="fade-left" data-aos-delay="400">
                        <div class="experience-wrap" data-aos="fade-up" data-aos-delay="300">
                            <h2 class="title">2+ <span><?php echo __('homepage_exp_years'); ?></span></h2>
                            <p><?php echo __('homepage_exp_label'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-three">
                        <div class="section-title-two mb-20 tg-heading-subheading animation-style3">
                            <span class="sub-title span1"><?php echo __('about_subtitle'); ?></span>
                            <h2 class="title tg-element-title"><?php echo __('about_title'); ?></h2>
                        </div>
                        <p class="info-one"><?php echo __('homepage_about_lead'); ?></p>
                        <div class="about-list-two">
                            <ul class="list-wrap">
                                <li><i class="fas fa-arrow-right"></i><?php echo __('homepage_about_list_1'); ?></li>
                                <li><i class="fas fa-arrow-right"></i><?php echo __('homepage_about_list_2'); ?></li>
                                <li><i class="fas fa-arrow-right"></i><?php echo __('homepage_about_list_3'); ?></li>
                                <li><i class="fas fa-arrow-right"></i><?php echo __('homepage_about_list_4'); ?></li>
                            </ul>
                        </div>
                        <p><?php echo __('homepage_about_conclusion'); ?></p>
                        <div class="about-author-info">
                            <div class="thumb">
                                <img src="<?php echo ASSETS_URL; ?>img/images/about_author.png" alt="CEO">
                            </div>
                            <div class="content">
                                <h2 class="title">Erick Patrick Mouaffo</h2>
                                <span><?php echo __('about_ceo'); ?></span>
                            </div>
                            <div class="signature">
                                <img src="<?php echo ASSETS_URL; ?>img/images/signature.png" alt="Signature">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-shape-wrap-two">
            <img src="<?php echo ASSETS_URL; ?>img/images/h2_about_shape01.png" alt="">
            <img src="<?php echo ASSETS_URL; ?>img/images/h2_about_shape02.png" alt="">
            <img src="<?php echo ASSETS_URL; ?>img/images/h2_about_shape03.png" alt="" data-aos="fade-left" data-aos-delay="500">
        </div>
    </section>
    <!-- about-area-end -->

    <!-- services-area -->
    <section class="services-area-twelve fix">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="services-inner-content">
                        <div class="section-title-two white-title mb-15 tg-heading-subheading animation-style2">
                            <span class="sub-title tg-element-title span1"><?php echo __('services_subtitle'); ?></span>
                            <h2 class="title tg-element-title"><?php echo __('services_title'); ?></h2>
                        </div>
                        <p><?php echo $current_lang === 'fr' ? 'Nous fournissons des solutions digitales de bout en bout adaptées au contexte du marché africain et à vos besoins commerciaux spécifiques.' : 'We provide end-to-end digital solutions tailored to the African market context and your specific business needs.'; ?></p>
                        <a href="<?php echo getPageLink('services.php'); ?>" class="btn btn-three border-btn"><?php echo __('services_btn'); ?></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row gutter-24">
                        <?php 
                        $homepage_services = [
                            ['icon' => 'flaticon-mission', 'title_en' => 'Digital Strategy', 'title_fr' => 'Stratégie Digitale', 'desc_en' => 'Positioning, messaging and a clear plan to grow your business online.', 'desc_fr' => 'Positionnement, message et plan clair pour accélérer votre croissance en ligne.'],
                            ['icon' => 'flaticon-code', 'title_en' => 'Web Development', 'title_fr' => 'Développement Web', 'desc_en' => 'Fast, secure websites and apps built for performance and conversion.', 'desc_fr' => 'Sites et apps rapides, sécurisés, pensés performance et conversion.'],
                            ['icon' => 'flaticon-design', 'title_en' => 'Branding & UI/UX', 'title_fr' => 'Branding & UI/UX', 'desc_en' => 'Identity and product design that build trust and drive action.', 'desc_fr' => 'Identité et design produit pour renforcer la confiance et déclencher l’action.'],
                            ['icon' => 'flaticon-profit', 'title_en' => 'Growth Marketing', 'title_fr' => 'Marketing d’Acquisition', 'desc_en' => 'SEO and paid media systems that generate qualified leads consistently.', 'desc_fr' => 'SEO et publicité pour générer des prospects qualifiés de façon régulière.'],
                        ];
                        foreach ($homepage_services as $svc):
                        ?>
                        <div class="col-md-6">
                            <div class="services-item-eight">
                                <div class="services-icon-eight">
                                    <i class="<?php echo $svc['icon']; ?>"></i>
                                </div>
                                <div class="services-content-eight">
                                    <h2 class="title"><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo $current_lang === 'fr' ? $svc['title_fr'] : $svc['title_en']; ?></a></h2>
                                    <p><?php echo $current_lang === 'fr' ? $svc['desc_fr'] : $svc['desc_en']; ?></p>
                                    <a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>" class="link-btn"><?php echo $current_lang === 'fr' ? 'Voir Détails' : 'See Details'; ?>
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
    <!-- services-area-end -->

    <!-- counter-area -->
    <div class="counter-area-five">
        <div class="container">
            <div class="row">
                <?php 
                $counters = [
                    ['icon' => 'flaticon-folder-1', 'label_key' => 'counter_projects', 'count' => 9525],
                    ['icon' => 'flaticon-rating', 'label_key' => 'counter_clients', 'count' => 11985],
                    ['icon' => 'flaticon-trophy', 'label_key' => 'counter_awards', 'count' => 4722],
                    ['icon' => 'flaticon-puzzle-piece', 'label_key' => 'counter_countries', 'count' => 9522],
                ];
                foreach ($counters as $c):
                ?>
                <div class="col-lg-3 col-sm-6">
                    <div class="counter-item-five">
                        <div class="counter-icon-five">
                            <i class="<?php echo $c['icon']; ?>"></i>
                        </div>
                        <div class="counter-content-five">
                            <p><?php echo __($c['label_key']); ?></p>
                            <span class="count odometer" data-count="<?php echo $c['count']; ?>"></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- counter-area-end -->

    <!-- project-area -->
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
                <div class="col-lg-6 col-md-4">
                    <div class="view-all-btn text-end mb-30">
                        <a href="<?php echo getPageLink('projects.php'); ?>" class="btn btn-three"><?php echo __('projects_btn'); ?></a>
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
    <!-- project-area-end -->

    <!-- team-area -->
    <?php include 'components/team-section.php'; ?>
    <!-- team-area-end -->

    <!-- testimonial-area -->
    <section class="testimonial-area-four testimonial-bg-four" data-background="<?php echo ASSETS_URL; ?>img/bg/h4_testimonial_bg.jpg">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="testimonial-img-four">
                        <img src="<?php echo ASSETS_URL; ?>img/images/h4_testimonial_img.png" alt="">
                        <div class="icon">
                            <img src="<?php echo ASSETS_URL; ?>img/icons/quote02.svg" alt="">
                        </div>
                        <img src="<?php echo ASSETS_URL; ?>img/images/h4_testimonial_img_shape.png" alt="" class="shape">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="testimonial-item-wrap-four">
                        <div class="testimonial-active-four">
                            <div class="testimonial-item-four">
                                <div class="testimonial-content-four">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p>"<?php echo $current_lang === 'fr' ? 'Service exceptionnel et équipe très professionnelle. Ils ont transformé notre présence digitale et augmenté nos revenus de 40%.' : 'Exceptional service and very professional team. They transformed our digital presence and increased our revenue by 40%.'; ?>"</p>
                                    <div class="testimonial-info">
                                        <h2 class="title">Mr. Erick Patrick Mouaffo</h2>
                                        <span>CEO, DB Digital Agency</span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-item-four">
                                <div class="testimonial-content-four">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p>"<?php echo $current_lang === 'fr' ? 'DB Digital Agency a dépassé toutes nos attentes. Leur expertise en stratégie fiscale nous a fait économiser des milliers de dollars.' : 'DB Digital Agency exceeded all our expectations. Their tax strategy expertise saved us thousands of dollars.'; ?>"</p>
                                    <div class="testimonial-info">
                                        <h2 class="title">Sorelle Manga</h2>
                                        <span><?php echo $current_lang === 'fr' ? 'Directrice, TechStart Cameroun' : 'Director, TechStart Cameroon'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-nav-four"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonial-shape-wrap-four">
            <img src="<?php echo ASSETS_URL; ?>img/images/h4_testimonial_shape01.png" alt="" data-aos="fade-up-right" data-aos-delay="200">
            <img src="<?php echo ASSETS_URL; ?>img/images/h4_testimonial_shape02.png" alt="" data-aos="fade-down-left" data-aos-delay="200">
        </div>
    </section>
    <!-- testimonial-area-end -->

    <!-- brand-area -->
    <div class="brand-area-six pt-80 pb-80">
        <div class="container">
            <div class="row brand-active">
                <?php 
                $brands = ['brand_img01.png', 'brand_img02.png', 'brand_img03.png', 'brand_img04.png', 'brand_img05.png', 'brand_img03.png'];
                foreach ($brands as $brand): 
                ?>
                <div class="col-lg-12">
                    <div class="brand-item">
                        <img src="<?php echo ASSETS_URL; ?>img/brand/<?php echo $brand; ?>" alt="Partner">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- brand-area-end -->

    <!-- blog-area -->
    <section class="blog-area-two blog-bg-two" data-background="<?php echo ASSETS_URL; ?>img/bg/h2_blog_bg.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title-two text-center mb-50 tg-heading-subheading animation-style2">
                        <span class="sub-title tg-element-title span1"><?php echo __('blog_subtitle'); ?></span>
                        <h2 class="title tg-element-title"><?php echo __('blog_title'); ?></h2>
                        <p><?php echo $current_lang === 'fr' ? 'Restez informé avec nos analyses sur la transformation digitale, la stratégie d\'entreprise et les tendances du marché.' : 'Stay informed with insights on digital transformation, business strategy, and market trends.'; ?></p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php 
                $home_blogs = array_slice($blog_posts, 0, 3);
                foreach ($home_blogs as $post):
                ?>
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="blog-post-item-two">
                        <div class="blog-post-thumb-two">
                            <a href="<?php echo $post['url'] . ($current_lang !== 'en' ? '&lang=' . $current_lang : ''); ?>">
                                <img src="<?php echo ASSETS_URL; ?>img/blog/<?php echo $post['image']; ?>" alt="<?php echo htmlspecialchars(getBlogField($post, 'title')); ?>">
                            </a>
                            <a href="blog.php?category=<?php echo urlencode(getBlogField($post, 'category')) . ($current_lang !== 'en' ? '&lang=' . $current_lang : ''); ?>" class="tag"><?php echo getBlogField($post, 'category'); ?></a>
                        </div>
                        <div class="blog-post-content-two">
                            <h2 class="title">
                                <a href="<?php echo $post['url'] . ($current_lang !== 'en' ? '&lang=' . $current_lang : ''); ?>"><?php echo htmlspecialchars(getBlogField($post, 'title')); ?></a>
                            </h2>
                            <p><?php echo htmlspecialchars(getBlogField($post, 'excerpt')); ?></p>
                            <div class="blog-meta">
                                <ul class="list-wrap">
                                    <li>
                                        <a href="<?php echo $post['url'] . ($current_lang !== 'en' ? '&lang=' . $current_lang : ''); ?>"><img src="<?php echo ASSETS_URL; ?>img/blog/<?php echo $post['avatar']; ?>" alt="<?php echo htmlspecialchars($post['author']); ?>"><?php echo htmlspecialchars($post['author']); ?></a>
                                    </li>
                                    <li><i class="far fa-calendar"></i><?php echo $post['date']; ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- blog-area-end -->

</main>

<?php include 'includes/footer.php'; ?>