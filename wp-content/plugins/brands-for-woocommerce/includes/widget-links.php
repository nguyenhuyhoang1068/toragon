<?php
class BeRocket_product_brand_Widget extends WP_Widget 
{
    public static $defaults = array(
        'title'         => '',
        'use_image'     => '1',
        'use_name'      => '',
        'per_row'       => '3',
        'hide_empty'    => '1',
        'count'         => '',
        'orderby'       => 'name',
        'order'         => 'asc',
        'slider'        => '',
        'padding'       => '3px',
        'border_color'  => '',
        'border_width'  => '',
        'imgh'          => '64',
        'include'       => '',
        'exclude'       => '',
    );
	public function __construct() {
        parent::__construct("berocket_product_brand_widget", "WooCommerce Product Brands",
            array("description" => ""));
    }
    /**
     * WordPress widget
     */
    public function widget($args, $instance)
    {
        $instance = wp_parse_args( (array) $instance, self::$defaults );
        $instance['title'] = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
        $BeRocket_product_brand = BeRocket_product_brand::getInstance();
        $options = $BeRocket_product_brand->get_option();
        $instance['args'] = $args;
        set_query_var( 'brbrands_atts', $instance );
        ob_start();
        $BeRocket_product_brand->br_get_template_part( 'widget' );
        $content = ob_get_clean();
        if( $content ) {
            echo $args['before_widget'];
            echo $content;
            echo $args['after_widget'];
        }
	}
    /**
     * Update widget settings
     */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['use_image'] = ! empty( $new_instance['use_image'] );
		$instance['use_name'] = ! empty( $new_instance['use_name'] );
		$instance['hide_empty'] = ! empty( $new_instance['hide_empty'] );
		$instance['per_row'] = strip_tags( $new_instance['per_row'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );
		$instance['slider'] = ! empty( $new_instance['slider'] );
		$instance['padding'] = strip_tags( $new_instance['padding'] );
		$instance['border_color'] = strip_tags( $new_instance['border_color'] );
		$instance['border_width'] = strip_tags( $new_instance['border_width'] );
		$instance['imgh'] = strip_tags( $new_instance['imgh'] );
		return $instance;
	}
    /**
     * Widget settings form
     */
	public function form($instance)
	{
        $instance = wp_parse_args( (array) $instance, self::$defaults );
		$title = strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
        <p>
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('use_image'); ?>"<?php if(@ $instance['use_image']) echo ' checked'; ?>><?php _e( 'Display image', 'brands-for-woocommerce' ); ?></label>
        </p>
        <p>
            <label><?php _e( 'Maximum image height', 'brands-for-woocommerce' ); ?></label>
            <input type="number" value="<?php echo $instance['imgh']; ?>" name="<?php echo $this->get_field_name('imgh'); ?>">
        </p>
        <p>
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('use_name'); ?>"<?php if(@ $instance['use_name']) echo ' checked'; ?>><?php _e( 'Display name', 'brands-for-woocommerce' ); ?></label>
        </p>
        <p>
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('hide_empty'); ?>"<?php if(@ $instance['hide_empty']) echo ' checked'; ?>><?php _e( 'Hide empty', 'brands-for-woocommerce' ); ?></label>
        </p>
        <p>
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('slider'); ?>"<?php if(@ $instance['slider']) echo ' checked'; ?>><?php _e( 'Slider', 'brands-for-woocommerce' ); ?></label>
        </p>
        <div class="br_brandw_js">
        <p>
            <label><?php _e( 'Brands per row', 'brands-for-woocommerce' ); ?></label>
            <input class="br_brandw_perrow" type="number" value="<?php echo $instance['per_row']; ?>" name="<?php echo $this->get_field_name('per_row'); ?>">
        </p>
        <p>
            <label><?php _e( 'Number of brands', 'brands-for-woocommerce' ); ?></label>
            <input class="br_brandw_count" placeholder="<?php _e( 'All brands', 'brands-for-woocommerce' ); ?>" type="number" value="<?php echo $instance['count']; ?>" name="<?php echo $this->get_field_name('count'); ?>">
        </p>
        </div>
        <p>
            <label><?php _e( 'Order brands by', 'brands-for-woocommerce' ); ?></label>
            <select name="<?php echo $this->get_field_name('orderby'); ?>">
                <?php
                $orderby = array(
                    'name' => __( 'Brand name', 'brands-for-woocommerce' ),
                    'count' => __( 'Count of products', 'brands-for-woocommerce' ),
                );
                foreach($orderby as $orderby_id => $ordeby_name) {
                    echo '<option value="', $orderby_id, '"', ($orderby_id == $instance['orderby'] ? 'selected' : ''), '>', $ordeby_name, '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <label><?php _e( 'Padding around brands', 'brands-for-woocommerce' ); ?></label>
            <input type="text" value="<?php echo $instance['padding']; ?>" name="<?php echo $this->get_field_name('padding'); ?>">
        </p>
        <div class="br_brand_widget_color">
            <div class="brand_label"><?php _e( 'Border color', 'brands-for-woocommerce' ); ?></div>
            <div class="colorpicker_field_brand" data-color="<?php echo ( @ $instance['border_color'] ) ? $instance['border_color'] : '000000' ?>"></div>
            <input class="br_border_color_set" type="hidden" value="<?php echo ( @ $instance['border_color'] ) ? $instance['border_color'] : '' ?>" name="<?php echo $this->get_field_name('border_color'); ?>" />
            <input type="button" value="<?php _e('Default', 'brands-for-woocommerce') ?>" class="theme_default button">
        </div>
        <p>
            <label><?php _e( 'Border width', 'brands-for-woocommerce' ); ?></label>
            <input type="number" value="<?php echo $instance['border_width']; ?>" name="<?php echo $this->get_field_name('border_width'); ?>">
        </p>
        <script>
        jQuery(document).ready(function() {
            brand_widget_init();
        });
        </script>
		<?php
	}
}
?>
