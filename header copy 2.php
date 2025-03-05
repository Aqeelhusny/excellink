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
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text"
            href="#primary"><?php esc_html_e( 'Skip to content', 'excellink-store' ); ?></a>

            <div class="header-top">
                <p class="container mb-0 text-capitalize">welcome to srilanka</p>
            </div>
        <header id="masthead" class="site-header sticky-top">
            
            <div class="sitehead">
                <div class="container excellogo d-flex justify-content-between align-items-center">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/public/images/excellogo.png"
                            alt="<?php echo esc_attr(get_bloginfo()); ?>" class="excellogoimg">
                    </a>

                    <div class="yith searchproductshead">
                        <?php echo do_shortcode('[yith_woocommerce_ajax_search preset="default"]'); ?>
                    </div>

                    <p class="cartheadico">Cart</p>
                </div>
            </div>

            <div class="menu-container">
            <div class="d-flex justify-content-between gap-4 container">
                <nav id="site-navigation" class="main-navigation">
                    <!-- <button class="menu-toggle" aria-controls="primary-menu"
                        aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'excellink-store' ); ?></button> -->
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                        )
                    );
                    ?>
                </nav>

                <p class="mb-0"><a
                        href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"><?php esc_html_e('Account', 'excellink-store'); ?></a>
                </p>
                <p class="mb-0">Tracking</p>

            </div>

        </div>

        </header><!-- #masthead -->
        