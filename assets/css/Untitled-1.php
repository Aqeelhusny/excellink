<?php
/**
 * The template for displaying product content within loops
 *
 */

defined( 'ABSPATH' ) || exit;

global $product;

$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'custom-product', $product ); ?>>
	<div class="custom-product-card">
		<?php
		/**
		 * Sale Flash
		 */
		$discount_percentage = '';
        if ($sale_price && $regular_price) {
            $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        }
	
		if ($product->is_on_sale() && !empty($discount_percentage)) : ?>
			<span class="custom-onsale">Sale <?php echo esc_html($discount_percentage . '%'); ?></span>
		<?php endif; ?>

		<?php
		/**
		 * Product Image
		 */
		?>
		<a href="<?php the_permalink(); ?>" class="custom-product-image">
			<?php echo woocommerce_get_product_thumbnail(); ?>
		</a>

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

		<?php
		/**
		 * Product Title
		 */
		?>
		<h3 class="custom-product-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<!-- <?php
		/**
		 * Product Meta (Size/Weight)
		 */
		$attribute = $product->get_attribute('weight') ?: $product->get_attribute('size');
		if ($attribute) : ?>
			<div class="custom-product-meta">
				<span class="product-size"><?php echo esc_html($attribute); ?></span>
			</div>
		<?php endif; ?> -->

		<?php
		/**
		 * Product Price
		 */
		?>
		<div class="custom-product-price">
			<?php echo $product->get_price_html(); ?>
		</div>

		<!-- <?php
		/**
		 * Product Rating
		 */
		// ?>
		<div class="custom-product-rating">
			<?php if ( $product->get_rating_count() > 0 ) : ?>
				<div class="star-rating">
					<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
				</div>
				<span class="rating-count"><?php echo $product->get_rating_count(); ?></span>
			<?php else : ?>
				<div class="star-rating empty"></div>
				<span class="rating-count">0</span>
			<?php endif; ?>
		</div> -->

		
		
		<?php
		/**
		 * Product Add to Cart
		 */
		?>
		<!-- <div class="custom-product-add-to-cart add-to-cart-btn">
			<?php echo do_shortcode('[add_to_cart id="' . $product->get_id() . '" show_price="false" style="" class="single_add_to_cart_button button alt"]'); ?>
		</div> -->
		<button type="button" class="add-to-cart-btn-cs"
            data-product-id="<?php echo esc_attr($product->get_id()); ?>">

			<?php echo esc_html__('Add to Cart', 'woocommerce'); ?>
           
        </button>




	</div>
</li>