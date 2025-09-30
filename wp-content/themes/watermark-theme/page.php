<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'partials/content', 'page' );
			endwhile; // End of the loop.
			?>


			<?php if ( is_active_sidebar( 'events-footer' ) && ( tribe_is_events_home() || tribe_is_list_view() || tribe_is_month() ) ) : ?>
				<aside class="aside--footer aside--events">
					<?php dynamic_sidebar( 'events-footer' ); ?>
				</aside>
			<?php elseif ( is_active_sidebar( 'leaderboard-footer' ) ) : ?>
				<aside class="aside--footer">
					<?php dynamic_sidebar( 'leaderboard-footer' ); ?>
				</aside>
			<?php endif; ?>
		</div>

	</main><!-- #main -->

<?php get_footer(); ?>
