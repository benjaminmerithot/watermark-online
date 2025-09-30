<?php
/**
 * The template for displaying the search form.
 *
 * @package watermark-theme
 */

?>

<form method="get" class="search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-field"><span class="visually-hidden"><?php esc_html_e( 'To search this site, enter a search term', 'watermark-theme' ); ?></span></label>
	<div class="field has-addons">
		<div class="control is-expanded">
			<input class="input" id="search-field" type="text" name="s" value="<?php echo get_search_query(); ?>" aria-required="false" autocomplete="off" placeholder="<?php echo esc_attr_e( 'Search', 'watermark-theme' ); ?>" />
		</div>
		<div class="control">
			<button id="search-submit" class="button button--icon">
				<span class="visually-hidden">Submit</span>
				<svg class="icon icon--search" role="img">
					<use xlink:href="#magnifying-glass"></use>
				</svg>
			</button>
		</div>
	</div>
</form>
