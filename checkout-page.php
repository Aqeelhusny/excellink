<?php
/**
 * Template Name: Custom Checkout Page
 *
 * A custom page template for the WooCommerce checkout
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="custom-checkout-container">
            <?php
            // Display the checkout form
            echo do_shortcode('[woocommerce_checkout]');
            ?>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();