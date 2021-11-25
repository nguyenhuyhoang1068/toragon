<?php
class BeRocket_brands_show_brands_class {
    function __construct() {
        $this->brand_icon_display();
        add_filter('brfr_tabs_info_product_brand', array($this, 'brfr_tabs_info'));
        add_filter('brfr_data_product_brand', array($this, 'brfr_data'));
    }
    public function brfr_tabs_info($tabs_info) {
        $tabs_info = berocket_insert_to_array($tabs_info, 'Slider', array(
            'Shop Page' => array(
                'icon' => 'cubes',
            ),
            'Product Page' => array(
                'icon' => 'cube',
            ),
        ));
        return $tabs_info;
    }
    public function brfr_data($data) {
        $data = berocket_insert_to_array($data, 'Slider', array(
            'Shop Page' => array(
                'shop_display_brand' => array(
                    "type"     => "checkbox",
                    "label"    => __('Display Brand', 'brands-for-woocommerce'),
                    "class"    => "shop_display_brand",
                    "name"     => "shop_display_brand",
                    "value"    => "1",
                ),
                'shop_display_position' => array(
                    "type"     => "selectbox",
                    "label"    => __('Brand Position', 'brands-for-woocommerce'),
                    "name"     => "shop_display_position",
                    "tr_class" => "shop_display_brand_enabled",
                    "value"    => "",
                    "options"  => array(
                        array("value" => "before_all", "text" => __( 'Before all', 'brands-for-woocommerce' )),
                        array("value" => "after_image", "text" => __( 'After Image', 'brands-for-woocommerce' )),
                        array("value" => "after_title", "text" => __( 'After Title', 'brands-for-woocommerce' )),
                        array("value" => "after_price", "text" => __( 'After Price', 'brands-for-woocommerce' )),
                        array("value" => "after_add_to_cart", "text" => __( 'After Add to cart button', 'brands-for-woocommerce' )),
                    )
                ),
                'shop_what_to_display' => array(
                    'label' => __('What to display', 'brands-for-woocommerce'),
                    "tr_class" => "shop_display_brand_enabled",
                    'items' => array(
                        'shop_what_to_display_image' => array(
                            "type"     => "checkbox",
                            "label_for"=> __('Image', 'brands-for-woocommerce'),
                            "name"     => "shop_what_to_display_image",
                            "value"    => "1",
                        ),
                        'shop_what_to_display_text' => array(
                            "type"     => "checkbox",
                            "label_for"=> __('Name', 'brands-for-woocommerce'),
                            "name"     => "shop_what_to_display_text",
                            "value"    => "1",
                        ),
                    ),
                ),
                'shop_display_as_link' => array(
                    "type"     => "checkbox",
                    "label"    => __('Display As Link', 'brands-for-woocommerce'),
                    "tr_class" => "shop_display_brand_enabled",
                    "name"     => "shop_display_as_link",
                    "value"    => "1",
                ),
                'shop_display_image_width' => array(
                    "type"     => "text",
                    "label"    => __('Image width', 'brands-for-woocommerce'),
                    "tr_class" => "shop_display_brand_enabled",
                    "name"     => "shop_display_image_width",
                    "value"    => "",
                ),
                'shop_display_image_css' => array(
                    "type"     => "textarea",
                    "tr_class" => "shop_display_brand_enabled",
                    "label"    => __('Image custom CSS', 'brands-for-woocommerce'),
                    "name"     => "shop_display_image_css",
                    "value"    => "",
                ),
                'shop_display_text_css' => array(
                    "type"     => "textarea",
                    "tr_class" => "shop_display_brand_enabled",
                    "label"    => __('Name custom CSS', 'brands-for-woocommerce'),
                    "name"     => "shop_display_text_css",
                    "value"    => "",
                ),
            ),
            'Product Page' => array(
                'product_display_brand' => array(
                    "type"     => "checkbox",
                    "class"    => "product_display_brand",
                    "label"    => __('Display Brand', 'brands-for-woocommerce'),
                    "name"     => "product_display_brand",
                    "value"    => "1",
                ),
                'product_display_position' => array(
                    "type"     => "selectbox",
                    "tr_class" => "product_display_brand_enabled",
                    "label"    => __('Brand Position', 'brands-for-woocommerce'),
                    "name"     => "product_display_position",
                    "value"    => "",
                    "options"  => array(
                        array("value" => "before_all", "text" => __( 'Before all', 'brands-for-woocommerce' )),
                        array("value" => "after_image", "text" => __( 'After Image', 'brands-for-woocommerce' )),
                        array("value" => "after_title", "text" => __( 'After Title', 'brands-for-woocommerce' )),
                        array("value" => "after_price", "text" => __( 'After Price', 'brands-for-woocommerce' )),
                        array("value" => "after_add_to_cart", "text" => __( 'After Add to cart button', 'brands-for-woocommerce' )),
                    )
                ),
                'product_what_to_display' => array(
                    'label' => __('What to display', 'brands-for-woocommerce'),
                    "tr_class" => "product_display_brand_enabled",
                    'items' => array(
                        'product_what_to_display_image' => array(
                            "type"     => "checkbox",
                            "label_for"=> __('Image', 'brands-for-woocommerce'),
                            "name"     => "product_what_to_display_image",
                            "value"    => "1",
                        ),
                        'product_what_to_display_text' => array(
                            "type"     => "checkbox",
                            "label_for"=> __('Text', 'brands-for-woocommerce'),
                            "name"     => "product_what_to_display_text",
                            "value"    => "1",
                        ),
                    ),
                ),
                'product_display_as_link' => array(
                    "type"     => "checkbox",
                    "label"    => __('Display As Link', 'brands-for-woocommerce'),
                    "tr_class" => "product_display_brand_enabled",
                    "name"     => "product_display_as_link",
                    "value"    => "1",
                ),
                'product_display_image_width' => array(
                    "type"     => "text",
                    "label"    => __('Image width', 'brands-for-woocommerce'),
                    "tr_class" => "product_display_brand_enabled",
                    "name"     => "product_display_image_width",
                    "value"    => "",
                ),
                'product_display_image_css' => array(
                    "type"     => "textarea",
                    "label"    => __('Image custom CSS', 'brands-for-woocommerce'),
                    "tr_class" => "product_display_brand_enabled",
                    "name"     => "product_display_image_css",
                    "value"    => "",
                ),
                'product_display_text_css' => array(
                    "type"     => "textarea",
                    "label"    => __('Name custom CSS', 'brands-for-woocommerce'),
                    "tr_class" => "product_display_brand_enabled",
                    "name"     => "product_display_text_css",
                    "value"    => "",
                ),
            ),
        ));
        return $data;
    }
    public function brand_icon_display($action = 'add_action') {
        $options = $this->get_option();
        $hooks = array();
        if( ! empty($options['shop_display_brand']) ) {
            $hooks['display_shop_post_brands'] = array(
                'hooks' => array(),
            );
            switch($options['shop_display_position']) {
                case 'before_all':
                    $hooks['display_shop_post_brands']['hooks']['woocommerce_before_shop_loop_item'] = 5;
                    $hooks['display_shop_post_brands']['hooks']['lgv_advanced_before'] = 38;
                    break;
                case 'after_image': 
                    $hooks['display_shop_post_brands']['hooks']['woocommerce_before_shop_loop_item_title'] = 20;
                    $hooks['display_shop_post_brands']['hooks']['lgv_advanced_after_img'] = 38;
                    break;
                case 'after_title': 
                    $hooks['display_shop_post_brands']['hooks']['woocommerce_shop_loop_item_title'] = 38;
                    $hooks['display_shop_post_brands']['hooks']['lgv_advanced_before_description'] = 38;
                    break;
                case 'after_price': 
                    $hooks['display_shop_post_brands']['hooks']['woocommerce_after_shop_loop_item_title'] = 38;
                    $hooks['display_shop_post_brands']['hooks']['lgv_advanced_after_price'] = 38;
                    break;
                case 'after_add_to_cart': 
                    $hooks['display_shop_post_brands']['hooks']['woocommerce_after_shop_loop_item'] = 38;
                    $hooks['display_shop_post_brands']['hooks']['lgv_advanced_after_price'] = 38;
                    break;
            }
        }
        if( ! empty($options['product_display_brand']) ) {
            $hooks['display_product_post_brands'] = array(
                'hooks' => array(),
            );
            switch($options['product_display_position']) {
                case 'before_all':
                    $hooks['display_product_post_brands']['hooks']['woocommerce_before_single_product'] = 10;
                    break;
                case 'after_image': 
                    $hooks['display_product_post_brands']['hooks']['woocommerce_before_single_product_summary'] = 30;
                    break;
                case 'after_title': 
                    $hooks['display_product_post_brands']['hooks']['woocommerce_single_product_summary'] = 7;
                    break;
                case 'after_price': 
                    $hooks['display_product_post_brands']['hooks']['woocommerce_single_product_summary'] = 15;
                    break;
                case 'after_add_to_cart': 
                    $hooks['display_product_post_brands']['hooks']['woocommerce_single_product_summary'] = 33;
                    break;
            }
        }
        if( ! empty($options['product_display_brand']) ) {
            
        }
        foreach($hooks as $function => $hook_data) {
            foreach($hook_data['hooks'] as $hook => $hook_priority) {
                $action( $hook, array( $this, $function ), $hook_priority );
            }
        }
    }
    public function display_shop_post_brands() {
        $options = $this->get_option();
        $post_id = get_the_ID();
        $terms = get_the_terms($post_id, 'berocket_brand');
        if( empty($terms) ) {
            return;
        }
        if( ! empty($terms) && is_array($terms) ) {
            foreach($terms as $term) {
                $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
                $html = '';
                if( ! empty($options['shop_what_to_display_image']) && ! empty($image) ) {
                    $html .= '<img class="berocket_brand_post_image" src="' . $image . '" alt="' . $term->name . '" style="display:inline-block;' .
                    (empty($options['shop_display_image_width']) ? '' : 'width:'.$options['shop_display_image_width'].';') .
                    $options['shop_display_image_css'] . '">';
                }
                if( ! empty($options['shop_what_to_display_text']) ) {
                    $html .= '<span class="berocket_brand_post_image" style="' . $options['shop_display_text_css'] . '">' . $term->name . '</span>';
                }
                if( ! empty($options['shop_display_as_link']) ) {
                    $term_link = get_term_link($term);
                    $html = '<a href="' . $term_link . '">' . $html . '</a>';
                }
                echo $html;
            }
        }
    }
    public function display_product_post_brands() {
        $options = $this->get_option();
        $post_id = get_the_ID();
        $terms = get_the_terms($post_id, 'berocket_brand');
        if( empty($terms) ) {
            return;
        }
        if( ! empty($terms) && is_array($terms) ) {
            foreach($terms as $term) {
                $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
                $html = '';
                if( ! empty($options['product_what_to_display_image']) && ! empty($image) ) {
                    $html .= '<img class="berocket_brand_post_image" src="' . $image . '" alt="' . $term->name . '" style="display:inline-block;' .
                    (empty($options['product_display_image_width']) ? '' : 'width:' . $options['product_display_image_width'] . ';') .
                    $options['product_display_image_css'] . '">';
                }
                if( ! empty($options['product_what_to_display_text']) ) {
                    $html .= '<span class="berocket_brand_post_image" style="' . $options['product_display_text_css'] . '">' . $term->name . '</span>';
                }
                if( ! empty($options['product_display_as_link']) ) {
                    $term_link = get_term_link($term);
                    $html = '<a href="' . $term_link . '">' . $html . '</a>';
                }
                echo $html;
            }
        }
    }
    public function get_option() {
        $BeRocket_product_brand = BeRocket_product_brand::getInstance();
        return $BeRocket_product_brand->get_option();
    }
}
new BeRocket_brands_show_brands_class(); 
