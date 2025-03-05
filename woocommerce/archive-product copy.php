<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
// do_action('woocommerce_before_main_content');
?>

<section class="container">
    <div class="custom-breadcrumb">
        <?php woocommerce_breadcrumb(); ?>
    </div>

    <div class="grocery-shop-container">

        <!-- Sidebar / Filter Column -->
        <div class="shop-sidebar">
            <div class="sidebar-section widget-price-range">
                <h3 class="sidebar-title"><?php esc_html_e('Price Range', 'woocommerce'); ?></h3>
                <div class="price-inputs">
                    <div class="min-price">
                        <label for="min-price"><?php esc_html_e('Min', 'woocommerce'); ?></label>
                        <input type="number" id="min-price" name="min_price" placeholder="LKR 0"
                            value="<?php echo isset($_GET['min_price']) ? esc_attr($_GET['min_price']) : ''; ?>">
                    </div>
                    <div class="max-price">
                        <label for="max-price"><?php esc_html_e('Max', 'woocommerce'); ?></label>
                        <input type="number" id="max-price" name="max_price" placeholder="LKR 5000"
                            value="<?php echo isset($_GET['max_price']) ? esc_attr($_GET['max_price']) : ''; ?>">
                    </div>
                </div>
                <div class="price-slider-wrapper">
                    <div class="price-slider"></div>
                </div>
            </div>

            <div class="sidebar-section widget-categories">
                <h3 class="sidebar-title"><?php esc_html_e('Product Categories', 'woocommerce'); ?></h3>
                <ul class="product-categories">
                    <?php
                    $product_categories = get_terms([
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => 0,
                    ]);

                    if (!empty($product_categories)) {
                        foreach ($product_categories as $category) {
                            $category_count = $category->count;
                            echo '<li class="cat-item">';
                            echo '<a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
                            echo '<span class="count">(' . esc_html($category_count) . ')</span>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="sidebar-section widget-stock-status">
                <h3 class="sidebar-title"><?php esc_html_e('Filter by Stock', 'woocommerce'); ?></h3>
                <ul class="stock-status-list">
                    <li>
                        <label class="stock-status-checkbox">
                            <input type="checkbox" name="stock_status[]" value="instock"
                                <?php checked(isset($_GET['stock_status']) && in_array('instock', (array)$_GET['stock_status'])); ?>>
                            <span class="status-indicator in-stock"></span>
                            <?php esc_html_e('In Stock', 'woocommerce'); ?>
                        </label>
                    </li>
                    <li>
                        <label class="stock-status-checkbox">
                            <input type="checkbox" name="stock_status[]" value="outofstock"
                                <?php checked(isset($_GET['stock_status']) && in_array('outofstock', (array)$_GET['stock_status'])); ?>>
                            <span class="status-indicator out-of-stock"></span>
                            <?php esc_html_e('Out of Stock', 'woocommerce'); ?>
                        </label>
                    </li>
                    <li>
                        <label class="stock-status-checkbox">
                            <input type="checkbox" name="stock_status[]" value="onbackorder"
                                <?php checked(isset($_GET['stock_status']) && in_array('onbackorder', (array)$_GET['stock_status'])); ?>>
                            <span class="status-indicator on-backorder"></span>
                            <?php esc_html_e('On Backorder', 'woocommerce'); ?>
                        </label>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section filter-actions">
                <button class="filter-all-btn"><?php esc_html_e('Apply Filters', 'woocommerce'); ?></button>
            </div>
        </div>

        <!-- Main Content / Products Column -->
        <div class="shop-main-content">
            <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <header class="category-header">
                <h1 class="woocommerce-products-header__title page-title">
                    <?php woocommerce_page_title(); ?>
                </h1>
                <!-- <?php if (is_product_category()) : ?>
                <div class="category-description">
                    <?php
                        // Get the current category
                        $category = get_queried_object();
                        
                        // Display the category description if it exists
                        if ($category && !empty($category->description)) {
                            echo '<div class="term-description">' . wc_format_content($category->description) . '</div>';
                        } else {
                            // Fallback description
                            echo '<p class="category-tagline">' . esc_html__('Discover our selection of fresh and quality products', 'woocommerce') . '</p>';
                        }
                        ?>
                </div>
                <?php endif; ?> -->
            </header>
            <?php endif; ?>

            <?php
        /**
         * Hook: woocommerce_archive_description.
         */
        do_action('woocommerce_archive_description');
        ?>

            <div class="shop-toolbar">
                <?php
            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action('woocommerce_before_shop_loop');
            ?>
            </div>

            <?php if (woocommerce_product_loop()) : ?>
                <div class="custom-products-wrapper">
        <ul class="products columns-3">
            <?php
            while (have_posts()) {
                the_post();
                wc_get_template_part('content', 'product');
            }
            ?>
        </ul>
    </div>
            

            <?php
            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
            ?>

            <?php else : ?>
            <?php
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found');
            ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');