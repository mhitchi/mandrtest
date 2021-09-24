<!DOCTYPE html>
<html class="no-js" <?php language_attributes();?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
	<link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet"> 

    <?php wp_head(); ?>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#ffffff">
    
    <script type="text/javascript">
    <?php if( is_front_page() ) : ?>
        $(document).ready(function(){
            $('#loading-delay').delay(1000).fadeOut(300);
            setTimeout( function(){
                $(document.body).trigger('siteLoaded');
                $(document.body).addClass('site-loaded');
            }, 700);
        });	
    <?php else : ?>
        $(document).ready(function(){
            $('#loading-delay').delay(400).fadeOut(300);
            setTimeout( function(){
                $(document.body).trigger('siteLoaded');
                $(document.body).addClass('site-loaded');
            }, 700);
        });	
    <?php endif; ?>
    </script>	
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <div id="loading-delay"></div>

    <a class="skip-content" href="#primary-wrap" title="Skip to main content of page" tabindex="0">Skip to Content</a>
	
    <div id="main">
        <header id="header" class="header" role="banner">
            <div class="header__container container">
                <p class="header__logo site-title">
                    <a class="header__logo__link" href="<?php bloginfo('url'); ?>/">
                        <img class="header__logo__image" src="<?php bloginfo('template_url'); ?>/assets/images/logo.svg" alt="<?php echo bloginfo('name'); ?> logo" />
                    </a>
                    <span class="header__logo__text sr-only"><?php echo bloginfo('name'); ?></span>
                </p>
                
                <nav class="header__navigation primary-nav">
                    <?php 
                        wp_nav_menu( array(
                            'container'       => 'ul', 
                            'menu_class'      => 'sf-menu', 
                            'menu_id'         => 'topnav',
                            'depth'           => 0,
                            'theme_location' => 'header_menu',
                            'link_before' => '<span class="link-text">',
                            'link_after' => '</span>'
                        )); 
                    ?>
                </nav>
                <button id="mobile-trigger" type="button" class="mobile-header__button button--clear">
                    <span class="mobile-header__button__icon"></span>
                    <span class="mobile-header__button__text sr-only"><span class="text-closed">Menu</span><span class="text-opened">Close</span></span>
                </button>
            </div>

            <?php get_template_part('template-parts/menus/mobile-nav'); ?>
        </header>
