
            jQuery(document).ready(function($) {
                // Toggle coupon form visibility
                $("#show-coupon-form").on("change", function() {
                    $(".coupon-form").slideToggle(200);
                });
                
                // Apply coupon via AJAX when the button is clicked
                $(".coupon-form button").on("click", function(e) {
                    e.preventDefault();
                    var coupon_code = $("#coupon_code").val();
                    
                    if (coupon_code) {
                        var data = {
                            action: "apply_coupon",
                            coupon_code: coupon_code,
                            security: wc_checkout_params.apply_coupon_nonce
                        };
                        
                        $.ajax({
                            type: "POST",
                            url: wc_checkout_params.ajax_url,
                            data: data,
                            success: function(response) {
                                $(".woocommerce-notices-wrapper").html(response);
                                $("body").trigger("update_checkout");
                            }
                        });
                    }
                });
            });
        