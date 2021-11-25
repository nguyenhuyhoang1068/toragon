<?php
class BeRocket_product_brand_description_Widget extends WP_Widget 
{
    public static $defaults = array(
        'display_title'         => '',
        'display_thumbnail'     => '1',
        'display_description'   => '1',
        'width'                 => '100%',
        'align'                 => 'none',
    );
	public function __construct() {
        parent::__construct("berocket_product_brand_description_widget", "WooCommerce Product Brands Description",
            array("description" => ""));
    }
    /**
     * WordPress widget
     */
    public function widget($args, $instance)
    {
        $instance['display_title'] = apply_filters( 'widget_title', empty($instance['display_title']) ? '' : $instance['display_title'], $instance );
        if ( ! is_tax( 'berocket_brand' ) ) {
			return;
        }
		if ( ! get_query_var( 'term' ) ) {
			return;
        }
        $instance = wp_parse_args( (array) $instance, self::$defaults );
        $term = get_term_by( 'slug', get_query_var( 'term' ), 'berocket_brand' );
        $image 	= get_term_meta( $term->term_id, 'brand_image_url', true );
        set_query_var( 'display_thumbnail', @ $instance['display_thumbnail'] );
        set_query_var( 'display_description', @ $instance['display_description'] );
        set_query_var( 'width', @ $instance['width'] );
        set_query_var( 'align', @ $instance['align'] );
        set_query_var( 'brand_term', @ $term );
        set_query_var( 'brand_image', @ $image );
        ob_start();
        $BeRocket_product_brand = BeRocket_product_brand::getInstance();
        $BeRocket_product_brand->br_get_template_part( 'description' );
        $content = ob_get_clean();
        if( $content ) {
            echo $args['before_widget'];
            if( @ $instance['display_title'] ) {
                echo $args['before_title'].$term->name.$args['after_title'];
            }
            echo $content;
            echo $args['after_widget'];
        }
	}
    /**
     * Update widget settings
     */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['display_title'] = strip_tags( $new_instance['display_title'] );
		$instance['display_thumbnail'] = strip_tags( $new_instance['display_thumbnail'] );
		$instance['display_description'] = strip_tags( $new_instance['display_description'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['align'] = strip_tags( $new_instance['align'] );
		return $instance;
	}
    /**
     * Widget settings form
     */
	public function form($instance)
	{
        $instance = wp_parse_args( (array) $instance, self::$defaults );
		?>
        <p>
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('display_title'); ?>"<?php if(@ $instance['display_title']) echo ' checked'; ?>><?php _e( 'Display title', 'brands-for-woocommerce' ); ?></label>
        </p>
        <p>
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('display_thumbnail'); ?>"<?php if(@ $instance['display_thumbnail']) echo ' checked'; ?>><?php _e( 'Display thumbnails', 'brands-for-woocommerce' ); ?></label>
        </p>
        <p>
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('display_description'); ?>"<?php if(@ $instance['display_description']) echo ' checked'; ?>><?php _e( 'Display description', 'brands-for-woocommerce' ); ?></label>
        </p>
        <p>
            <label><?php _e( 'Image width', 'brands-for-woocommerce' ); ?></label>
            <input type="text" value="<?php echo $instance['width']; ?>" name="<?php echo $this->get_field_name('width'); ?>">
        </p>
        <p>
            <label><?php _e( 'Image align', 'brands-for-woocommerce' ); ?></label>
            <select name="<?php echo $this->get_field_name('align'); ?>">
                <?php
                $align = array(
                    'none' => __( 'none', 'brands-for-woocommerce' ),
                    'left' => __( 'Left', 'brands-for-woocommerce' ),
                    'right' => __( 'Right', 'brands-for-woocommerce' ),
                );
                foreach($align as $align_id => $align_name) {
                    echo '<option value="', $align_id, '"', ($align_id == $instance['align'] ? 'selected' : ''), '>', $align_name, '</option>';
                }
                ?>
            </select>
        </p>
		<?php
	}
}
?>
