<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php wp_head(); ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172034250-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-172034250-1');
        </script>

        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '206789840594244');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=206789840594244&ev=PageView&noscript=1"
            /></noscript>
        <!-- End Facebook Pixel Code -->

        <link rel="profile" href="https://gmpg.org/xfn/11" />

        <link href="https://fonts.googleapis.com/css?family=Oswald:400,700|Work+Sans:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/fonts/icomoon/style.css">

        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/magnific-popup.css">
        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/jquery-ui.css">
        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/animate.css">

        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/fonts/flaticon/font/flaticon.css">

        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/jquery.fancybox.min.css">

        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/aos.css">

        <link rel="stylesheet" href="<?=get_theme_file_uri()?>/css/style.css">
    </head>

    <body <?php body_class(); ?> >
    <?php wp_body_open(); ?>
    <div class="site-wrap">

        <div class="site-mobile-menu">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div> <!-- .site-mobile-menu -->


        <div class="site-navbar-wrap fixed-top js-site-navbar bg-white">

            <div class="container">
                <div class="site-navbar bg-light">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <h2 class="mb-0 site-logo">
                                <a href="<?=get_home_url()?>" class="font-weight-bold text-uppercase">
                                    <img src="<?=get_theme_file_uri()?>/images/logo-transparent-min.png" alt="Tasyakur ID" class="logo-img">
                                </a>
                            </h2>
                        </div>
                        <div class="col-10">
                            <nav class="site-navigation text-right" role="navigation">
                                <?php
                                wp_nav_menu([
                                    'menu'            => 'primary',
                                    'theme_location'  => 'header-menu',
                                    'container'       => 'div',
                                    'container_class' => 'container',
                                    'menu_id'         => false,
                                    'menu_class'      => 'site-menu js-clone-nav d-none d-lg-block',
                                    'items_wrap'      => '<div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div><ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'depth'           => 0,
                                    'walker'          => new MainNavMenuWalker(),
                                ]);
                                ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrap">