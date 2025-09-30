<?php

$category = get_field( 'featured_category' );
$category_link = get_category_link( $category );

$args = array(
	'posts_per_page' => 4,
	'category__in'   => $category,
	'no_found_rows'  => true,
);

$teaser_query = new WP_Query( $args );
?>
<div class="column">
	<div class="teaser__header level">
		<h2 class="teaser__heading"><?php echo $category->name; ?></h2>
		<a href="<?php echo esc_url( $category_link ); ?>" class="teaser--more is-hidden-touch">
			<span>See More</span>
			<svg class="icon-svg" role="img">
				<use xlink:href="#arrow-right"></use>
			</svg>
		</a>
	</div>
	<ul class="teaser__items columns is-gapless is-multiline is-flex-touch">
		<?php
		$count = 0;
		foreach ( $teaser_query->posts as $post ) :
			setup_postdata( $post );

			$post_id = $post->ID;

			$class = 'column teaser--column teaser--medium';
			$image_size = 'teaser-medium';

			if ( $count == 0 ) {
				$class = 'column is-12-desktop teaser--row teaser--large has-border-bottom';
				$image_size = 'teaser-large-rect';
			}

			$args = array(
				'post_id' => $post_id,
				'class' => $class,
				'image_size' => $image_size,
			);

			watermark_display_teaser( $args );
			$count++;

		endforeach;

		wp_reset_postdata();
		?>

	</ul>
	<div class="teaser__footer is-hidden-desktop has-text-centered">
		<a href="<?php echo esc_url( $category_link ); ?>" class="teaser--more">
			<span>See More</span>
			<svg class="icon-svg" role="img">
				<use xlink:href="#arrow-right"></use>
			</svg>
		</a>
	</div>

</div>

