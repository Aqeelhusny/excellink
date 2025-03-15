<?php
/**
 * The template for displaying single product content
 *
 * Optimized to work with WooCommerce JS files and core functionality
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Ensure WooCommerce assets are properly loaded
wp_enqueue_script('wc-add-to-cart-variation');
wp_enqueue_script('woocommerce');
wp_enqueue_script('wc-single-product');

get_header('shop');

/**
 * Hook: woocommerce_before_main_content
 * 
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
// do_action('woocommerce_before_main_content');
?>

<section class="container">
    <div class="custom-breadcrumb">
        <?php woocommerce_breadcrumb(); ?>
    </div>

    <?php while (have_posts()) : the_post(); 
        global $product;
        
        // Ensure $product is valid
        if (!is_a($product, 'WC_Product')) {
            $product = wc_get_product(get_the_ID());
        }
        
        if (!$product) {
            return;
        }

        /**
         * Hook: woocommerce_before_single_product
         *
         * @hooked woocommerce_output_all_notices - 10
         */
        do_action('woocommerce_before_single_product');
    ?>
    
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('custom-single-product', $product); ?>>
        <div class="product-image-gallery">
            <div class="main-image">
                <?php 
                /**
                 * Hook: woocommerce_before_single_product_summary
                 * 
                 * This is where we'd normally output the product image gallery
                 * But we're customizing it directly here instead
                 */
                if (has_post_thumbnail()) {
                    echo get_the_post_thumbnail($product->get_id(), 'full', array('class' => 'main-product-image'));
                } else {
                    echo wc_placeholder_img('full');
                }
                ?>
            </div>
            
            <div class="thumbnails-container">
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                
                if ($attachment_ids && has_post_thumbnail()) {
                    // Add featured image to gallery
                    array_unshift($attachment_ids, get_post_thumbnail_id());
                    
                    foreach ($attachment_ids as $attachment_id) {
                        $image_link = wp_get_attachment_url($attachment_id);
                        if (!$image_link) {
                            continue;
                        }
                        
                        $image_html = wp_get_attachment_image($attachment_id, 'thumbnail', false, array(
                            'class' => 'product-thumbnail',
                            'data-large-image' => wp_get_attachment_url($attachment_id, 'full'),
                            'data-large-image-width' => wp_get_attachment_metadata($attachment_id)['width'] ?? 800,
                            'data-large-image-height' => wp_get_attachment_metadata($attachment_id)['height'] ?? 800,
                        ));
                        
                        echo '<div class="thumbnail-item">' . $image_html . '</div>';
                    }
                }
                ?>
            </div>
        </div>
        
        <div class="product-details">
            <?php
            /**
             * Hook: woocommerce_single_product_summary
             * 
             * We're not using this hook directly since we're customizing the layout,
             * but we'll call individual template parts that WooCommerce normally would.
             */
            ?>
            <h1 class="product-title entry-title"><?php the_title(); ?></h1>
            
            <div class="product-meta">
                <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>
                    <span class="sku-wrapper">
                        <span class="sku-label"><?php esc_html_e('SKU:', 'woocommerce'); ?></span>
                        <span class="sku"><?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span>
                    </span>
                <?php endif; ?>
                
                <div class="product-rating-container">
                    <?php
                    if (!empty($average = $product->get_average_rating())) {
                        echo wc_get_rating_html($average);
                        echo '<span class="rating-count">(' . $product->get_review_count() . ')</span>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="product-description">
                <?php
                // Custom short description template with icon
                if ($product->get_short_description()) {
                    echo '<div class="short-description woocommerce-product-details__short-description">';
                    echo '<p class="organic-description">' . $product->get_short_description() . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
            
            <div class="product-price price">
                <?php echo $product->get_price_html(); ?>
                <!-- <?php
                // Show price per unit if applicable
                $weight = $product->get_weight();
                if ($weight && $product->get_price()) {
                    $price_per_unit = $product->get_price() / $weight;
                    echo '<span class="price-per-unit">(' . wc_price($price_per_unit) . ' / ' . get_option('woocommerce_weight_unit') . ')</span>';
                }
                ?> -->
            </div>
            
            <div class="custom-add-to-cart">
                <?php
                // Custom stock status display
                if ($product->is_in_stock()) {
                    echo '<div class="stock-status in-stock"><span class="status-text">' . __('In Stock', 'woocommerce') . '</span></div>';
                } else {
                    echo '<div class="stock-status out-of-stock"><span class="status-text">' . __('Out of Stock', 'woocommerce') . '</span></div>';
                }
                
                // Preserve WooCommerce's add to cart functionality but customize the template
                remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
                remove_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
                
                if ($product->is_type('simple')) {
                    // Add custom class to the form but keep WooCommerce's functionality
                    add_filter('woocommerce_add_to_cart_form_class', function($classes) {
                        $classes[] = 'custom-add-to-cart-form';
                        return $classes;
                    });
                    
                    // Customize the quantity input
                    add_filter('woocommerce_quantity_input_args', function($args) {
                        $args['input_id'] = 'custom-quantity';
                        $args['input_name'] = 'quantity';
                        $args['classes'] = array('input-text', 'qty', 'text', 'custom-qty-input');
                        return $args;
                    });

                    // Custom add to cart template for simple products
                    echo '<form class="cart" method="post" enctype="multipart/form-data">';
                    
                    // Quantity selector with custom buttons
                    echo '<div class="quantity-selector">';
                    echo '<button type="button" class="qty-btn qty-minus">-</button>';
                    woocommerce_quantity_input(array(
                        'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                        'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                        'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                    ));
                    echo '<button type="button" class="qty-btn qty-plus">+</button>';
                    echo '</div>';
                    
                    // Add to cart button group
                    // Add to cart button group
echo '<div class="button-group">';
echo '<button type="submit" name="add-to-cart" value="' . esc_attr($product->get_id()) . '" class="single_add_to_cart_button button alt">' . esc_html($product->single_add_to_cart_text()) . '</button>';
echo '</div>';
                    
                    echo '</form>';
                } else {
                    // For variable and other product types, use default WooCommerce templates
                    do_action('woocommerce_' . $product->get_type() . '_add_to_cart');
                }
                ?>
            </div>
            
            <?php if ($product->is_type('variable')) : 
    $available_variations = $product->get_available_variations();
    if (!empty($available_variations)) : ?>
        <div class="product-size-selector product-variations">
            <?php
            // Let WooCommerce handle the variation form display
            do_action('woocommerce_variable_add_to_cart');
            ?>
        </div>
    <?php endif; 
endif; ?>

            
            <div class="product-actions">
                <div class="action-item">
                    <?php 
                    // Use YITH Wishlist integration if available
                    if (function_exists('YITH_WCWL')) {
                        echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                    } else {
                    ?>
                        <a href="#" class="add-to-wishlist">
                            <i class="icon heart-icon"></i>
                            <span><?php echo esc_html__('Add to Wishlist', 'woocommerce'); ?></span>
                        </a>
                    <?php } ?>
                </div>
                <div class="action-item">
                    <a href="#" class="share-product">
                        <i class="icon share-icon"></i>
                        <span><?php echo esc_html__('Share this Product', 'woocommerce'); ?></span>
                    </a>
                </div>
                <div class="action-item">
                    <?php 
                    // Use YITH Compare integration if available
                    if (function_exists('yith_woocompare_constructor')) {
                        echo do_shortcode('[yith_compare_button]');
                    } else {
                    ?>
                        <a href="#" class="compare-product">
                            <i class="icon compare-icon"></i>
                            <span><?php echo esc_html__('Compare', 'woocommerce'); ?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
            
            <div class="shipping-returns-section">
                <div class="info-item">
                    <i class="icon shipping-icon"></i>
                    <div class="info-content">
                        <h4><?php echo esc_html__('Shipping', 'woocommerce'); ?></h4>
                        <p><?php echo esc_html__('Free delivery for orders over $50. Orders ship same day if placed by 2pm.', 'woocommerce'); ?></p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="icon returns-icon"></i>
                    <div class="info-content">
                        <h4><?php echo esc_html__('Returns', 'woocommerce'); ?></h4>
                        <p><?php echo esc_html__('Not satisfied with your product? Return within 30 days for a full refund.', 'woocommerce'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="product-tabs wc-tabs-wrapper">
        <div class="tabs-header">
            <button class="tab-button active" data-tab="description"><?php echo esc_html__('Description', 'woocommerce'); ?></button>
            <button class="tab-button" data-tab="reviews"><?php echo esc_html__('Reviews', 'woocommerce') . ' (' . $product->get_review_count() . ')'; ?></button>
        </div>
        
        <div class="tab-content woocommerce-Tabs-panel woocommerce-Tabs-panel--description active" id="description-tab">
            <div class="description-content">
                <?php the_content(); ?>
            </div>
        </div>
        
        <div class="tab-content woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews" id="reviews-tab">
            <div class="reviews-content">
                <?php 
                // Use WooCommerce's comment template for reviews
                comments_template();
                ?>
            </div>
        </div>
    </div>
    
    <?php 
    /**
     * Hook: woocommerce_after_single_product_summary
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    do_action('woocommerce_after_single_product_summary'); 
    ?>
    
   

    <?php endwhile; // end of the loop. ?>
</section>

<?php
/**
 * Hook: woocommerce_after_main_content
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action('woocommerce_sidebar');

get_footer('shop');