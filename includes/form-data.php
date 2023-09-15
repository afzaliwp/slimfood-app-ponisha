<?php

namespace AfzaliWP\SlimFood\Includes;

defined( 'ABSPATH' ) || die();

class Form_Data {

	private $HTML_Generator;

	public function __construct() {
		$this->HTML_Generator = new HTML_Generator();
	}

	public function step_start() {
		ob_start();
		?>
        <div class="step step-start-parent" data-step="1" data-sub-step="1" style="display: flex;">
			<?php echo $this->HTML_Generator->next_step( '.step-phone-parent', 'شماره موبایل' ); ?>
        </div>
		<?php
		echo ob_get_clean();
	}

	public function step_phone() {
		ob_start();
		?>
        <div class="step step-phone-parent" data-step="1" data-sub-step="1">
            <div class="phone">
                <div class="phone-number">09</div>
                <div class="phone-keys">
                    <button type="button" class="key" data-number="1">
                        <strong>1</strong>
                    </button>
                    <button type="button" class="key" data-number="2">
                        <strong>2</strong>
                        <small>ABC</small>
                    </button>
                    <button type="button" class="key" data-number="3">
                        <strong>3</strong>
                        <small>DEF</small>
                    </button>
                    <button type="button" class="key" data-number="4">
                        <strong>4</strong>
                        <small>GHI</small>
                    </button>
                    <button type="button" class="key" data-number="5">
                        <strong>5</strong>
                        <small>JKL</small>
                    </button>
                    <button type="button" class="key" data-number="6">
                        <strong>6</strong>
                        <small>MNO</small>
                    </button>
                    <button type="button" class="key" data-number="7">
                        <strong>7</strong>
                        <small>PQRS</small>
                    </button>
                    <button type="button" class="key" data-number="8">
                        <strong>8</strong>
                        <small>TUV</small>
                    </button>
                    <button type="button" class="key" data-number="9">
                        <strong>9</strong>
                        <small>WXYZ</small>
                    </button>
                    <button type="button" class="key" data-number="*">
                        <strong>*</strong>
                    </button>
                    <button type="button" class="key" data-number="0">
                        <strong>0</strong>
                        <small>+</small>
                    </button>
                    <button type="button" class="key" data-number="clear">
                        <strong><img src="<?php slimfood_get_image( 'icons-remove.png' ); ?>" alt="remove"></strong>
                    </button>
                </div>
				<?php echo $this->HTML_Generator->next_step( '.step-categories-parent', 'ORDER NOW', false ); ?>
            </div>
            <div class="right-side">
                <img src="<?php slimfood_get_image( 'phone.png' ); ?>" alt="phone-enter-side">
            </div>
        </div>
		<?php
		echo ob_get_clean();
	}

	public function step_categories() {
		ob_start();
		?>
        <div class="step step-categories-parent" data-step="1" data-sub-step="1">
            <div class="title">
                <h4>از غذای اصلی شروع کنید.</h4>
            </div>
            <div class="items">
                <button class="item step-navigator next" data-step-selector=".step-1-parent">
                    <img src="<?php slimfood_get_image( 'main-course.jpg' ); ?>" alt="main course">
                    <strong>غذای اصلی</strong>
                </button>
                <button class="item step-navigator next" data-step-selector=".step-2-parent">
                    <img src="<?php slimfood_get_image( 'meat.jpg' ); ?>" alt="meat">
                    <strong>انواع گوشت، مرغ و پروتئین</strong>
                </button>
                <button class="item step-navigator next" data-step-selector=".step-3-parent">
                    <img src="<?php slimfood_get_image( 'sides.jpg' ); ?>" alt="sides">
                    <strong>متعلقات</strong>
                </button>
                <button class="item step-navigator next" data-step-selector=".step-4-parent">
                    <img src="<?php slimfood_get_image( 'drinks.jpg' ); ?>" alt="drinks">
                    <strong>نوشیدنی</strong>
                </button>

            </div>
        </div>
		<?php
		echo ob_get_clean();
	}

	public function step_1() {
		?>
        <ul class="steps-nav-view">
            <li class="step">غذای اصلی</li>
            <li class="step">کربوهیدرات و پروتئین</li>
            <li class="step">متعلقات</li>
            <li class="step">نوشیدنی</li>
            <li class="step">آدرس</li>
        </ul>
		<?php
		echo $this->step_1_categories();
		echo $this->step_1_pasta();
		echo $this->step_1_rice();
	}

	public function step_2() {
		?>
        <ul class="steps-nav-view">
            <li class="step">غذای اصلی</li>
            <li class="step">کربوهیدرات و پروتئین</li>
            <li class="step">متعلقات</li>
            <li class="step">نوشیدنی</li>
            <li class="step">آدرس</li>
        </ul>
		<?php
		echo $this->step_2_categories_and_products();
		echo $this->step_2_fish();
	}

	public function step_3() {
		?>
        <ul class="steps-nav-view">
            <li class="step">غذای اصلی</li>
            <li class="step">کربوهیدرات و پروتئین</li>
            <li class="step">متعلقات</li>
            <li class="step">نوشیدنی</li>
            <li class="step">آدرس</li>
        </ul>
		<?php
		echo $this->step_3_categories_and_products();
		echo $this->step_3_vegetables();
	}

	public function step_4() {
		?>
        <ul class="steps-nav-view">
            <li class="step">غذای اصلی</li>
            <li class="step">کربوهیدرات و پروتئین</li>
            <li class="step">متعلقات</li>
            <li class="step">نوشیدنی</li>
            <li class="step">آدرس</li>
        </ul>
		<?php
		echo $this->step_4_categories_and_products();
	}

	public function step_5() {
		?>
        <ul class="steps-nav-view">
            <li class="step">غذای اصلی</li>
            <li class="step">کربوهیدرات و پروتئین</li>
            <li class="step">متعلقات</li>
            <li class="step">نوشیدنی</li>
            <li class="step">آدرس</li>
        </ul>
		<?php
		echo $this->step_5_address_choose();
		echo $this->step_5_form();
	}

	public function step_6() {
		?>
        <ul class="steps-nav-view">
            <li class="step">غذای اصلی</li>
            <li class="step">کربوهیدرات و پروتئین</li>
            <li class="step">متعلقات</li>
            <li class="step">نوشیدنی</li>
            <li class="step">آدرس</li>
        </ul>
		<?php
		echo $this->step_6_time_choose();
	}

	public function step_7() {
		?>
        <ul class="steps-nav-view">
            <li class="step">غذای اصلی</li>
            <li class="step">کربوهیدرات و پروتئین</li>
            <li class="step">متعلقات</li>
            <li class="step">نوشیدنی</li>
            <li class="step">آدرس</li>
        </ul>
		<?php
		echo $this->step_7_invoice_and_pay();
	}

	private function step_1_categories() {
		ob_start();
		?>
        <div class="step step-1-parent" data-step="1" data-sub-step="1">
			<?php
			//Render Skip card
			echo $this->HTML_Generator->skip_step( '.step-2-parent' );

			//Render Rice category card
			echo $this->HTML_Generator->category_item(
				[
					'slug'          => 'category-all-rices',
					'category_slug' => 'all-rices',
					'name'          => 'انواع برنج کته',
				]
			);

			//Render Pasta category card
			echo $this->HTML_Generator->category_item(
				[
					'slug'          => 'category-pasta',
					'category_slug' => 'pasta',
					'name'          => 'پاستا',
				]
			);
			?>

            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-2-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_1_pasta() {
		$products = $this->get_products( 'pasta' );

		ob_start();
		?>
        <div class="step" data-step="1" data-sub-step="category-pasta">
			<?php
			foreach ( $products as $product ) {
				$image_id  = $product->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $product->get_id(),
						'title'      => $product->get_name(),
						'price'      => $product->get_price(),
						'img'        => $image_url,
					]
				);
			}
			?>
            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-2-parent' );
				echo $this->HTML_Generator->previous_step( '.step-1-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_1_rice() {
		$products = $this->get_products( 'all-rices' );

		ob_start();
		?>
        <div class="step" data-step="1" data-sub-step="category-all-rices">
			<?php
			foreach ( $products as $product ) {
				$image_id  = $product->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $product->get_id(),
						'title'      => $product->get_name(),
						'price'      => $product->get_price(),
						'img'        => $image_url,
					]
				);
			}

			?>
            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-2-parent' );
				echo $this->HTML_Generator->previous_step( '.step-1-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_2_categories_and_products() {
		$chickens = $this->get_products( 'chicken' );
		$meats    = $this->get_products( 'meat' );
		$shrimps  = $this->get_products( 'shrimp' );
		ob_start();
		?>
        <div class="step step-2-parent" data-step="1" data-sub-step="1">

			<?php
			//Render Skip card
			echo $this->HTML_Generator->skip_step( '.step-3-parent' );

			foreach ( $chickens as $chicken ) {
				$image_id  = $chicken->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $chicken->get_id(),
						'title'      => $chicken->get_name(),
						'price'      => $chicken->get_price(),
						'img'        => $image_url,
					]
				);
			}
			?>

			<?php
			foreach ( $meats as $meat ) {
				$image_id  = $meat->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $meat->get_id(),
						'title'      => $meat->get_name(),
						'price'      => $meat->get_price(),
						'img'        => $image_url,
					]
				);
			}
			?>

			<?php
			foreach ( $shrimps as $shrimp ) {
				$image_id  = $shrimp->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $shrimp->get_id(),
						'title'      => $shrimp->get_name(),
						'price'      => $shrimp->get_price(),
						'img'        => $image_url,
					]
				);
			}

			//Render Fish category card
			echo $this->HTML_Generator->category_item(
				[
					'slug'          => 'category-fish',
					'category_slug' => 'fish',
					'name'          => 'انواع ماهی',
				]
			);
			?>

            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-3-parent' );
				echo $this->HTML_Generator->previous_step( '.step-1-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_2_fish() {
		$products = $this->get_products( 'fish' );

		ob_start();
		?>
        <div class="step" data-step="2" data-sub-step="category-fish">
			<?php
			foreach ( $products as $product ) {
				$image_id  = $product->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $product->get_id(),
						'title'      => $product->get_name(),
						'price'      => $product->get_price(),
						'img'        => $image_url,
					]
				);
			}

			?>
            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-3-parent' );
				echo $this->HTML_Generator->previous_step( '.step-2-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function get_products( $category ) {
		$args = [
			'category' => [ $category ],
			'limit'    => - 1,
			'orderby'  => 'rand',
		];

		return wc_get_products( $args );
	}

	private function step_3_categories_and_products() {
		$eggs       = $this->get_products( 'egg' );
		$potatoes   = $this->get_products( 'potato' );
		$chocolates = $this->get_products( 'chocolate' );
		ob_start();
		?>
        <div class="step step-3-parent" data-step="1" data-sub-step="1">

			<?php
			foreach ( $eggs as $egg ) {
				$image_id  = $egg->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $egg->get_id(),
						'title'      => $egg->get_name(),
						'price'      => $egg->get_price(),
						'img'        => $image_url,
					]
				);
			}
			?>

			<?php
			foreach ( $potatoes as $potato ) {
				$image_id  = $potato->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $potato->get_id(),
						'title'      => $potato->get_name(),
						'price'      => $potato->get_price(),
						'img'        => $image_url,
					]
				);
			}

			foreach ( $chocolates as $chocolate ) {
				$image_id  = $chocolate->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $chocolate->get_id(),
						'title'      => $chocolate->get_name(),
						'price'      => $chocolate->get_price(),
						'img'        => $image_url,
					]
				);
			}

			//Render vegetables category card
			echo $this->HTML_Generator->category_item(
				[
					'slug'          => 'category-vegetable',
					'category_slug' => 'vegetable',
					'name'          => 'سبزیجات',
				]
			);
			?>

            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-4-parent' );
				echo $this->HTML_Generator->previous_step( '.step-2-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_3_vegetables() {
		$products = $this->get_products( 'vegetable' );

		ob_start();
		?>
        <div class="step" data-step="3" data-sub-step="category-vegetable">
			<?php
			foreach ( $products as $product ) {
				$image_id  = $product->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $product->get_id(),
						'title'      => $product->get_name(),
						'price'      => $product->get_price(),
						'img'        => $image_url,
					]
				);
			}

			?>
            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-4-parent' );
				echo $this->HTML_Generator->previous_step( '.step-3-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_4_categories_and_products() {
		$drinks = $this->get_products( 'drinks' );
		ob_start();
		?>
        <div class="step step-4-parent" data-step="1" data-sub-step="1">

			<?php
			//Render Skip card
			echo $this->HTML_Generator->skip_step( '.step-5-parent' );

			foreach ( $drinks as $drink ) {
				$image_id  = $drink->get_image_id();
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );

				echo $this->HTML_Generator->product_item(
					[
						'product-id' => $drink->get_id(),
						'title'      => $drink->get_name(),
						'price'      => $drink->get_price(),
						'img'        => $image_url,
					]
				);
			}

			echo $this->HTML_Generator->next_step( '.step-5-parent', 'FINISH', false, 'finish-button' );
			?>

            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-5-parent' );
				echo $this->HTML_Generator->previous_step( '.step-3-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_5_address_choose() {
		ob_start();
		?>
        <div class="step step-5-parent" data-step="5" data-sub-step="1">
            <div class="choose-address">
				<?php echo $this->HTML_Generator->next_step( '.step-6-parent', 'در محل سفارش (رایگان)', false ); ?>
				<?php echo $this->HTML_Generator->next_step( '.address-form-step', 'تحویل در آدرس دلخواه', false ); ?>
            </div>

            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->previous_step( '.step-4-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_5_form() {
		ob_start();
		?>
        <div class="step address-form-step" data-step="5" data-sub-step="address-form-step">
            <form action="" id="address-form">
                <img src="<?php slimfood_get_image( 'address.jpg' ); ?>" alt="address form">
                <input id="address" type="text" name="address">
            </form>

            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-6-parent' );
				echo $this->HTML_Generator->previous_step( '.step-5-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_6_time_choose() {
		ob_start();
		?>
        <div class="step step-6-parent" data-step="6" data-sub-step="1">
            <div class="title">
                <h4>بازه های زمانی تحویل</h4>
            </div>
            <div class="choose-time">
                <button type="button" class="step-navigator next" data-step-selector=".step-7-parent"
                        data-start-time="12">
                    <img src="<?php slimfood_get_image( 'clock.jpg' ); ?>" alt="clock">
                    12 الی 13
                </button>
                <button type="button" class="step-navigator next" data-step-selector=".step-7-parent"
                        data-start-time="14">
                    <img src="<?php slimfood_get_image( 'clock.jpg' ); ?>" alt="clock">
                    14 الی 15
                </button>
                <button type="button" class="step-navigator next" data-step-selector=".step-7-parent"
                        data-start-time="18">
                    <img src="<?php slimfood_get_image( 'clock.jpg' ); ?>" alt="clock">
                    18 الی 19
                </button>
                <button type="button" class="step-navigator next" data-step-selector=".step-7-parent"
                        data-start-time="20">
                    <img src="<?php slimfood_get_image( 'clock.jpg' ); ?>" alt="clock">
                    20 الی 21
                </button>
            </div>

            <div class="navigators-wrapper">
				<?php
				echo $this->HTML_Generator->next_step( '.step-7-parent' );
				echo $this->HTML_Generator->previous_step( '.step-5-parent' );
				?>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	private function step_7_invoice_and_pay() {
		ob_start();
		?>
        <div class="step step-7-parent" data-step="7" data-sub-step="1">
            <div class="invoice">
                <h3>فاکتور نهایی:</h3>

                <div class="item-invoice first">
                    <div class="products"></div>
                </div>
                <div class="item-invoice shipping">
                    <p>هزینه ارسال</p>
                    <p class="price">50 هزار تومان</p>
                </div>
                <div class="item-invoice total">
                    <p>جمع کل</p>
                    <p class="price"><span>0</span> هزار تومان</p>
                </div>
            </div>

            <form id="pay-form" method="post" action="<?php echo esc_url( wc_get_checkout_url() ); ?>">
                <input type="hidden" name="order_time">
                <input type="hidden" name="order_is_in_place">
                <input type="hidden" name="redirect_path">
                <input type="hidden" name="place_phone">

                <input type="hidden" name="billing_first_name">
                <input type="hidden" name="billing_address_1">
                <input type="hidden" name="billing_address_2">
                <input type="hidden" name="billing_phone">
                <input type="hidden" name="payment_method" value="wc_zpal">
            </form>
            <button type="button" id="pay-button" name="custom_checkout">پرداخت</button>
        </div>
		<?php
		return ob_get_clean();
	}
}