jQuery(document).ready(function($) {
    // Handle all filters with a single button
    $('.filter-all-btn').on('click', function() {
        // Create a new form element
        const form = $('<form></form>');
        form.attr('method', 'get');
        form.attr('action', window.location.pathname);
        
        // Get current query parameters (except our filter parameters)
        const currentParams = new URLSearchParams(window.location.search);
        
        // Remove filter parameters that we'll handle
        currentParams.delete('min_price');
        currentParams.delete('max_price');
        currentParams.delete('stock_status[]');
        
        // Add other existing parameters
        for (const [key, value] of currentParams.entries()) {
            form.append($('<input type="hidden" name="' + key + '" value="' + value + '">'));
        }
        
        // Add price range if values exist
        const minPrice = $('#min-price').val();
        const maxPrice = $('#max-price').val();
        
        if (minPrice && minPrice.trim() !== '') {
            form.append($('<input type="hidden" name="min_price" value="' + minPrice + '">'));
        }
        
        if (maxPrice && maxPrice.trim() !== '') {
            form.append($('<input type="hidden" name="max_price" value="' + maxPrice + '">'));
        }
        
        // Add stock status filters
        $('input[name="stock_status[]"]:checked').each(function() {
            form.append($('<input type="hidden" name="stock_status[]" value="' + $(this).val() + '">'));
        });
        
        // Append form to body and submit
        $('body').append(form);
        form.submit();
    });
    
    // Initialize price slider
    if ($.ui && $.ui.slider) {
        // Get min and max prices for the range
        const minValue = parseInt($('#min-price').val()) || 0;
        const maxValue = parseInt($('#max-price').val()) || 5000;
        
        $('.price-slider').slider({
            range: true,
            min: 0,
            max: 10000,
            values: [minValue, maxValue],
            slide: function(event, ui) {
                $('#min-price').val(ui.values[0]);
                $('#max-price').val(ui.values[1]);
            }
        });
    }
    
    // Update price inputs when slider changes
    $('.price-slider').on('slidechange', function(event, ui) {
        $('#min-price').val(ui.values[0]);
        $('#max-price').val(ui.values[1]);
    });
    
    // Update slider when price inputs change
    $('#min-price, #max-price').on('change', function() {
        const minValue = parseInt($('#min-price').val()) || 0;
        const maxValue = parseInt($('#max-price').val()) || 5000;
        
        if ($.ui && $.ui.slider) {
            $('.price-slider').slider('values', [minValue, maxValue]);
        }
    });
});