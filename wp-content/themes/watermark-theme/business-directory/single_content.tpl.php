<?php
/**
 * Listing detail view rendering template
 *
 * @package BDP/Templates/Single Content
 */

?>
<h1><?php echo esc_html( $title ); ?></h1>

<div class="listing-columns">
	<?php if ( $images->main || $images->thumbnail ) : ?>
		<div class="main-image">
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $images->main ? $images->main->html : $images->thumbnail->html;
			?>
		</div>
	<?php endif; ?>

	<div class="listing-details cf<?php echo esc_attr( ( $images->main || $images->thumbnail ) ? '' : ' wpbdp-no-thumb' ); ?>">

		<?php if ( $fields->business_genre->value ) : ?>
			<div class="wpbdp-field-display wpbdp-field wpbdp-field-value">
				<span class="wpbdp-field-label">Category</span>
				<span class="wpbdp-field-value"><?php echo $fields->business_genre->value; ?></span>
			</div>
		<?php endif; ?>

		<?php if ( $fields->long_business_description->value ) : ?>
			<div class="wpbdp-field-display wpbdp-field wpbdp-field-value">
				<span class="wpbdp-field-label">Description</span>
				<p class="wpbdp-field-value"><?php echo $fields->long_business_description->value; ?></p>
			</div>
		<?php endif; ?>

		<?php if ( $fields->business_website_address->value ) : ?>
			<div class="wpbdp-field-display wpbdp-field wpbdp-field-value">
				<span class="wpbdp-field-label">Website</span>
				<span class="wpbdb-field-value"><?php echo $fields->business_website_address->value; ?></span>
			</div>
		<?php endif; ?>

		<?php if ( $fields->business_phone_number->value ) : ?>
			<div class="wpbdp-field-display wpbdp-field wpbdp-field-value">
				<span class="wpbdp-field-label">Phone</span>
				<span class="wpbdp-field-value"><?php echo $fields->business_phone_number->value; ?></span>
			</div>
		<?php endif; ?>

		<?php if ( $fields->business_address->value ) : ?>
			<div class="wpbdp-field-display wpbdp-field wpbdp-field-value">
				<span class="wpbdp-field-label">Address</span>
				<span class="wpbdp-field-value"><?php echo $fields->business_address->value; ?></span>
			</div>
		<?php endif; ?>

		<?php
			wpbdp_x_part( 'parts/listing-images' );
		?>
	</div>
</div>
