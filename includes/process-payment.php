<?php

namespace AfzaliWP\SlimFood\Includes;

defined( 'ABSPATH' ) || die();

class Process_Payment {
	public function __construct() {
		add_action( 'wp_ajax_afzaliwp_add_to_cart', [ $this, 'add_to_cart' ] );
		add_action( 'wp_ajax_nopriv_afzaliwp_add_to_cart', [ $this, 'add_to_cart' ] );

		add_action( 'wp_ajax_afzaliwp_create_order', [ $this, 'create_order' ] );
		add_action( 'wp_ajax_nopriv_afzaliwp_create_order', [ $this, 'create_order' ] );
	}

	public function add_to_cart() {
		if ( isset( $_POST[ 'products' ] ) ) {
			$products = $_POST[ 'products' ];

			WC()->cart->empty_cart();

			foreach ( $products as $product_id => $product_data ) {
				WC()->cart->add_to_cart( $product_id, $product_data[ 'quantity' ] );
			}

			wp_send_json_success( 'محصولات به سبد خرید اضافه شدند.' );
		}

		wp_send_json_error( 'محصولی ارسال نشده است.' );

		die();
	}

	/**
	 * @throws \WC_Data_Exception
	 */
	public function create_order() {
		// Check if cart data is set
		if ( isset( $_POST[ 'cart' ] ) ) {
			$cart = json_decode( stripslashes( $_POST[ 'cart' ] ), true );

			// Create new order
			$order = wc_create_order();

			// Check if file is uploaded
			if ( isset( $_FILES[ 'invoiceImg' ] ) ) {
				$this->upload_image( $order->get_id(), $_FILES[ 'invoiceImg' ] );
			}

			// Loop through cart items and add them to the order
			foreach ( $cart[ 'products' ] as $product_id => $product_data ) {
				$order->add_product( wc_get_product( $product_id ), $product_data[ 'quantity' ] );
			}

			// Set billing info
			$billing_info = [
				'first_name' => $cart[ 'place' ][ 'name' ],
				'address_1'  => '',
				'address_2'  => 'محل سفارش: ' . $cart[ 'place' ][ 'address' ],
				'phone'      => $cart[ 'phone' ],
			];
			if ( isset( $cart['address'] ) ) {
				$billing_info['address_1']  = 'دلخواه: ' . $cart[ 'address' ];
			}
			$order->set_address( $billing_info, 'billing' );

			if ( 'false' === $cart[ 'isInPlace' ] || empty( $cart[ 'isInPlace' ] ) ) {
				// Add shipping method
				$shipping_rate = new \WC_Shipping_Rate(
					'flat_rate_shipping', // Shipping rate id
					'Flat Rate Shipping', // Shipping method label
					50, // Cost
					[], // Taxes
					'flat_rate' // Shipping method id
				);

				$order->add_shipping( $shipping_rate );
			}

			// Set payment method to wc_zpal (zarinpal)
			$order->set_payment_method( 'wc_zpal' );

			$redirect_url = home_url() . '/app/' . $cart[ 'place' ][ 'redirectPath' ];
			$order->update_meta_data( 'app_redirect_path', $redirect_url );
			$order->update_meta_data( 'delivery_time', $cart[ 'time' ] );
			$order->update_meta_data( 'place_phone', $cart[ 'place' ][ 'phone' ] );

			// Save the order
			$order->calculate_totals();
			$order->save();

			// Get payment URL
			$order_id = $order->get_id();
//			$order_key = $order->get_order_key();
			$payment_url_wc = $order->get_checkout_payment_url();

			wp_send_json_success( [ 'order_id' => $order_id, 'payment_url_wc' => $payment_url_wc ] );
		} else {
			wp_send_json_error( 'Cart data is not set.' );
		}

		die();
	}

	private function upload_image( $order_id, $file ) {
		$upload_dir  = wp_upload_dir();
		$upload_path = $upload_dir[ 'basedir' ] . '/order-invoices/' . $order_id . '/';

		// Create the folder if it doesn't exist
		if ( ! file_exists( $upload_path ) ) {
			mkdir( $upload_path, 0755, true );
		}

		// Move the uploaded file
		move_uploaded_file( $file[ 'tmp_name' ], $upload_path . 'order.jpg' );
	}
}