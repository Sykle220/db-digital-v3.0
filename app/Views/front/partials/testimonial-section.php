<?php $testimonials = $testimonials ?? []; ?>
<section class="testimonial-area-four testimonial-bg-four" data-background="<?= asset_url('img/bg/h4_testimonial_bg.jpg') ?>">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="testimonial-img-four">
                    <div class="testimonial-img-active-four">
                        <?php foreach ($testimonials as $item): ?>
                        <div class="testimonial-img-slide-four">
                            <img src="<?= esc((string) ($item['image_url'] ?? asset_url('img/images/temoignage.png')), 'attr') ?>" alt="<?= esc((string) ($item['name'] ?? '')) ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="icon">
                        <img src="<?= asset_url('img/icons/quote02.svg') ?>" alt="">
                    </div>
                    <img src="<?= asset_url('img/images/h4_testimonial_img_shape.png') ?>" alt="" class="shape">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="testimonial-item-wrap-four">
                    <div class="testimonial-active-four">
                        <?php foreach ($testimonials as $item): ?>
                        <div class="testimonial-item-four">
                            <div class="testimonial-content-four">
                                <div class="rating">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <p>"<?= esc(lang_field($item, 'quote', $locale ?? null)) ?>"</p>
                                <div class="testimonial-info">
                                    <h2 class="title"><?= esc((string) ($item['name'] ?? '')) ?></h2>
                                    <span><?= esc(lang_field($item, 'role', $locale ?? null)) ?></span>
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
        <img src="<?= asset_url('img/images/h4_testimonial_shape01.png') ?>" alt="" data-aos="fade-up-right" data-aos-delay="200">
        <img src="<?= asset_url('img/images/h4_testimonial_shape02.png') ?>" alt="" data-aos="fade-down-left" data-aos-delay="200">
    </div>
</section>
