<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<section class="container">
    <div class="custom-breadcrumb py-2">
        <?php woocommerce_breadcrumb(); ?>
    </div>

    <div class="shop-mobile-filter-toggle d-md-none mb-3">
        <button class="filter-toggle-btn">
            <span class="filter-icon"><i class="fas fa-filter"></i></span>
            <span>Show Filters</span>
        </button>
    </div>

    <div class="grocery-shop-container">
        <!-- Sidebar / Filter Column -->
        <div class="shop-sidebar" id="shopSidebar">
            <div class="sidebar-header d-md-none">
                <h3>Filters</h3>
                <button class="close-sidebar">&times;</button>
            </div>

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
                <!-- <div class="price-slider-wrapper"> not configured yet
                    <div class="price-slider"></div>
                </div> -->
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
                            <input type="checkbox" name="stock_status" value="instock"
                                <?php checked(isset($_GET['stock_status']) && in_array('instock', (array)$_GET['stock_status'])); ?>>
                            <span class="status-indicator in-stock"></span>
                            <?php esc_html_e('In Stock', 'woocommerce'); ?>
                        </label>
                    </li>
                    <li>
                        <label class="stock-status-checkbox">
                            <input type="checkbox" name="stock_status" value="outofstock"
                                <?php checked(isset($_GET['stock_status']) && in_array('outofstock', (array)$_GET['stock_status'])); ?>>
                            <span class="status-indicator out-of-stock"></span>
                            <?php esc_html_e('Out of Stock', 'woocommerce'); ?>
                        </label>
                    </li>
                    <!-- <li>
                        <label class="stock-status-checkbox">
                            <input type="checkbox" name="stock_status[]" value="onbackorder"
                                <?php checked(isset($_GET['stock_status']) && in_array('onbackorder', (array)$_GET['stock_status'])); ?>>
                            <span class="status-indicator on-backorder"></span>
                            <?php esc_html_e('On Backorder', 'woocommerce'); ?>
                        </label>
                    </li> -->
                </ul>
            </div>

            <div class="sidebar-section filter-actions">
                <button class="filter-all-btn"><?php esc_html_e('Apply Filters', 'woocommerce'); ?></button>
                <button class="reset-filters-btn d-md-none"><?php esc_html_e('Reset Filters', 'woocommerce'); ?></button>
            </div>
        </div>

        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay d-md-none"></div>

        <!-- Main Content / Products Column -->
        <div class="shop-main-content">
            <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <header class="category-header">
                <h1 class="woocommerce-products-header__title page-title">
                    <?php woocommerce_page_title(); ?>
                </h1>
            </header>
            <?php endif; ?>

            <?php
            /**
             * Hook: woocommerce_archive_description.
             */
            do_action('woocommerce_archive_description');
            ?>

            <div class="shop-toolbar custom-shop-toolbar">
                <?php
                /**
                 * Hook: woocommerce_before_shop_loop.
                 */
                do_action('woocommerce_before_shop_loop');
                ?>
            </div>

            <?php if (woocommerce_product_loop()) : ?>
                <div class="custom-products-wrapper">
                    <ul class="products">
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
                 */
                do_action('woocommerce_after_shop_loop');
                ?>

            <?php else : ?>
                <?php do_action('woocommerce_no_products_found'); ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
do_action('woocommerce_after_main_content');
get_footer('shop');
?>