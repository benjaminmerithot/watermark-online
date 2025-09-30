<?php

$heading = get_field( 'heading' ) ?: '';

$args = array(
	'post_type' 			=> 'post',
	'posts_per_page' 	=> 5,
	'post_status'    	=> 'publish',
);

$teaser_query = new WP_Query( $args ); ?>

<div class="teaser__list">

	<?php if ( $heading ) : ?>
		<h2 class="teaser__heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>

	<ul class="teaser__items">
		<?php

		foreach( $teaser_query->posts as $post ) :
			setup_postdata( $post );

			$post_id = $post->ID;

			$args = [
				'post_id' => $post_id,
				'image_size' => 'teaser-small',
				'class' => 'teaser--small',
				'show_byline' => false,
			];

			watermark_display_teaser( $args );
		endforeach;

		wp_reset_postdata();
		?>
	</ul>
</div>
