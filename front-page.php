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
 $carousel_config = json_decode(file_get_contents(get_template_directory() . '/assets/json/home-main-carousel-config.json'), true);
 $banner_config = json_decode(file_get_contents(get_template_directory() . '/assets/json/home-promo-banners-config.json'), true);
 $banner_config_sale = json_decode(file_get_contents(get_template_directory() . '/assets/json/home-sale-banners-config.json'), true);
 ?>

<main id="primary" class="site-main">

    <section class="container my-4">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-indicators">
                <?php foreach($carousel_config['carousel']['slides'] as $index => $slide): ?>
                <button type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"
                    aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    aria-label="Slide <?php echo $index + 1; ?>">
                </button>
                <?php endforeach; ?>
            </div>


            <div class="carousel-inner">
                <?php foreach($carousel_config['carousel']['slides'] as $index => $slide): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <a href="<?php echo esc_url($slide['desktop']['link']); ?>">
                        <img class="d-block w-100 d-none d-md-block rounded-3"
                            src="<?php echo esc_url($slide['desktop']['image']); ?>"
                            alt="<?php echo esc_attr($slide['desktop']['alt']); ?>">
                        <img class="d-block w-100 d-md-none rounded-3"
                            src="<?php echo esc_url($slide['mobile']['image']); ?>"
                            alt="<?php echo esc_attr($slide['mobile']['alt']); ?>">
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    </section>


    <div class="container">
        <div class="row">
            <h2 class="text-center">New Arrivals</h2>
            <p class="text-center">Grab the latest decorative collection</p>
            <?php echo do_shortcode( '[products limit="12" columns="6" orderby="id" order="DESC" visibility="visible"]' ); ?>
        </div>
    </div>


    <section class="container my-5">
        <!-- promotional banner section -->
        <div class="row row-gap-3">
            <div class="col-12 col-md-6">
                <a
                    href="<?php echo esc_url($banner_config['promotional_banners']['left_banner']['desktop']['link']); ?>">
                    <img src="<?php echo esc_url($banner_config['promotional_banners']['left_banner']['desktop']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config['promotional_banners']['left_banner']['desktop']['alt']); ?>"
                        class="img-fluid w-100 d-none d-md-block rounded-2" style="height: 250px; object-fit: cover;">
                    <img src="<?php echo esc_url($banner_config['promotional_banners']['left_banner']['mobile']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config['promotional_banners']['left_banner']['mobile']['alt']); ?>"
                        class="img-fluid w-100 d-md-none rounded-2" style="height: 250px; object-fit: cover;">
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a
                    href="<?php echo esc_url($banner_config['promotional_banners']['right_banner']['desktop']['link']); ?>">
                    <img src="<?php echo esc_url($banner_config['promotional_banners']['right_banner']['desktop']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config['promotional_banners']['right_banner']['desktop']['alt']); ?>"
                        class="img-fluid w-100 d-none d-md-block rounded-2" style="height: 250px; object-fit: cover;">
                    <img src="<?php echo esc_url($banner_config['promotional_banners']['right_banner']['mobile']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config['promotional_banners']['right_banner']['mobile']['alt']); ?>"
                        class="img-fluid w-100 d-md-none rounded-2" style="height: 250px; object-fit: cover;">
                </a>
            </div>
        </div>
    </section>


    <section class="container mb-5">
        <div class="row">
            <h1 class="text-center">Featured Products</h1>
            <p class="text-center">Limited featured products</p>
            <?php echo do_shortcode('[featured_products per_page="12" columns="6" visibility="visible"]'); ?>
        </div>
    </section>

    <section class="container">
        <h2 class="text-center">On Sale</h2>
        <p class="text-center">Limited Sale Collection</p>
        <?php echo do_shortcode('[sale_products per_page="12" columns="6" visibility="visible" orderby="rand"]'); ?>
    </section>

    <section class="container my-5">
        <!-- sale banner section -->
        <div class="row row-gap-3">
            <div class="col-12 col-md-4">
                <a
                    href="<?php echo esc_url($banner_config_sale['promotional_banners']['left_banner']['desktop']['link']); ?>">
                    <img src="<?php echo esc_url($banner_config_sale['promotional_banners']['left_banner']['desktop']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config_sale['promotional_banners']['left_banner']['desktop']['alt']); ?>"
                        class="img-fluid w-100 d-none d-md-block rounded-2" style="height: 250px; object-fit: cover;">
                    <img src="<?php echo esc_url($banner_config_sale['promotional_banners']['left_banner']['mobile']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config_sale['promotional_banners']['left_banner']['mobile']['alt']); ?>"
                        class="img-fluid w-100 d-md-none rounded-2" style="height: 250px; object-fit: cover;">
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a
                    href="<?php echo esc_url($banner_config_sale['promotional_banners']['middle_banner']['desktop']['link']); ?>">
                    <img src="<?php echo esc_url($banner_config_sale['promotional_banners']['middle_banner']['desktop']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config_sale['promotional_banners']['middle_banner']['desktop']['alt']); ?>"
                        class="img-fluid w-100 d-none d-md-block rounded-2" style="height: 250px; object-fit: cover;">
                    <img src="<?php echo esc_url($banner_config_sale['promotional_banners']['middle_banner']['mobile']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config_sale['promotional_banners']['middle_banner']['mobile']['alt']); ?>"
                        class="img-fluid w-100 d-md-none rounded-2" style="height: 250px; object-fit: cover;">
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a
                    href="<?php echo esc_url($banner_config_sale['promotional_banners']['right_banner']['desktop']['link']); ?>">
                    <img src="<?php echo esc_url($banner_config_sale['promotional_banners']['right_banner']['desktop']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config_sale['promotional_banners']['right_banner']['desktop']['alt']); ?>"
                        class="img-fluid w-100 d-none d-md-block rounded-2" style="height: 250px; object-fit: cover;">
                    <img src="<?php echo esc_url($banner_config_sale['promotional_banners']['right_banner']['mobile']['image']); ?>"
                        alt="<?php echo esc_attr($banner_config_sale['promotional_banners']['right_banner']['mobile']['alt']); ?>"
                        class="img-fluid w-100 d-md-none rounded-2" style="height: 250px; object-fit: cover;">
                </a>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <h2 class="text-center">Best Sellers</h2>
        <p class="text-center">
            Top Trending Collections
        </p>
        <?php echo do_shortcode( '[products limit="12" columns="6" best_selling="true" ]' ); ?>
    </section>

    <section class="container">
        <h2 class="text-center">Just For You</h2>
        <p class="text-center">Essencials choosen for you</p>
        <div class="woocommerce">
            <ul class="products columns-5" id="just-for-you-products">
                <?php echo do_shortcode('[products limit="24" columns="6" orderby="rand"]'); ?>
            </ul>
        </div>
        <div class="text-center mt-4">
            <button id="load-more" class="btn btn-light" data-page="1" data-loading="false">
                Load More Products
            </button>
        </div>
    </section>

</main>

<?php 
get_footer();