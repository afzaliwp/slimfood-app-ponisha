<?php
/**
 * Plugin Name:       AfzaliWP SlimFood App
 * Plugin URI:        https://afzaliwp.com
 * Description:       Slim Food app is a plugin to manage multiple gyms and food ordering.
 * Version:           1.0.0
 * Author:            Mohammad Afzali
 * Author URI:        https://afzaliwp.com
 */

namespace AfzaliWP;

use AfzaliWP\SlimFood\Includes\Custom_Food_Meta;
use AfzaliWP\SlimFood\Includes\Process_Payment;
use AfzaliWP\SlimFood\Includes\Sell_Form;
use Exception;

defined( 'ABSPATH' ) || die();

require 'functions.php';

final class SlimFood {

	private static $instances = [];

	protected function __construct() {
		spl_autoload_register( 'afzaliwp_slimfood_autoload' );
		$this->define_constants();

		include_once __DIR__ . '/includes/class-wc-gateway-zarinpal.php';
		add_action( 'init', function () {
			$this->woocommerce_related();
		} );
		new Process_Payment();

		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles_and_scripts' ] );
	}

	protected function __clone() {}

	/**
	 * @throws Exception
	 */
	public function __wakeup() {
		throw new Exception( "Cannot unserialize a singleton." );
	}

	public static function get_instance() {
		$cls = SlimFood::class;

		if ( ! isset( self::$instances[ $cls ] ) ) {
			self::$instances[ $cls ] = new SlimFood();
		}

		return self::$instances[ $cls ];
	}

	public function activation() {}

	public function deactivation() {}

	public function register_styles_and_scripts() {
		wp_enqueue_style(
			'afzaliwp-sf-style',
			AFZALIWP_SF_ASSETS_URL . 'frontend.min.css',
			'',
			AFZALIWP_SF_ASSETS_VERSION
		);

		//Toastify
		wp_enqueue_style(
			'afzaliwp-sf-tostify-style',
			'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css',
			[ 'afzaliwp-sf-style' ],
			AFZALIWP_SF_ASSETS_VERSION
		);

		wp_enqueue_script(
			'afzaliwp-sf-script',
			AFZALIWP_SF_ASSETS_URL . 'frontend.min.js',
			AFZALIWP_SF_ASSETS_VERSION,
			null,
			true
		);

		wp_localize_script(
			'afzaliwp-sf-script',
			'afzaliwpSfAJAX',
			[
				'homeUrl' => get_bloginfo( 'url' ),
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'afzaliwp-sf-nonce' ),
			]
		);
	}

	public function register_admin_styles_and_scripts() {
		wp_enqueue_style(
			'afzaliwp-sf-admin-style',
			AFZALIWP_SF_ASSETS_URL . 'admin.min.css',
			'',
			AFZALIWP_SF_ASSETS_VERSION
		);

		wp_enqueue_script(
			'afzaliwp-sf-admin-script',
			AFZALIWP_SF_ASSETS_URL . 'admin.min.js',
			[],
			AFZALIWP_SF_ASSETS_VERSION,
			true
		);
	}

	public function woocommerce_related() {
		new Sell_Form();
		new Custom_Food_Meta();
	}

	public function define_constants() {
		define( 'AFZALIWP_SF_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'AFZALIWP_SF_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'AFZALIWP_SF_TPL_DIR', trailingslashit( AFZALIWP_SF_DIR . 'templates' ) );
		define( 'AFZALIWP_SF_WC_TPL_DIR', trailingslashit( AFZALIWP_SF_DIR . 'woocommerce' ) );
		define( 'AFZALIWP_SF_INC_DIR', trailingslashit( AFZALIWP_SF_DIR . 'includes' ) );
		define( 'AFZALIWP_SF_ASSETS_URL', trailingslashit( AFZALIWP_SF_URL . 'assets/dist' ) );
		define( 'AFZALIWP_SF_IMAGES', trailingslashit( AFZALIWP_SF_URL . 'assets/images' ) );
		define( 'AFZALIWP_SF_JSON', trailingslashit( AFZALIWP_SF_ASSETS_URL . 'json' ) );

		if ( str_contains( get_bloginfo( 'wpurl' ), 'localhost' ) ) {
			define( 'AFZALIWP_SF_IS_LOCAL', true );
			define( 'AFZALIWP_SF_ASSETS_VERSION', time() );
		} else {
			define( 'AFZALIWP_SF_IS_LOCAL', false );
			define( 'AFZALIWP_SF_ASSETS_VERSION', '1.0.0' );
		}
	}
}

SlimFood::get_instance();