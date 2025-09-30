<?php
/**
 * Template part for displaying page content in page-blog.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */

?>

<div <?php post_class(); ?>>

	<div class="entry-content">
		<?php
			the_content();
		?>
	</div>

</div>
