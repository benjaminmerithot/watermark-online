<?php
$background_url = get_the_post_thumbnail_url( $post->ID, 'full-width' );
?>
<div class="teaser__background" style="background-image: url(<?php echo esc_url( $background_url); ?>);">
	<div class="container">
		<div class="teaser teaser--latest media">
			<?php // TODO: add featured image as background image ?>
			<div class="media-left">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="teaser__image">
					<?php the_post_thumbnail('teaser_square'); ?>
				</a>
			</div>
			<div class="media-content">
				<div class="wrapper">
					<h2>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="teaser__link"><?php the_title(); ?></a>
					</h2>
					<?php the_excerpt(); ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="button button--wide">Read Online</a>
				</div>
			</div>
		</div>
	</div>
</div>
