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