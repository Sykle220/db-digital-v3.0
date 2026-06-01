<?php
// components/breadcrumb.php
// Usage: include 'components/breadcrumb.php'; (définir $breadcrumb_title avant)
?>
<section class="breadcrumb-area breadcrumb-bg" data-background="<?php echo ASSETS_URL; ?>img/bg/breadcrumb_bg.png">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content">
                    <h2 class="title"><?php echo $breadcrumb_title; ?></h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo getPageLink('index.php'); ?>"><?php echo __('breadcrumb_home'); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb_title; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-shape-wrap">
        <img src="<?php echo ASSETS_URL; ?>img/images/breadcrumb_shape01.png" alt="">
        <img src="<?php echo ASSETS_URL; ?>img/images/breadcrumb_shape02.png" alt="">
    </div>
</section>