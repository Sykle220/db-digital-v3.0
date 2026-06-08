<?php
// components/testimonial-section.php
// Section témoignages (carrousel image + texte synchronisés)
// Utilisable sur index.php et autres pages

$testimonials = $testimonials ?? [
    [
        'img' => 'temoignage_kamga.png',
        'name' => 'Mr. Aristide KAMGA',
        'role_fr' => 'Direction Générale, N2VTI',
        'role_en' => 'General Direction, N2VTI',
        'quote_fr' => 'Avant DB Digital Agency, nous avions peu d’inscriptions. En quelques semaines, leur stratégie a boosté notre visibilité et attiré des candidats qualifiés. Nous recommandons vivement.',
        'quote_en' => 'Before working with DB Digital Agency, we had few enrollments. Within weeks, their strategy boosted our visibility and attracted qualified applicants. We highly recommend them.',
    ],
    [
        'img' => 'temoignage_kamagate.png',
        'name' => 'ALLY Kamagaté',
        'role_fr' => 'Administration, DM Academy Côte d’Ivoire',
        'role_en' => 'Administration, DM Academy Ivory Coast',
        'quote_fr' => 'Nous cherchions une solution d’inscriptions prévisible. DB Digital Agency nous a apporté une stratégie efficace, générant plus de prospects qualifiés et de conversions. Un partenaire clé de notre croissance.',
        'quote_en' => 'We were looking for a predictable enrollment solution. DB Digital Agency delivered an effective strategy that increased qualified leads and conversions. A key partner in our growth.',
    ],
];

foreach ($testimonials as &$testimonial_item) {
    $testimonial_item['img_url'] = testimonialImageUrl($testimonial_item['img']);
}
unset($testimonial_item);
?>
<section class="testimonial-area-four testimonial-bg-four" data-background="<?php echo ASSETS_URL; ?>img/bg/h4_testimonial_bg.jpg">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="testimonial-img-four">
                    <div class="testimonial-img-active-four">
                        <?php foreach ($testimonials as $testimonial_item): ?>
                        <div class="testimonial-img-slide-four">
                            <img src="<?php echo $testimonial_item['img_url']; ?>" alt="<?php echo htmlspecialchars($testimonial_item['name']); ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="icon">
                        <img src="<?php echo ASSETS_URL; ?>img/icons/quote02.svg" alt="">
                    </div>
                    <img src="<?php echo ASSETS_URL; ?>img/images/h4_testimonial_img_shape.png" alt="" class="shape">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="testimonial-item-wrap-four">
                    <div class="testimonial-active-four">
                        <?php foreach ($testimonials as $testimonial_item): ?>
                        <div class="testimonial-item-four">
                            <div class="testimonial-content-four">
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p>"<?php echo $current_lang === 'fr' ? $testimonial_item['quote_fr'] : $testimonial_item['quote_en']; ?>"</p>
                                <div class="testimonial-info">
                                    <h2 class="title"><?php echo htmlspecialchars($testimonial_item['name']); ?></h2>
                                    <span><?php echo $current_lang === 'fr' ? $testimonial_item['role_fr'] : $testimonial_item['role_en']; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
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
