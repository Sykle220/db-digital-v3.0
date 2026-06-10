<section class="cta-area-five">
    <div class="container">
        <div class="cta-inner-wrap-two" data-background="<?= asset_url('img/bg/cta_bg02.jpg') ?>">
            <div class="row align-items-center">
                <div class="col-xl-9 col-12">
                    <div class="cta-content">
                        <div class="cta-info-wrap">
                            <div class="icon">
                                <i class="flaticon-phone-call"></i>
                            </div>
                            <div class="content">
                                <span><?= esc(site_trans('call_for_more_info', $locale ?? null)) ?></span>
                                <a href="tel:<?= esc(preg_replace('/\s+/', '', (string) ($contactPhone1 ?? '')), 'attr') ?>">
                                    <?= esc($contactPhone1 ?? '') ?>
                                </a>
                            </div>
                        </div>
                        <h2 class="title"><?= esc(site_trans('call_desc', $locale ?? null)) ?></h2>
                    </div>
                </div>
                <div class="col-xl-3 col-12">
                    <div class="cta-btn text-xl-end text-center">
                        <a href="<?= page_url('get-quote', $locale ?? null) ?>" class="btn btn-three btn-has-i"><?= btn_icon('quote') ?><?= esc(site_trans('btn_quote', $locale ?? null)) ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
