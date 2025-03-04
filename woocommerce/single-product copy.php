<?php
/**
 * The template for displaying single product content
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<section class="container">



    <div class="custom-breadcrumb">
        <?php woocommerce_breadcrumb(); ?>
    </div>

    <?php while ( have_posts() ) : the_post(); 
        global $product;
    ?>
    
    <div class="custom-single-product">
        <div class="product-image-gallery">
            <div class="main-image">
                <?php 
                if ( has_post_thumbnail() ) {
                    echo get_the_post_thumbnail( $product->get_id(), 'full', array( 'class' => 'main-product-image' ) );
                } else {
                    echo wc_placeholder_img( 'full' );
                }
                ?>
            </div>
            
            <div class="thumbnails-container">
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                
                if ( $attachment_ids && has_post_thumbnail() ) {
                    // Add featured image to gallery
                    array_unshift( $attachment_ids, get_post_thumbnail_id() );
                    
                    foreach ( $attachment_ids as $attachment_id ) {
                        $image_link = wp_get_attachment_url( $attachment_id );
                        if ( ! $image_link ) {
                            continue;
                        }
                        
                        $image_html = wp_get_attachment_image( $attachment_id, 'thumbnail', false, array(
                            'class' => 'product-thumbnail',
                            'data-image-full' => wp_get_attachment_url( $attachment_id, 'full' )
                        ) );
                        
                        echo '<div class="thumbnail-item">' . $image_html . '</div>';
                    }
                }
                ?>
            </div>
        </div>
        
        <div class="product-details">
            <h1 class="product-title"><?php the_title(); ?></h1>
            
            <div class="product-meta">
                <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                    <span class="sku-wrapper">
                        <span class="sku-label"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?></span>
                        <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span>
                    </span>
                <?php endif; ?>
                
                <div class="product-rating-container">
                    <?php 
                    if ( ! empty( $average = $product->get_average_rating() ) ) {
                        echo wc_get_rating_html( $average );
                        echo '<span class="rating-count">(' . $product->get_review_count() . ')</span>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="product-description">
                <?php 
                // Custom short description template with icon
                if ( $product->get_short_description() ) {
                    echo '<div class="short-description">';
                    echo '<p class="organic-description">' . $product->get_short_description() . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
            
            <div class="product-price">
                <?php echo $product->get_price_html(); ?>
                <?php 
                // Show price per unit if applicable
                $weight = $product->get_weight();
                if ( $weight && $product->get_price() ) {
                    $price_per_unit = $product->get_price() / $weight;
                    echo '<span class="price-per-unit">(' . wc_price( $price_per_unit ) . ' / ' . get_option( 'woocommerce_weight_unit' ) . ')</span>';
                }
                ?>
            </div>
            
            <?php 
            // Custom add to cart section
            echo '<div class="custom-add-to-cart">';
                if ( $product->is_in_stock() ) {
                    echo '<div class="stock-status in-stock"><span class="status-text">In Stock</span></div>';
                } else {
                    echo '<div class="stock-status out-of-stock"><span class="status-text">Out of Stock</span></div>';
                }
                
                // Add to cart form
                if ( $product->is_type( 'simple' ) ) {
                    echo '<form class="cart" action="' . esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ) . '" method="post" enctype="multipart/form-data">';
                    
                    // Quantity input
                    echo '<div class="quantity-selector">';
                    echo '<button type="button" class="qty-btn qty-minus">-</button>';
                    woocommerce_quantity_input( array(
                        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
                    ) );
                    echo '<button type="button" class="qty-btn qty-plus">+</button>';
                    echo '</div>';
                    
                    // Add to cart buttons
                    echo '<div class="button-group">';
                    echo '<button type="submit" name="add-to-cart" value="' . esc_attr( $product->get_id() ) . '" class="single_add_to_cart_button button alt">Add to cart</button>';
                    echo '<button type="button" class="buy-now-button">Buy now</button>';
                    echo '</div>';
                    
                    echo '</form>';
                } else {
                    // For variable products, use the default WooCommerce form
                    woocommerce_template_single_add_to_cart();
                }
            echo '</div>';
            ?>
            
            <div class="product-size-selector">
                <span class="size-label">Size:</span>
                <div class="size-options">
                    <button class="size-option active">1lb</button>
                    <button class="size-option">2lb</button>
                    <button class="size-option">3lb</button>
                    <button class="size-option">4lb</button>
                </div>
            </div>
            
            <div class="product-actions">
                <div class="action-item">
                    <a href="#" class="add-to-wishlist">
                        <i class="icon heart-icon"></i>
                        <span>Add to Wishlist</span>
                    </a>
                </div>
                <div class="action-item">
                    <a href="#" class="share-product">
                        <i class="icon share-icon"></i>
                        <span>Share this Product</span>
                    </a>
                </div>
                <div class="action-item">
                    <a href="#" class="compare-product">
                        <i class="icon compare-icon"></i>
                        <span>Compare</span>
                    </a>
                </div>
            </div>
            
            <?php 
            // Shipping and return info
            echo '<div class="shipping-returns-section">';
                echo '<div class="info-item">';
                    echo '<i class="icon shipping-icon"></i>';
                    echo '<div class="info-content">';
                        echo '<h4>Shipping</h4>';
                        echo '<p>Free delivery for orders over $50. Orders ship same day if placed by 2pm.</p>';
                    echo '</div>';
                echo '</div>';
                
                echo '<div class="info-item">';
                    echo '<i class="icon returns-icon"></i>';
                    echo '<div class="info-content">';
                        echo '<h4>Returns</h4>';
                        echo '<p>Not satisfied with your product? Return within 30 days for a full refund.</p>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            ?>
        </div>
    </div>
    
    <div class="product-tabs">
        <div class="tabs-header">
            <button class="tab-button active" data-tab="description">Description</button>
            <button class="tab-button" data-tab="reviews">Reviews (<?php echo $product->get_review_count(); ?>)</button>
        </div>
        
        <div class="tab-content active" id="description-tab">
            <div class="description-content">
                <?php the_content(); ?>
            </div>
        </div>
        
        <div class="tab-content" id="reviews-tab">
            <div class="reviews-content">
                <?php comments_template(); ?>
            </div>
        </div>
    </div>
    
    <?php woocommerce_output_related_products(); ?>
    
    <?php endwhile; // end of the loop. ?>
    </section>
<?php get_footer( 'shop' );