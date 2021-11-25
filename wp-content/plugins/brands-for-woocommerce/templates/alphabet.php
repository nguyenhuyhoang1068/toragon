<?php
$args = array(
    'hide_empty'    => true,
    'orderby'       => 'name',
    'order'         => 'ASC'
);
$atts = shortcode_atts( array(
			'image'     => '',
            'text'      => true,
            'style'     => 'vertical',
            'position'  => '1',
            'column'    => '2',
            'imgw'      => '',
            'imgh'      => '64px',
            'hide_empty'=> true
		), $alphabet_atts );
$args['hide_empty'] = ! empty($atts['hide_empty']);
$args['orderby']    = (empty($atts['orderby']) ? $args['orderby'] : $atts['orderby']);
$args['order']      = (empty($atts['order']) ? $args['order'] : $atts['order']);

$terms = get_terms( 'berocket_brand', $args );
$alphabet = array();
if( !empty($terms) && is_array($terms) && count($terms) > 0 ) {
    $terms_sort = wp_list_pluck($terms, 'name');
    $terms_sort2 = array_keys($terms);
    foreach($terms_sort as &$term_sort) {
        $term_sort = strtoupper(substr($term_sort,0,1));
    }
    array_multisort($terms_sort, SORT_ASC, SORT_STRING, $terms_sort2, $terms);
    ob_start();
    global $berocket_unique_value;
    $berocket_unique_value++;
    $random_class = $berocket_unique_value;
    $random_class = 'berocket_letter_block_'.$random_class;
    echo '<div class="berocket_letter_blocks ', $random_class, '">';
    $additional_class = ' '.$atts['style'] . ' pos_' . $atts['position'].' ';
    $closed = true;
    foreach($terms as $term) {
        $letter = mb_substr($term->name, 0, 1);
        $letter = mb_strtoupper($letter);
        if( ! in_array($letter, $alphabet) ) {
            if( count($alphabet) != 0 ) {
                echo '<div class="br_after_letter', $additional_class, '"></div></div>';
                do_action("brands_letter_after_brands", $letter, $atts, $random_class);
            }
            $alphabet[] = $letter;
            do_action("brands_letter_before_brands", $letter, $atts, $random_class);
            echo '<div id="', $random_class, '_', $letter, '" class="br_brand_letter_block ', $additional_class, '">';
            $closed = false;
            echo '<h3>', $letter, '</h3>';
        }
        echo '<div class="br_brand_letter_element ', $additional_class, '">
            <a href="', get_term_link( $term->slug, 'berocket_brand' ), '">';
        $img_html = '';
        if( ! empty($atts['image']) ) {
            $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
            if( ! empty($image) ) {
                $img_html = '<img src="' . $image . '" alt="' . $term->name . '" style="' . ( empty($atts['imgw']) ? '' : 'width:'.$atts['imgw'].';' ) . ( empty($atts['imgh']) ? '' : 'height:'.$atts['imgh'].';' ) . '">';
            }
        }
        $text_html = '';
        if( ! empty($atts['text']) ) {
            $text_html = '<span>' . $term->name . '</span>';
        }
        if( $atts['position'] == 2 ) {
            echo $text_html, $img_html;
        } else {
            echo $img_html, $text_html;
        }
        echo '</a>
        <div class="br_after_letter ', $additional_class, '"></div></div>';
    }
    if( ! $closed ) {
        echo '</div>';
    }
    echo '</div>';
    do_action("brands_letter_after_brands", $letter, $atts, $random_class);
    $width = 100 / $atts['column'];
    echo '<style>
    .', $random_class, ' .br_brand_letter_block.horizontal {
        width: ', $width,'%;
        float: left;
    }
    .', $random_class, ' .br_brand_letter_element.vertical {
        width: ', $width,'%;
        float: left;
    }
    .', $random_class, ' .br_brand_letter_block.horizontal:nth-child(', $atts['column'], 'n + 1) {
        clear: both;
    }
    </style>';
    echo "<script>
        jQuery(document).on('click', '.berocket_brand_name_letters.pos_4 a', function(event) {
            event.preventDefault();
            if( jQuery(this).attr('href') == '#all' ) {
                jQuery('.br_brand_letter_block.pos_4').show();
            } else {
                jQuery('.br_brand_letter_block.pos_4').hide();
                jQuery(jQuery(this).attr('href')+'.br_brand_letter_block.pos_4').show();
            }
        }); 
    </script>";
    $brands_by_name = ob_get_clean();
    echo '<div class="berocket_brand_name_letters', $additional_class, '">';
    if( $atts['position'] == 4 ) {
        echo '<a href="#all" class="button">', __('All', 'brands-for-woocommerce'), '</a>';
    }
    foreach($alphabet as $letter) {
        echo '<a href="#', $random_class, '_', $letter, '" class="button">', $letter, '</a>';
    }
    echo '</div>';
    echo $brands_by_name;
    echo '<div style="clear:both;"></div>';
}
?>
