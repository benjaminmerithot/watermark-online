<div class="columns">
	<div id="wpbdp-categories" class="column is-3-desktop">
		<div class="list__header has-text-centered has-background-grey-med is-size-6 py-4 px-2">Categories</div>
		<?php wpbdp_the_directory_categories(); ?>
	</div>

	<?php if ( $listings ) : ?>
		<div class="column">
			<?php echo $listings; ?>
		</div>
	<?php endif; ?>
</div>
