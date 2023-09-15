<?php

namespace AfzaliWP\SlimFood\Includes;

defined( 'ABSPATH' ) || die();

class Sell_Form {
	public function __construct() {
		add_shortcode( 'afzaliwp-slimfood-app', [ $this, 'render' ] );
	}

	public function render( $atts ) {
		$place_name    = $atts[ 'name' ];
		$place_address = $atts[ 'address' ];
		$place_phone   = $atts[ 'phone' ];
		$redirect_path = $atts[ 'path' ];
		ob_start();
		?>
        <div id="slimfood-app" class="slimfood-wrapper" data-current=".step-start-parent"
             data-place-name="<?php echo $place_name; ?>" data-place-address="<?php echo $place_address; ?>"
             data-place-phone="<?php echo $place_phone; ?>" data-redirect-path="<?php echo $redirect_path; ?>">
			<?php
			if ( isset( $_GET[ 'is_success' ] ) ) {
				echo $this->create_modal();
			}
			?>
            <div class="main">
                <div class="items-wrapper">
					<?php $this->steps(); ?>
                </div>
            </div>
            <div class="side">
                <div class="side-section chart">
                    <ul class="chart-indicators">
                        <li class="indicator protein">پروتئین</li>
                        <li class="indicator carbohydrate">کربوهیدرات</li>
                        <li class="indicator fat">چربی</li>
                    </ul>
                    <canvas id="pie-chart"></canvas>
                </div>
                <div class="side-section calories-calculator">
                    <strong id="calories-count">0</strong>
                    <small class="unit">Calories</small>
                    <small class="desc">انرژی غذایی شما تا این لحظه</small>
                </div>
                <div class="side-section price-calculator">
                    <small class="unit">Price</small>
                    <small class="desc">
                        قیمت سفارش
                        شما تا این لحظه
                    </small>
                    <div class="price-container">
                        <strong id="price-count">0</strong>
                        <small class="currency">هزار تومان</small>
                    </div>
                </div>

                <p class="motto">
                    <img src="<?php slimfood_get_image( 'slimfood-logo.png' ); ?>" alt="">
                </p>
            </div>
            <img class="bg-image" src="<?php slimfood_get_image( 'bg.png' ); ?>" alt="green leaf">
        </div>
		<?php
		return ob_get_clean();
	}

	private function steps() {
		$Form_Data = new Form_Data();
		$Form_Data->step_start();
		$Form_Data->step_phone();
		$Form_Data->step_categories();
		$Form_Data->step_1();
		$Form_Data->step_2();
		$Form_Data->step_3();
		$Form_Data->step_4();
		$Form_Data->step_5();
		$Form_Data->step_6();
		$Form_Data->step_7();
	}

	public function create_modal() {
		$status      = $_GET[ 'is_success' ];
		$order_id    = $_GET[ 'order_id' ];
		$payment_url = $_GET[ 'payment_url' ];

		switch ( $status ) {
			default:
			case 'success':
			{
				$message      = 'پرداخت شما با موفقیت انجام شد. شماره سفارش: ' . $order_id;
				$title_prefix = 'موفق';
				break;
			}
			case 'already-success':
			{
				$message      = 'پرداخت شما قبلا با موفقیت انجام شده است. شماره سفارش: ' . $order_id;
				$title_prefix = 'موفق';
				break;
			}
			case 'failed':
			{
				$message      = sprintf(
					'متاسفانه پرداخت ناموفق بود. میتوانید از طریق دکمه زیر مجددا برای پرداخت تلاش کنید. <a class="repay-button" href="%s">پرداخت مجدد</a>',
					rawurldecode( $payment_url )
				);
				$title_prefix = 'ناموفق';
				break;
			}
		}
		ob_start();
		?>
        <div class="afzaliwp-slimfood-modal show status-<?php echo $status; ?>">
            <div class="head">
                <button class="close-button">&times;</button>
                <h3 class="title">نتیجه ثبت سفارش (<?php echo $title_prefix; ?>)</h3>
            </div>
            <div class="body">
				<?php echo $message; ?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}
}