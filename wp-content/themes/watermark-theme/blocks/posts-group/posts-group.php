<?php
// NOTE: excluding the "En Español" category from the query by ID
$args = [
	'post_type' => 'post',
	'posts_per_page' => 5,
	'post_status' => 'publish',
	'cat'=> '-78993',
];

$col1_query = new WP_Query( $args );

$args = [
	'post_type' => 'post',
	'posts_per_page' => 6,
	'post_status' => 'publish',
	'cat'=> '-78993',
	'offset' => 5,
];

$col2_query = new WP_Query( $args );

?>
<div class="column is-6-desktop">
	<div class="teaser__list">
		<ul class="teaser__items">
			<?php
			$count = 0;

			foreach ( $col1_query->posts as $post ) :
				setup_postdata( $post );

				$post_id = $post->ID;

				$image_size = 'teaser';
				$class = 'teaser--medium teaser--row';

				if ( $count === 0 ) {
					$image_size = 'teaser-large';
					$class = 'teaser--large teaser--column has-border-bottom';
				}

				$args = [
					'post_id' => $post_id,
					'image_size' => $image_size,
					'class' => $class,
				];

				watermark_display_teaser( $args );

				$count++;
			endforeach;

			wp_reset_postdata();
			?>
		</ul>

	</div>
</div>
<div class="column is-3-desktop">
	<div class="teaser__list">
		<h2 class="teaser__heading">Latest</h2>
		<ul class="teaser__items">
			<?php
			$count = 0;
			foreach ( $col2_query->posts as $post ) :
				setup_postdata( $post );

				$post_id = $post->ID;

				if ( $count === 0 ) {
					$args = [
						'post_id' => $post_id,
						'image_size' => 'teaser-medium',
						'class' => 'teaser--medium teaser--column has-border-bottom',
					];

					watermark_display_teaser( $args );

					$blockAdType = 'sidebar-300x250';

					get_template_part( 'partials/ad-script' );

				} else {

					$args = [
						'post_id' => $post_id,
						'image_size' => 'teaser-small',
						'class' => 'teaser--small',
						'show_byline' => false,
					];

					watermark_display_teaser( $args );
				}

				$count++;
			endforeach;

			wp_reset_postdata();
			?>
		</ul>
	</div>
</div>
