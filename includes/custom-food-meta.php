<?php

namespace AfzaliWP\SlimFood\Includes;

defined( 'ABSPATH' ) || die();

class Custom_Food_Meta {
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
		add_action( 'woocommerce_admin_process_product_object', [ $this, 'save' ] );
		add_action( 'woocommerce_admin_order_data_after_billing_address', [ $this, 'custom_checkout_field_display_admin_order_meta' ], 10, 1 );
		add_action( 'admin_init', [ $this, 'settings_fields' ] );

	}

	function custom_checkout_field_display_admin_order_meta( $order ) {
		echo '<p><strong>شماره سفارش گیرنده:</strong> ' . get_post_meta( $order->get_id(), 'place_phone', true ) . '</p>';
		echo '<p><strong>زمان ارسال:</strong> ' . get_post_meta( $order->get_id(), 'delivery_time', true ) . '</p>';
	}

	public function add_meta_box() {
		add_meta_box(
			'food_meta_box',
			__( 'Food Meta', 'slimfood' ),
			[ $this, 'render_meta_box_content' ],
			'product',
			'advanced',
			'high'
		);
		add_meta_box(
			'invoice_img',
			__( 'Invoice Image', 'slimfood' ),
			[ $this, 'render_invoice_img_meta_box_content' ],
			'shop_order',
			'advanced',
			'high'
		);
	}

	public function render_meta_box_content( $post ) {
		wp_nonce_field( 'food_meta_box', 'food_meta_box_nonce' );

		$calories = get_post_meta( $post->ID, 'food_calories', true );
		$fat = get_post_meta( $post->ID, 'food_fat', true );
		$carbohydrate = get_post_meta( $post->ID, 'food_carbohydrate', true );
		$protein = get_post_meta( $post->ID, 'food_protein', true );
		$sugar = get_post_meta( $post->ID, 'food_sugar', true );

		// Display the form, using the current value.
		echo '<label for="food_calories">';
		_e( "Calories", 'slimfood' );
		echo '</label> ';
		echo '<input type="number" id="food_calories" name="food_calories" value="' . esc_attr( $calories ) . '" step="0.01" min="0"/><br>';

		echo '<label for="food_fat">';
		_e( "Fat", 'slimfood' );
		echo '</label> ';
		echo '<input type="number" id="food_fat" name="food_fat" value="' . esc_attr( $fat ) . '" step="0.01" min="0"/><br>';

		echo '<label for="food_carbohydrate">';
		_e( "Carbohydrate", 'slimfood' );
		echo '</label> ';
		echo '<input type="number" id="food_carbohydrate" name="food_carbohydrate" value="' . esc_attr( $carbohydrate ) . '" step="0.01" min="0"/><br>';

		echo '<label for="food_protein">';
		_e( "Protein", 'slimfood' );
		echo '</label> ';
		echo '<input type="number" id="food_protein" name="food_protein" value="' . esc_attr( $protein ) . '" step="0.01" min="0"/><br>';

		echo '<label for="food_sugar">';
		_e( "Sugar", 'slimfood' );
		echo '</label> ';
		echo '<input type="number" id="food_sugar" name="food_sugar" value="' . esc_attr( $sugar ) . '" step="0.01" min="0"/><br>';

	}

	public function render_invoice_img_meta_box_content( $post ) {
		echo sprintf( '<img src="%s" alt="" %s>', get_home_url() . '/wp-content/uploads/order-invoices/' . $post->ID . '/order.jpg', 'style="max-width: 100%; height: auto;"' );
	}

	public function save( $product ) {
		if ( !isset( $_POST[ 'food_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'food_meta_box_nonce' ], 'food_meta_box' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( !current_user_can( 'edit_post', $product->get_id() ) ) {
			return;
		}

		if ( isset( $_POST[ 'food_protein' ] ) ) {
			$product->update_meta_data( 'food_protein', floatval( $_POST[ 'food_protein' ] ) );
		}

		if ( isset( $_POST[ 'food_calories' ] ) ) {
			$product->update_meta_data( 'food_calories', floatval( $_POST[ 'food_calories' ] ) );
		}

		if ( isset( $_POST[ 'food_carbohydrate' ] ) ) {
			$product->update_meta_data( 'food_carbohydrate', floatval( $_POST[ 'food_carbohydrate' ] ) );
		}

		if ( isset( $_POST[ 'food_fat' ] ) ) {
			$product->update_meta_data( 'food_fat', floatval( $_POST[ 'food_fat' ] ) );
		}

		if ( isset( $_POST[ 'food_sugar' ] ) ) {
			$product->update_meta_data( 'food_sugar', floatval( $_POST[ 'food_sugar' ] ) );
		}

		$product->save_meta_data();
	}

	public function settings_fields() {
		register_setting( 'general', 'melipayamak_api_address', 'esc_attr' );
		add_settings_section( 'melipayamak_api_address_section', 'Melipayamak API Address', [ $this, 'melipayamak_api_address_section_callback' ], 'general' );
		add_settings_field( 'melipayamak_api_address_field', '<label for="melipayamak_api_address">' . __( 'Melipayamak API Address', 'melipayamak_api_address' ) . '</label>', [ $this, 'melipayamak_api_address_field_callback' ], 'general', 'melipayamak_api_address_section' );
	}

	public function melipayamak_api_address_section_callback() {
		echo '<p>Please enter the Melipayamak API address below:</p>';
	}

	public function melipayamak_api_address_field_callback() {
		$melipayamak_api_address = get_option( 'melipayamak_api_address', '' );
		echo '<input type="text" id="melipayamak_api_address" name="melipayamak_api_address" value="' . $melipayamak_api_address . '" />';
	}
}
