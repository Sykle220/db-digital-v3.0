<?php
// includes/footer.php
?>

    <!-- footer-area -->
    <footer>
        <div class="footer-area footer-bg">
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-lg-3 col-md-7">
                            <div class="footer-widget">
                                <h4 class="fw-title"><?php echo __('footer_info_title'); ?></h4>
                                <div class="footer-info">
                                    <ul class="list-wrap">
                                        <li>
                                            <div class="icon"><i class="flaticon-pin"></i></div>
                                            <div class="content"><p><?php echo CONTACT_ADDRESS; ?></p></div>
                                        </li>
                                        <li>
                                            <div class="icon"><i class="flaticon-phone-call"></i></div>
                                            <div class="content">
                                                <a href="tel:<?php echo preg_replace('/\s+/', '', CONTACT_PHONE_1); ?>"><?php echo CONTACT_PHONE_1; ?></a><br>
                                                <a href="tel:<?php echo preg_replace('/\s+/', '', CONTACT_PHONE_2); ?>"><?php echo CONTACT_PHONE_2; ?></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i class="flaticon-clock"></i></div>
                                            <div class="content">
                                                <p><?php echo __('footer_opening_hours'); ?>, <br> <?php echo __('footer_sunday'); ?> : <span><?php echo __('footer_closed'); ?></span></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 col-sm-6">
                            <div class="footer-widget">
                                <h4 class="fw-title"><?php echo __('footer_menu_title'); ?></h4>
                                <div class="footer-link">
                                    <ul class="list-wrap">
                                        <li><a href="<?php echo getPageLink('about.php'); ?>"><?php echo __('footer_menu_company'); ?></a></li>
                                        <li><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo __('footer_menu_careers'); ?></a></li>
                                        <li><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo __('footer_menu_press'); ?></a></li>
                                        <li><a href="<?php echo getPageLink('blog.php'); ?>"><?php echo __('nav_blog'); ?></a></li>
                                        <li><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo __('footer_menu_privacy'); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 col-sm-6">
                            <div class="footer-widget">
                                <h4 class="fw-title"><?php echo __('footer_quicklinks_title'); ?></h4>
                                <div class="footer-link">
                                    <ul class="list-wrap">
                                        <li><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo __('footer_ql_how'); ?></a></li>
                                        <li><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo __('footer_ql_partners'); ?></a></li>
                                        <li><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo __('footer_ql_testimonials'); ?></a></li>
                                        <li><a href="<?php echo getPageLink('projects.php'); ?>"><?php echo __('footer_ql_cases'); ?></a></li>
                                        <li><a href="#<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><?php echo __('footer_ql_pricing'); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-7">
                            <div class="footer-widget">
                                <h4 class="fw-title"><?php echo __('footer_newsletter'); ?></h4>
                                <div class="footer-newsletter">
                                    <p><?php echo __('footer_newsletter_desc'); ?></p>
                                    <form action="#">
                                        <input type="email" placeholder="<?php echo __('footer_email_placeholder'); ?>">
                                        <button type="submit"><?php echo __('footer_subscribe'); ?></button>
                                    </form>
                                    <span><?php echo __('footer_no_spam'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="left-sider">
                                <div class="f-logo">
                                    <a href="index.php<?php echo $current_lang !== 'en' ? '?lang=' . $current_lang : ''; ?>"><img src="<?php echo ASSETS_URL; ?>img/logo/w_logo02.png" alt=""></a>
                                </div>
                                <div class="copyright-text">
                                    <p><?php echo __('footer_copyright'); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="footer-social">
                                <?php echo renderSocialIcons(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- BOUTON WHATSAPP FLOTTANT -->
    <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=<?php echo urlencode(WHATSAPP_MESSAGE); ?>" 
       class="whatsapp-float" 
       target="_blank" 
       rel="noopener noreferrer"
       title="<?php echo __('whatsapp_text'); ?>">
        <i class="fab fa-whatsapp"></i>
        <!-- <span class="whatsapp-text"><?php echo __('whatsapp_text'); ?></span> -->
    </a>

<?php include __DIR__ . '/scripts.php'; ?>
</body>
</html>