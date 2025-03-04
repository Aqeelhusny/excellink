/**
 * Optimized WooCommerce single product JavaScript
 * Works with WooCommerce's native JS files and functionality
 */
(function($) {
    'use strict';

    // Only run on single product pages
    if (!$('.custom-single-product').length) {
        return;
    }

    $(document).ready(function() {
        /**
         * Custom Product Image Gallery
         * Works alongside WooCommerce's gallery but with custom interactions
         */
        $('.thumbnail-item').on('click', function(e) {
            e.preventDefault();
            
            // Get image data
            var $img = $(this).find('img');
            var largeImage = $img.data('large-image');
            var largeWidth = $img.data('large-image-width');
            var largeHeight = $img.data('large-image-height');
            
            // Update main image
            $('.main-product-image').attr('src', largeImage);
            $('.main-product-image').attr('srcset', '');
            
            // Update active state
            $('.thumbnail-item').removeClass('active');
            $(this).addClass('active');
            
            // Trigger WooCommerce gallery update event
            $(document.body).trigger('woocommerce_gallery_image_changed', [this]);
        });

        /**
         * Custom Quantity Buttons
         * Integrate with WooCommerce's quantity input
         */
        $('.qty-minus').on('click', function(e) {
            e.preventDefault();
            
            var $input = $(this).siblings('.qty');
            var val = parseInt($input.val());
            var min = parseInt($input.attr('min')) || 1;
            
            if (val > min) {
                $input.val(val - 1).change();
                // Trigger WooCommerce quantity change event
                $(document.body).trigger('quantity_decrement', [this]);
            }
            
            if (parseInt($input.val()) === min) {
                $(this).attr('disabled', true);
            }
        });
        
        $('.qty-plus').on('click', function(e) {
            e.preventDefault();
            
            var $input = $(this).siblings('.qty');
            var val = parseInt($input.val());
            var max = parseInt($input.attr('max')) || 999;
            
            if (val < max) {
                $input.val(val + 1).change();
                $('.qty-minus').attr('disabled', false);
                // Trigger WooCommerce quantity change event
                $(document.body).trigger('quantity_increment', [this]);
            }
            
            if (parseInt($input.val()) === max) {
                $(this).attr('disabled', true);
            }
        });
        
        // Initialize quantity buttons state
        function updateQtyButtonState() {
            $('.qty').each(function() {
                var $input = $(this);
                var val = parseInt($input.val());
                var min = parseInt($input.attr('min')) || 1;
                var max = parseInt($input.attr('max')) || 999;
                
                if (val <= min) {
                    $input.siblings('.qty-minus').attr('disabled', true);
                } else {
                    $input.siblings('.qty-minus').attr('disabled', false);
                }
                
                if (val >= max) {
                    $input.siblings('.qty-plus').attr('disabled', true);
                } else {
                    $input.siblings('.qty-plus').attr('disabled', false);
                }
            });
        }
        
        updateQtyButtonState();
        
        // Listen for WooCommerce's quantity change events
        $(document.body).on('updated_cart_totals', updateQtyButtonState);
        $('.qty').on('change', updateQtyButtonState);

        /**
         * Buy Now Button
         * Adds product to cart and redirects to checkout
         */
        $('.buy-now-button').on('click', function(e) {
            e.preventDefault();
            
            var $form = $(this).closest('form.cart');
            var formData = new FormData($form[0]);
            
            // Add the buy now parameter
            formData.append('buy_now', 'true');
            
            // Use WooCommerce's AJAX add to cart
            $.ajax({
                type: 'POST',
                url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.error) {
                        // Show error message
                        if ($(document).find('.woocommerce-error').length) {
                            $(document).find('.woocommerce-error').remove();
                        }
                        $form.before('<div class="woocommerce-error">' + response.error + '</div>');
                    } else {
                        // Redirect to checkout
                        window.location = wc_add_to_cart_params.checkout_url;
                    }
                },
                error: function() {
                    // Fallback: standard form submission
                    $form.find('button[name="add-to-cart"]').trigger('click');
                    
                    // Wait for WooCommerce to process then redirect
                    setTimeout(function() {
                        window.location = wc_add_to_cart_params.checkout_url;
                    }, 1000);
                }
            });
        });

        /**
         * Custom Size Selection
         * For simple products only (variable products use WooCommerce's variation system)
         */
        if (!$('.variations_form').length) {
            $('.size-option').on('click', function() {
                $('.size-option').removeClass('active');
                $(this).addClass('active');
                
                // This could also update a hidden field if needed
                // or trigger custom events for plugins to listen to
            });
        }

        /**
         * Custom Product Tabs
         * Integrate with WooCommerce's tab system
         */
        $('.tab-button').on('click', function() {
            var tab = $(this).data('tab');
            
            // Update active tab button
            $('.tab-button').removeClass('active');
            $(this).addClass('active');
            
            // Show selected tab content
            $('.tab-content').removeClass('active');
            $('#' + tab + '-tab').addClass('active');
            
            // Notify WooCommerce of tab change
            $(document.body).trigger('woocommerce_tab_changed', [tab]);
        });

        /**
         * Wishlist & Compare Functionality
         * Only needed if not using dedicated plugins
         */
        // Only attach custom handlers if YITH plugins are not present
        if (!$('.yith-wcwl-add-to-wishlist').length) {
            $('.add-to-wishlist').on('click', function(e) {
                e.preventDefault();
                
                $(this).toggleClass('active');
                
                if ($(this).hasClass('active')) {
                    showWooNotice(woocommerce_params.i18n_wishlist_added || 'Product added to wishlist', 'success');
                } else {
                    showWooNotice(woocommerce_params.i18n_wishlist_removed || 'Product removed from wishlist', 'success');
                }
            });
        }
        
        if (!$('.yith-compare-button').length) {
            $('.compare-product').on('click', function(e) {
                e.preventDefault();
                
                showWooNotice(woocommerce_params.i18n_compare_added || 'Product added to comparison', 'success');
            });
        }

        /**
         * Share Product
         */
        $('.share-product').on('click', function(e) {
            e.preventDefault();
            
            if (navigator.share) {
                // Use Web Share API if available
                navigator.share({
                    title: document.title,
                    url: window.location.href
                }).catch(function() {
                    // Fallback to clipboard
                    copyToClipboard(window.location.href);
                    showWooNotice(woocommerce_params.i18n_copied_link || 'Product URL copied to clipboard', 'success');
                });
            } else {
                // Fallback for browsers without Share API
                copyToClipboard(window.location.href);
                showWooNotice(woocommerce_params.i18n_copied_link || 'Product URL copied to clipboard', 'success');
            }
        });

        /**
         * Helper Functions
         */
        // Copy text to clipboard
        function copyToClipboard(text) {
            var temp = $('<input>');
            $('body').append(temp);
            temp.val(text).select();
            document.execCommand('copy');
            temp.remove();
        }
        
        // Show WooCommerce notification
        function showWooNotice(message, type) {
            // Remove existing notices
            $('.woocommerce-notices-wrapper').find('.woocommerce-' + type).remove();
            
            // Add new notice
            $('.woocommerce-notices-wrapper').prepend(
                '<div class="woocommerce-' + type + '">' + message + '</div>'
            );
            
            // Scroll to notice if not visible
            $('html, body').animate({
                scrollTop: $('.woocommerce-notices-wrapper').offset().top - 100
            }, 500);
            
            // Remove after 5 seconds
            setTimeout(function() {
                $('.woocommerce-notices-wrapper').find('.woocommerce-' + type).fadeOut(500, function() {
                    $(this).remove();
                });
            }, 5000);
        }
        
        // Ensure WooCommerce notices wrapper exists
        if (!$('.woocommerce-notices-wrapper').length) {
            $('.custom-single-product').before('<div class="woocommerce-notices-wrapper"></div>');
        }
    });

    // Make sure all WooCommerce scripts are fully loaded
    $(window).on('load', function() {
        // Trigger resize to make sure product images are properly laid out
        setTimeout(function() {
            $(window).trigger('resize');
        }, 100);
    });

})(jQuery);