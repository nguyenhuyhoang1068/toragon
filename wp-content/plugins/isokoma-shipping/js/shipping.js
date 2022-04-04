jQuery(document).ready(function() {
    if (jQuery('.woocommerce-shipping-totals.shipping span.woocommerce-Price-amount').length == 0) {
        //jQuery('.woocommerce-shipping-totals.shipping th').remove();
        jQuery('.woocommerce-shipping-totals.shipping  ul li').eq(1).remove();
    }




});
jQuery(document).ajaxComplete(function(event, request, settings) {
    if (jQuery('.woocommerce-shipping-totals.shipping span.woocommerce-Price-amount').length == 0) {
        //jQuery('.woocommerce-shipping-totals.shipping th').remove();
        jQuery('.woocommerce-shipping-totals.shipping  ul li').eq(1).remove();
    }
});


jQuery(document).ready(function(e) {
    jQuery('.state_select').on('change', function() {
        jQuery('body').trigger('update_checkout');
    });
    /*
    var $ = jQuery;
    if (typeof wc_checkout_params === 'undefined')
        return false;
    var updateTimer, dirtyInput = false,
        xhr;

    function update_order_review_table(billingstate, billingcountry) {
        if (xhr) xhr.abort();
        $('#order_methods, #order_review').block({ message: null, overlayCSS: { background: '#fff url(' + wc_checkout_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } });

        var data = {
            action: 'woocommerce_update_order_review',
            security: wc_checkout_params.update_order_review_nonce,
            billing_state: billingstate,
            billing_country: billingcountry,
            post_data: $('form.checkout').serialize()
        };

        xhr = $.ajax({
            type: 'POST',
            url: wc_checkout_params.ajax_url,
            data: data,
            success: function(response) {
                var order_output = $(response);
                $('#order_review').html(response['fragments']['.woocommerce-checkout-review-order-table'] + response['fragments']['.woocommerce-checkout-payment']);
                $('body').trigger('update_checkout');
            },
            error: function(code) {
                console.log('ERROR');
            }
        });
    }
    jQuery('.state_select').change(function(e, params) {
        update_order_review_table(jQuery(this).val(), jQuery('#billing_country').val());
    });*/
});