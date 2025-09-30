<?php
$blockAdType = isset( $blockAdType ) ? $blockAdType : 'sidebar-300x250';
$adSize = explode('-', $blockAdType);

if ( have_rows( 'ad_scripts', 'option' ) ) :
	echo '<li class="ad-block ad-block--' . $blockAdType . ' ad-block--' . $adSize[0] . '">';
	while ( have_rows( 'ad_scripts', 'option' ) ) :
		the_row();

		if ( $blockAdType === get_sub_field( 'ad_type' ) ) :
			echo get_sub_field( 'script_code' );
		endif;

	endwhile;
	echo '</li>';

endif;
