<?php
class BeRocket_alphabet_brand_Widget extends WP_Widget 
{
    public static $defaults = array(
        'image'     => '',
        'text'      => true,
        'style'     => 'vertical',
        'position'  => '1',
        'column'    => '2',
        'imgw'      => '',
        'imgh'      => '64px',
    );
	public function __construct() {
        parent::__construct("berocket_alphabet_brand_widget", "WooCommerce Brands By Name",
            array("description" => ""));
    }
    /**
     * WordPress widget
     */
    public function widget($args, $instance)
    {
        $instance = wp_parse_args( (array) $instance, self::$defaults );
        $BeRocket_product_brand = BeRocket_product_brand::getInstance();
        $options = $BeRocket_product_brand->get_option();
        set_query_var( 'alphabet_atts', $instance );
        set_query_var( 'args', $args );
        ob_start();
        $BeRocket_product_brand->br_get_template_part( 'alphabet' );
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
		$instance['image'] = strip_tags( $new_instance['image'] );
		$instance['text'] = strip_tags( $new_instance['text'] );
		$instance['column'] = strip_tags( $new_instance['column'] );
		$instance['imgh'] = strip_tags( $new_instance['imgh'] );
		$instance['imgw'] = strip_tags( $new_instance['imgw'] );
		$instance['position'] = strip_tags( $new_instance['position'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
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
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('image'); ?>"<?php if(@ $instance['image']) echo ' checked'; ?>><?php _e( 'Display image', 'brands-for-woocommerce' ); ?></label>
        </p>
        <p>
            <label><?php _e( 'Maximum image height', 'brands-for-woocommerce' ); ?></label>
            <input type="text" value="<?php echo $instance['imgh']; ?>" name="<?php echo $this->get_field_name('imgh'); ?>">
        </p>
        <p>
            <label><?php _e( 'Maximum image width', 'brands-for-woocommerce' ); ?></label>
            <input type="text" value="<?php echo $instance['imgw']; ?>" name="<?php echo $this->get_field_name('imgw'); ?>">
        </p>
        <p>
            <label><input type="checkbox" value="1" name="<?php echo $this->get_field_name('text'); ?>"<?php if(@ $instance['text']) echo ' checked'; ?>><?php _e( 'Display name', 'brands-for-woocommerce' ); ?></label>
        </p>
        <p>
            <label><?php _e( 'Columns', 'brands-for-woocommerce' ); ?></label>
            <input type="number" value="<?php echo $instance['column']; ?>" name="<?php echo $this->get_field_name('column'); ?>">
        </p>
        <p>
            <label><?php _e( 'Position', 'brands-for-woocommerce' ); ?></label>
            <select name="<?php echo $this->get_field_name('position'); ?>">
                <?php
                $orderby = array(
                    '1' => __( 'Name after image', 'brands-for-woocommerce' ),
                    '2' => __( 'Name before image', 'brands-for-woocommerce' ),
                    '3' => __( 'Name under image', 'brands-for-woocommerce' ),
                    '4' => __( 'Show only on letter click', 'brands-for-woocommerce' ),
                );
                foreach($orderby as $orderby_id => $ordeby_name) {
                    echo '<option value="', $orderby_id, '"', ($orderby_id == $instance['position'] ? 'selected' : ''), '>', $ordeby_name, '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <label><?php _e( 'Style', 'brands-for-woocommerce' ); ?></label>
            <select name="<?php echo $this->get_field_name('style'); ?>">
                <?php
                $orderby = array(
                    'vertical' => __( 'Vertical', 'brands-for-woocommerce' ),
                    'horizontal' => __( 'Horizontal', 'brands-for-woocommerce' ),
                );
                foreach($orderby as $orderby_id => $ordeby_name) {
                    echo '<option value="', $orderby_id, '"', ($orderby_id == $instance['style'] ? 'selected' : ''), '>', $ordeby_name, '</option>';
                }
                ?>
            </select>
        </p>
		<?php
	}
}
?>
