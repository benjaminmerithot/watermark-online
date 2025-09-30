<?php
/**
 * Template part for displaying a single post.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="meta">
			<div class="meta--header meta--category">
				<?php $cat_args = [
					'show_link_color' => true,
				]; ?>
				<?php watermark_print_post_category( $cat_args ); ?>
			</div>
		</div>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php $date_args = [
			'date_text' => ''
		]; ?>

		<div class="meta">
			<div class="meta--footer">
				<div class="meta__posted">
					<?php watermark_print_post_author(); ?>
					<span class="sep"></span>
					<?php watermark_print_post_date( $date_args ); ?>
				</div>
			</div>
		</div>
	</header>

	<figure class="entry__image image__cover">
		<?php watermark_display_post_image( 'article' ); ?>
	</figure>

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'watermark-theme' ),
					'after'  => '</div>',
				)
			);

			echo watermark_entry_footer();
		?>
	</div>
</article>
