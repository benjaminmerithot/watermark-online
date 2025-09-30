<?php
$publications = get_field( 'publications' );

if ( $publications ) :
	?>

	<ul class="teaser__items columns is-gapless is-multiline is-flex-touch">
		<?php
		foreach ( $publications as $post ) :
			setup_postdata( $post );

			$post_id = $post->ID;

			$class = 'column teaser--column teaser--medium';
			$image_size = 'teaser-medium';

			$args = array(
				'post_id' => $post_id,
				'class' => $class,
				'image_size' => $image_size,
			);

			watermark_display_teaser( $args );

		endforeach;

		wp_reset_postdata();
		?>

	</ul>
<?php endif; ?>

