jQuery(document).ready(function($) {
    $('#load-more').on('click', function() {
        const button = $(this);
        const page = parseInt(button.data('page'));
        
        if(button.data('loading') === true) return;
        
        button.data('loading', true);
        button.text('Loading...');

        $.ajax({
            url: ajax_object.ajax_url,
            data: {
                action: 'load_more_products',
                page: page + 1
            },
            success: function(response) {
                // Find and append only the li elements from the response
                const $response = $(response);
                const $products = $response.find('li.product');
                $('#just-for-you-products').append($products);
                
                button.data('page', page + 1);
                button.data('loading', false);
                button.text('Load More Products');
            }
        });
    });
});
