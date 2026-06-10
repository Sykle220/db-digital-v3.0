<?php $breadcrumbTitle = $breadcrumbTitle ?? ''; ?>
<section class="breadcrumb-area breadcrumb-bg" data-background="<?= asset_url('img/bg/breadcrumb_bg.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content">
                    <h2 class="title"><?= esc($breadcrumbTitle) ?></h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= page_url('home', $locale ?? null) ?>"><?= esc(site_trans('breadcrumb_home', $locale ?? null)) ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= esc($breadcrumbTitle) ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-shape-wrap">
        <img src="<?= asset_url('img/images/breadcrumb_shape01.png') ?>" alt="">
        <img src="<?= asset_url('img/images/breadcrumb_shape02.png') ?>" alt="">
    </div>
</section>
