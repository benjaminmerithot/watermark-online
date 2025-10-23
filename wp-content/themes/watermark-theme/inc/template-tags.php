<?php
/**
 * Custom template tags for this theme.
 *
 * @package watermark-theme
 */

 if ( ! function_exists( 'watermark_print_post_date' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function watermark_print_post_date( $args = [] ) {

		// Set defaults.
		$defaults = [
			'post_id'     => null,
			'date_text'   => esc_html__( 'Posted on', 'watermark-theme' ),
			'date_format' => get_option( 'date_format' ),
		];

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		?>
		<span class="posted-on">
			<?php echo esc_html( $args['date_text'] . ' ' ); ?>
			<a href="<?php echo esc_url( get_permalink( $args[ 'post_id' ] ) ); ?>" rel="bookmark"><time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $args[ 'post_id' ] ) ); ?>"><?php echo esc_html( get_the_time( $args['date_format'], $args[ 'post_id' ] ) ); ?></time></a>
		</span>
		<?php
	}
endif;

if ( ! function_exists( 'watermark_posted_ago' ) ) :

	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function watermark_posted_ago( $post_id = null ) {

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s ago', 'post date', 'watermark-theme' ),
			human_time_diff( get_the_time( 'U', $post_id ), current_time( 'timestamp' ) )
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'watermark_print_post_author' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 *
	 * @param array $args Configuration args.
	 */
	function watermark_print_post_author( $args = [] ) {

		// Set defaults.
		$defaults = [
			'author_text' => esc_html__( 'By', 'watermark-theme' ),
		];

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		// Check for contributor first.
		$contributor = watermark_get_post_contributor();
		$custom_author = get_post_meta( get_the_ID(), 'author', true ) ?: null;

		?>
		<span class="post-author">
			<?php echo esc_html( $args['author_text'] . ' ' ); ?>
			<span class="author vcard">
				<?php if ( $contributor ) : ?>
					<a class="url fn n" href="<?php echo esc_url( get_permalink( $contributor->ID ) ); ?>"><?php echo esc_html( $contributor->post_title ); ?></a>
				<?php elseif ( $custom_author ) : ?>
					<?php echo esc_html( $custom_author ); ?>
				<?php else : ?>
					<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
				<?php endif; ?>
			</span>
		</span>
		<?php
	}
endif;


if ( ! function_exists( 'watermark_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories and tags
	 */
	function watermark_entry_footer() {
		// Hide tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'watermark-theme' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<div class="entry__footer"><div class="tag__links"><span class="tag__header">Tags:</span> ' . esc_html__( '%1$s', 'watermark-theme' ) . '</div></div>', $tags_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'watermark_print_post_category' ) ) :
	/**
	 * Display the main category.
	 *
	 * @return string The main category HTML.
	 */
	function watermark_print_post_category( $args = [] ) {

		// Set defaults.
		$defaults = [
			'post_id' => null,
			'show_link_color' => false,
		];

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		$category = get_category( watermark_get_post_category_ID( $args[ 'post_id' ] ) );

		if ( ! $category ) {
			return;
		}

		$category_link = get_category_link( $category->term_id );
		$category_name = $category->name;
		$category_color = get_term_meta( $category->term_id, 'category_color', true );
		$category_link_color = $args[ 'show_link_color' ] ? true : false;
		$category_class = 'teaser__category teaser--' . $category_color . ( $category_link_color ? ' teaser--link-' . $category_color : '' );
		?>

		<a href="<?php echo esc_url( $category_link ); ?>" class="<?php echo esc_attr( $category_class ); ?>"><span><?php echo esc_html( $category_name ); ?></span></a>

		<?php
	}
endif;


/**
 * Get the main category ID.
 *
 * @return int The main category ID.
 */
function watermark_get_post_category_ID( $post_id = null ) {
	$categories = get_the_category( $post_id );

	if ( empty( $categories ) ) {
		return false;
	}

	$category = $categories[0];
	return $category->term_id;
}


/**
 * Echo an image, with a fallback to a default image.
 *
 * @param string $size The image size to use. Default is 'thumbnail'.
 *
 * @return string The image HTML.
 */
function watermark_display_post_image( $size = 'thumbnail' ) {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $size );
		return false;
	}

	$attached_image_url = watermark_get_attached_image_url( $size );

	// Else, display an attached image or placeholder.
	?>
	<img src="<?php echo esc_url( $attached_image_url ); ?>" alt="<?php echo esc_html( get_the_title() ); ?>" class="attachment-thumbnail wp-post-image">
	<?php
}

/**
 * Get the URL of an attached image, or a placeholder image.
 *
 * @param string $size The image size to use. Default is 'thumbnail'.
 *
 * @return string The image URL.
 */
function watermark_get_attached_image_url( $size = 'thumbnail' ) {
	$attached_image_url = get_template_directory_uri() . '/assets/images/placeholder.png';

	// If there's an attached image, use that.
	$attached_image = get_attached_media( 'image' );
	if ( ! empty( $attached_image ) ) {
		$attached_image = array_shift( $attached_image );
		$attached_image_url = wp_get_attachment_image_url( $attached_image->ID, $size );
	}

	return $attached_image_url;
}

/**
 * Display a teaser
 *
 * @param array $args Teaser defaults.
 */
function watermark_display_teaser( $args = [] ) {
	$defaults = [
		'post_id' => null,
		'image' => true,
		'image_size' => 'teaser',
		'class' => '',
		'show_byline' => true,
	];

	$args = wp_parse_args( $args, $defaults );
	?>

	<li class="<?php echo esc_attr( $args['class'] ); ?> teaser media">
		<?php if ( $args['image'] ) : ?>
			<div class="media-left">
				<a href="<?php echo esc_url( get_permalink( $args['post_id']) ); ?>" class="teaser__image">
					<?php echo get_the_post_thumbnail( $args['post_id'], $args['image_size'] ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="media-content">
			<div class="wrapper">
				<div class="meta">
					<span class="meta--category">
						<?php $cat_args = [
							'post_id' => $args['post_id'],
						]; ?>
						<?php watermark_print_post_category( $cat_args ); ?>
					</span>
					<?php if ( ! $args['show_byline'] ) : ?>
						<span class="sep"> / </span>
						<span class="meta--date"><?php watermark_posted_ago( $args['post_id'] ); ?></span>
					<?php endif; ?>
				</div>
				<h3 class="teaser__title">
					<a href="<?php echo esc_url( get_permalink( $args['post_id'] ) ); ?>" class="teaser__link">
						<?php echo esc_html( get_the_title( $args['post_id'] ) ); ?>
					</a>
				</h3>
			</div>

			<?php if ( $args['show_byline'] ) : ?>
				<?php $date_args = [
					'post_id' => $args['post_id'],
					'date_text' => null,
					'date_format' => 'M d, Y',
				]; ?>

				<?php $author_args = [
					'author_text' => null,
				]; ?>

				<div class="meta meta--footer">
					<?php watermark_print_post_date( $date_args ); ?>
					<span class="sep"> / </span>
					<?php watermark_print_post_author( $author_args ); ?>
				</div>
			<?php endif; ?>
		</div>
	</li>
	<?php
}

/**
 * Displays numeric pagination on archive pages
 *
 * @param array 		$args 	Array of parameters for the pagination.
 * @param WP_Query 	$query 	The Query object. Only needed if you're using a custom query.
 */
function watermark_numeric_pagination( $args = [], $query = null ) {
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	// Make the pagination work with custom queries.
	$total_pages = isset( $query->max_num_pages ) ? $query->max_num_pages : 1;

	$defaults = array(
		'prev_text' => __( '&larr;', 'watermark-theme' ),
		'next_text' => __( '&rarr;', 'watermark-theme' ),
		'mid_size' 	=> 4,
		'total' 		=> $total_pages,
	);

	$args = wp_parse_args( $args, $defaults );

	if ( null === paginate_links( $args ) ) {
		return;
	}
	?>

	<nav class="pagination" aria-label="<?php echo esc_attr_e( 'numeric pagination', 'watermark' ); ?>">
		<?php echo paginate_links( $args ); ?>
	</nav>

	<?php
}
