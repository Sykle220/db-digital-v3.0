<?php
// components/team-section.php
// Section équipe utilisée sur index.php et about.php
?>
<section class="team-area-eight fix team-bg-eight" data-background="<?php echo ASSETS_URL; ?>img/bg/h9_team_bg.jpg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-title-two text-center text-lg-start mb-40 tg-heading-subheading animation-style2">
                    <span class="sub-title tg-element-title span1"><?php echo __('team_subtitle'); ?></span>
                    <h2 class="title tg-element-title"><?php echo __('team_title'); ?></h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-top-content mb-30">
                    <p><?php echo __('team_lead'); ?></p>
                </div>
            </div>
        </div>
        <?php
        $team_members = [
            ['img' => 'team_img_rose.png', 'name' => 'Eugénie Rose Yuoyang', 'role_key' => 'about_ceo'],
            ['img' => 'team_img_pascal.png', 'name' => 'Pierre Pascal Essomba', 'role_key' => 'team_role_graphic_designer'],
            ['img' => 'team_img_stephane.png', 'name' => 'Stephane Kamga', 'role_key' => 'team_role_dev'],
            ['img' => 'team_img03.jpg', 'name' => 'Fabien Meboue', 'role_key' => 'about_dg_douala'],
            ['img' => 'team_img_delphine.png', 'name' => 'Delphine Mengue', 'role_key' => 'team_role_video_designer'],
            ['img' => 'team_img_roland.png', 'name' => 'Roland Nyemeck', 'role_key' => 'about_dg_baf'],
            ['img' => 'team_img_lionel.png', 'name' => 'Lionel Dounia', 'role_key' => 'team_role_marketing_director'],
            ['img' => 'team_img_van.png', 'name' => 'Van Besong', 'role_key' => 'team_role_community_manager'],
            ['img' => 'team_img_ulrich.png', 'name' => 'Ulrich Fotso', 'role_key' => 'team_role_dev'],
        ];
        $team_use_carousel = count($team_members) > 4;
        $team_row_class = $team_use_carousel
            ? 'row team-active justify-content-center'
            : 'row justify-content-center';
        ?>
        <div class="<?php echo $team_row_class; ?>">
            <?php foreach ($team_members as $member): ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-9">
                <div class="team-item">
                    <div class="team-thumb">
                        <img src="<?php echo ASSETS_URL; ?>img/team/<?php echo $member['img']; ?>" alt="<?php echo $member['name']; ?>">
                        <div class="team-social">
                            <?php echo renderSocialIcons(); ?>
                        </div>
                    </div>
                    <div class="team-content">
                        <h2 class="title"><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo $member['name']; ?></a></h2>
                        <span><?php echo __($member['role_key']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="team-shape-two">
        <img src="<?php echo ASSETS_URL; ?>img/team/h9_team_shape01.png" alt="shape">
        <img src="<?php echo ASSETS_URL; ?>img/team/h9_team_shape02.png" alt="shape" data-aos="fade-up" data-aos-delay="400">
    </div>
</section>