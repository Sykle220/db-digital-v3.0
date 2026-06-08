<?php
// components/testimonial-section.php
// Section témoignages (carrousel image + texte synchronisés)
// Utilisable sur index.php et autres pages

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
                                <p>"<?php echo htmlspecialchars(getTestimonialField($testimonial_item, 'quote')); ?>"</p>
                                <div class="testimonial-info">
                                    <h2 class="title"><?php echo htmlspecialchars($testimonial_item['name']); ?></h2>
                                    <span><?php echo htmlspecialchars(getTestimonialField($testimonial_item, 'role')); ?></span>
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
