<?php 
extract($brbrands_atts);
if( $title ) echo $args['before_title'].$title.$args['after_title'];
$args = array(
    'taxonomy'      => 'berocket_brand',
    'hide_empty'    => ! empty($hide_empty),
);
$BeRocket_product_brand = BeRocket_product_brand::getInstance();
$options = $BeRocket_product_brand->get_option();
$options_args = array(
    'number'    => 'count',
    'orderby'   => 'orderby',
    'order'     => 'order',
    'include'   => 'include',
    'exclude'   => 'exclude',
);
foreach($options_args as $to_var => $from_var) {
    if( ! empty($brbrands_atts[$from_var]) ) {
        $args[$to_var] = $brbrands_atts[$from_var];
    }
}
$terms = get_terms( apply_filters('brbrands_widget_get_terms_args', $args, $brbrands_atts) );
if( ! empty($terms) && is_array($terms) && count($terms) > 0 ) {
    $per_row = (int)$per_row;
    $width = 100 / $per_row;
    global $berocket_unique_value;
    $berocket_unique_value++;
    $slider_rand = $berocket_unique_value;
    if( ! empty($slider) ) {
        wp_enqueue_style( 'berocket_slick_slider' );
    ?>
    <script>
    (function ($){
        $(document).ready( function () {
            <?php 
            if( empty($options['slider_infinite']) ) {
                echo "$('.brcs_slider_brands:not(\".slick-slider\")').on('afterChange init', function(event, slick) {
                    $(this).find('.slick-prev').show();
                    $(this).find('.slick-next').show();
                    if (slick.currentSlide === 0) {
                        $(this).find('.slick-prev').hide();
                    } else if($(this).find('.slick-slide').last().is('.slick-active')) {
                        $(this).find('.slick-next').hide();
                    }
                });";
            }
            ?>
            $('.brcs_slider_brands:not(".slick-slider")').slick({
                prevArrow:'<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                nextArrow:'<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                autoplay:<?php echo ( empty($options['slider_autoplay']) ? 'false' : 'true' ); ?>,
                autoplaySpeed:<?php echo ( empty($options['slider_autoplay_speed']) ? '5000' : $options['slider_autoplay_speed'] ); ?>,
                infinite:<?php echo ( empty($options['slider_infinite']) ? 'false' : 'true' ); ?>,
                arrows:<?php echo ( empty($options['slider_arrows']) ? 'false' : 'true' ); ?>,
                pauseOnFocus:<?php echo ( empty($options['slider_stop_focus']) ? 'false' : 'true' ); ?>,
            });
        });
    })(jQuery);
    </script>
    <?php
        wp_enqueue_script( 'berocket_slick_slider_js');
        wp_enqueue_style( 'berocket_slick_slider' );
        wp_enqueue_style( 'font-awesome');
        $slider_col = $per_row;
        $loop = new WP_Query( $args );
        if( empty($slider_col) ) {
            $slider_col = 3;
        }
        $slider_scroll = max(min( intval(empty($options['slider_slides_scroll']) ? $slider_col : $options['slider_slides_scroll'] ), intval($slider_col)), 1);
        echo '<div data-slick=\'{"slidesToShow":'.$slider_col.',"slidesToScroll":' . $slider_scroll . '}\' class="brcs_slider_brands br_brand_', $slider_rand, '">';
        foreach($terms as $term) {
            $brand_link = get_term_link( $term, 'berocket_brand' );
            if( is_wp_error($brand_link) ) {
                $error_string = $brand_link->get_error_message();
                echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
                $brand_link = '#error_link';
            }
            echo '<div class="br_widget_brand_element_slider">';
            if( $use_image ) {
                $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
                if( ! empty($image) ) {
                    echo '<div class="brand_slider_image"><a href="', $brand_link, '"><img src="', $image, '" alt="', $term->name, '"></a></div>';
                }
            }
            if( $use_name ) {
                echo '<a href="', $brand_link, '">', $term->name, '</a>';
            }
            echo '</div>';
        }
        echo '</div>';
        if( substr($border_color, 0, 1) != '#' ) {
            $border_color = '#'.$border_color;
        }
        echo '<style>.br_brand_', $slider_rand, ' .br_widget_brand_element_slider{
            padding:', $padding, ';
            box-sizing: border-box;
            ', ( ( ! empty ($border_color) && ! empty ($border_width) ) ? 'border: ' . $border_width . 'px solid ' . $border_color : '' ), '!important;
        }';
        if( ! empty($imgh) ) {
            echo '.br_brand_', $slider_rand, ' .br_widget_brand_element_slider .brand_slider_image{
                height: ', $imgh, 'px;
                line-height: ', $imgh, 'px;
            }';
            echo '.br_brand_', $slider_rand, ' .br_widget_brand_element_slider .brand_slider_image img{
                max-height: ', $imgh, 'px;
            }';
        }
        echo '</style>';
    } else {
        ob_start();
        foreach($terms as $term) {
            $brand_link = get_term_link( $term, 'berocket_brand' );
            if( is_wp_error($brand_link) ) {
                $error_string = $brand_link->get_error_message();
                echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
                $brand_link = '#error_link';
            }
            ob_start();
            if( $use_image ) {
                $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
                if( ! empty($image) ) {
                    echo '<a class="brand_image_link" href="', $brand_link, '"><img src="', $image, '" alt="', $term->name, '"', ( empty($imgh) ? '' : ' style="max-height:'.$imgh.'px;"' ), '></a>';
                }
            }
            if( $use_name ) {
                echo '<a href="', $brand_link, '">', $term->name, '</a>';
            }
            $brand_link_html = ob_get_clean();
            if( ! empty($brand_link_html) ) {
                echo '<div class="br_widget_brand_element" style="width:', ($width - 1), '%;float:left;margin-right: 1%;">';
                echo $brand_link_html;
                echo '</div>';
            }
        }
        $brands_list_html = ob_get_clean();
        if( ! empty($brands_list_html) ) {
            echo '<div class="br_brand_', $slider_rand, '">';
            echo $brands_list_html;
            echo '</div>';
            if( substr($border_color, 0, 1) != '#' ) {
                $border_color = '#'.$border_color;
            }
            echo '<style>.br_brand_', $slider_rand, ' .br_widget_brand_element{
                padding:', $padding, ';
                box-sizing: border-box;
                ', ( ( ! empty ($border_color) && ! empty ($border_width) ) ? 'border: ' . $border_width . 'px solid ' . $border_color : '' ), '!important;
            }
            .br_brand_', $slider_rand, ' .br_widget_brand_element:nth-child('.$per_row.'n + 1) {
                clear: left;
            }';
            if( ! empty($imgh) ) {
                echo '.br_brand_', $slider_rand, ' .brand_image_link{
                    display: inline-block;
                    height: ', $imgh, 'px;';
            }
            echo '</style>';
            echo '<div style="clear:both;"></div>';
        }
    }
}
?>
