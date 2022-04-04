<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Create the admin page under wp-admin -> WooCommerce -> Woo PFP
 *
 * @author   thuytranthanhbd
 * @since    1.0
 *
 */
class WooPfp_Admin_Page
{

  /**
   * @var string The message to display after saving settings
   */
  var $message = '';

  /**
   * WooPfp_Admin_Page constructor.
   */
  public function __construct()
  {
    // Catch and run the save_settings() action
    if (isset($_REQUEST['woopfp_nonce']) && isset($_REQUEST['action']) && 'woopfp_save_settings' == $_REQUEST['action']) {
      $this->save_settings();
    }

    add_action('admin_menu', array($this, 'register_submenu_page'));
  }

  /**
   * Save settings for the plugin
   */
  public function save_settings()
  {
    if (wp_verify_nonce($_REQUEST['woopfp_nonce'], 'woopfp_save_settings')) {
      update_option('woo-pfp', $_REQUEST['settings']);

      $this->message =
        '<div class="updated notice"><p><strong>' .
        __('Settings saved', 'woo-pfp') .
        '</p></strong></div>';
    } else {

      $this->message =
        '<div class="error notice"><p><strong>' .
        __('Can not save settings! Please refresh this page.', 'woo-pfp') .
        '</p></strong></div>';
    }
  }

  /**
   * Register the sub-menu under "WooCommerce"
   * Link: http://my-site.com/wp-admin/admin.php?page=woo-pfp
   */
  public function register_submenu_page()
  {
    add_submenu_page(
      'woocommerce',
      __('PFP Settings', 'pfp'),
      'Stripe setting',
      'manage_options',
      'woo-pfp',
      array($this, 'admin_page_html')
    );
  }

  /**
   * Generate the HTML code of the settings page
   */
  public function admin_page_html()
  {
    // check user capabilities
    if (!current_user_can('manage_options')) {
      return;
    }

    $settings = PfpViet::get_settings();

?>
    <div class="wrap">
      <h1><?= esc_html(get_admin_page_title()); ?></h1>
      <form name="woocommerce_pfp_for_vietnam" method="post" novalidate>
        <?php echo $this->message ?>
        <input type="hidden" id="action" name="action" value="woopfp_save_settings">
        <input type="hidden" id="woopfp_nonce" name="woopfp_nonce" value="<?php echo wp_create_nonce('woopfp_save_settings') ?>">
        <table class="form-table">
          <tbody>   
            <tr style="display: none;">
              <th scope="row"><?php printf(__('Support VND for <a href="%s">the PayPal Standard gateway</a>', 'woo-pfp'), 'https://docs.woocommerce.com/document/paypal-standard/') ?></th>
              <td>
                <input name="settings[vnd_paypal_standard][enabled]" type="hidden" value="no">
                <input name="settings[vnd_paypal_standard][enabled]" type="checkbox" id="vnd_paypal_standard" value="yes" <?php if ('yes' == $settings['vnd_paypal_standard']['enabled'])
                                                                                                                            echo 'checked="checked"' ?>>
                <label for="vnd_paypal_standard"><?php _e('Enabled', 'woo-pfp') ?></label>

                <fieldset><br />
                  <select name="settings[vnd_paypal_standard][currency]" id="vnd_paypal_standard_currency">
                    <?php
                    $paypal_supported_currencies = array(
                      'AUD',
                      'BRL',
                      'CAD',
                      'MXN',
                      'NZD',
                      'HKD',
                      'SGD',
                      'USD',
                      'EUR',
                      'JPY',
                      'TRY',
                      'NOK',
                      'CZK',
                      'DKK',
                      'HUF',
                      'ILS',
                      'MYR',
                      'PHP',
                      'PLN',
                      'SEK',
                      'CHF',
                      'TWD',
                      'THB',
                      'GBP',
                      'RMB',
                      'RUB'
                    );
                    foreach ($paypal_supported_currencies as $currency) {

                      if (strtoupper($currency) == $settings['vnd_paypal_standard']['currency']) {
                        printf('<option selected="selected" value="%1$s">%1$s</option>', $currency);
                      } else {
                        printf('<option value="%1$s">%1$s</option>', $currency);
                      }
                    }
                    ?>
                  </select>
                  <label for="vnd_paypal_standard_currency"><?php _e('Select a PayPal supported currency (like USD, EUR, etc), which is used to convert VND prices', 'woo-pfp') ?></label>
                  <br />
                  <br />

                  <input name="settings[vnd_paypal_standard][rate]" type="number" step="1" min="100" id="vnd_paypal_standard_rate" style="width: 70px; padding-right: 0;" value="<?php echo $settings['vnd_paypal_standard']['rate'] ?>" <label for="vnd_paypal_standard_rate"><?php _e('Insert the exchange rate of this currency to VND', 'woo-pfp') ?></label>
                </fieldset>

              </td>
            </tr>
            <tr style="display: none;">
              <th scope="row"><?php printf(__('Support VND for <a href="%s">the PayPal Express Checkout gateway</a>', 'woo-pfp'), 'https://docs.woocommerce.com/document/paypal-express-checkout/') ?></th>
              <td>
                <input name="settings[vnd_paypal_express_checkout][enabled]" type="hidden" value="no">
                <input name="settings[vnd_paypal_express_checkout][enabled]" type="checkbox" id="vnd_paypal_express_checkout" value="yes" <?php if ('yes' == $settings['vnd_paypal_express_checkout']['enabled'])
                                                                                                                                            echo 'checked="checked"' ?>>
                <label for="vnd_paypal_express_checkout"><?php _e('Enabled', 'woo-pfp') ?></label>

                <fieldset><br />
                  <select name="settings[vnd_paypal_express_checkout][currency]" id="vnd_paypal_express_checkout_currency">
                    <?php
                    foreach ($paypal_supported_currencies as $currency) {

                      if (strtoupper($currency) == $settings['vnd_paypal_express_checkout']['currency']) {
                        printf('<option selected="selected" value="%1$s">%1$s</option>', $currency);
                      } else {
                        printf('<option value="%1$s">%1$s</option>', $currency);
                      }
                    }
                    ?>
                  </select>
                  <label for="vnd_paypal_express_checkout_currency"><?php _e('Select a PayPal supported currency (like USD, EUR, etc), which is used to convert VND prices', 'woo-pfp') ?></label>
                  <br />
                  <br />
                  <input name="settings[vnd_paypal_express_checkout][rate]" type="number" step="1" min="100" id="vnd_paypal_express_checkout_rate" style="width: 70px; padding-right: 0;" value="<?php echo $settings['vnd_paypal_express_checkout']['rate'] ?>" <label for="vnd_paypal_express_checkout_rate"><?php _e('Insert the exchange rate of this currency to VND', 'woo-pfp') ?></label>
                </fieldset>
              </td>
            </tr>

    

            <tr>
              <th scope="row"><?php printf(__('Stripe Fees', 'woo-pfp')) ?></th>
              <td>
                <input name="settings[vnd_stripe_fees][enabled]" type="hidden" value="no">
                <input name="settings[vnd_stripe_fees][enabled]" type="checkbox" id="vnd_stripe_fees" value="yes" <?php if ('yes' == $settings['vnd_stripe_fees']['enabled']) echo 'checked="checked"' ?>>
                <label for="vnd_stripe_fees"><?php _e('Enabled', 'woo-pfp') ?></label>
                <fieldset>  
                  <input name="settings[vnd_stripe_fees][rate]" type="number" step="0.034" id="vnd_stripe_fees" style="width: 70px; padding-right: 0;" value="<?php echo $settings['vnd_stripe_fees']['rate']; ?>" ><label for="vnd_stripe_fees"><?php _e('Stripe Fee percent e.g 0.034', 'woo-pfp') ?></label> <br/>
                  <input name="settings[vnd_stripe_fees][fixedfee]" type="number" step="0.011" id="vnd_stripe_fees_fixedfee" style="width: 70px; padding-right: 0;" value="<?php echo $settings['vnd_stripe_fees']['fixedfee']; ?>" ><label for="vnd_stripe_fees_fixedfee"><?php _e('Stripe Fix Fee USD e.g US$0.6', 'woo-pfp') ?></label> <br/>
                  <input name="settings[vnd_stripe_fees][paypalfixedfee]" type="number" step="1" min="5000" max="20000" id="vnd_stripe_fees_paypalfixedfee" style="width: 70px; padding-right: 0;" value="<?php echo $settings['vnd_stripe_fees']['paypalfixedfee']; ?>" ><label for="vnd_stripe_fees_paypalfixedfee"><?php _e('Stripe Fix Fee VND e.g 10000', 'woo-pfp') ?></label>
                </fieldset>
              </td>
            </tr>
          </tbody>
        </table>
        <p class="submit">
          <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
      </form>      
    </div>
    <!-- #wrap ->
        <?php
      }
    }
