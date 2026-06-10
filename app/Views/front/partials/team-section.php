<?php $team = $team ?? []; ?>
<section class="team-area-eight fix team-bg-eight" data-background="<?= asset_url('img/bg/h9_team_bg.jpg') ?>">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-title-two text-center text-lg-start mb-40 tg-heading-subheading animation-style2">
                    <span class="sub-title tg-element-title span1"><?= esc(site_trans('team_subtitle', $locale ?? null)) ?></span>
                    <h2 class="title tg-element-title"><?= esc(site_trans('team_title', $locale ?? null)) ?></h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-top-content mb-30">
                    <p><?= esc(site_trans('team_lead', $locale ?? null)) ?></p>
                </div>
            </div>
        </div>
        <?php $teamUseCarousel = count($team) > 4; ?>
        <div class="<?= $teamUseCarousel ? 'row team-active justify-content-center' : 'row justify-content-center' ?>">
            <?php foreach ($team as $member): ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-9">
                <div class="team-item">
                    <div class="team-thumb">
                        <img src="<?= esc(team_image_url($member), 'attr') ?>" alt="<?= esc((string) ($member['name'] ?? '')) ?>">
                        <div class="team-social">
                            <?= social_icons_html($socialLinks ?? null) ?>
                        </div>
                    </div>
                    <div class="team-content">
                        <h2 class="title"><a href="#"><?= esc((string) ($member['name'] ?? '')) ?></a></h2>
                        <span><?= esc(lang_field($member, 'role', $locale ?? null) ?: site_trans((string) ($member['role_key'] ?? ''), $locale ?? null)) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="team-shape-two">
        <img src="<?= asset_url('img/team/h9_team_shape01.png') ?>" alt="shape">
        <img src="<?= asset_url('img/team/h9_team_shape02.png') ?>" alt="shape" data-aos="fade-up" data-aos-delay="400">
    </div>
</section>
