<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Excellink
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'excellink-store'); ?></a>

        <div class="header-top">
            <p class="container mb-0 text-capitalize">Srilanka No.1 Largest Cake Decor Store | Limited offers | Free Shipping Orders LKR 5000/-</p>
        </div>
        
        <header id="masthead" class="site-header sticky-top">
            <div class="sitehead">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Mobile Navigation -->
                         <div class="col-3 d-md-none">
                        <button class="menu-toggle ms-3" data-bs-toggle="offcanvas" data-bs-target="#mobileNavigation" aria-controls="mobileNavigation" aria-expanded="false">
                                 <i class="bi bi-list"></i>
                            </button>
                            </div>

                        <!-- Logo -->
                        <div class="col-6 col-md-3 mb-2 mb-md-0">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-container">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/public/images/excellogo.png"
                                    alt="<?php echo esc_attr(get_bloginfo()); ?>" class="excellogoimg">
                            </a>
                        </div>
                        
                        <!-- Search on desktop -->
                        <div class="col-md-6 d-none d-md-block">
                            <div class="yith searchproductshead">
                                <?php echo do_shortcode('[yith_woocommerce_ajax_search preset="default"]'); ?>
                            </div>
                        </div>
                        
                        <!-- Cart and mobile menu toggle -->
                        <div class="col-3 col-md-3 d-flex align-items-center justify-content-center">
                            <div class="cart-container">
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cartheadico">
                                    <span class="cart-icon"><i class="fas fa-shopping-cart"></i></span>
                                    <span class="cart-text d-none d-md-inline">Cart</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Search on mobile - under logo and cart -->
                        <div class="col-12 d-md-none mt-2 mb-2">
                            <div class="yith searchproductshead">
                                <?php echo do_shortcode('[yith_woocommerce_ajax_search preset="default"]'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Menu -->
        <div class="menu-container d-none d-md-block">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <nav id="site-navigation" class="main-navigation">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'primary-menu',
                                'container_class' => 'primary-menu-container',
                            )
                        );
                        ?>
                    </nav>
                    
                    <div class="header-links d-flex">
                        <p class="mb-0 me-4">
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                                <?php esc_html_e('Account', 'excellink-store'); ?>
                            </a>
                        </p>
                        <p class="mb-0">
                            <a href="/tracking">Tracking</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Off-Canvas Menu -->
        <div class="d-md-none">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNavigation" aria-labelledby="mobileNavigationLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="mobileNavigationLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <nav class="mobile-navigation">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'mobile-menu',
                                'container_class' => 'mobile-menu-container',
                            )
                        );
                        ?>
                    </nav>
                    
                    <div class="header-links d-flex flex-column mt-4">
                        <p class="mb-2">
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                                <?php esc_html_e('Account', 'excellink-store'); ?>
                            </a>
                        </p>
                        <p class="mb-0">
                            <a href="#">Tracking</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </header><!-- #masthead -->