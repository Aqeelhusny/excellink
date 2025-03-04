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

                <!-- <div class="view-options">
                    <span><?php esc_html_e('View', 'woocommerce'); ?>:</span>
                    <button class="view-button grid-view active" data-view="grid">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                        </svg>
                    </button>
                    <button class="view-button list-view" data-view="list">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="4" />
                            <rect x="3" y="10" width="18" height="4" />
                            <rect x="3" y="17" width="18" height="4" />
                        </svg>
                    </button>
                </div> -->
            </div>

            <?php if (woocommerce_product_loop()) : ?>
            <div class="custom-products-wrapper">
                <ul class="products columns-3 grid-view-active">
                    <?php
                    while (have_posts()) {
                        the_post();
                        global $product;
                        
                        // Get product data
                        $product_id = $product->get_id();
                        $product_permalink = get_permalink($product_id);
                        $product_name = $product->get_name();
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        $price_html = $product->get_price_html();
                        $rating_count = $product->get_rating_count();
                        $average_rating = $product->get_average_rating();
                        $review_count = $product->get_review_count();
                        
                        // Calculate discount percentage if on sale
                        $discount_percentage = '';
                        if ($sale_price && $regular_price) {
                            $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                        }
                        
                        // Get product weight
                        // $weight = $product->get_weight();
                        // $weight_unit = get_option('woocommerce_weight_unit');
                        // $weight_display = $weight ? $weight . $weight_unit : '';
                        
                        // Check if product is in stock
                        $in_stock = $product->is_in_stock();
                        $stock_status_class = $in_stock ? 'in-stock' : 'out-of-stock';
                        
                        // Get product tags for organic label
                        // $is_organic = has_term('organic', 'product_tag', $product_id);
                        ?>

                    <li class="product product-item <?php echo esc_attr($stock_status_class); ?>">
                        <div class="product-inner">
                            <?php if ($discount_percentage) : ?>
                            <div class="discount-badge">
                                <span>Sale <?php echo esc_html($discount_percentage . '%'); ?></span>
                            </div>
                            <?php endif; ?>

                            <!-- <?php if ($is_organic) : ?>
                            <div class="organic-badge">
                                <span><?php esc_html_e('Organic', 'woocommerce'); ?></span>
                            </div>
                            <?php endif; ?> -->

                            <div class="wishlist-button">
                                <button type="button" class="add-to-wishlist"
                                    data-product-id="<?php echo esc_attr($product_id); ?>">
                                    <svg width="18" height="18" viewBox="0 0 24 24">
                                        <path
                                            d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
                                    </svg>
                                </button>
                            </div>

                            <a href="<?php echo esc_url($product_permalink); ?>" class="product-image">
                                <?php echo $product->get_image('woocommerce_medium'); ?>
                            </a>

                            <div class="product-details">
                                <?php
                                /**
                                 * Stock Status
                                 */
                                $stock_status = $product->get_stock_status();
                                $status_class = 'status-' . $stock_status;
                                $status_text = 'In Stock';
                                
                                if ($stock_status == 'outofstock') {
                                    $status_text = 'Out of Stock';
                                } elseif ($stock_status == 'onbackorder') {
                                    $status_text = 'On Backorder';
                                }
                                ?>
                                <div class="custom-stock-status <?php echo esc_attr($status_class); ?>">
                                    <span class="status-dot"></span>
                                    <span class="status-text"><?php echo esc_html($status_text); ?></span>
                                </div>

                                <h2 class="woocommerce-loop-product__title">
                                    <a href="<?php echo esc_url($product_permalink); ?>">
                                        <?php echo esc_html($product_name); ?>
                                    </a>
                                </h2>

                                <div class="product-price-container">
                                    <span class="price"><?php echo $price_html; ?></span>
                                </div>

                                <div class="product-actions ">
                                    <div class="quantity-buttons">
                                        <button type="button" class="quantity-btn qty-minus"
                                            data-product-id="<?php echo esc_attr($product_id); ?>">-</button>
                                        <input type="number" class="qty" value="1" min="1" max="99">
                                        <button type="button" class="quantity-btn qty-plus"
                                            data-product-id="<?php echo esc_attr($product_id); ?>">+</button>
                                    </div>

                                    <button type="button" class="add-to-cart-btn"
                                        data-product-id="<?php echo esc_attr($product_id); ?>">
                                        <?php esc_html_e('Add to cart', 'woocommerce'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                    } // end of the loop
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