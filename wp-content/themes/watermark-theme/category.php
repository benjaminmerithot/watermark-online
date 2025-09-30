<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

get_header();
$category_color = get_term_meta( get_queried_object_id(), 'category_color', true ) ?: null;
$color_property = $category_color ? 'style="--wm--c-page-header: var(--wm--c-' . $category_color . ');"' : '';
$category_id = get_queried_object_id();
$featured_categories = get_term_meta( get_queried_object_id(), 'featured_categories' ) ?: null;
$used_entries = [];
$category_slug = get_queried_object()->slug;
$leaderboard_header = $category_slug == 'en-espanol' ? 'leaderboard-header-es' : 'leaderboard-header';
$leaderboard_footer = $category_slug == 'en-espanol' ? 'leaderboard-footer-es' : 'leaderboard-footer';
$sidebar = $category_slug == 'en-espanol' ? 'sidebar-es' : 'category-sidebar';
?>

	<main id="main" class="site-main" role="main">
		<div class="container">
			<?php if ( is_active_sidebar( $leaderboard_header ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( $leaderboard_header ); ?>
				</aside>
			<?php endif; ?>

			<header class="page__header has-background-color has-background-white mb-0" <?php echo $color_property; ?>>
				<div class="inner has-background-white">
					<?php single_term_title( '<h1 class="page__title mb-0">', '</h1>' ); ?>
				</div>
			</header>

			<div class="columns has-background-white">
				<div class="column">
				<?php if ( have_posts() ) : ?>

					<?php if ( $paged < 2 ) : ?>

						<?php $args = [
							'cat' => $category_id,
							'posts_per_page' => 4,
						];

						$latest = new WP_Query( $args );

						if ( $latest->have_posts() ) : ?>
							<section class="teaser__group mb-6">
								<ul class="teaser__items columns is-gapless is-multiline">
								<?php
									$count = 0;
									while ( $latest->have_posts() ) : $latest->the_post();
										if ( $count == 0 ) :
											get_template_part( 'partials/teaser', 'large' );
										else :
											get_template_part( 'partials/teaser', 'archive-row' );
										endif;

										$used_entries[] = get_the_ID();
										$count++;
									endwhile;
								?>

								</ul>
							</section>
						<?php endif;
						wp_reset_postdata();

						if ( $featured_categories && $featured_categories[0] ) :

							$featured_ids = array_values( $featured_categories[0] );
							$i = 0;

							foreach ( $featured_ids as $featured_category ) :
								$per_page = $i <= 1 ? 6 : 7;
								$args = [
									'cat' => $featured_category,
									'posts_per_page' => $per_page,
									'post__not_in' => $used_entries,
								];

								$category_name = get_cat_name( $featured_category );
								$category_link = get_category_link( $featured_category );

								$query = new WP_Query( $args );

								if ( $query->have_posts() ) : ?>
									<section class="teaser__group has-gap-large">
										<div class="teaser__header level">
											<h2 class="teaser__heading"><?php echo $category_name; ?></h2>
											<a href="<?php echo esc_url( $category_link ); ?>" class="teaser--more is-hidden-touch">
												<span>See More</span>
												<svg class="icon-svg" role="img">
													<use xlink:href="#arrow-right"></use>
												</svg>
											</a>
										</div>

										<?php if ( $i == 0 ) :
											echo '<div class="columns">';

											echo '<ul class="teaser__items column">';

											while ( $query->have_posts() ) : $query->the_post();

												$args = [
													'image_size' => 'teaser-large-rect',
													'class' => 'teaser--column teaser--large',
												];

												watermark_display_teaser( $args );
												$used_entries[] = get_the_ID();


												if ( $query->current_post == 0 ) break;
											endwhile;

											echo '</ul>';

											// Second column of entries
											echo '<ul class="teaser__items column is-4-desktop">';

											while ( $query->have_posts() ) : $query->the_post();
												$class = $query->current_post != 5 ? 'has-border-bottom' : '';

												$args = [
													'image' => false,
													'show_byline' => false,
													'class' => $class,
												];

												watermark_display_teaser( $args );
												$used_entries[] = get_the_ID();

											endwhile;

											echo '</ul>';

											echo '</div>';

										elseif ( $i == 1 ) :

											echo '<ul class="teaser__items columns is-multiline">';

											while ( $query->have_posts() ) : $query->the_post();

												$args = [
													'class' => 'column is-4-desktop teaser--column teaser--medium',
												];

												watermark_display_teaser( $args );
												$used_entries[] = get_the_ID();


											endwhile;

											echo '</ul>';

										else :

											echo '<div class="columns">';

											echo '<ul class="teaser__items column">';

											while ( $query->have_posts() ) : $query->the_post();

												$args = [
													'class' => 'teaser--row',
												];

												watermark_display_teaser( $args );
												$used_entries[] = get_the_ID();


												if ( $query->current_post == 2 ) break;
											endwhile;

											echo '</ul>';

											// Second column of entries
											echo '<ul class="teaser__items column is-4-desktop">';

											while ( $query->have_posts() ) : $query->the_post();
												$class = $query->current_post != 6 ? 'has-border-bottom' : '';

												$args = [
													'image' => false,
													'show_byline' => false,
													'class' => $class,
												];

												watermark_display_teaser( $args );
												$used_entries[] = get_the_ID();

											endwhile;

											echo '</ul>';

											echo '</div>';

										endif;  ?>
										<div class="teaser__footer is-hidden-desktop has-text-centered">
											<a href="<?php echo esc_url( $category_link ); ?>" class="teaser--more">
												<span>See More</span>
												<svg class="icon-svg" role="img">
													<use xlink:href="#arrow-right"></use>
												</svg>
											</a>
										</div>
									</section>
							<?php
								endif;

								$i++;
								wp_reset_postdata();
							endforeach;
						endif;
					endif; ?>

					<section class="teaser__list teaser--archives">
						<h2 class="teaser__header">More Stories</h2>
						<ul class="teaser__items">
							<?php
								$current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
								$current_page = max( 1, $current_page );
								$per_page = 12;
								$offset_start = 4;
								$offset = ( $current_page - 1 ) * $per_page + $offset_start;

								$args = [
									'cat' => $category_id,
									'posts_per_page' => $per_page,
									'offset' => $offset,
									'paged' => $current_page,
								];

								$query = new WP_Query( $args );
								/* Start the Loop */
								while ( $query->have_posts() ) :
									$query->the_post();
									get_template_part( 'partials/teaser-loop' );
								endwhile;
								wp_reset_postdata();
							?>
						</ul>

					<?php
						watermark_numeric_pagination( $args = [], $query );

					else :
						get_template_part( 'partials/content', 'none' );
						?>
					</section>
				<?php	endif; ?>
				</div>

				<?php if ( is_active_sidebar( $sidebar ) ) : ?>
					<div class="column is-3-desktop">
						<aside class="aside--sidebar sidebar widget-area">
							<?php dynamic_sidebar( $sidebar ); ?>
						</aside>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( is_active_sidebar( $leaderboard_footer ) ) : ?>
				<aside class="aside--footer">
					<?php dynamic_sidebar( $leaderboard_footer ); ?>
				</aside>
			<?php endif; ?>
		</div>
	</main>
<?php get_footer(); ?>
