<?php
/**
 * The template for displaying the author archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

get_header(); ?>

	<main id="main" class="site-main page--author" role="main">
		<div class="container">

			<?php if ( is_active_sidebar( 'leaderboard-header' ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( 'leaderboard-header' ); ?>
				</aside>
			<?php endif; ?>

			<header class="page__header">
				<div class="media">
					<div class="media-left">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 168 ); ?>
					</div>
					<div class="media-content">
						<h1 class="page__title"><?php echo get_the_author_meta( 'display_name' ); ?></h1>
						<?php if ( get_the_author_meta( 'description' ) ) : ?>
							<p class="page__description"><?php echo get_the_author_meta( 'description' ); ?></p>
						<?php endif; ?>
						<?php // TODO: add social links ?>

					</div>
				</div>
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
