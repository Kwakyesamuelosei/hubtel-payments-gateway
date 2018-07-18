<?php
/**
 * Plugin Name: Hubtel Payments Gateway.
 * Plugin URI: https://wordpress.org/plugins/hubtel-payments-gateway
 * Description: This plugin enables you to accept online payments for Ghana issued cards and mobile money payments using Hubtel payments API..
 * Version: 1.0.0
 * Author: Adams Agalic
 * Author URI: http://twitter.com/aagalic
 * Author Email: aagalic@gmail.com
 * License: GPLv2 or later
 * Requires at least: 4.4
 * Tested up to: 4.9
 * 
 * 
 * @package Hubtel Payments Gateway
 * @category Plugin
 * @author Agalic Adams
 */



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function hubtel_init()
{


	function add_hubtel_gateway_class( $methods ) 
	{
		$methods[] = 'WC_Hubtel_Payment_Gateway'; 
		return $methods;
	}
	add_filter( 'woocommerce_payment_gateways', 'add_hubtel_gateway_class' );

	if(class_exists('WC_Payment_Gateway'))
	{
		class WC_Hubtel_Payment_Gateway extends WC_Payment_Gateway 
		{

			public function __construct()
			{

				$this->id               = 'hubtel-payments';
				$this->icon             = plugins_url( 'images/hubtel-0.png' , __FILE__ ) ;
				$this->has_fields       = true;
				$this->method_title     = 'Hubtel Payments'; 
				$this->description       = $this->get_option( 'hubtel_description');            
				$this->init_form_fields();
				$this->init_settings();

				$this->title                    = $this->get_option( 'hubtel_title' );
				$this->hubtel_description       = $this->get_option( 'hubtel_description');
				$this->hubtel_clientid  	    = $this->get_option( 'hubtel_clientid' );
				$this->hubtel_clientsecret      = $this->get_option( 'hubtel_clientsecret' );
				$this->hubtel_merchant_number   = $this->get_option( 'hubtel_merchant_number' );
				$this->hubtel_merchant_logo     = $this->get_option( 'hubtel_merchant_logo' );

				
				if (is_admin()) 
				{

					if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=')) {
						add_action('woocommerce_update_options_payment_gateways_' . $this->id, array(&$this, 'process_admin_options'));
					} else {
						add_action('woocommerce_update_options_payment_gateways', array(&$this, 'process_admin_options'));
					}				}
				
				//register webhook listener action
				add_action( 'woocommerce_api_wc_hubtel_payment_webhook', array( $this, 'check_hubtel_payment_webhook' ) );

			}


			public function init_form_fields()
			{

				$this->form_fields = array(
					'enabled' => array(
						'title' =>  'Enable/Disable',
						'type' => 'checkbox',
						'label' =>  'Enable Hubtel Payments',
						'default' => 'yes'
						),

					'hubtel_title' => array(
						'title' =>  'Title',
						'type' => 'text',
						'description' =>  'This displays the title which the user sees during checkout options.',
						'default' =>  'Pay With Hubtel',
						'desc_tip'      => true,
						),

					'hubtel_description' => array(
						'title' =>  'Description',
						'type' => 'textarea',
						'description' =>  'This is the description which the user sees during checkout.',
						'default' =>  'Safe and secure payments with Ghanaian issued cards and mobile money from all networks.',
						'desc_tip'      => true,
						),

					'hubtel_clientid' => array(
						'title' =>  'Client ID',
						'type' => 'text',
						'description' =>  'This is your Hubtel API Client ID which you can find in your Dashboard.',
						'default' => '',
						'desc_tip'      => true,
						'placeholder' => 'Hubtel API Clientid'
						),

					'hubtel_clientsecret' => array(
						'title' =>  'Client Secret',
						'type' => 'text',
						'description' =>  'This is your Hubtel API Client Secret which you can find in your Dashboard.',
						'default' => '',
						'desc_tip'      => true,
						'placeholder' => 'Hubtel API Clientsecret'
						),

				'hubtel_merchant_number' => array(
						'title' =>  'Hubtel Merchant Number',
						'type' => 'text',
						'description' =>  'This is your Hubtel Merchant Account which you can find in your Hubtel Dashboard',
						'default' => '',
						'desc_tip'      => true,
						'placeholder' => 'Hubtel API Clientsecret'
						),
			'hubtel_merchant_logo' => array(
						'title' =>  'Hubtel Merchant Logo URL',
						'type' => 'text',
						'description' =>  'This is the Merchant logo URL that should be displayed on the checkout page.',
						'default' => '',
						'desc_tip'      => true,
						'placeholder' => 'Hubtel API Clientsecret'
						)
						
					);

			}

			/**
			 * handle webhook callback
			 */
			public function check_hubtel_payment_webhook()
			{
				// receive callback 
				$webhook_res = json_encode(file_get_contents("php://input"));
				
				 //Update the order status
				// $order->update_status('on-hold', '');

				// //Error Note
				// $message = 'Thank you for shopping with us.<br />Your payment transaction was successful, but the amount paid is not the same as the total order amount.<br />Your order is currently on-hold.<br />Kindly contact us for more information regarding your order and payment status.';
				// $message_type = 'notice';

				// //Add Customer Order Note
			    // $order->add_order_note( $message.'<br />Paga Transaction ID: '.$transaction_id, 1 );
				// Reduce stock levels
				$order->reduce_order_stock();

				// Empty cart
				WC()->cart->empty_cart();

				
			}

			/**
			 * process payments
			 */
			public function process_payment($order_id)
			{
				global $woocommerce;

				$order = new WC_Order( $order_id );

				// Get an instance of the WC_Order object
				$order = wc_get_order( $order_id );

				$order_data = $order->get_items();

				//build order items for the hubel request body
				$hubtel_items = [];
				$items_counter = 0;
				$total_cost = 0;
				foreach ($order_data as $order_key => $order_value):

					$hubtel_items[$items_counter] = [
							"name" => $order_value->get_name(),
							"quantity" => $order_value->get_quantity(), // Get the item quantity
							"unitPrice" => $order_value->get_total()/$order_value->get_quantity()
					];
					
						$total_cost += $order_value->get_total();
						$items_counter++;
				endforeach;


				//hubtel payment request body args
				$hubtel_request_args = [
					  "items" => $hubtel_items,
					  "totalAmount" =>$total_cost, //get total cost of order items
					  "description" => $this->get_option('hubtel_description'),
					  "callbackUrl" => WC()->api_request_url( 'WC_Hubtel_Payment_Gateway'), //register callback
					  "returnUrl" => $order->get_checkout_order_received_url(), //return to this page
					  "merchantBusinessLogoUrl" => $this->hubtel_merchant_logo, 
					  "merchantAccountNumber" => $this->hubtel_merchant_number,
					  "cancellationUrl" => get_home_url(), //checkout url
					  "clientReference" => date('his').rand(0, 10000) //generate a unique id the client reference
				];
				
				
				
				//initiate request to Hubtel payments API
				$base_url = 'https://api.hubtel.com/v2/pos/onlinecheckout/items/initiate';
				$response = wp_remote_post($base_url, array(
					'method' => 'POST',
					'timeout' => 60,
					'headers' => array(
						'Authorization' => 'Basic '.base64_encode($this->hubtel_clientid.':'.$this->hubtel_clientsecret),
						'Content-Type' => 'application/json'
					),
					'body' => json_encode($hubtel_request_args)
					)
				);

				
				//retrieve response body and extract the 
				$response_code = wp_remote_retrieve_response_code( $response );
				$response_body = wp_remote_retrieve_body($response);

				$response_body_args = json_decode($response_body, true);

				if($response_code == 200){
					return array(
						'result'   => 'success',
						'redirect' => $response_body_args['data']['checkoutUrl']
					);
				}else{
					$order->add_order_note('Could not reach Hubtel');
				}			
					
			}


        }  // end of class WC_Hubtel_Payment_Gateway

} // end of if class exist WC_Gateway

}

/*Activation hook*/
add_action( 'plugins_loaded', 'hubtel_init' );



