<?php
/**
 * The template for displaying the Digital Publication archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

get_header(); ?>

	<main id="main" class="site-main main--publications" role="main">
		<div class="container">

			<?php if ( is_active_sidebar( 'leaderboard-header' ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( 'leaderboard-header' ); ?>
				</aside>
			<?php endif; ?>


			<?php if ( have_posts() ) : ?>

				<?php if ( $paged < 2) : ?>

					<header class="page__header has-text-centered">
						<?php the_archive_description(); ?>
					</header>

					<?php $args = [
						'category_name' => 'digital-publication',
						'posts_per_page' => 1,
					];

					$latest = new WP_Query( $args );

					if ( $latest->have_posts() ) : ?>
						<section class="teaser__latest teaser--issue is-full-width">
							<?php while ( $latest->have_posts() ) : $latest->the_post(); ?>
								<?php get_template_part( 'partials/teaser', 'latest' ); ?>
							<?php endwhile; ?>
						</section>
					<?php endif;
					wp_reset_postdata();
					?>

					<?php if ( is_active_sidebar( 'pub-specialty' ) ) : ?>
						<aside class="aside--specialty">
							<?php dynamic_sidebar( 'pub-specialty' ); ?>
						</aside>
					<?php endif; ?>

				<?php endif; ?>

				<section class="teaser__columns teaser--pubs">
					<h2 class="h1 has-text-centered"><?php single_cat_title(); ?></h2>
					<?php //TODO: change to a div instead of an unordered list ?>
					<ul class="teaser__items columns is-multiline is-gapless">
						<?php

							$current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
							$current_page = max( 1, $current_page );
							$per_page = 16;
							$offset_start = 1;
							$offset = ( $current_page - 1 ) * $per_page + $offset_start;

							$args = [
								'category_name' => 'digital-publication',
								'posts_per_page' => $per_page,
								'offset' => $offset,
								'paged' => $current_page,
							];

							$query = new WP_Query( $args );
							$count = 0;
							/* Start the Loop */
							while ( $query->have_posts() ) :
								$query->the_post();
								get_template_part( 'partials/teaser', 'archive-row' );
								if ( $count == 7 && is_active_sidebar( 'leaderboard-pub' ) ) :
									echo '<aside class="aside--leaderboard column is-12 my-5">';
									dynamic_sidebar( 'leaderboard-pub' );
									echo '</aside>';
								endif;
								$count++;
							endwhile; wp_reset_postdata(); ?>
					</ul>
					<?php
						watermark_numeric_pagination( $args = [], $query );
					else :
						get_template_part( 'partials/content', 'none' );
					?>
				</section>

			<?php endif; ?>

			<?php if ( is_active_sidebar( 'leaderboard-footer' ) ) : ?>
				<aside class="aside--footer mt-6">
					<?php dynamic_sidebar( 'leaderboard-footer' ); ?>
				</aside>
			<?php endif; ?>
		</div>

	</main><!-- #main -->
<?php get_footer(); ?>
