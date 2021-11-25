<?php
define( "BeRocket_product_brand_domain", 'brands-for-woocommerce'); 
define( "product_brand_TEMPLATE_PATH", plugin_dir_path( __FILE__ ) . "templates/" );
load_plugin_textdomain('brands-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
require_once(plugin_dir_path( __FILE__ ).'berocket/framework.php');
foreach (glob(__DIR__ . "/includes/*.php") as $filename)
{
    include_once($filename);
}

class BeRocket_product_brand extends BeRocket_Framework {
    public static $settings_name = 'br-product_brand-options';
    protected static $instance;
    protected $plugin_version_capability = 15;
    public $info, $defaults, $values;

    function __construct () {
        global $berocket_unique_value;
        $berocket_unique_value = 1;
        $this->info = array(
            'id'          => 19,
            'version'     => BeRocket_product_brand_version,
            'plugin'      => '',
            'slug'        => '',
            'key'         => '',
            'name'        => '',
            'plugin_name' => 'product_brand',
            'full_name'   => 'Brands for WooCommerce',
            'norm_name'   => 'Brands',
            'price'       => '24',
            'domain'      => 'brands-for-woocommerce',
            'templates'   => product_brand_TEMPLATE_PATH,
            'plugin_file' => BeRocket_product_brand_file,
            'plugin_dir'  => __DIR__,
        );

        $this->defaults = array(
            'display_thumbnail'             => '',
            'thumbnail_width'               => '100%',
            'thumbnail_align'               => 'none',
            'display_description'           => '',
            'slider_autoplay'               => '1',
            'slider_autoplay_speed'         => '5000',
            'slider_infinite'               => '1',
            'slider_arrows'                 => '1',
            'slider_slides_scroll'          => '1',
            'slider_stop_focus'             => '1',
            'custom_css'                    => '',
            'shop_display_brand'            => '',
            'shop_display_position'         => 'after_image',
            'shop_what_to_display_image'    => '',
            'shop_what_to_display_text'     => '',
            'shop_display_image_width'      => '40px',
            'shop_display_image_css'        => '',
            'shop_display_text_css'         => '',
            'product_display_brand'         => '',
            'product_display_position'      => 'after_image',
            'product_what_to_display_image' => '',
            'product_what_to_display_text'  => '',
            'product_display_image_width'   => '40px',
            'product_display_image_css'     => '',
            'product_display_text_css'      => '',
            'script'                        => array(
                'js_page_load'                  => '',
            ),
            'fontawesome_frontend_disable'    => '',
            'fontawesome_frontend_version'    => '',
        );

        $this->values = array(
            'settings_name' => 'br-product_brand-options',
            'option_page'   => 'br-product_brand',
            'premium_slug'  => 'woocommerce-brands',
            'free_slug'     => 'brands-for-woocommerce',
        );

        // List of the features missed in free version of the plugin
        $this->feature_list = array();
        $this->framework_data['fontawesome_frontend'] = true;

        $this->active_libraries = array('addons', 'popup');
        parent::__construct( $this );

        if ( $this->init_validation() ) {
            add_action ( 'init', array( $this, 'register_taxonomy' ) );
            $options = $this->get_option();
            $last_version = get_option('berocket_version_'.$this->info['plugin_name']);
            if( $last_version === FALSE ) $last_version = 0;
            if ( version_compare($last_version, $this->info['version'], '<') ) {
                $this->update_from_older ( $last_version );
            }
            add_action( "wp_ajax_br_product_brand_settings_save", array ( $this, 'save_settings' ) );
            add_action( "woocommerce_archive_description", array ( $this, 'description' ), 5 );
            add_action ( "widgets_init", array ( $this, 'widgets_init' ) );
            add_shortcode( 'brands_product_thumbnail', array( $this, 'shortcode_brands_product_thumbnail' ) );
            add_shortcode( 'brands_info', array( $this, 'shortcode_brands_info' ) );
            add_shortcode( 'product_brands_info', array( $this, 'shortcode_product_brands_info' ) );
            add_shortcode( 'brands_products', array( $this, 'products_shortcode' ) );
            add_shortcode( 'brands_list', array( $this, 'brands_list_shortcode' ) );
            add_shortcode( 'brands_by_name', array( $this, 'brands_by_name_shortcode' ) );
            add_filter( 'template_include', array( $this, 'template_loader' ) );
            add_action( 'current_screen', array( $this, 'register_permalink_option' ) );
            add_filter( 'berocket_filter_filter_type_array', array( $this, 'filter_type_array' ) );
            add_filter( 'BeRocket_updater_menu_order_sub_order', array($this, 'menu_order_sub_order') );
            //WC shortcode compatibility
            add_filter('shortcode_atts_products', array($this, 'wc_shortcode_atts'), 10, 3);
            add_filter('woocommerce_shortcode_products_query', array($this, 'wc_shortcode_query'), 10, 2);
        }
        add_filter('parent_file', array($this, 'select_menu'));
        add_filter('submenu_file', array($this, 'select_submenu'));
    }
    function init_validation() {
        return ( ( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) && 
            br_get_woocommerce_version() >= 2.1 );
    }
    public function update_from_older( $version ) {
        $options = $this->get_option();
        if ( version_compare($version, '3.0.1', '<') ) {
            $version_index = 1;
        } else {
            $version_index = 2;
        }

        if( $version_index == 1 && ! empty($options['product_thumbnail']) ) {
            $options['product_display_brand'] = '1';
            $options['product_display_position'] = 'after_title';
            $options['product_what_to_display_image'] = '1';
            $options['product_display_image_width'] = '35%';
        }
        update_option( $this->values['settings_name'], $options );
    }
    public function widgets_init() {
        register_widget("berocket_product_brand_widget");
        register_widget("berocket_product_brand_description_widget");
        register_widget("berocket_alphabet_brand_widget");
    }
    public function template_loader( $template ) {

		$find = array( 'woocommerce.php' );
		$file = '';

		if ( is_tax( 'berocket_brand' ) ) {

			$term = get_queried_object();

			$woocommerce_url = apply_filters( 'woocommerce_template_url', 'woocommerce/' );
            $file   = 'taxonomy-' . $term->taxonomy . '.php';
			$find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] = $woocommerce_url . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] = $file;
			$find[] = $woocommerce_url . $file;

		}

		if ( $file ) {
			$template = locate_template( $find );
			if ( ! $template ) $template = product_brand_TEMPLATE_PATH . $file;
		}

		return $template;
	}
    public function shortcode_brands_product_thumbnail($atts = array()) {
        ob_start();
        $this->description_post($atts);
        $return = ob_get_clean();
        return apply_filters('shortcode_brands_product_thumbnail_return', $return, $atts);
    }
    public function shortcode_brands_info( $atts = array()) {
        $default = array('type' => 'name,image,description', 'id' => false);
        if( ! empty($atts) && is_array($atts) ) {
            $atts = array_merge($default, $atts);
        } else {
            $atts = $default;
        }
        if( empty ($atts['type']) ) {
            return;
        }
        if($atts['type'] == 'all') {
            $atts['type'] = $default['type'];
        }
        $values = explode(',', $atts['type']);
        if( empty($values) || ! is_array($values) || count($values) == 0 ) {
            return;
        }
        if( empty($atts['id']) ) {
            if( ! is_tax('berocket_brand') ) {
                return;
            }
            if ( ! get_query_var( 'term' ) ) {
                return;
            }
            $term = get_term_by( 'slug', get_query_var( 'term' ), 'berocket_brand' );
        } else {
            $term = get_term_by( 'term_id', $atts['id'], 'berocket_brand' );
        }
        ob_start();
        do_action('brands_info_before', $term, $atts);
        $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
        foreach($values as $value) {
            if( $value == 'name' ) {
                echo '', $term->name, '';
            } elseif( $value == 'image' ) {
                echo '<img src="', $image, '" alt="', $term->name, '">';
            } elseif( $value == 'description' ) {
                echo '<div class="br_brand_description">', term_description($term), '</div>';
            }
        }
        do_action('brands_info_after', $term, $atts);
        $return = ob_get_clean();
        return apply_filters('shortcode_brands_info_return', $return, $term, $atts);
    }
    public function shortcode_product_brands_info($atts = array()) {
        $default = array('type' => 'name,image,description', 'product_id' => false);
        if( ! empty($atts) && is_array($atts) ) {
            $atts = array_merge($default, $atts);
        } else {
            $atts = $default;
        }
        if( empty ($atts['type']) ) {
            return;
        }
        if($atts['type'] == 'all') {
            $atts['type'] = $default['type'];
        }
        $values = explode(',', $atts['type']);
        if( empty($values) || ! is_array($values) || count($values) == 0 ) {
            return;
        }
        if( empty($atts['product_id']) ) {
            global $wp_query;
            $product_id = $wp_query->queried_object->ID;
        } else {
            $product_id = $atts['product_id'];
        }
        $terms = get_the_terms($product_id, 'berocket_brand' );
        if( $terms === false || is_wp_error($terms) ) {
            return;
        }
        $term = $terms[0];
        ob_start();
        do_action('product_brands_info_before', $term, $atts);
        $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
        foreach($values as $value) {
            if( $value == 'name' ) {
                echo '', $term->name, '';
            } elseif( $value == 'image' ) {
                echo '<img src="', $image, '" alt="', $term->name, '">';
            } elseif( $value == 'description' ) {
                echo '<div class="br_brand_description">', term_description($term), '</div>';
            }
        }
        do_action('product_brands_info_after', $term, $atts);
        $return = ob_get_clean();
        return apply_filters('shortcode_product_brands_info_return', $return, $term, $atts);
    }
    public function brands_by_name_shortcode($atts = array()) {
        set_query_var( 'alphabet_atts', @ $atts );
        ob_start();
        $this->br_get_template_part( 'alphabet' );
        $return = ob_get_clean();
        return apply_filters('brands_by_name_shortcode_return', $return, $atts);
    }
    public function brands_list_shortcode($atts = array()) {
        ob_start();
        the_widget( 'berocket_product_brand_widget', $atts);
        $return = ob_get_clean();
        return apply_filters('brands_list_shortcode_return', $return, $atts);
    }
    public function products_shortcode($atts = array()) {
        $atts = shortcode_atts( array(
			'columns'   => '4',
			'orderby'   => 'title',
			'order'     => 'desc',
			'brand_id'  => '',
			'brand_slug'=> '',
			'operator'  => 'IN',
            'per_page'  => '12'
		), $atts );

		if ( empty($atts['brand_id']) && empty($atts['brand_slug']) ) {
			return '';
		}

		// Default ordering args
		$ordering_args = WC()->query->get_catalog_ordering_args( $atts['orderby'], $atts['order'] );
		$meta_query    = WC()->query->get_meta_query();
        if( ! empty($atts['brand_id']) ) {
            $brand = $atts['brand_id'];
            $brand_field = 'id';
        } elseif( ! empty($atts['brand_slug']) ) {
            $brand = $atts['brand_slug'];
            $brand_field = 'slug';
        }
        if( empty($atts['per_page']) ) {
            unset($atts['per_page']);
        }
		$query_args    = array(
			'post_type'            => 'product',
			'post_status'          => 'publish',
			'orderby'              => $ordering_args['orderby'],
			'order'                => $ordering_args['order'],
			'posts_per_page'       => (empty($atts['per_page']) ? '12' : $atts['per_page']),
			'meta_query'           => $meta_query,
			'tax_query'            => array(
				array(
					'taxonomy'     => 'berocket_brand',
					'terms'        => explode( ',', $brand ),
					'field'        => $brand_field,
					'operator'     => $atts['operator']
				)
			)
		);

		if ( isset( $ordering_args['meta_key'] ) ) {
			$query_args['meta_key'] = $ordering_args['meta_key'];
		}

		$return = $this->product_loop( $query_args, $atts, 'product_cat' );

		// Remove ordering query arguments
		WC()->query->remove_ordering_args();

        return apply_filters('brands_products_shortcode_return', $return, $atts);
    }
	private function product_loop( $query_args, $atts, $loop_name ) {
		global $woocommerce_loop;

		$products                    = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts, $loop_name ) );
		$columns                     = absint( $atts['columns'] );
		$woocommerce_loop['columns'] = $columns;
		$woocommerce_loop['name']    = $loop_name;

		ob_start();
		if ( $products->have_posts() ) {
			?>

			<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

			<?php
		} else {
			do_action( "woocommerce_shortcode_{$loop_name}_loop_no_results" );
		}

		woocommerce_reset_loop();
		wp_reset_postdata();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
	}
    public function register_taxonomy () {
        $permalink_option = get_option( 'berocket_brands_permalink' );
        if( function_exists('wc_get_page_id') ) {
            $shop_page_id = wc_get_page_id( 'shop' );
        } else {
            $shop_page_id = woocommerce_get_page_id( 'shop' );
        }
		$base_slug = $shop_page_id > 0 && get_page( $shop_page_id ) ? get_page_uri( $shop_page_id ) : 'shop';
		$category_base = get_option('woocommerce_prepend_shop_page_to_urls') == "yes" ? trailingslashit( $base_slug ) : '';

		register_taxonomy( 'berocket_brand',
			array('product'),
			array(
				'hierarchical'          => true,
				'update_count_callback' => '_update_post_term_count',
				'label'                 => __( 'Brands', 'brands-for-woocommerce'),
				'labels'                => array(
                    'name'                  => __( 'Brands', 'brands-for-woocommerce' ),
                    'singular_name'         => __( 'Brand', 'brands-for-woocommerce' ),
                    'search_items'          => __( 'Search Brands', 'brands-for-woocommerce' ),
                    'all_items'             => __( 'All Brands', 'brands-for-woocommerce' ),
                    'parent_item'           => __( 'Parent Brand', 'brands-for-woocommerce' ),
                    'parent_item_colon'     => __( 'Parent Brand:', 'brands-for-woocommerce' ),
                    'edit_item'             => __( 'Edit Brand', 'brands-for-woocommerce' ),
                    'update_item'           => __( 'Update Brand', 'brands-for-woocommerce' ),
                    'add_new_item'          => __( 'Add New Brand', 'brands-for-woocommerce' ),
                    'new_item_name'         => __( 'New Brand Name', 'brands-for-woocommerce' )
				),
				'show_ui'               => true,
                'show_in_menu'          => true,
				'show_admin_column'     => true,
				'show_in_nav_menus'     => true,
				'show_in_quick_edit'    => true,
				'meta_box_cb'           => 'post_categories_meta_box',
				'capabilities'          => array(
					'manage_terms'          => 'manage_product_terms',
					'edit_terms'            => 'edit_product_terms',
					'delete_terms'          => 'delete_product_terms',
					'assign_terms'          => 'assign_product_terms'
				),

				'rewrite' => array( 
                    'slug' => $category_base . ( empty($permalink_option) ? __( 'brands', 'brands-for-woocommerce' ) : $permalink_option ), 
                    'with_front' => true, 
                    'hierarchical' => true 
                )
			)
		);
    }
    public function init () {
        global $woocommerce;

        add_filter( 'woocommerce_coupon_is_valid', array( $this, 'validate_coupon' ), 10, 3 );
        add_filter( 'woocommerce_coupon_get_discount_amount', array( $this, 'apply_discount' ), null, 5 );

        parent::init();

        $options = $this->get_option();
        // wp_enqueue_script("jquery");
        // wp_register_style( 'berocket_slick_slider', plugins_url( 'css/slick.css', __FILE__ ) );
        // wp_register_script( 'berocket_slick_slider_js', plugins_url( 'js/slick.min.js', __FILE__ ), array( 'jquery' ) );
        // wp_register_style( 'berocket_product_brand_style', 
        //     plugins_url( 'css/frontend.css', __FILE__ ), 
        //     "", 
        //     BeRocket_product_brand_version );
        // wp_enqueue_style( 'berocket_product_brand_style' );
    }
    function wc_get_product_brand_ids( $product_id ) {
        $product_brands = wc_get_product_term_ids( $product_id, 'berocket_brand' );

        foreach ( $product_brands as $product_cat ) {
            $product_brands = array_merge( $product_brands, get_ancestors( $product_cat, 'berocket_brand' ) );
        }

        return $product_brands;
    }
    function wc_get_brands_for_coupon( &$coupon ) {
		if ( ! isset( $coupon->in_brands ) && ! isset( $coupon->ex_brands ) ) {
            $in_brands = get_post_meta( $coupon->get_id(), 'berocket_brand', true );
            $ex_brands = get_post_meta( $coupon->get_id(), 'exclude_berocket_brand', true );
            $coupon->in_brands = $in_brands;
            $coupon->ex_brands = $ex_brands;
		} else {
            $in_brands = $coupon->in_brands;
            $ex_brands = $coupon->ex_brands;
        }
        return $coupon;
    }
    public function validate_coupon($valid, $coupon, $coupon_class) {
        if ( ! $valid ) return $valid;
        $valid = false;
        foreach ( $coupon_class->get_items_to_validate() as $item ) {
            if ( $coupon->get_exclude_sale_items() && $item->product && $item->product->is_on_sale() ) {
                continue;
            }
            if( $this->is_coupon_applied_to_product($item->product, $coupon) ) {
                $valid = true;
                break;
            }
        }
        return $valid;
    }
    public function apply_discount($discount, $amount, $cart_item, $single, $coupon) {
        if ( ! is_a( $coupon, 'WC_Coupon' ) || ! $coupon->is_type( array( 'fixed_product', 'percent' ) ) ) {
            return $discount;
        }
        if( $this->is_coupon_applied_to_product($cart_item['data'], $coupon) ) {
            return $discount;
        } else {
            return 0;
        }
    }
    function is_coupon_applied_to_product($product, $coupon) {
        $this->wc_get_brands_for_coupon($coupon);
        $is_in_brands = ! empty($coupon->in_brands) && is_array($coupon->in_brands) && count($coupon->in_brands) > 0;
        $is_ex_brands = ! empty($coupon->ex_brands) && is_array($coupon->ex_brands) && count($coupon->ex_brands) > 0;
        if ( ! $is_in_brands && ! $is_ex_brands ) {
            return true;
        }
        $product_brands = $this->wc_get_product_brand_ids( $product->get_id() );

        if ( $product->get_parent_id() ) {
            $product_brands = array_merge( $product_brands, $this->wc_get_product_brand_ids( $product->get_parent_id() ) );
        }
        if( ( $is_in_brands && count( array_intersect( $product_brands, $coupon->in_brands ) ) > 0) 
        || (! $is_in_brands && (! $is_ex_brands || count( array_intersect( $product_brands, $coupon->ex_brands ) ) == 0) ) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function adding styles/scripts and settings to admin_init WordPress action
     *
     * @access public
     *
     * @return void
     */
    public function admin_init () {
        parent::admin_init();
        wp_enqueue_script('berocket_widget-colorpicker');
        wp_enqueue_style('berocket_widget-colorpicker-style');
        wp_enqueue_script( 'berocket_product_brand_admin', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), BeRocket_product_brand_version );
        wp_register_style( 'berocket_product_brand_admin_style', plugins_url( 'css/admin.css', __FILE__ ), "", BeRocket_product_brand_version );
        wp_enqueue_style( 'berocket_product_brand_admin_style' );
		add_action( 'berocket_brand_add_form_fields', array( $this, 'add_field' ) );
		add_action( 'berocket_brand_edit_form_fields', array( $this, 'edit_field' ), 10, 2 );
		add_action( 'created_term', array( $this, 'field_save' ), 10, 3 );
		add_action( 'edit_term', array( $this, 'field_save' ), 10, 3 );
		add_filter( 'woocommerce_product_filters', array( $this, 'product_filter' ) );
		add_action( 'woocommerce_coupon_options_usage_restriction', array( $this, 'coupon_field' ) );
		add_action( 'woocommerce_coupon_options_save', array( $this, 'save_coupon' ) );
        add_filter( 'woocommerce_sortable_taxonomies', array($this, 'add_brands_to_sortable') );
        add_filter( 'woocommerce_screen_ids', array($this, 'woocommerce_screen_ids') );
    }
    public function add_brands_to_sortable($taxonomies) {
        $taxonomies[] = 'berocket_brand';
        return $taxonomies;
    }
    public function woocommerce_screen_ids($screens) {
        $screens[] = 'edit-berocket_brand';
        return $screens;
    }
    public function register_permalink_option() {
        $screen = get_current_screen();
        $default_values = '';
        if($screen->id == 'options-permalink') {
            $this->save_permalink_option();
            $this->_register_permalink_option();
        }
    }
    public function _register_permalink_option() {
        add_settings_section(
            'berocket_permalinks_brand',
            $this->info['norm_name'],
            array($this, 'permalink_input_section'),
            'permalink'
        );
    }
    function permalink_input_section() {
        set_query_var( 'norm_name', $this->info['norm_name'] );
        $this->br_get_template_part( 'permalink_option' );
    }
    public function save_permalink_option() {
        if ( isset( $_POST['berocket_brands_permalink'] ) ) {
            $option_values = $_POST['berocket_brands_permalink'];
            update_option( 'berocket_brands_permalink', $option_values );
        }
    }
    public function add_field () {
        echo '<table class="form-table">
		<tbody><tr class="form-field term-name-wrap">
			<th scope="row"><label for="name">', __( 'Thumbnail', 'brands-for-woocommerce' ), '</label></th>
			<td><div class="br_brands_image">', berocket_font_select_upload('', 'br_brand_options_ajax_load_icon', 'br_brand_image', '', false), '</div></td>
		</tr>
			</tbody></table>';
    }
    public function edit_field ( $term, $taxonomy ) {
        $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
        echo '
        <table class="form-table"><tbody>
            <tr class="form-field term-name-wrap">
                <th scope="row"><label for="name">', __( 'Thumbnail', 'brands-for-woocommerce' ), '</label></th>
                <td><div class="br_brands_image">', berocket_font_select_upload('', 'br_brand_options_ajax_load_icon', 'br_brand_image', @ $image, false), '</div></td>
            </tr>
        </tbody></table>';
    }
    public function field_save ( $term_id, $tt_id, $taxonomy ) {
        if ( isset( $_POST['br_brand_image'] ) ) {
			update_term_meta( $term_id, 'brand_image_url', $_POST['br_brand_image'] );
		}
    }
    public function description() {
        if( ! is_tax('berocket_brand') ) {
            return;
        }
		if ( ! get_query_var( 'berocket_brand' ) && ! get_query_var( 'term' ) ) {
			return;
        }
        $term_find = get_query_var( 'berocket_brand' );
        $term_find = ( empty($term_find) ? get_query_var( 'term' ) : $term_find );
        $term = get_term_by( 'slug', $term_find, 'berocket_brand' );
        if( empty($term) ) {
            return;
        }
        $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
        $options = $this->get_option();
        set_query_var( 'display_thumbnail', @ $options['display_thumbnail'] );
        set_query_var( 'width', @ $options['thumbnail_width'] );
        set_query_var( 'align', @ $options['thumbnail_align'] );
        set_query_var( 'display_description', @ $options['display_description'] );
        set_query_var( 'brand_term', @ $term );
        set_query_var( 'brand_image', @ $image );
        $this->br_get_template_part( 'description' );
        remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
        remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
    }
    public function description_post($atts = array()) {
        $atts = shortcode_atts( array(
			'post_id'   => '',
			'width'     => '35%',
			'height'    => '',
			'position'  => 'right',
            'image'     => '1',
			'url'       => '',
		), $atts );
        if( empty($atts['post_id']) ) {
            $atts['post_id'] = get_the_ID();
            if( empty($atts['post_id']) ) {
                return;
            }
        }
        $terms = get_the_terms($atts['post_id'], 'berocket_brand');
        if( empty($terms) ) {
            return;
        }
        if( ! empty($terms) && is_array($terms) ) {
            foreach($terms as $term) {
                $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
                if( ! empty($atts['url']) ) {
                    echo '<a href="'.get_term_link((int)$term->term_id).'">';
                }
                if( ! empty($image) && ! empty($atts['image']) ) {
                    echo '<img class="berocket_brand_post_image" src="', $image, '" alt="', $term->name, '" style="',
                    (empty($atts['width']) ? '' : 'width:'.$atts['width'].';'),
                    (empty($atts['height']) ? '' : 'height:'.$atts['height'].';'),
                    (empty($atts['position']) ? '' : 'float:'.$atts['position'].';'),
                    '">';
                } else {
                    echo '<span class="berocket_brand_post_image" style="display: block;', 
                    (empty($atts['width']) ? '' : 'width:'.$atts['width'].';'),
                    (empty($atts['height']) ? '' : 'height:'.$atts['height'].';'),
                    (empty($atts['position']) ? '' : 'float:'.$atts['position'].';'),
                    '">', @ $term->name, '</span>';
                }
                if( ! empty($atts['url']) ) {
                    echo '</a>';
                }
            }
        }
    }
	public function product_filter( $filters ) {
		global $wp_query;

		$current_product_brand = (! empty( $wp_query->query['berocket_brand'] ) ? $wp_query->query['berocket_brand'] : '');
		$terms = get_terms( 'berocket_brand' );

		if ( empty($terms) ) {
			return $filters;
		}
		$args                  = array(
			'pad_counts'         => 1,
			'show_count'         => 1,
			'hierarchical'       => 1,
			'hide_empty'         => 1,
			'show_uncategorized' => 1,
			'orderby'            => 'name',
			'selected'           => $current_product_brand,
			'menu_order'         => false
		);

		$filters = $filters . PHP_EOL;
		$filters .= "<select name='berocket_brand' class='dropdown_berocket_brand'>";
		$filters .= '<option value="" ' .  selected( $current_product_brand, '', false ) . '>' . __( 'Select a brand', 'brands-for-woocommerce' ) . '</option>';
		$filters .= wc_walk_category_dropdown_tree( $terms, 0, $args );
		$filters .= "</select>";

		return $filters;
	}
	public function coupon_field () {
		global $post;
        $categories   = get_terms( 'berocket_brand', 'orderby=name&hide_empty=0' );
		?>
        <div class="options_group">
		<p class="form-field">
            <label for="berocket_brand"><?php _e( 'Product brands', 'brands-for-woocommerce' ); ?></label>
            <select id="berocked_brand" name="berocket_brand[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php _e( 'Any brand', 'brands-for-woocommerce' ); ?>">
                <?php
                    $category_ids = (array) get_post_meta( $post->ID, 'berocket_brand', true );
                    if ( $categories && is_array($categories) ) foreach ( $categories as $cat ) {
                        echo '<option value="' . esc_attr( $cat->term_id ) . '"' . selected( in_array( $cat->term_id, $category_ids ), true, false ) . '>' . esc_html( $cat->name ) . '</option>';
                    }
                ?>
            </select>
            <?php 
            if( function_exists('wc_help_tip') ) {
                echo wc_help_tip( __( 'Products with these brands will be discounted', 'brands-for-woocommerce' ) );
            } ?>
        </p>
		<p class="form-field">
            <label for="exclude_berocket_brand"><?php _e( 'Exclude brands', 'brands-for-woocommerce' ); ?></label>
            <select id="exclude_berocked_brand" name="exclude_berocket_brand[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php _e( 'No brands', 'brands-for-woocommerce' ); ?>">
                <?php
                    $category_ids = (array) get_post_meta( $post->ID, 'exclude_berocket_brand', true );

                    if ( $categories && is_array($categories) ) foreach ( $categories as $cat ) {
                        echo '<option value="' . esc_attr( $cat->term_id ) . '"' . selected( in_array( $cat->term_id, $category_ids ), true, false ) . '>' . esc_html( $cat->name ) . '</option>';
                    }
                ?>
            </select>
            <?php 
            if( function_exists('wc_help_tip') ) {
                echo wc_help_tip( __( 'Products with these brands will not be discounted', 'brands-for-woocommerce' ) );
            } ?>
        </p>
        </div>
		<?php
	}
    public function save_coupon($post_id) {
		$berocket_brand         = empty( $_POST['berocket_brand'] ) ? array() : $_POST['berocket_brand'];
		$exclude_berocket_brand = empty( $_POST['exclude_berocket_brand'] ) ? array() : $_POST['exclude_berocket_brand'];

		// Save
		update_post_meta( $post_id, 'berocket_brand', $berocket_brand );
		update_post_meta( $post_id, 'exclude_berocket_brand', $exclude_berocket_brand );
    }
    public function admin_menu() {
        if( parent::admin_menu() ) {
            add_submenu_page(
                'woocommerce',
                __( $this->info[ 'norm_name' ] . ' settings', $this->info[ 'domain' ] ),
                __( $this->info[ 'norm_name' ], $this->info[ 'domain' ] ),
                'manage_options',
                $this->values[ 'option_page' ],
                array(
                    $this,
                    'option_form'
                )
            );
        }
    }
    public function admin_settings( $tabs_info = array(), $data = array() ) {
        parent::admin_settings(
            array(
                'General' => array(
                    'icon' => 'cog',
                ),
                'Slider' => array(
                    'icon' => 'arrows-h',
                ),
                'CSS'     => array(
                    'icon' => 'css3',
                ),
                'Addons' => array(
                    'icon'  => 'cog'
                ),
                'License' => array(
                    'icon' => 'unlock-alt',
                    'link' => admin_url( 'admin.php?page=berocket_account' )
                ),
            ),
            array(
            'General' => array(
                'display_thumbnail' => array(
                    "type"     => "checkbox",
                    "label"    => __('Display thumnail on brand page', 'brands-for-woocommerce'),
                    "name"     => "display_thumbnail",
                    "value"    => "1",
                ),
                'thumbnail_width' => array(
                    "type"     => "text",
                    "label"    => __('Thumbnail width', 'brands-for-woocommerce'),
                    "name"     => "thumbnail_width",
                    "value"    => "",
                ),
                'thumbnail_align' => array(
                    "type"     => "selectbox",
                    "label"    => __('Thumbnail align', 'brands-for-woocommerce'),
                    "name"     => "thumbnail_align",
                    "value"    => "",
                    "options"  => array(
                        array("value" => "none", "text" => __( 'none', 'brands-for-woocommerce' )),
                        array("value" => "left", "text" => __( 'Left', 'brands-for-woocommerce' )),
                        array("value" => "right", "text" => __( 'Right', 'brands-for-woocommerce' )),
                    )
                ),
                'display_description' => array(
                    "type"     => "checkbox",
                    "label"    => __('Display description on brand page', 'brands-for-woocommerce'),
                    "name"     => "display_description",
                    "value"    => "1",
                ),
                'shortcodes_explanation' => array(
                    "section"  => "shortcodes_explanation",
                ),
            ),
            'Slider' => array(
                'slider_autoplay' => array(
                    "type"     => "checkbox",
                    "label"    => __('Autoplay', 'brands-for-woocommerce'),
                    "name"     => "slider_autoplay",
                    "value"    => "1",
                ),
                'slider_autoplay_speed' => array(
                    "type"     => "number",
                    "label"    => __('Autoplay Speed', 'brands-for-woocommerce'),
                    "name"     => "slider_autoplay_speed",
                    "value"    => "",
                ),
                'slider_infinite' => array(
                    "type"     => "checkbox",
                    "label"    => __('Infinite', 'brands-for-woocommerce'),
                    "name"     => "slider_infinite",
                    "value"    => "1",
                ),
                'slider_arrows' => array(
                    "type"     => "checkbox",
                    "label"    => __('Display Arrows', 'brands-for-woocommerce'),
                    "name"     => "slider_arrows",
                    "value"    => "1",
                ),
                'slider_slides_scroll' => array(
                    "type"     => "number",
                    "label"    => __('Brands to Scroll', 'brands-for-woocommerce'),
                    "name"     => "slider_slides_scroll",
                    "value"    => "",
                ),
                'slider_stop_focus' => array(
                    "type"     => "checkbox",
                    "label"    => __('Stop Autoscroll on Focus', 'brands-for-woocommerce'),
                    "name"     => "slider_stop_focus",
                    "value"    => "1",
                ),
            ),
            'CSS'     => array(
                'global_font_awesome_disable' => array(
                    "label"     => __( 'Disable Font Awesome', "brands-for-woocommerce" ),
                    "type"      => "checkbox",
                    "name"      => "fontawesome_frontend_disable",
                    "value"     => '1',
                    'label_for' => __('Don\'t loading css file for Font Awesome on site front end. Use it only if you doesn\'t uses Font Awesome icons in widgets or you have Font Awesome in your theme.', 'brands-for-woocommerce'),
                ),
                'global_fontawesome_version' => array(
                    "label"    => __( 'Font Awesome Version', "brands-for-woocommerce" ),
                    "name"     => "fontawesome_frontend_version",
                    "type"     => "selectbox",
                    "options"  => array(
                        array('value' => '', 'text' => __('Font Awesome 4', 'brands-for-woocommerce')),
                        array('value' => 'fontawesome5', 'text' => __('Font Awesome 5', 'brands-for-woocommerce')),
                    ),
                    "value"    => '',
                    "label_for" => __('Version of Font Awesome that will be used on front end. Please select version that you have in your theme', 'brands-for-woocommerce'),
                ),
                array(
                    "type"  => "textarea",
                    "label" => __('Custom CSS', 'brands-for-woocommerce'),
                    "name"  => "custom_css",
                ),
            ),
            'Addons'     => array(
                array(
                    "label" => '',
                    'section' => 'addons'
                ),
            ),
        ) );
    }
    public function section_shortcodes_explanation() {
        $html = '<th scope="row">' . __('Shortcodes', 'brands-for-woocommerce') . '</th>
            <td>
                <ul class="br_shortcode_info">
                    <li>
                        <strong>[brands_list]</strong> - '.__("list of brands", 'brands-for-woocommerce').'
                        <ul>
                            <li><i>title</i> - '.__("title text before brand list", 'brands-for-woocommerce').'</li>
                            <li><i>use_image</i> - '.__("display brand image(1 or 0)", 'brands-for-woocommerce').'</li>
                            <li><i>use_name</i> - '.__("display brand name(1 or 0)", 'brands-for-woocommerce').'</li>
                            <li><i>per_row</i> - '.__("Count of columns for brands list(count of brand per slider)", 'brands-for-woocommerce').'</li>
                            <li><i>hide_empty</i> - '.__("Hide brands without products(1 or 0)", 'brands-for-woocommerce').'</li>
                            <li><i>count</i> - '.__("maximum number of brand", 'brands-for-woocommerce').'</li>
                            <li><i>slider</i> - '.__("is this slider with brands(1 or 0)", 'brands-for-woocommerce').'</li>
                            <li><i>padding</i> - '.__("padding around image and name(Default: 3px)", 'brands-for-woocommerce').'</li>
                            <li><i>border_color</i> - '.__("border color in HEX(#FFFFFF - white, #000000 - black)", 'brands-for-woocommerce').'</li>
                            <li><i>border_width</i> - '.__("border width in pixels", 'brands-for-woocommerce').'</li>
                            <li><i>orderby</i> - '.__("sort brands", 'brands-for-woocommerce').'
                                <ul>
                                    <li><i>name</i> - '.__("Order by brand name", 'brands-for-woocommerce').'</li>
                                    <li><i>count</i> - '.__("Order by brand product count", 'brands-for-woocommerce').'</li>
                                    <li><i>slug</i> - '.__("Order by brand slug", 'brands-for-woocommerce').'</li>
                                    <li><i>description</i> - '.__("Order by brand description", 'brands-for-woocommerce').'</li>
                                </ul>
                            </li>
                            <li><i>order</i> - '.__("ascending(asc) or descending(desc) order", 'brands-for-woocommerce').'</li>
                            <li><i>imgh</i> - '.__("brand image height, number(Default: 64)", 'brands-for-woocommerce').'</li>
                            <li><i>include</i> - '.__("brand ids list that will be displayed(Example: [brands_list include='45,47,52,61'])", 'brands-for-woocommerce').'</li>
                            <li><i>exclude</i> - '.__("brand ids list that will be excluded(Example: [brands_list exclude='45,47,52,61'])", 'brands-for-woocommerce').'</li>
                        </ul>
                    </li>
                    <li>
                        <strong>[brands_by_name]</strong> - '.__("brands list by name", 'brands-for-woocommerce').'
                        <ul>
                            <li>image - '.__("display brand image", 'brands-for-woocommerce').'</li>
                            <li>text - '.__("display brand name", 'brands-for-woocommerce').'</li>
                            <li>style - '.__('"vertical" or "horizontal" position of elements', 'brands-for-woocommerce').'</li>
                            <li>position - '.__("image and name position for brand", 'brands-for-woocommerce').'
                                <ul>
                                    <li>1 - '.__("Name after image", 'brands-for-woocommerce').'</li>
                                    <li>2 - '.__("Name before image", 'brands-for-woocommerce').'</li>
                                    <li>3 - '.__("Name under image", 'brands-for-woocommerce').'</li>
                                    <li>4 - '.__("Show only on letter click", 'brands-for-woocommerce').'</li>
                                </ul>
                            </li>
                            <li>column - '.__("Count of columns for brands list", 'brands-for-woocommerce').'</li>
                            <li>imgw - '.__("image width(Default: 64px)", 'brands-for-woocommerce').'</li>
                            <li>imgh - '.__("image height", 'brands-for-woocommerce').'</li>
                            <li>hide_empty - '.__("remove brands without products(1 - remove, 0 - leave)", 'brands-for-woocommerce').'</li>
                        </ul>
                    </li>
                    <li>
                        <strong>[brands_products]</strong> - '.__("product list by brand id", 'brands-for-woocommerce').'
                        <ul>
                            <li><i>brand_id</i> - '.__("brand ID(s). One or more brand ID(Example: 12,34,35)", 'brands-for-woocommerce').'</li>
                            <li><i>brand_slug</i> - '.__("brand slug(s). One or more brand slug name(Example: brand1,brand2,brand3)", 'brands-for-woocommerce').'</li>
                            <li>'.__("Use only one option brand_id or brand_slug", 'brands-for-woocommerce').'</li>
                            <li><i>columns</i> - '.__("count of columns for product list. Can doesn\'t work with some theme or plugin", 'brands-for-woocommerce').'</li>
                            <li><i>orderby</i> - '.__("order products by this field(title, name, date, modified)", 'brands-for-woocommerce').'
                                <ul>
                                    <li><i>title</i> - '.__("Order by title", 'brands-for-woocommerce').'</li>
                                    <li><i>name</i> - '.__("Order by post name (post slug)", 'brands-for-woocommerce').'</li>
                                    <li><i>date</i> - '.__("Order by date", 'brands-for-woocommerce').'</li>
                                    <li><i>modified</i> - '.__("Order by last modified date", 'brands-for-woocommerce').'</li>
                                    <li><i>rand</i> - '.__("Random order", 'brands-for-woocommerce').'</li>
                                </ul>
                            </li>
                            <li><i>order</i> - '.__("ascending(asc) or descending(desc) order", 'brands-for-woocommerce').'</li>
                        </ul>
                    </li>
                    <li>
                        <strong>[brands_info]</strong> - '.__("brand information", 'brands-for-woocommerce').'
                        <ul>
                            <li>id - '.__("brand ID(optionaly)", 'brands-for-woocommerce').'</li>
                            <li>type - '.__("type of information(name, image or description)", 'brands-for-woocommerce').'</li>
                        </ul>
                    </li>
                    <li>
                        <strong>[brands_product_thumbnail]</strong> - '.__("brand image for product page", 'brands-for-woocommerce').'
                        <ul>
                            <li>post_id - '.__("product id(optionaly)", 'brands-for-woocommerce').'</li>
                            <li>width - '.__("image width(Default: 35%)", 'brands-for-woocommerce').'</li>
                            <li>height - '.__("image height(optionaly)", 'brands-for-woocommerce').'</li>
                            <li>position - '.__("float style for element(Default: right)", 'brands-for-woocommerce').'</li>
                            <li>image - '.__("display image if brand has it: 1 or 0(Default: 1)", 'brands-for-woocommerce').'</li>
                            <li>url - '.__("display it as link: 1 or 0(Default: 0)", 'brands-for-woocommerce').'</li>
                        </ul>
                    </li>
                    <li>
                        <strong>[product_brands_info]</strong> - '.__("single brand info for single product", 'brands-for-woocommerce').'
                        <ul>
                            <li><i>product_id</i> - '.__("product ID. On single product page can get it automatically", 'brands-for-woocommerce').'</li>
                            <li><i>type</i> - '.__("data to display(name, image, description)", 'brands-for-woocommerce').'
                                <ul>
                                    <li><i>name</i> - '.__("Brand name", 'brands-for-woocommerce').'</li>
                                    <li><i>image</i> - '.__("Brand image", 'brands-for-woocommerce').'</li>
                                    <li><i>description</i> - '.__("Brand description", 'brands-for-woocommerce').'</li>
                                </ul>
                            </li>
                        </ul>
                </ul>
            </td>';
        return $html;
    }
    public function filter_type_array($filter_type_array) {
        $filter_type_array['berocket_brand'] = array(
            'name' => __('Brands', 'brands-for-woocommerce'),
            'sameas' => 'custom_taxonomy',
            'attribute' => 'berocket_brand',
        );
        return $filter_type_array;
    }
    public function menu_order_sub_order($new_sub_order) {
        $new_sub_order[ 'br-product_brand' ][] = array(
            "<span class='berocket_admin_menu_custom_post_submenu'>" . __( 'All Brands', 'brands-for-woocommerce' ) . "</span>",
            'edit_posts',
            'edit-tags.php?taxonomy=berocket_brand&post_type=product&menu=berocket_account',
            'Brands',
        );
        return $new_sub_order;
    }
    function select_menu($file) {
        global $plugin_page, $submenu_file;
        if( $submenu_file == htmlentities('edit-tags.php?taxonomy=berocket_brand&post_type=product') ) {
            $plugin_page = 'berocket_account';
        }
        return $file;
    }
    function select_submenu($submenu_file) {
        if( $submenu_file == htmlentities('edit-tags.php?taxonomy=berocket_brand&post_type=product') ) {
            return 'edit-tags.php?taxonomy=berocket_brand&post_type=product&menu=berocket_account';
        }
        return $submenu_file;
    }
    function activation() {
        parent::activation();
        $this->register_taxonomy();
        flush_rewrite_rules();
    }
    function wc_shortcode_atts($out, $pairs, $atts) {
        if( ! empty($atts['brand']) ) {
            $out['brand'] = $atts['brand'];
        }
        return $out;
    }
    function wc_shortcode_query($query_args, $atts = array()) {
        if ( ! empty( $atts['brand'] ) ) {
			$taxonomy = 'berocket_brand';
			$terms    = array_map( 'sanitize_title', explode( ',', $atts['brand'] ) );
			$field    = 'slug';

			if ( $terms && is_numeric( $terms[0] ) ) {
				$field = 'term_id';
				$terms = array_map( 'absint', $terms );
				// Check numeric slugs.
				foreach ( $terms as $term ) {
					$the_term = get_term_by( 'slug', $term, $taxonomy );
					if ( false !== $the_term ) {
						$terms[] = $the_term->term_id;
					}
				}
			}

			if( ! empty($terms) ) {
                $query_args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'terms'    => $terms,
                    'field'    => $field,
                    'operator' => $atts['terms_operator'],
                );
            }
		}
        return $query_args;
    }
}

new BeRocket_product_brand;

