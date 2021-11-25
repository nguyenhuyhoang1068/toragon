<?php
/**
 * Exit if accessed directly
 *
 * @since      1.0.0
 * @package    points-and-rewards-for-wooCommerce
 * @subpackage points-and-rewards-for-wooCommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="mwb_wpr_table mwb_wpr_overview-wrapper">
	<div class="mwb_wpr_overview_content">
		<h3 class="mwb_wpr_overview_heading"><?php esc_html_e( 'Guide config Point For WooCommerce', 'points-and-rewards-for-woocommerce' ); ?></h3>		
	</div>
	<div class="mwb_wpr_video_wrapper">
    <h2><?php esc_html_e( 'Tích điểm và sử dụng điểm thưởng.', 'points-and-rewards-for-woocommerce' ); ?></h2>
		<ol>
      <li><?php esc_html_e( 'Quy định số tiền chuyển đổi từ giá trị đơn hàng. VD:100.000 đ = 1 điểm.', 'points-and-rewards-for-woocommerce' ); ?></li>
      <li><?php esc_html_e( 'Quy định điểm chuyển đổi thành tiền, cho phep trừ trực tiếp vào giá trị đơn hàng tiếp theo: VD: 1 điểm = 1.000 đ', 'points-and-rewards-for-woocommerce' ); ?></li>
      <li><?php esc_html_e( 'Bắt đầu tính điểm tích lũy khi tổng thanh toán cộng dồn từ 10 triệu đồng.', 'points-and-rewards-for-woocommerce' ); ?></li>
    </ol> 
    <h2><?php esc_html_e( 'Earn points and use points', 'points-and-rewards-for-woocommerce' ); ?></h2>  
    <ol>
      <li><?php esc_html_e( 'Specify the amount to convert from the order value : 100,000 VND = 1 point', 'points-and-rewards-for-woocommerce' ); ?></li>
      <li><?php esc_html_e( 'Set points to convert to money, to deduct directly from the value of the next order: 1 point = 1,000 VND', 'points-and-rewards-for-woocommerce' ); ?></li>
      <li><?php esc_html_e( 'Start calculating accumulated points when total payments accrue from 10 million dong', 'points-and-rewards-for-woocommerce' ); ?></li>
    </ol>  
	</div>
</div>
