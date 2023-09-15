<?php

namespace AfzaliWP\SlimFood\Includes;

defined( 'ABSPATH' ) || die();

class HTML_Generator {

	public function __construct() {}

	public function product_item( $data ) {
		$calories     = get_post_meta( $data[ 'product-id' ], 'food_calories', true );
		$fat          = get_post_meta( $data[ 'product-id' ], 'food_fat', true );
		$carbohydrate = get_post_meta( $data[ 'product-id' ], 'food_carbohydrate', true );
		$protein      = get_post_meta( $data[ 'product-id' ], 'food_protein', true );

		$max = '';
		if ( isset( $data[ 'max' ] ) ) {
			$max = $data[ 'max' ];
		}
		ob_start();
		?>
        <div class="item product" data-product-id="<?php echo $data[ 'product-id' ]; ?>">
            <img src="<?php echo $data[ 'img' ]; ?>" alt="">
            <p class="title">
				<?php echo $data[ 'title' ]; ?>
            </p>
            <p class="price">
                <strong><?php echo $data[ 'price' ]; ?> هزار تومان</strong>
            </p>
            <div class="quantity"
                 data-max="<?php echo $max; ?>"
                 data-product-id="<?php echo $data[ 'product-id' ]; ?>"
                 data-name="<?php echo $data[ 'title' ]; ?>"
                 data-price="<?php echo $data[ 'price' ]; ?>"
                 data-calories="<?php echo $calories; ?>"
                 data-protein="<?php echo $protein; ?>"
                 data-carbohydrate="<?php echo $carbohydrate; ?>"
                 data-fat="<?php echo $fat; ?>"
            >
                <button type="button" class="increase">+</button>
                <span class="number">0</span>
                <button type="button" class="decrease">-</button>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	public function category_item( $data ) {
		ob_start();
		?>
        <div class="item category" data-sub-step="<?php echo $data[ 'slug' ]; ?>">
            <img src="<?php echo $this->get_category_thumbnail_url( $data[ 'category_slug' ] ); ?>" alt="">
            <p class="title">
				<?php echo $data[ 'name' ]; ?>
            </p>
        </div>
		<?php
		return ob_get_clean();
	}

	public function skip_step( $next_step_selector ) {
		ob_start();
		?>
        <div class="item skip-step" data-step-selector="<?php echo $next_step_selector; ?>">
            <img src="<?php slimfood_get_image( 'skip.png' ); ?>" alt="">
            <p class="title">
                بدون نیاز
            </p>
        </div>
		<?php
		return ob_get_clean();
	}

	public function previous_step( $previous_step_selector, $previous_step_text = 'بازگشت', $show_img = true, $custom_class = '' ) {
		ob_start();
		?>
        <div class="previous-step <?php echo $custom_class; ?>">
            <button type="button" class="step-navigator previous"
                    data-step-selector="<?php echo $previous_step_selector; ?>">
				<?php if ( $show_img ) { ?>
                    <img src="<?php slimfood_get_image( 'prev.png' ); ?>" alt="previous">
				<?php } ?>
				<?php echo $previous_step_text; ?>
            </button>
        </div>
		<?php
		return ob_get_clean();
	}

	public function next_step( $next_step_selector, $next_step_text = 'تایید', $show_img = true, $custom_class = '' ) {
		ob_start();
		?>
        <div class="next-step <?php echo $custom_class; ?>">
            <button type="button" class="step-navigator next" data-step-selector="<?php echo $next_step_selector; ?>">
				<?php if ( $show_img ) { ?>
                    <img src="<?php slimfood_get_image( 'next.png' ); ?>" alt="next">
				<?php } ?>
				<?php echo $next_step_text; ?>
            </button>
        </div>
		<?php
		return ob_get_clean();
	}

	private function get_category_thumbnail_url( $slug ) {
		$taxonomy     = 'product_cat';
		$term_id      = get_term_by( 'slug', $slug, $taxonomy )->term_id;
		$thumbnail_id = get_term_meta( $term_id, 'thumbnail_id', true );

		return wp_get_attachment_url( $thumbnail_id );
	}
}