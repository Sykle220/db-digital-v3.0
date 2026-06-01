<?php
// includes/scripts.php
?>
    <!-- JS here -->
    <script src="<?php echo ASSETS_URL; ?>js/vendor/jquery-3.6.0.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/jquery.odometer.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/jquery.appear.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/gsap.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/ScrollTrigger.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/SplitText.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/gsap-animation.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/jarallax.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/jquery.parallaxScroll.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/particles.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/jquery.easypiechart.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/jquery.inview.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/swiper-bundle.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/slick.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/ajax-form.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/aos.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/wow.min.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/main.js"></script>
    <script>
        // Circle text animation
        const text = document.querySelector('.circle');
        if(text) {
            text.innerHTML = text.textContent.replace(/\S/g, "<span>$&</span>");
            const element = document.querySelectorAll('.circle span');
            for (let i = 0; i < element.length; i++) {
                element[i].style.transform = "rotate(" + i * 16 + "deg)";
            }
        }
    </script>