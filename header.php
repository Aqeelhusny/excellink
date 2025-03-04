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


                    <!-- <div class="searchproductshead">
                        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                        <form role="search" method="ge t" class="woocommerce-product-search"
                            action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <label class="screen-reader-text"
                                for="woocommerce-product-search-field"><?php esc_html_e( 'Search for:', 'woocommerce' ); ?></label>
                            <select class="cat-dropdown" name="product_cat">
                                <option value=""><?php esc_html_e( 'All Categories', 'woocommerce' ); ?></option>
                                <?php
                $categories = get_terms( 'product_cat' );
                foreach ( $categories as $category ) {
                    echo '<option value="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
                }
                ?>
                            </select>
                            <input type="search" id="woocommerce-product-search-field" class="search-field"
                                placeholder="<?php echo esc_attr_x( 'Search products&hellip;', 'placeholder', 'woocommerce' ); ?>"
                                value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit"
                                value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'woocommerce' ); ?></button>
                            <input type="hidden" name="post_type" value="product" />
                        </form>
                        <?php endif; ?>
                    </div> -->
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
        