<?php

$category = watermark_get_post_category_ID();

$args = array(
	'posts_per_page' => 3,
	'post__not_in'   => array( get_the_ID() ),
	'category__in'   => $category,
	'no_found_rows'  => true,
);

$teaser_query = new WP_Query( $args );

foreach ( $teaser_query->posts as $post ) :
	setup_postdata( $post );

	$post_id = $post->ID;

	$args = array(
		'post_id' => $post_id,
		'class' => 'column teaser--column teaser--medium',
	);

	watermark_display_teaser( $args );

endforeach;

wp_reset_postdata();

