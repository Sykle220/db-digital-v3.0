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
        <div class="row justify-content-center">
            <?php
            $team_members = [
                ['img' => 'team_img01.jpg', 'name' => 'Brooklyn Simmons', 'role_key' => 'team_role_strategy'],
                ['img' => 'team_img02.jpg', 'name' => 'Guy Hawkins', 'role_key' => 'team_role_design'],
                ['img' => 'team_img03.jpg', 'name' => 'Savannah Nguyen', 'role_key' => 'team_role_dev'],
                ['img' => 'team_img04.jpg', 'name' => 'Kristin Watson', 'role_key' => 'team_role_marketing'],
            ];
            foreach ($team_members as $member):
            ?>
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