<?php
/**
 * Deals of the Day Template
 * 
 * Path: wp-content/themes/your-theme/woocommerce/deals-of-day.php
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * Display Deals of the Day section with featured product
 * 
 * @param array $args {
 *     Optional. Arguments to control products display.
 *     @type int    $number_of_products Number of products to display (excluding featured product)
 *     @type string $category           Product category slug
 *     @type string $tag                Product tag slug
 * }
 */
function display_deals_of_day($args = []) {
    // Parse arguments
    $args = wp_parse_args($args, [
        'number_of_products' => 4,
        'category' => '',
        'tag' => '',
    ]);
    
    // Get on-sale products ordered by highest discount percentage
    $sale_products = get_discounted_products($args['number_of_products'] + 1, $args['category'], $args['tag']);
    
    if (empty($sale_products)) {
        return;
    }
    
    // Get the product with the highest discount (first item)
    $featured_product = $sale_products[0];
    
    // Remove the featured product from the regular product list
    array_shift($sale_products);
    
    // Output the deals section
    ?>
    <div class="deals-of-day-section">
        <div class="deals-header">
            <h2>Deals Of The Day</h2>
            <span class="subtitle">The freshest grocery products are waiting for you</span>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="view-all">View All →</a>
        </div>
        
        <div class="deals-container">
            <!-- Left column - Regular deals -->
            <div class="regular-deals">
                <?php foreach ($sale_products as $product) : 
                    $product_id = $product->get_id();
                    $discount_percentage = get_discount_percentage($product);
                    $regular_price = $product->get_regular_price();
                    $sale_price = $product->get_sale_price();
                    $rating_count = $product->get_rating_count();
                    $average_rating = $product->get_average_rating();
                ?>
                    <div class="product-card">
                        <div class="discount-badge"><?php echo esc_html($discount_percentage); ?>%</div>
                        
                        <?php if (function_exists('wishlist_button')) : ?>
                            <div class="wishlist-icon"><?php wishlist_button($product_id); ?></div>
                        <?php else : ?>
                            <div class="wishlist-icon">❤</div>
                        <?php endif; ?>
                        
                        <div class="product-image">
                            <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                <?php echo $product->get_image(); ?>
                            </a>
                        </div>
                        
                        <div class="product-rating">
                            <?php echo wc_get_rating_html($average_rating, $rating_count); ?>
                            <span class="rating-count"><?php echo esc_html($rating_count); ?></span>
                        </div>
                        
                        <h3 class="product-title">
                            <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                <?php echo esc_html($product->get_name()); ?>
                            </a>
                        </h3>
                        
                        <div class="product-price">
                            <span class="sale-price"><?php echo wc_price($sale_price); ?></span>
                            <span class="regular-price"><?php echo wc_price($regular_price); ?></span>
                        </div>
                        
                        <div class="add-to-cart">
                            <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="button add_to_cart_button">
                                Add to cart
                            </a>
                            <span class="quantity-buttons">
                                <button class="qty-minus">-</button>
                                <button class="qty-plus">+</button>
                            </span>
                        </div>
                        
                        <div class="countdown-timer">
                            <?php display_countdown_timer(); ?>
                            <span>Remains until the end of the offer</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Right column - Featured deal -->
            <div class="featured-deal">
                <?php
                $product = $featured_product;
                $product_id = $product->get_id();
                $discount_percentage = get_discount_percentage($product);
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $rating_count = $product->get_rating_count();
                $average_rating = $product->get_average_rating();
                ?>
                
                <div class="featured-product-card">
                    <div class="discount-badge"><?php echo esc_html($discount_percentage); ?>%</div>
                    
                    <?php if (function_exists('wishlist_button')) : ?>
                        <div class="wishlist-icon"><?php wishlist_button($product_id); ?></div>
                    <?php else : ?>
                        <div class="wishlist-icon">❤</div>
                    <?php endif; ?>
                    
                    <div class="product-image">
                        <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                            <?php echo $product->get_image('large'); ?>
                        </a>
                    </div>
                    
                    <div class="product-details">
                        <div class="product-rating">
                            <?php echo wc_get_rating_html($average_rating, $rating_count); ?>
                            <span class="rating-count"><?php echo esc_html($rating_count); ?></span>
                        </div>
                        
                        <h3 class="product-title">
                            <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                <?php echo esc_html($product->get_name()); ?>
                            </a>
                        </h3>
                        
                        <div class="product-price">
                            <span class="sale-price"><?php echo wc_price($sale_price); ?></span>
                            <span class="regular-price"><?php echo wc_price($regular_price); ?></span>
                        </div>
                        
                        <div class="product-description">
                            <?php echo wpautop(wp_trim_words($product->get_short_description(), 30)); ?>
                        </div>
                        
                        <div class="inventory-status">
                            <div class="progress-bar">
                                <div class="progress" style="width: 70%"></div>
                            </div>
                            <div class="status-text">This product is about to run out</div>
                        </div>
                        
                        <div class="stock-availability">
                            <span>Available only:</span>
                            <span class="available-count"><?php echo $product->get_stock_quantity() ?: '18'; ?></span>
                        </div>
                        
                        <div class="add-to-cart-featured">
                            <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="button add_to_cart_button">
                                Add to cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Get products ordered by discount percentage
 */
function get_discounted_products($number, $category = '', $tag = '') {
    $args = array(
        'status' => 'publish',
        'limit' => $number,
        'on_sale' => true,
        'orderby' => 'meta_value_num',
        'meta_key' => '_discount_percentage',
    );
    
    if (!empty($category)) {
        $args['category'] = array($category);
    }
    
    if (!empty($tag)) {
        $args['tag'] = array($tag);
    }
    
    $products = wc_get_products($args);
    
    // If no products found with the custom meta, calculate and sort by discount percentage
    if (empty($products)) {
        $args = array(
            'status' => 'publish',
            'limit' => 50, // Get more to sort later
            'on_sale' => true,
        );
        
        if (!empty($category)) {
            $args['category'] = array($category);
        }
        
        if (!empty($tag)) {
            $args['tag'] = array($tag);
        }
        
        $products = wc_get_products($args);
        
        // Sort products by discount percentage
        usort($products, function($a, $b) {
            $a_percentage = get_discount_percentage($a);
            $b_percentage = get_discount_percentage($b);
            return $b_percentage <=> $a_percentage;
        });
        
        // Slice to get the required number
        $products = array_slice($products, 0, $number);
    }
    
    return $products;
}

/**
 * Calculate discount percentage for a product
 */
function get_discount_percentage($product) {
    $regular_price = floatval($product->get_regular_price());
    $sale_price = floatval($product->get_sale_price());
    
    if ($regular_price > 0 && $sale_price > 0) {
        $percentage = round(($regular_price - $sale_price) / $regular_price * 100);
        return $percentage;
    }
    
    return 0;
}

/**
 * Display countdown timer
 */
function display_countdown_timer() {
    ?>
    <div class="timer-container">
        <div class="timer-box">
            <span class="time-value">84</span>
        </div>
        <div class="timer-box">
            <span class="time-value">06</span>
        </div>
        <div class="timer-box">
            <span class="time-value">59</span>
        </div>
        <div class="timer-box">
            <span class="time-value">59</span>
        </div>
    </div>
    <?php
}

// Calculate and store discount percentages for products
function calculate_product_discount_percentages() {
    $args = array(
        'status' => 'publish',
        'limit' => -1,
        'on_sale' => true,
    );
    
    $products = wc_get_products($args);
    
    foreach ($products as $product) {
        $percentage = get_discount_percentage($product);
        if ($percentage > 0) {
            update_post_meta($product->get_id(), '_discount_percentage', $percentage);
        }
    }
}
// Run this on product save or via a scheduled event

// Example usage in your template:
// display_deals_of_day(['number_of_products' => 4]);