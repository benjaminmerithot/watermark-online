<?php
$rows = get_field( 'categories' );

$cat1 = $rows[0]['category'];
$cat1_link = get_category_link( $cat1 );

$args = array(
	'posts_per_page' => 4,
	'category__in'   => $cat1,
	'no_found_rows'  => true,
);

$cat1_query = new WP_Query( $args );

$cat2 = $rows[1]['category'];
$cat2_link = get_category_link( $cat2 );

$args = array(
	'posts_per_page' => 3,
	'category__in'   => $cat2,
	'no_found_rows'  => true,
);

$cat2_query = new WP_Query( $args );

$cat3 = $rows[2]['category'];
$cat3_link = get_category_link( $cat3 );

$args = array(
	'posts_per_page' => 3,
	'category__in'   => $cat3,
	'no_found_rows'  => true,
);

$cat3_query = new WP_Query( $args );
?>

<section class="teaser__group">
	<div class="columns">
		<div class="column">
			<div class="teaser__header level">
				<h2 class="teaser__heading"><?php echo $cat1->name; ?></h2>
				<a href="<?php echo esc_url( $cat1_link ); ?>" class="teaser--more is-hidden-touch">
					<span>See More</span>
					<svg class="icon-svg" role="img">
						<use xlink:href="#arrow-right"></use>
					</svg>
				</a>
			</div>
			<ul class="teaser__items">
				<?php
				$count = 0;
				foreach ( $cat1_query->posts as $post ) :
					setup_postdata( $post );

					$post_id = $post->ID;

					$class = 'teaser--row';
					$image_size = 'teaser';

					if ( $count === 3 ) {
						$class = 'teaser--column teaser--large has-border-top';
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

			<div class="teaser__footer mt-5 is-hidden-desktop has-text-centered">
				<a href="<?php echo esc_url( $cat1_link ); ?>" class="teaser--more">
					<span>See More</span>
					<svg class="icon-svg" role="img">
						<use xlink:href="#arrow-right"></use>
					</svg>
				</a>
			</div>

		</div>
		<div class="column is-3-desktop">
			<h2 class="teaser__heading mb-2"><?php echo $cat2->name; ?></h2>

			<ul class="teaser__items">
				<?php
				foreach ( $cat2_query->posts as $post ) :

					setup_postdata( $post );
					$post_id = $post->ID;

					$class = 'teaser--column';
					$image_size = 'teaser-medium';

					$args = array(
						'post_id' => $post_id,
						'class' => $class,
						'image_size' => $image_size,
					);

					watermark_display_teaser( $args );

				endforeach;

				wp_reset_postdata();
				?>
			</ul>

		</div>
		<div class="column is-3-desktop">
			<h2 class="teaser__heading mb-2"><?php echo $cat3->name; ?></h2>

			<ul class="teaser__items">
				<?php
				foreach ( $cat3_query->posts as $post ) :

					setup_postdata( $post );

					$post_id = $post->ID;

					$class = 'teaser--row teaser--small';
					$image_size = 'teaser-small';

					$args = array(
						'post_id' => $post_id,
						'class' => $class,
						'image_size' => $image_size,
						'show_byline' => false,
					);

					watermark_display_teaser( $args );

				endforeach;

				wp_reset_postdata(); ?>

				<li>
					<a href="<?php echo esc_url( $cat3_link ); ?>" class="teaser--more has-text-centered-touch">
						<span>See More</span>
						<svg class="icon-svg" role="img">
							<use xlink:href="#arrow-right"></use>
						</svg>
					</a>
				</li>

				<?php
				$blockAdType = 'sidebar-300x600';
				get_template_part( 'partials/ad-script' );
				?>
			</ul>

		</div>
	</div>
</section>
