<?php
/**
 * The template for displaying front page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Excellink
 */

 get_header();
 ?>

<main id="primary" class="site-main">

    <div class="container">
        <div class="row">
        <h2>New Arrivals</h2>
        <p>Grab the latest decorative collection</p>
        <?php echo do_shortcode( '[products limit="10" columns="5" orderby="id" order="DESC" visibility="visible"]' ); ?>
        </div>
    </div>

    <section class="container">
        <div class="row">
            <h1>Featured Products</h1>
            <?php echo do_shortcode('[featured_products per_page="10" columns="5" visibility="visible"]'); ?>
        </div>
    </section>

    <section class="container">
        <h2>On Sale</h2>
    <?php echo do_shortcode('[sale_products per_page="10" columns="5" visibility="visible"]'); ?>
    </section>

    <section class="container">
        <h2>Recently Added</h2>
        <?php echo do_shortcode( '[recent_products per_page="10" columns="5" visibility="visible"]' ); ?>
    </section>

    <section class="container">
        <h2>Best Sellers</h2>
        <?php echo do_shortcode( '[products limit="10" columns="5" best_selling="true" ]' ); ?>
    </section>



</main>

<?php 
get_footer();