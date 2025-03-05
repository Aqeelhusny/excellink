<?php
/**
 * Excellink functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Excellink
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function excellink_store_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Excellink, use a find and replace
		* to change 'excellink-store' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'excellink-store', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'excellink-store' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'excellink_store_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'excellink_store_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function excellink_store_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'excellink_store_content_width', 640 );
}
add_action( 'after_setup_theme', 'excellink_store_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function excellink_store_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'excellink-store' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'excellink-store' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'excellink_store_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function excellink_store_scripts() {
	// wp_enqueue_style( 'excellink-store-style', get_stylesheet_uri(), array(), _S_VERSION );
	// wp_style_add_data( 'excellink-store-style', 'rtl', 'replace' );
    wp_enqueue_style( 'excellink-store-style', get_template_directory_uri() . '/style.min.css', array(), _S_VERSION );

	wp_enqueue_script( 'excellink-store-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'excellink_store_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Add this code to your theme's functions.php file or use a code snippets plugin
add_filter('woocommerce_currency_symbol', 'change_lkr_currency_symbol', 10, 2);

function change_lkr_currency_symbol($currency_symbol, $currency) {
    // If the currency is LKR (Sri Lankan Rupee)
    if ($currency === 'LKR') {
        return 'LKR';
    }
    return $currency_symbol;
}

//single product page js
function enqueue_single_product_scripts() {
    if (is_product()) {
        wp_enqueue_script('single-product-js', get_template_directory_uri() . '/js/single-product.js', array('jquery'), '1.0', true);
		wp_enqueue_style('woocommerce-category', get_template_directory_uri() . '/assets/css/woo-single-product.css', array(), '1.0.0');
        
        // Pass the checkout URL to JavaScript
        wp_localize_script('single-product-js', 'wc_checkout_data', array(
            'checkout_url' => wc_get_checkout_url(),
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_single_product_scripts');

//archive product page js
function enqueue_archive_product_scripts() {
    if (is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_script('archive-product-js', get_template_directory_uri() . '/js/archive-product.js', array('jquery'), '1.0', true);
		wp_enqueue_style('woocommerce-category', get_template_directory_uri() . '/assets/css/woo-archive-product.css', array(), '1.0.0');
       
        wp_localize_script('archive-product-js', 'wc_checkout_data', array(
            'checkout_url' => wc_get_checkout_url(),
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_archive_product_scripts');

// // Add this to your theme's functions.php
// function enqueue_category_page_styles() {
//     if (is_product_category() || is_shop()) {
        
//     }
// }
// add_action('wp_enqueue_scripts', 'enqueue_category_page_styles');

//checkout page
/**
 * Custom Checkout Page Functions
 */

// Enqueue custom checkout styles


/**
 * WooCommerce Checkout Customizations
 * Add this code to your theme's functions.php file
 */

// Enqueue custom styles
function custom_checkout_styles() {
    if (is_checkout()) {
        wp_enqueue_style('custom-checkout-styles', get_stylesheet_directory_uri() . '/assets/css/custom-checkout.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'custom_checkout_styles');

// Customize the checkout fields (labels, placeholders, etc.)
function custom_checkout_fields($fields) {
    // Billing fields
    if (isset($fields['billing'])) {
        // First name field
        if (isset($fields['billing']['billing_first_name'])) {
            $fields['billing']['billing_first_name']['label'] = 'First name';
            $fields['billing']['billing_first_name']['placeholder'] = '';
        }
        
        // Last name field
        if (isset($fields['billing']['billing_last_name'])) {
            $fields['billing']['billing_last_name']['label'] = 'Last name';
            $fields['billing']['billing_last_name']['placeholder'] = '';
        }
        
        // Company field
        if (isset($fields['billing']['billing_company'])) {
            $fields['billing']['billing_company']['label'] = 'Company name (optional)';
            $fields['billing']['billing_company']['placeholder'] = '';
        }
        
        // Country field
        if (isset($fields['billing']['billing_country'])) {
            $fields['billing']['billing_country']['label'] = 'Country / Region';
        }
        
        // Address 1 field
        if (isset($fields['billing']['billing_address_1'])) {
            $fields['billing']['billing_address_1']['label'] = 'Street address';
            $fields['billing']['billing_address_1']['placeholder'] = 'House number and street name';
        }
        
        // Address 2 field
        if (isset($fields['billing']['billing_address_2'])) {
            $fields['billing']['billing_address_2']['label'] = '';
            $fields['billing']['billing_address_2']['placeholder'] = 'Apartment, suite, unit, etc. (optional)';
        }
        
        // City field
        if (isset($fields['billing']['billing_city'])) {
            $fields['billing']['billing_city']['label'] = 'Town / City';
            $fields['billing']['billing_city']['placeholder'] = '';
        }
        
        // State field
        if (isset($fields['billing']['billing_state'])) {
            $fields['billing']['billing_state']['label'] = 'State';
        }
        
        // Postcode field
        if (isset($fields['billing']['billing_postcode'])) {
            $fields['billing']['billing_postcode']['label'] = 'ZIP Code';
            $fields['billing']['billing_postcode']['placeholder'] = '';
        }
        
        // Phone field
        if (isset($fields['billing']['billing_phone'])) {
            $fields['billing']['billing_phone']['label'] = 'Phone';
            $fields['billing']['billing_phone']['placeholder'] = '';
        }
        
        // Email field
        if (isset($fields['billing']['billing_email'])) {
            $fields['billing']['billing_email']['label'] = 'Email address';
            $fields['billing']['billing_email']['placeholder'] = '';
        }
    }
    
    // Order notes
    if (isset($fields['order']['order_comments'])) {
        $fields['order']['order_comments']['label'] = 'Order notes (optional)';
        $fields['order']['order_comments']['placeholder'] = 'Notes about your order, e.g. special notes for delivery.';
    }
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'custom_checkout_fields');

// Add free shipping notice to checkout
function add_free_shipping_notice() {
    if (!is_checkout()) {
        return;
    }
    
    $minimum_amount = 299.17; // Set your minimum amount for free shipping
    $current_total = WC()->cart->subtotal;
    
    if ($current_total < $minimum_amount) {
        $remaining = $minimum_amount - $current_total;
        $formatted_remaining = wc_price($remaining);
        
        wc_add_notice(
            sprintf('Add %s to cart and get free shipping!', $formatted_remaining),
            'notice'
        );
    }
}
add_action('woocommerce_before_checkout_form', 'add_free_shipping_notice');

// Customize the payment gateway titles
function customize_payment_gateways($gateways) {
    if (isset($gateways['bacs'])) {
        $gateways['bacs']->title = 'Direct Bank Transfer';
        $gateways['bacs']->description = 'Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.';
    }
    
    if (isset($gateways['cod'])) {
        $gateways['cod']->title = 'Cash On Delivery';
    }
    
    return $gateways;
}
add_filter('woocommerce_available_payment_gateways', 'customize_payment_gateways');

// Add product image to checkout order review
function add_product_thumbnail_to_checkout($product_name, $cart_item, $cart_item_key) {
    if (!is_checkout()) {
        return $product_name;
    }
    
    $product = $cart_item['data'];
    $thumbnail = $product->get_image(array(40, 40));
    
    return $thumbnail . '<div class="product-name-wrapper">' . $product_name . '</div>';
}
add_filter('woocommerce_cart_item_name', 'add_product_thumbnail_to_checkout', 10, 3);

// Add "New Arrivals" section after checkout
function add_new_arrivals_after_checkout() {
    if (!is_checkout()) {
        return;
    }
    
    echo '<div class="new-arrivals-section">';
    echo '<h2>New Arrivals</h2>';
    
    // Query for latest products
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        echo '<ul class="products new-arrivals">';
        
        while ($query->have_posts()) : $query->the_post();
            wc_get_template_part('content', 'product');
        endwhile;
        
        echo '</ul>';
    }
    
    wp_reset_postdata();
    echo '</div>';
}
add_action('woocommerce_after_checkout_form', 'add_new_arrivals_after_checkout', 20);

// Add New Arrivals CSS
function new_arrivals_css() {
    if (!is_checkout()) {
        return;
    }
    ?>
    <style>
        .new-arrivals-section {
            clear: both;
            padding-top: 40px;
            margin-top: 40px;
            border-top: 1px solid #eee;
        }
        
        .new-arrivals-section h2 {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        ul.new-arrivals {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
            padding: 0;
            list-style: none;
        }
        
        ul.new-arrivals li.product {
            flex: 0 0 calc(25% - 20px);
            margin: 0 10px 20px !important;
            box-sizing: border-box;
        }
        
        ul.new-arrivals li.product img {
            margin-bottom: 10px;
        }
        
        ul.new-arrivals li.product .woocommerce-loop-product__title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        ul.new-arrivals li.product .price {
            font-size: 14px;
            color: #6b5acd;
            font-weight: 600;
        }
        
        @media (max-width: 991px) {
            ul.new-arrivals li.product {
                flex: 0 0 calc(33.33% - 20px);
            }
        }
        
        @media (max-width: 767px) {
            ul.new-arrivals li.product {
                flex: 0 0 calc(50% - 20px);
            }
        }
        
        @media (max-width: 479px) {
            ul.new-arrivals li.product {
                flex: 0 0 calc(100% - 20px);
            }
        }
    </style>
    <?php
}
add_action('wp_head', 'new_arrivals_css');

// Add thumbnail CSS to checkout page
function checkout_product_thumbnail_css() {
    if (!is_checkout()) {
        return;
    }
    ?>
    <style>
        .woocommerce-checkout-review-order-table .product-name {
            display: flex;
            align-items: center;
        }
        
        .woocommerce-checkout-review-order-table .product-name img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 3px;
            object-fit: cover;
        }
        
        .product-name-wrapper {
            display: inline-block;
        }
    </style>
    <?php
}
add_action('wp_head', 'checkout_product_thumbnail_css');


// Register Slider Custom Post Type
function register_slider_post_type() {
    $labels = array(
        'name'               => 'Slides',
        'singular_name'      => 'Slide',
        'menu_name'          => 'Banner Slider',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Slide',
        'edit_item'          => 'Edit Slide',
        'new_item'           => 'New Slide',
        'view_item'          => 'View Slide',
        'search_items'       => 'Search Slides',
        'not_found'          => 'No slides found',
        'not_found_in_trash' => 'No slides found in Trash',
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-images-alt2',
        'hierarchical'        => false,
        'supports'            => array('title', 'thumbnail', 'page-attributes'),
        'has_archive'         => false,
        'rewrite'             => false,
        'menu_position'       => 20,
    );
    
    register_post_type('slide', $args);
}
add_action('init', 'register_slider_post_type');

// Add custom image sizes
add_theme_support('post-thumbnails');
add_image_size('slider-desktop', 1920, 600, true);
add_image_size('slider-mobile', 768, 500, true);

// Add custom meta boxes for mobile image and slide details
function slider_meta_boxes() {
    add_meta_box(
        'slide_details',
        'Slide Details',
        'slide_details_callback',
        'slide',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'slider_meta_boxes');

// Callback function for the meta box
function slide_details_callback($post) {
    wp_nonce_field('slide_details_nonce', 'slide_details_nonce');
    
    $mobile_image = get_post_meta($post->ID, '_mobile_image', true);
    $slide_description = get_post_meta($post->ID, '_slide_description', true);
    $button_text = get_post_meta($post->ID, '_button_text', true);
    $button_url = get_post_meta($post->ID, '_button_url', true);
    ?>
    <p>
        <label for="mobile_image">Mobile Image (if different from featured image):</label><br>
        <input type="hidden" name="mobile_image" id="mobile_image" value="<?php echo esc_attr($mobile_image); ?>">
        <button type="button" class="button" id="mobile_image_button">Select Image</button>
        <div id="mobile_image_preview" style="margin-top: 10px;">
            <?php if($mobile_image): ?>
                <?php echo wp_get_attachment_image($mobile_image, 'medium'); ?>
            <?php endif; ?>
        </div>
    </p>
    <p>
        <label for="slide_description">Slide Description:</label><br>
        <textarea name="slide_description" id="slide_description" class="large-text" rows="3"><?php echo esc_textarea($slide_description); ?></textarea>
    </p>
    <p>
        <label for="button_text">Button Text (optional):</label><br>
        <input type="text" name="button_text" id="button_text" class="regular-text" value="<?php echo esc_attr($button_text); ?>">
    </p>
    <p>
        <label for="button_url">Button URL (optional):</label><br>
        <input type="url" name="button_url" id="button_url" class="large-text" value="<?php echo esc_url($button_url); ?>">
    </p>
    <script>
    jQuery(document).ready(function($) {
        $('#mobile_image_button').click(function() {
            var frame = wp.media({
                title: 'Select Mobile Image',
                multiple: false,
                library: { type: 'image' }
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#mobile_image').val(attachment.id);
                $('#mobile_image_preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto;">');
            });
            
            frame.open();
        });
    });
    </script>
    <?php
}

// Save the meta box data
function save_slide_details($post_id) {
    if(!isset($_POST['slide_details_nonce']) || !wp_verify_nonce($_POST['slide_details_nonce'], 'slide_details_nonce')) {
        return;
    }
    
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if(!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if(isset($_POST['mobile_image'])) {
        update_post_meta($post_id, '_mobile_image', sanitize_text_field($_POST['mobile_image']));
    }
    
    if(isset($_POST['slide_description'])) {
        update_post_meta($post_id, '_slide_description', sanitize_textarea_field($_POST['slide_description']));
    }
    
    if(isset($_POST['button_text'])) {
        update_post_meta($post_id, '_button_text', sanitize_text_field($_POST['button_text']));
    }
    
    if(isset($_POST['button_url'])) {
        update_post_meta($post_id, '_button_url', esc_url_raw($_POST['button_url']));
    }
}
add_action('save_post_slide', 'save_slide_details');


/**
 * Banner Shortcodes
 */

// Single Banner Shortcode
function single_banner_shortcode($atts) {
    $atts = shortcode_atts(array(
        'desktop' => '',         // Desktop image URL
        'mobile' => '',          // Mobile image URL
        'title' => '',           // Banner title
        'description' => '',     // Banner description
        'button_text' => '',     // Button text
        'button_url' => '',      // Button URL
        'button_class' => 'btn btn-primary', // Button class
        'height' => 'auto',      // Banner height (desktop)
        'mobile_height' => 'auto', // Banner height (mobile)
        'text_color' => '#fff',  // Text color
        'text_position' => 'center', // Text position: left, center, right
    ), $atts);
    
    ob_start();
    ?>
    <div class="promo-banner">
        <div class="d-none d-md-block">
            <?php if($atts['desktop']): ?>
                <div class="banner-image-container" style="height: <?php echo esc_attr($atts['height']); ?>;">
                    <img src="<?php echo esc_url($atts['desktop']); ?>" class="banner-image" alt="<?php echo esc_attr($atts['title']); ?>">
                </div>
            <?php endif; ?>
        </div>
        
        <div class="d-block d-md-none">
            <?php if($atts['mobile']): ?>
                <div class="banner-image-container" style="height: <?php echo esc_attr($atts['mobile_height']); ?>;">
                    <img src="<?php echo esc_url($atts['mobile']); ?>" class="banner-image" alt="<?php echo esc_attr($atts['title']); ?>">
                </div>
            <?php elseif($atts['desktop']): ?>
                <div class="banner-image-container" style="height: <?php echo esc_attr($atts['mobile_height']); ?>;">
                    <img src="<?php echo esc_url($atts['desktop']); ?>" class="banner-image" alt="<?php echo esc_attr($atts['title']); ?>">
                </div>
            <?php endif; ?>
        </div>
        
        <?php if($atts['title'] || $atts['description'] || ($atts['button_text'] && $atts['button_url'])): ?>
            <div class="banner-content text-<?php echo esc_attr($atts['text_position']); ?>" style="color: <?php echo esc_attr($atts['text_color']); ?>">
                <?php if($atts['title']): ?>
                    <h2 class="banner-title"><?php echo esc_html($atts['title']); ?></h2>
                <?php endif; ?>
                
                <?php if($atts['description']): ?>
                    <div class="banner-description"><?php echo wp_kses_post($atts['description']); ?></div>
                <?php endif; ?>
                
                <?php if($atts['button_text'] && $atts['button_url']): ?>
                    <a href="<?php echo esc_url($atts['button_url']); ?>" class="<?php echo esc_attr($atts['button_class']); ?>"><?php echo esc_html($atts['button_text']); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('banner', 'single_banner_shortcode');

// Slider Banner Shortcode
function slider_banner_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 5,           // Number of slides to show
        'category' => '',       // Optional category slug to filter slides
        'height' => 'auto',     // Banner height (desktop)
        'mobile_height' => 'auto', // Banner height (mobile)
        'interval' => 5000,     // Time between slides (ms)
        'id' => 'bannerCarousel' . rand(100, 999), // Unique ID
    ), $atts);
    
    // Query slides
    $args = array(
        'post_type' => 'slide',
        'posts_per_page' => intval($atts['count']),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    // Add category filter if provided
    if(!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'slide_category',
                'field' => 'slug',
                'terms' => $atts['category']
            )
        );
    }
    
    $slides = new WP_Query($args);
    
    if(!$slides->have_posts()) {
        return '<div class="alert alert-info">No slides found</div>';
    }
    
    ob_start();
    ?>
    <div id="<?php echo esc_attr($atts['id']); ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="<?php echo esc_attr($atts['interval']); ?>">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <?php 
            $slide_count = 0;
            while($slides->have_posts()): $slides->the_post(); 
            ?>
                <button type="button" data-bs-target="#<?php echo esc_attr($atts['id']); ?>" data-bs-slide-to="<?php echo $slide_count; ?>" <?php echo ($slide_count == 0) ? 'class="active"' : ''; ?>></button>
            <?php 
                $slide_count++;
            endwhile; 
            $slides->rewind_posts();
            ?>
        </div>
        
        <!-- Slides -->
        <div class="carousel-inner">
            <?php 
            $slide_count = 0;
            while($slides->have_posts()): $slides->the_post();
                $mobile_image_id = get_post_meta(get_the_ID(), '_mobile_image', true);
                $slide_description = get_post_meta(get_the_ID(), '_slide_description', true);
                $button_text = get_post_meta(get_the_ID(), '_button_text', true);
                $button_url = get_post_meta(get_the_ID(), '_button_url', true);
            ?>
                <div class="carousel-item <?php echo ($slide_count == 0) ? 'active' : ''; ?>">
                    <!-- Desktop Image -->
                    <div class="d-none d-md-block">
                        <?php if(has_post_thumbnail()): ?>
                            <div class="banner-image-container" style="height: <?php echo esc_attr($atts['height']); ?>;">
                                <?php the_post_thumbnail('full', array('class' => 'banner-image')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Mobile Image -->
                    <div class="d-block d-md-none">
                        <?php if($mobile_image_id): ?>
                            <div class="banner-image-container" style="height: <?php echo esc_attr($atts['mobile_height']); ?>;">
                                <?php echo wp_get_attachment_image($mobile_image_id, 'full', false, array('class' => 'banner-image')); ?>
                            </div>
                        <?php elseif(has_post_thumbnail()): ?>
                            <div class="banner-image-container" style="height: <?php echo esc_attr($atts['mobile_height']); ?>;">
                                <?php the_post_thumbnail('full', array('class' => 'banner-image')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if(get_the_title() || $slide_description || ($button_text && $button_url)): ?>
                        <div class="carousel-caption">
                            <h2><?php the_title(); ?></h2>
                            <?php if($slide_description): ?>
                                <div class="slide-description"><?php echo wp_kses_post($slide_description); ?></div>
                            <?php endif; ?>
                            
                            <?php if($button_text && $button_url): ?>
                                <a href="<?php echo esc_url($button_url); ?>" class="btn btn-primary"><?php echo esc_html($button_text); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php
                $slide_count++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo esc_attr($atts['id']); ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo esc_attr($atts['id']); ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('slider', 'slider_banner_shortcode');

// Add slide categories taxonomy
function register_slide_taxonomy() {
    $labels = array(
        'name'              => 'Slide Categories',
        'singular_name'     => 'Slide Category',
        'search_items'      => 'Search Categories',
        'all_items'         => 'All Categories',
        'parent_item'       => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Category',
        'update_item'       => 'Update Category',
        'add_new_item'      => 'Add New Category',
        'new_item_name'     => 'New Category Name',
        'menu_name'         => 'Categories',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'slide-category'),
    );

    register_taxonomy('slide_category', array('slide'), $args);
}
add_action('init', 'register_slide_taxonomy');

//home page load more products just for you section
function load_more_products() {
    $page = $_POST['page'];
    echo do_shortcode('[products limit="24" columns="6" orderby="rand" page="' . $page . '"]');
    die();
}
add_action('wp_ajax_load_more_products', 'load_more_products');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products');

function enqueue_load_more_script() {
    wp_enqueue_script('load-more', get_template_directory_uri() . '/js/load-more.js', array('jquery'), '1.0', true);
    wp_localize_script('load-more', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');
