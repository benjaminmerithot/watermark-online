<?php
/**
 * Template part for displaying front page content.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

?>

	<?php
		if ( is_active_sidebar( 'leaderboard-header' ) ) :
			echo '<aside class="aside--header">';
			dynamic_sidebar( 'leaderboard-header' );
			echo '</aside>';
		endif;

		get_template_part( 'partials/hero-slider' );

		get_template_part( 'partials/featured-posts-row' );

		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'watermark-theme' ),
				'after'  => '</div>',
			)
		);
	?>

