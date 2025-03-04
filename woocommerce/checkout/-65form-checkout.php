<?php
/**
 * Checkout Form
 *
 * This template overrides the WooCommerce checkout form
 */

defined('ABSPATH') || exit;

// Check if cart is empty
if (!WC()->cart->is_empty()) :

    do_action('woocommerce_before_checkout_form', $checkout);

    // Filter to disable Woo styles if needed
    $checkout_classes = apply_filters('custom_checkout_classes', '');
?>

<div class="checkout-wrapper <?php echo esc_attr($checkout_classes); ?>">
    <div class="checkout-breadcrumb">
        <?php if (function_exists('woocommerce_breadcrumb')) {
            woocommerce_breadcrumb();
        } ?>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>
            <h3><?php esc_html_e('Billing &amp; Shipping', 'woocommerce'); ?></h3>
        <?php else : ?>
            <h3><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>
        <?php endif; ?>

        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <div class="col2-set" id="customer_details">
            <div class="col-1">
                <?php do_action('woocommerce_checkout_billing'); ?>
            </div>

            <div class="col-2">
                <?php do_action('woocommerce_checkout_shipping'); ?>
            </div>
        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

        <div class="order-summary-wrapper">
            <h3 id="order_review_heading"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>

            <?php do_action('woocommerce_checkout_before_order_review'); ?>

            <div id="order_review" class="woocommerce-checkout-review-order">
                <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>

            <?php do_action('woocommerce_checkout_after_order_review'); ?>
        </div>

        <div class="coupon-section">
            <?php if (wc_coupons_enabled()) : ?>
                <div class="coupon-container">
                    <label>
                        <input type="checkbox" id="show-coupon-form" />
                        <span><?php esc_html_e('Have a coupon? Click here to enter your code.', 'woocommerce'); ?></span>
                    </label>
                    <div class="coupon-form" style="display: none;">
                        <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                        <button type="button" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <div class="shipping-options">
                <?php wc_cart_totals_shipping_html(); ?>
            </div>
        <?php endif; ?>

        <div class="payment-methods-section">
            <?php do_action('woocommerce_checkout_payment'); ?>
        </div>

        <div class="place-order-section">
            <button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="<?php esc_attr_e('Place order', 'woocommerce'); ?>" data-value="<?php esc_attr_e('Place order', 'woocommerce'); ?>"><?php esc_html_e('Place order', 'woocommerce'); ?></button>
        </div>

    </form>

    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
</div>

<?php else : ?>
    <div class="empty-cart-message">
        <p><?php esc_html_e('Your cart is empty.', 'woocommerce'); ?></p>
        <p><a class="button wc-backward" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
            <?php esc_html_e('Return to shop', 'woocommerce'); ?>
        </a></p>
    </div>
<?php endif; ?>