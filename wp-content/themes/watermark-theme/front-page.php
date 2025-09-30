<?php
/**
 * The template for displaying the front page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

get_header(); ?>

	<main id="main" class="site-main main--home" role="main">

		<div class="container">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'partials/content', 'front-page' );
			endwhile; // End of the loop.
			?>
		</div>

	</main><!-- #main -->

<?php get_footer(); ?>
