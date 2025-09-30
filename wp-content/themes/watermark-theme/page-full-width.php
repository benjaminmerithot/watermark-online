<?php
/**
 * Template Name: Full Width
 *
 * The template for displaying full width pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<div class="container">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'partials/content', 'page' );
			endwhile; // End of the loop.
			?>
		</div>

	</main><!-- #main -->

<?php get_footer(); ?>
