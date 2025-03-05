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


//toggle sidebar
document.addEventListener('DOMContentLoaded', function() {
    // Filter toggle button
    const filterToggleBtn = document.querySelector('.filter-toggle-btn');
    const shopSidebar = document.getElementById('shopSidebar');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const closeSidebarBtn = document.querySelector('.close-sidebar');
    
    if (filterToggleBtn && shopSidebar && sidebarOverlay && closeSidebarBtn) {
        filterToggleBtn.addEventListener('click', function() {
            shopSidebar.classList.add('open');
            sidebarOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
        
        closeSidebarBtn.addEventListener('click', function() {
            shopSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        });
        
        sidebarOverlay.addEventListener('click', function() {
            shopSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        });
    }
});

/**
 * Mobile Shop Filter Functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    // Filter toggle button
    const filterToggleBtn = document.querySelector('.filter-toggle-btn');
    const shopSidebar = document.getElementById('shopSidebar');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const closeSidebarBtn = document.querySelector('.close-sidebar');
    const resetFiltersBtn = document.querySelector('.reset-filters-btn');
    
    // Mobile sidebar toggle
    if (filterToggleBtn && shopSidebar && sidebarOverlay && closeSidebarBtn) {
        // Open sidebar
        filterToggleBtn.addEventListener('click', function() {
            shopSidebar.classList.add('open');
            sidebarOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
        
        // Close sidebar functions
        const closeSidebar = function() {
            shopSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        };
        
        closeSidebarBtn.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);
        
        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && shopSidebar.classList.contains('open')) {
                closeSidebar();
            }
        });
    }
    
    // Reset filters
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function() {
            // Reset all inputs
            const inputs = shopSidebar.querySelectorAll('input[type="checkbox"], input[type="number"]');
            inputs.forEach(function(input) {
                if (input.type === 'checkbox') {
                    input.checked = false;
                } else if (input.type === 'number') {
                    input.value = '';
                }
            });
        });
    }
    
    // Price slider functionality (simplified example)
    const priceSlider = document.querySelector('.price-slider');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    
    if (priceSlider && minPriceInput && maxPriceInput) {
        // This is just a visual example - for a real implementation, 
        // you'd want to use a library like noUiSlider
        
        // Update slider appearance based on inputs
        const updateSliderAppearance = function() {
            const min = parseInt(minPriceInput.value) || 0;
            const max = parseInt(maxPriceInput.value) || 5000;
            const total = 5000; // Maximum possible value
            
            const leftPercent = (min / total) * 100;
            const rightPercent = 100 - ((max / total) * 100);
            
            priceSlider.style.setProperty('--left-percent', leftPercent + '%');
            priceSlider.style.setProperty('--right-percent', rightPercent + '%');
        };
        
        minPriceInput.addEventListener('input', updateSliderAppearance);
        maxPriceInput.addEventListener('input', updateSliderAppearance);
        
        // Initial update
        updateSliderAppearance();
    }
    
    // Apply filters button
    const applyFiltersBtn = document.querySelector('.filter-all-btn');
    
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
            // Create a form to submit all filter values
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = window.location.pathname;
            
            // Get all filter inputs
            const inputs = shopSidebar.querySelectorAll('input[type="checkbox"]:checked, input[type="number"][value]');
            
            inputs.forEach(function(input) {
                const hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = input.name;
                hiddenField.value = input.value;
                form.appendChild(hiddenField);
            });
            
            // Append form to body and submit
            document.body.appendChild(form);
            form.submit();
        });
    }
});