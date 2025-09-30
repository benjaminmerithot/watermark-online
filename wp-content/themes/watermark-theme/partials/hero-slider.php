<?php if ( have_rows( 'hero_slides' ) ) : ?>
<div class="carousel" data-carousel>
	<?php
	// $count = 0;
	while ( have_rows( 'hero_slides' ) ) :
		the_row();
		global $post;

		$post_object = get_sub_field( 'hero_post' );
		// $active = ( $count < 1 ) ? 'is-active' : '';

		$post = $post_object;

		setup_postdata( $post );

		$background_image = get_the_post_thumbnail_url( $post->ID, 'full-width' );

		$title = get_the_title( $post->ID );
		$link = get_permalink( $post->ID );
		$post_date = get_the_date( 'M d, Y', $post->ID );
		?>

		<div class="carousel__slide" style="background-image: url(<?php echo esc_url( $background_image ); ?>);">
			<div class="container">
				<div class="carousel__content">
					<div class="carousel__category">
						<?php watermark_print_post_category( $args = [ 'post_id' => $post->ID ] ); ?>
					</div>
					<h2 class="carousel__title">
						<a href="<?php echo esc_url( $link ); ?>" class="carousel__link">
							<?php echo esc_html( $title ); ?>
						</a>
					</h2>
					<div class="carousel__meta">
						<span class="carousel__date"><?php echo esc_html( $post_date ); ?></span>
					</div>
					<div class="carousel__button">
						<a href="<?php echo esc_url( $link ); ?>" class="button button--white button--wide">
							<?php esc_html_e( 'Read More', 'watermark' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>

		<?php
		// $count++;
		wp_reset_postdata();
	endwhile;
	?>
</div>
<div class="carousel__teasers columns mb-0 is-hidden-touch" data-carousel-nav>
	<?php
	// $count = 0;
	while ( have_rows( 'hero_slides' ) ) :
		the_row();
		global $post;

		$post_object = get_sub_field( 'hero_post' );
		// $active = ( $count < 1 ) ? 'is-active' : '';

		$post = $post_object;

		setup_postdata( $post );

		$title = get_the_title( $post->ID );
		$link = get_permalink( $post->ID );
		?>

		<div class="carousel__teaser column">
			<div class="carousel__content">
				<div class="carousel__category">
					<?php watermark_print_post_category( $args = [ 'post_id' => $post->ID ] ); ?>
				</div>
				<h3 class="carousel__title">
					<a href="<?php echo esc_url( $link ); ?>" class="carousel__link">
						<?php echo esc_html( $title ); ?>
					</a>
				</h3>
			</div>
		</div>

		<?php
		// $count++;
		wp_reset_postdata();
	endwhile;
	?>
</div>
<?php endif; ?>
