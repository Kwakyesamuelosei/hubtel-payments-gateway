=== Hubtel Payments WooCommerce Gateway  ===
Contributors: aagalic
Tags: hubtel, woocommerce, payment gateway, mobile money, aagalic plugins, ghana, mastercard, visa, payments api
Requires at least: 4.4
Tested up to: 4.9
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Introduction ==
Hubtel believes Africa will be a better place when businesses make customers happy. 

This Woocommerce payment gateway makes it possible for merchants to add the Hubtel Payments to their WordPress websites.

The purpose is to help you increase sales by providing more channels for accepting payments. Hubtel provides a Merchant Account with which you can receive payments from Ghana issued VISA and Mastercards. You can also receive payments from all the mobile money Mobile Network Operators: MTN, AirtelTigo and Vodafone.

To signup for a Hubtel Merchant Account, visit [here](https://unity.hubtel.com/merchantaccount)

Access more [help articles and documentation](https://help.hubtel.com) to know more about the service.

= Note =

Hubtel Payments currently works for only Ghanaian Merchants.

= Plugin Features =

* Accept payments from bank cards (local VISA & Mastercard)
* Accept payments from mobile money channels


You can also follow me on Twitter! **[@aagalic](http://twitter.com/aagalic)**

== Installation ==

= Automatic Installation =
* 	Login to your WordPress Admin area
* 	Go to "Plugins > Add New" from the left hand menu
* 	Serarch for __Hubtel Payments Gateway__
*	From the search result you will see __Hubtel Payments Gateway__ click __Install Now__ to install the plugin
*	After installation, activate the plugin from the admin dashboard.
* 	Go to the settings page for WooCommerce and click the "Checkout" tab.
* 	Click on the __Hubtel Payments__ link from the available Checkout Options
*	Configure your __Hubtel Payments__ settings. See below for details.

= Manual Installation =
* 	Download the plugin zip file
* 	Login to your WordPress Admin. Click on "Plugins > Add New" from the left hand menu.
*   Click on the "Upload" option, then click "Choose File" to select the zip file from your computer. Once selected, press "OK" and press the "Install Now" button.
*   Activate the plugin.
* 	Go to the settings page for WooCommerce and click the "Checkout" tab.
* 	Click on the __Hubtel Payments__ link from the available Checkout Options
*	Configure your __Hubtel Payments__ settings. See below for details.

or

* Unzip the files and upload the folder into your plugins folder (/wp-content/plugins/) overwriting older versions if they exist
* Activate the plugin in your WordPress admin area.


= Configure the plugin =
To configure the Hubtel Payments Gateway plugin to work with your WordPress site, go to __WooCommerce > Settings__ from the left hand menu, then click __Checkout__ from the top tab. You will see __Hubtel Payments__ as part of the available Checkout Options. Click on it to configure the payment gateway.

* __Enable/Disable__ - check this box to enable you receive payments with Hubtel.
* __Title__ - this displays the title your customers see when they are choosing checkout options on the checkout page.
* __Description__ - this displays the description under the checkout title on the checkout page.
* __Hubtel ClientID__ - provide your Hubtel [API client ID](https://unity.hubtel.com/account/api-accounts) which can be accessed from your Merchant Account Dashboard on Hubtel.
* __Hubtel ClientSecret__ - provide your Hubtel API client Secret](https://unity.hubtel.com//account/api-accounts), this can also be accessed fromm your Merchant Account Dashboard.
* __Your Merchant Account Number__ - provide your merchant account number displayed on your dashboard.
* Remember to configure your currency to Ghana Cedis on WooCommerce.

== Frequently Asked Questions ==

= How do I get started with receiving payments with Hubtel using this plugin =

1.	You also need to have a Hubtel Merchant Account.
2.	You need to have WooCommerce plugin installed and activated on your WordPress site.
3.	You need to install and activate this plugin.

= What do I do if I am facing issues with this plugin =

You can raise a support ticket [here](https://wordpress.org/support/plugin/hubtel-payments-gateway).


= Where do I get more information on how to use Hubtel =

You can find more help information and documentation on how to use Hubtel [here](http://help.hubtel.com).

== Changelog ==
1.0.1 Handle Hubtel callback for successful and failed payment scenarios
      Update Wordpress with correct Plugin URL
      Improve order status notifications

1. First Release

1.0.0 is a initial release of this plugin 
