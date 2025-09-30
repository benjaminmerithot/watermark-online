<?php
$header = get_field( 'header' );
$content = get_field( 'content' );
$form_shortcode = get_field( 'form_shortcode' );
$color = get_field( 'color' );
$color_class = 'subscribe--' . $color;
?>

<div class="subscribe <?php echo $color_class; ?>">
	<div class="subscribe__inner">
		<h2 class="subscribe__heading"><?php echo $header; ?></h2>

		<p><?php echo $content; ?></p>
		<div class="subscribe__form">
			<?php echo do_shortcode( $form_shortcode ); ?>
		</div>
	</div>
</div>
