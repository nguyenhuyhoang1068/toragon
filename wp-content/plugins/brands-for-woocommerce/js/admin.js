var br_saved_timeout;
var br_savin_ajax = false;
function brand_widget_init() {
    jQuery('.colorpicker_field_brand').each(function (i,o){
        jQuery(o).css('backgroundColor', '#'+jQuery(o).data('color'));
        jQuery(o).colpick({
            layout: 'hex',
            submit: 0,
            color: '#'+jQuery(o).data('color'),
            onChange: function(hsb,hex,rgb,el,bySetColor) {
                jQuery(el).css('backgroundColor', '#'+hex).next().val(hex).trigger('change');
            }
        })
    });
}
(function ($){
    $(document).ready( function () {
        brand_widget_init();
        
        $(document).on('click', '.br_brands_image .berocket_aapf_upload_icon', function(e) {
            e.preventDefault();
            $p = $(this);
            var custom_uploader = wp.media({
                title: 'Select custom Icon',
                button: {
                    text: 'Set Icon'
                },
                multiple: false 
            }).on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $p.prevAll(".berocket_aapf_selected_icon_show").html('<i class="fa"><image src="'+attachment.url+'" alt=""></i>');
                $p.prevAll(".berocket_aapf_icon_text_value").val(attachment.url);
            }).open();
        });
        $(document).on('click', '.br_brands_image .berocket_aapf_remove_icon',function(event) {
            event.preventDefault();
            $(this).prevAll(".berocket_aapf_icon_text_value").val("");
            $(this).prevAll(".berocket_aapf_selected_icon_show").html("");
        });

        $(document).on('click', '.theme_default', function (event) {
            event.preventDefault();
            $(this).prev().prev().css('backgroundColor', '#000000').colpickSetColor('#000000');
            $(this).prev().val('');
        });
        $(document).on('change', '.br_brandw_perrow, .br_brandw_count', function() {
            var $parent = $(this).parents('.br_brandw_js');
            if( $parent.find('.br_brandw_count').val() && $parent.find('.br_brandw_perrow').val() ) {
                var count = parseInt($parent.find('.br_brandw_count').val());
                var perrow = parseInt($parent.find('.br_brandw_perrow').val());
                if( perrow > count ) {
                    $parent.find('.br_brandw_perrow').val(count);
                }
            }
        });
        function shop_display_brand() {
            if( $('.shop_display_brand').prop('checked') ) {
                $('.shop_display_brand_enabled').show();
            } else {
                $('.shop_display_brand_enabled').hide();
            }
        }
        $(document).on('change', '.shop_display_brand', shop_display_brand);
        shop_display_brand();
        function product_display_brand() {
            if( $('.product_display_brand').prop('checked') ) {
                $('.product_display_brand_enabled').show();
            } else {
                $('.product_display_brand_enabled').hide();
            }
        }
        $(document).on('change', '.product_display_brand', product_display_brand);
        product_display_brand();
    });
})(jQuery);
