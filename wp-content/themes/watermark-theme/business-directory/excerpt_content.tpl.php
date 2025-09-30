<?php if ( $images->thumbnail ) : ?>
  <?php echo $images->thumbnail->html; ?>
<?php endif; ?>

<div class="listing-details<?php echo esc_attr( $images->thumbnail ? '' : ' wpbdp-no-thumb' ); ?>">

	<h2><?php echo $fields->business_name->value; ?></h2>

	<?php if ( $fields->business_genre->value ) : ?>
		<div class="wpbdp-field-display wpbdp-field wpbdp-field-value">
			<span class="wpbdp-field-label">Listed in</span>
			<span class="wpbdp-field-value"><?php echo $fields->business_genre->value; ?></span>
		</div>
	<?php endif; ?>

	<?php if ( $fields->business_phone_number->value ) : ?>
		<div class="wpbdp-field-display wpbdp-field wpbdp-field-value">
			<span class="wpbdp-field-label">Phone Number:</span>
			<span class="wpbdp-field-value"><?php echo $fields->business_phone_number->value; ?></span>
		</div>
	<?php endif; ?>

	<?php if ( $fields->business_address->value ) : ?>
		<div class="wpbdp-field-display wpbdp-field wpbdp-field-value">
			<span class="wpbdp-field-value"><?php echo $fields->business_address->value; ?></span>
		</div>
	<?php endif; ?>

</div>
