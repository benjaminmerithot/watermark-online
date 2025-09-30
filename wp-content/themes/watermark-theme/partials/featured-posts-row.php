<?php if ( have_rows( 'featured_posts_row' ) ) : ?>
	<section class="teaser__row">
		<ul class="teaser__items columns is-gapless">
			<?php
			while ( have_rows( 'featured_posts_row' ) ) :
				the_row();
				global $post;

				$post_object = get_sub_field( 'featured_post' );

				$post = $post_object;
				setup_postdata( $post );

				$args = [
					'post_id' => $post->ID,
					'image_size' => 'teaser-medium',
					'class' => 'teaser--medium teaser--column column',
				];
				watermark_display_teaser( $args );

				wp_reset_postdata();
			endwhile;
			?>
		</ul>
	</section>
<?php endif; ?>
