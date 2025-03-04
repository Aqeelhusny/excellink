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

		<?php
		/**
		 * Product Price
		 */
		?>
		<div class="custom-product-price">
			<?php echo $product->get_price_html(); ?>
		</div>

		<?php
		/**
		 * Product Quantity and Add to Cart - Using WooCommerce hooks
		 */
		?>
		<div class="custom-product-add-to-cart">
			<?php if ($stock_status == 'outofstock') : ?>
				<button type="button" class="add-to-cart-btn-cs out-of-stock" disabled>
					<?php echo esc_html__('Out of Stock', 'woocommerce'); ?>
				</button>
			<?php else : ?>
				<div class="inline-quantity-cart">
					<?php
					// Add quantity input field
					woocommerce_quantity_input(
						array(
							'min_value'   => 1,
							'max_value'   => $product->get_max_purchase_quantity(),
							'input_value' => 1,
							'classes'     => apply_filters('woocommerce_quantity_input_classes', array('input-text', 'qty', 'text'), $product),
						),
						$product,
						false
					);
					
					// Add the add-to-cart button with the proper classes
					$args = array(
						'quantity'   => 1,
						'class'      => implode(' ', array_filter(array(
							'add-to-cart-btn-cs',
							$stock_status == 'onbackorder' ? 'backorder' : '',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : '',
						))),
						'attributes' => array(
							'data-product_id'  => $product->get_id(),
							'data-product_sku' => $product->get_sku(),
							'aria-label'       => $product->add_to_cart_description(),
							'rel'              => 'nofollow',
						),
					);
					
					echo apply_filters(
						'woocommerce_loop_add_to_cart_link',
						sprintf(
							'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
							esc_url($product->add_to_cart_url()),
							esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
							esc_attr(isset($args['class']) ? $args['class'] : 'button'),
							isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
							esc_html($product->add_to_cart_text())
						),
						$product,
						$args
					);
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</li>