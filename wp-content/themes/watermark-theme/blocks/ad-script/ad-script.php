<?php

$blockAdType = get_field( 'ad_script' );
$adSize = explode('-', $blockAdType);

if ( have_rows( 'ad_scripts', 'option' ) ) :
	echo '<div class="ad-block ad-block--' . $blockAdType . ' ad-block--' . $adSize[0] . '">';
	while ( have_rows( 'ad_scripts', 'option' ) ) :
		the_row();

		if ( $blockAdType === get_sub_field( 'ad_type' ) ) :
			echo get_sub_field( 'script_code' );
		endif;

	endwhile;
	echo '</div>';

endif;
