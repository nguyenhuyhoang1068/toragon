<?php
/**
 * JS Template to be used for adding new rows.
 */
?>
<script type="text/html" id="tmpl-rpt_table_row_template">
		
    <tr>
        <?php do_action( 'rpt_wc_table_td_template_start' ); ?>
        <td class="rpt-date-column">
            <input name="{{data.name}}[{{data.length}}][date]" class="widefat rpt-datepicker">
        </td>
        <td class="rpt-time-column">
                <select name="{{data.name}}[{{data.length}}][time]" class="widefat">
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
            <input name="{{data.name}}[{{data.length}}][price]" class="widefat">
        </td>
        <?php do_action( 'rpt_wc_table_td_template_end' ); ?>
        <td class="rpt-delete-column" align="center">
            <button type="button" class="button button-default button-small rpt-delete">X</buton>
        </td>
    </tr>
</script>