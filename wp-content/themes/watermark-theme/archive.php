<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">
		<div class="container">
			<?php if ( is_active_sidebar( 'leaderboard-header' ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( 'leaderboard-header' ); ?>
				</aside>
			<?php endif; ?>

			<header class="page__header">
				<?php
					single_term_title( '<h1 class="page__title">', '</h1>' );
				?>
			</header>
			<div class="columns">
				<div class="column">
					<section class="teaser__list teaser--archives">
						<ul class="teaser__items">
							<?php if ( have_posts() ) :
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									get_template_part( 'partials/teaser-loop' );
								endwhile; ?>
						</ul>
					<?php
						watermark_numeric_pagination();

					else :
						get_template_part( 'partials/content', 'none' ); ?>
					</section>
					<?php endif; ?>
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
