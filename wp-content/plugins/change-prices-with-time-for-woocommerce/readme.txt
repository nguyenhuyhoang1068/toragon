=== Change Prices with Time for WooCommerce ===
Contributors: ibenic, freemius
Tags: woocommerce, prices, time, countdown
Requires at least: 4.0
Tested up to: 5.9.3
Stable tag: 1.8.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Change Prices on Products with defined Times in the future. Build scarcity so your customers won't be able to resist.

== Description ==

Create a Fear of Missing out (FOMO) with your WooCommerce products and start getting more sales by providing a nice countdown to when your prices change.

With this plugin you can set different set of times when the prices of the product will change. For each defined date, the product price will change into the price that you've defined.

**WooCommerce 3.0 is requested. It won't work on version below 3.0.**

This plugin will directly change the **Regular Price** of your product, it won't save the regular price since it will be changed directly. This is done so that you may also delete all the sales points but retain the last price change of your product.

There will be a countdown displayed below the product summary. This countdown will then build up scarcity so that your customers can't resist into buying your product.

**Perfect when launching your next WooCommerce product or membership!**

Create your launch and define the early bird price. Then create different time points and the price that will then become available.
In case you use the new layout with prices, your visitors will see to which price it will increase.

Since it works with the product regular prices (or sale prices), you can use it with:
- WooCommerce Simple Product
- WooCommerce Variable Products (Premium)
- WooCommerce Subscription Products (Simple ones)
- WooCommerce Memberships

Features:

 - Define Time points that will change the Simple Product Regular Price
 - Countdown on the front page to build scarcity
 - Automatic restart of the countdown if there are more than 1 time point. Hiding it otherwise.
 - Shortcode [rpt_wc_countdown id={PRODUCT_ID}]

Premium Features:

 - Variations can have timed price points as well
 - Timed Incremental on Simple Product. Example Scenario: Increase price every hour from today until a maximum price has been met.

*If you want to change prices with each or several sales (instead of time), I have another plugin for you so be sure to check my plugins on my page. Click on my profile at the bottom of this page.*

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress 

== Frequently Asked Questions ==

= Will the original price remain? =

No. We make changes directly on the product regular price. This will ensure that your product is on the correct price even if you deactive this plugin or delete sales points by accident.

= When will the regular price be updated? =

Regular price will be updated only if the number of sales gets to a defined amount. Sales are not counted if the order has not been marked as **completed**.

== Screenshots ==

1. Product Countdown
2. Defining Time Points
3. New Layout

== Changelog ==

= 1.8.2 - 2022-04-17 =
* Fix: Security Fix

= 1.8.1 - 2021-10-01 =
* Fix: Fixing critical error in settings page
* Update: Freemius library updated.

= 1.8.0 - 2021-09-30 =
* New: Bulk Editing of Products under WooCommerce > Settings > Change Prices with Time
* Fix: Removing all scheduled timestamps prior to adding new ones.

= 1.7.1 - 2021-01-31 =
* New: Prices remain the same when added to cart and saves the changes of prices if other plugins are changing it.

= 1.7.0 - 2020-12-28 =
* New: Prices remain the same when added to cart if the time has passed.

= 1.6.0 - 2020-11-15 =
* New: New layout added to each product (or variation if premium)
* New: Showing next price with the new layout
* Fix: (Premium) Bundle changes time management much better done on the front. Takes into account the passed time.
* Update: Freemius updated to the latest library version.

= 1.5.0 - 2020-09-15 =
* New: Change Sale Prices - if the product is on sale, it will change the sale prices instead.

= 1.4.0 - 2020-07-22 =
* New: Shorcode [rpt_wc_countdown id=PRODUCT_ID].
* Fix: Added language .pot file for translating text.
* Fix: Datepicker class and JavaScript trigger changed to a specific one so other plugins won't break it.

= 1.3.0 - 2020-01-29 =
* New: Option to show countdown on archive and shop pages.
* Fix: fixing code when the countdown tried to start for times that were empty.

= 1.2.2 - 2019-11-13 =
* Fixed Error: Tried to start a countdown on variations even if there were no prices.

= 1.2.1 - 2019-11-09 =
* Fixed Error: Sometimes there was a fatal error when saving products without dates.
* Fixed (Premium): Variation data was not deleted when removing the timed options.
* Update: Freemius version updated to the latest.
* New: Refactored to code so both premium and free can still be activated.

= 1.2.0 - 2019-09-06 =
* New: Countdown shows the new price and restarts the coundown (if more price points are available) without a page refresh.
* New: (Premium) Timed Incrementals on Simple Products. Example Scenario: Increase price every hour from today until a maximum price has been met.

= 1.1.1 =
* Security Fix

= 1.1.0 =
* Fixed Error: After the date was saved, the date format reversed.
* Added: Time dropdown. You can now select the time and date.
* Added: Freemius service to provide premium features.
* Refactored: JavaScript and template for usage in different places.
* Added Premium: Variations can also have separate time

= 1.0.2 =
* Fixed Error: Did not remove all data. Now it deletes and unschedules even the latest deleted time.

= 1.0.1 =
* Fixed Error: Trying to create a countdown when there is are dates defined

= 1.0.0 =
* Initial release
