<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       ibenic.com
 * @since      1.0.0
 *
 * @package    rpt_wc
 * @subpackage rpt_wc/admin/partials
 */

$rpt_name = isset( $rpt_name ) ? $rpt_name : 'rpt_wc';
$field_name_layout = isset( $field_name_layout ) ? $field_name_layout : 'rpt_new_layout';
$field_name_sale = isset( $field_name_sale ) ? $field_name_sale : 'rpt_apply_sale';

woocommerce_wp_checkbox(
	array(
		'id'      => $field_name_sale,
		'value'   => $apply_on_sale ? $apply_on_sale : 'no',
		'label'   => __( 'Change the Sale Price?', 'rpt_wc' ),
		'description'   => __( 'While the Product is on sale, the price change will change the sale price instead of regular', 'rpt_wc' ),
		'cbvalue' => 'yes',
	)
);

woocommerce_wp_checkbox(
	array(
		'id'      => $field_name_layout,
		'value'   => $use_new_layout ? $use_new_layout : 'no',
		'label'   => __( 'Show Countdown?', 'rpt_wc' ),
		'description'   => __( 'Use the countcount with showing new price', 'rpt_wc' ),
		'cbvalue' => 'yes',
	)
);
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wc-rpt-metabox">
	<table  class="wc-rpt-table" data-formname="<?php echo $rpt_name; ?>" cellspacing="0" cellpadding="0">

		<thead>
			<?php do_action( 'rpt_wc_table_th_start' ); ?>
			<th>
				<?php _e( 'Date', 'rpt-wc' ); ?>
			</th>
			<th>
				<?php _e( 'Time', 'rpt-wc' ); ?>
			</th>
			<th>
				<?php _e( 'Price Change', 'rpt-wc' );?> <?php echo ' (' . get_woocommerce_currency_symbol() . ')'; ?>
			</th>
			<?php do_action( 'rpt_wc_table_th_end' ); ?>
			<th class="rpt-delete-column"></th>
		</thead>
		<tbody>
			<?php 
			$count = 0;
			if( $rpt_prices ) {
				
				foreach ( $rpt_prices as $datetime => $prices ) {
					$datetime_arr = explode( ' ', $datetime );
					$date = $datetime_arr[0];
					$date_arr = explode( '-', $date );
					$date = implode( '-', array_reverse( $date_arr ) ); 
					$time = isset( $datetime_arr[1] ) ? substr( $datetime_arr[1], 0, -3 ) : '00:00';
					?>
					<tr>
						<?php do_action( 'rpt_wc_table_td_start', $count ); ?>
						<td class="rpt-date-column">
							<input name="<?php echo $rpt_name; ?>[<?php echo $count; ?>][date]" class="widefat rpt-datepicker" value="<?php echo $date; ?>">
						</td>
						<td class="rpt-time-column">
							<select name="<?php echo $rpt_name; ?>[<?php echo $count; ?>][time]" class="widefat">
								<?php 
									for ( $h = 0; $h < 24; $h++ ) {
										$hour = $h < 10 ? '0' . $h : $h;
										for ( $m = 0; $m < 60; $m += 15 ) {
											$minute = $m < 10 ? '0' . $m : $m;
											$time_value = $hour . ':' . $minute;
											echo '<option ' . selected( $time, $time_value, false ) . ' value="' . esc_attr( $time_value ) . '">' . esc_attr( $time_value ) . '</option>';
										}
									}
								?>
							</select>
						</td>
						<td class="rpt-price-column">
							<input name="<?php echo $rpt_name; ?>[<?php echo $count; ?>][price]" class="widefat" value="<?php echo $prices; ?>">
						</td>
						<?php do_action( 'rpt_wc_table_td_end', $count ); ?>
						<td class="rpt-delete-column" align="center">
							<button type="button" class="button button-default button-small rpt-delete">X</buton>
						</td>
					</tr>
					<?php
					$count++;
				}
			} else {
			?>
			<tr>
				<?php do_action( 'rpt_wc_table_td_start', 0 ); ?>
				<td class="rpt-date-column">
					<input name="<?php echo $rpt_name; ?>[0][date]" class="widefat rpt-datepicker">
				</td>
				<td class="rpt-time-column">
					<select name="<?php echo $rpt_name; ?>[0][time]" class="widefat">
						<?php 
							for ( $h = 0; $h < 24; $h++ ) {
								$hour = $h < 10 ? '0' . $h : $h;
								for ( $m = 0; $m < 60; $m += 15 ) {
									$minute = $m < 10 ? '0' . $m : $m;
									$time_value = $hour . ':' . $minute;
									echo '<option value="' . esc_attr( $time_value ) . '">' . esc_attr( $time_value ) . '</option>';
								}
							}
						?>
					</select>
				</td>
				<td class="rpt-price-column">
					<input name="<?php echo $rpt_name; ?>[0][price]" class="widefat">
				</td>
				<?php do_action( 'rpt_wc_table_td_end', 0 ); ?>
				<td class="rpt-delete-column" align="center">
					<button type="button" class="button button-default button-small rpt-delete">X</buton>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
 
	<button type="button" id="rpt_add_row" data-formname="<?php echo $rpt_name; ?>" class="button button-default rpt-add-row"><?php _e( 'Add Time Point', 'rpt-wc' ); ?></button>
    
</div>
