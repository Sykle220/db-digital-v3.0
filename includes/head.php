<?php
// includes/head.php
require_once __DIR__ . '/functions.php';
?>
<!doctype html>
<html class="no-js" lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $page_title ?? SITE_NAME; ?> - <?php echo __('meta_suffix'); ?></title>
    <meta name="description" content="<?php echo $page_description ?? __('meta_default_description'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo ASSETS_URL; ?>img/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/animate.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/flaticon.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/odometer.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/jarallax.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/slick.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/aos.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/default.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/responsive.css">
    
    <!-- Custom CSS (WhatsApp + Lang Switcher) -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/custom.css">
    
    <!-- FontAwesome Brands (pour WhatsApp icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>