<?php
/**
 * The template for displaying the contributor archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

get_header(); ?>

	<main id="main" class="site-main page--contributor" role="main">
		<div class="container">

			<?php if ( is_active_sidebar( 'leaderboard-header' ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( 'leaderboard-header' ); ?>
				</aside>
			<?php endif; ?>

			<header class="page__header">
				<div class="media">
					<div class="media-left">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'contributor-photo' ) ); ?>
						<?php endif; ?>
					</div>
					<div class="media-content">
						<h1 class="page__title"><?php the_title(); ?></h1>
						<?php if ( get_the_content() ) : ?>
							<div class="page__description">
								<?php the_content(); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</header>

			<div class="columns">
				<div class="column">
					<section class="teaser__list teaser--archives">
						<h2 class="section__title">Articles by <?php the_title(); ?></h2>
						<ul class="teaser__items">
							<?php
							// Get all posts by this contributor
							$contributor_id = get_the_ID();
							$posts_query = new WP_Query( array(
								'post_type'      => 'post',
								'posts_per_page' => 10,
								'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
								'meta_query'     => array(
									array(
										'key'     => '_watermark_contributor_ids',
										'value'   => sprintf( ':"%s";', $contributor_id ),
										'compare' => 'LIKE',
									),
								),
							) );

							if ( $posts_query->have_posts() ) :
								/* Start the Loop */
								while ( $posts_query->have_posts() ) :
									$posts_query->the_post();
									get_template_part( 'partials/teaser-loop' );
								endwhile; ?>
						</ul>
					<?php
						// Pagination
						$big = 999999999;
						echo paginate_links( array(
							'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format'  => '?paged=%#%',
							'current' => max( 1, get_query_var( 'paged' ) ),
							'total'   => $posts_query->max_num_pages,
						) );

						wp_reset_postdata();
					else :
						echo '<li><p>No articles found by this contributor.</p></li>';
					endif; ?>
					</section>
				</div>

				<div class="column is-3-desktop">
					<?php get_sidebar(); ?>
				</div>
			</div>

			<?php if ( is_active_sidebar( 'leaderboard-footer' ) ) : ?>
				<aside class="aside--footer">
					<?php dynamic_sidebar( 'leaderboard-footer' ); ?>
				</aside>
			<?php endif; ?>
		</div>
	</main>

<?php get_footer(); ?>
