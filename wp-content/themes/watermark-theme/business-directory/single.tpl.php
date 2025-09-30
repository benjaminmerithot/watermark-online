<?php
/**
 * Template listing single view.
 *
 * Template Blocks: after
 *
 * @package BDP/Templates/Single
 */
?>

<div class="columns is-space-between">
	<div class="column is-8-desktop">
		<div id="<?php echo esc_attr( $listing_css_id ); ?>" class="<?php echo esc_attr( $listing_css_class ); ?>">
			<?php
			wpbdp_x_part(
				'parts/listing-buttons',
				array(
					'listing_id' => $listing_id,
					'view'       => 'single',
				)
			);

			wpbdp_x_part( 'single_content' );
			?>
		</div>

		<?php echo $blocks['after']; ?>

	</div>
	<div class="column is-3-desktop">
		<?php get_sidebar(); ?>
	</div>
</div>

