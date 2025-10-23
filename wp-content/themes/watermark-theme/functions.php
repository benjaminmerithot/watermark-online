<?php
/**
 * WP Theme constants and setup functions
 *
 * @package WatermarkTheme
 */

/**
 * Theme version.
 * @since 0.1.0
 */
define( 'WATERMARK_THEME_VERSION', wp_get_theme()->get( 'Version' ) );


if ( ! function_exists( 'watermark_theme_setup' ) ) :

	function watermark_theme_setup() {

		add_editor_style( '/style-editor.css' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		// Add additional image sizes.
		add_image_size( 'full-width', 1920, 1080, false );
		add_image_size( 'background', 1170, 732, true );
		add_image_size( 'article', 872, 490, true );
		add_image_size( 'teaser', 230, 120, true );
		add_image_size( 'teaser-small', 80, 80, false );
		add_image_size( 'teaser-medium', 305, 160, true );
		add_image_size( 'teaser-large-rect', 594, 310, true );
		add_image_size( 'teaser-large', 536, 350, true );
		add_image_size( 'teaser-square', 285, 285, true );

		// This theme uses wp_nav_menu() in multiple locations.
		register_nav_menus( array(
			'primary' 			=> esc_html__( 'Primary Menu', 'watermark-theme' ),
			'header-top' 		=> esc_html__( 'Header Top Menu', 'watermark-theme' ),
			'footer-column-1' 	=> esc_html__( 'Footer Column 1 Menu', 'watermark-theme' ),
			'footer-column-2' 	=> esc_html__( 'Footer Column 2 Menu', 'watermark-theme' ),
			'footer-column-3' 	=> esc_html__( 'Footer Column 3 Menu', 'watermark-theme' ),
			'footer-column-4' 	=> esc_html__( 'Footer Column 4 Menu', 'watermark-theme' ),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'watermark_theme_setup' );

/**
 * Disable block patterns from the WP pattern directory.
 */
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function watermark_theme_widgets_init() {

	// Define sidebars.
	$sidebars = array(
		'sidebar-1' => array(
			'name'          => esc_html__( 'Sidebar', 'watermark-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'category-sidebar' => array(
			'name'          => esc_html__( 'Category Sidebar', 'watermark-theme' ),
			'id'            => 'category-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'pub-specialty' => array(
			'name'          => esc_html__( 'Specialty Publications', 'watermark-theme' ),
			'id'            => 'pub-specialty',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'leaderboard-header' => array(
			'name'          => esc_html__( 'Leaderboard Header', 'watermark-theme' ),
			'id'            => 'leaderboard-header',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'leaderboard-footer' => array(
			'name'          => esc_html__( 'Leaderboard Footer', 'watermark-theme' ),
			'id'            => 'leaderboard-footer',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'leaderboard-pub' => array(
			'name'          => esc_html__( 'Leaderboard Publication', 'watermark-theme' ),
			'id'            => 'leaderboard-pub',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'events-footer' => array(
			'name'          => esc_html__( 'Events Footer', 'watermark-theme' ),
			'id'            => 'events-footer',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'footer' => array(
			'name'          => esc_html__( 'Footer', 'watermark-theme' ),
			'id'            => 'footer',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'leaderboard-header-es' => array(
			'name'          => esc_html__( 'Leaderboard Header - Spanish', 'watermark-theme' ),
			'id'            => 'leaderboard-header-es',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'leaderboard-footer-es' => array(
			'name'          => esc_html__( 'Leaderboard Footer - Spanish', 'watermark-theme' ),
			'id'            => 'leaderboard-footer-es',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
		'sidebar-es' => array(
			'name'          => esc_html__( 'Sidebar - Spanish', 'watermark-theme' ),
			'id'            => 'sidebar-es',
			'description'   => esc_html__( 'Add widgets here.', 'watermark-theme' ),
		),
	);

	// Loop through each sidebar and register it.
	foreach ( $sidebars as $sidebar ) {
		register_sidebar(
			array(
				'name'          => $sidebar['name'],
				'id'            => $sidebar['id'],
				'description'   => $sidebar['description'],
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'watermark_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function watermark_theme_scripts() {
	/**
	 * If WP is in script debug, or we pass ?script_debug in a URL - set debug to true.
	 */
	$debug = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) || ( isset( $_GET['script_debug'] ) ) ? true : false; // WPCS: CSRF OK.

	$suffix = ( true === $debug ) ? '' : '.min';

	// Enqueue Typekit Fonts.
	wp_enqueue_style( 'watermark-fonts', '//use.typekit.net/hnz0skw.css', [] );

	// Enqueue main stylesheet.
	wp_enqueue_style( 'watermark-style', get_stylesheet_directory_uri() . '/style' . $suffix . '.css', [], WATERMARK_THEME_VERSION );
	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/assets/css/slick.css', [], WATERMARK_THEME_VERSION );

	// Enqueue main JS file.
	wp_enqueue_script( 'watermark-script', get_template_directory_uri() . '/assets/scripts/script' . $suffix . '.js', ['jquery'], WATERMARK_THEME_VERSION, true );
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/scripts/slick.min.js', ['jquery'], WATERMARK_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'watermark_theme_scripts' );


if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page();
}

/**
 * Register blocks.
 */
function watermark_register_acf_blocks() {
	register_block_type( __DIR__ . '/blocks/ad-script' );
	register_block_type( __DIR__ . '/blocks/category-group' );
	register_block_type( __DIR__ . '/blocks/featured-category' );
	register_block_type( __DIR__ . '/blocks/latest-posts' );
	register_block_type( __DIR__ . '/blocks/posts-group' );
	register_block_type( __DIR__ . '/blocks/specialty-pub' );
}
add_action( 'init', 'watermark_register_acf_blocks' );

function watermark_distribution_shortcode() {
	return '<p class="my-5 has-text-centered"><a href="/distribution-map/"><span class="is-uppercase" style="font-size: 0.875rem; line-height: 1.2;">Looking for a print copy?</span><br><span>Click here to find a distribution site nearest you!</span></a></p>';
}
add_shortcode( 'distribution', 'watermark_distribution_shortcode' );

/**
 * Theme template tags.
 */
require get_template_directory() . '/inc/template-tags.php';

add_filter('tec_events_custom_tables_v1_db_transactions_supported', function() { return false; });

/**
 * Register Contributors custom post type.
 */
function watermark_register_contributors_post_type() {
	$labels = array(
		'name'                  => _x( 'Contributors', 'Post type general name', 'watermark-theme' ),
		'singular_name'         => _x( 'Contributor', 'Post type singular name', 'watermark-theme' ),
		'menu_name'             => _x( 'Contributors', 'Admin Menu text', 'watermark-theme' ),
		'name_admin_bar'        => _x( 'Contributor', 'Add New on Toolbar', 'watermark-theme' ),
		'add_new'               => __( 'Add New', 'watermark-theme' ),
		'add_new_item'          => __( 'Add New Contributor', 'watermark-theme' ),
		'new_item'              => __( 'New Contributor', 'watermark-theme' ),
		'edit_item'             => __( 'Edit Contributor', 'watermark-theme' ),
		'view_item'             => __( 'View Contributor', 'watermark-theme' ),
		'all_items'             => __( 'All Contributors', 'watermark-theme' ),
		'search_items'          => __( 'Search Contributors', 'watermark-theme' ),
		'parent_item_colon'     => __( 'Parent Contributors:', 'watermark-theme' ),
		'not_found'             => __( 'No contributors found.', 'watermark-theme' ),
		'not_found_in_trash'    => __( 'No contributors found in Trash.', 'watermark-theme' ),
		'featured_image'        => _x( 'Contributor Photo', 'Overrides the "Featured Image" phrase', 'watermark-theme' ),
		'set_featured_image'    => _x( 'Set contributor photo', 'Overrides the "Set featured image" phrase', 'watermark-theme' ),
		'remove_featured_image' => _x( 'Remove contributor photo', 'Overrides the "Remove featured image" phrase', 'watermark-theme' ),
		'use_featured_image'    => _x( 'Use as contributor photo', 'Overrides the "Use as featured image" phrase', 'watermark-theme' ),
		'archives'              => _x( 'Contributor archives', 'The post type archive label', 'watermark-theme' ),
		'insert_into_item'      => _x( 'Insert into contributor', 'Overrides the "Insert into post" phrase', 'watermark-theme' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this contributor', 'Overrides the "Uploaded to this post" phrase', 'watermark-theme' ),
		'filter_items_list'     => _x( 'Filter contributors list', 'Screen reader text for the filter links', 'watermark-theme' ),
		'items_list_navigation' => _x( 'Contributors list navigation', 'Screen reader text for the pagination', 'watermark-theme' ),
		'items_list'            => _x( 'Contributors list', 'Screen reader text for the items list', 'watermark-theme' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'contributor' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-groups',
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'contributor', $args );
}
add_action( 'init', 'watermark_register_contributors_post_type' );

/**
 * Add meta box for selecting contributor on posts.
 */
function watermark_add_contributor_meta_box() {
	add_meta_box(
		'watermark_contributor_meta_box',
		__( 'Article Contributors', 'watermark-theme' ),
		'watermark_render_contributor_meta_box',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'watermark_add_contributor_meta_box' );

/**
 * Render the contributor meta box.
 */
function watermark_render_contributor_meta_box( $post ) {
	wp_nonce_field( 'watermark_contributor_meta_box', 'watermark_contributor_meta_box_nonce' );

	$selected_contributors = get_post_meta( $post->ID, '_watermark_contributor_ids', true );
	if ( ! is_array( $selected_contributors ) ) {
		$selected_contributors = array();
	}

	$contributors = get_posts( array(
		'post_type'      => 'contributor',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );

	echo '<p>' . __( 'Override author with contributors (select one or more):', 'watermark-theme' ) . '</p>';
	echo '<div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 8px; background: #fff;">';

	if ( ! empty( $contributors ) ) {
		foreach ( $contributors as $contributor ) {
			$checked = in_array( $contributor->ID, $selected_contributors ) ? 'checked' : '';
			printf(
				'<label style="display: block; margin-bottom: 8px;"><input type="checkbox" name="watermark_contributor_ids[]" value="%s" %s> %s</label>',
				esc_attr( $contributor->ID ),
				$checked,
				esc_html( $contributor->post_title )
			);
		}
	} else {
		echo '<p><em>' . __( 'No contributors found. Create contributors first.', 'watermark-theme' ) . '</em></p>';
	}

	echo '</div>';
	echo '<p style="margin-top: 10px;"><small>' . __( 'Leave unchecked to use the post author.', 'watermark-theme' ) . '</small></p>';
}

/**
 * Save the contributor meta box data.
 */
function watermark_save_contributor_meta_box( $post_id ) {
	// Check if our nonce is set and verify it.
	if ( ! isset( $_POST['watermark_contributor_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['watermark_contributor_meta_box_nonce'], 'watermark_contributor_meta_box' ) ) {
		return;
	}

	// If this is an autosave, don't do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Save the contributor IDs.
	if ( isset( $_POST['watermark_contributor_ids'] ) && is_array( $_POST['watermark_contributor_ids'] ) ) {
		$contributor_ids = array_map( 'intval', $_POST['watermark_contributor_ids'] );
		update_post_meta( $post_id, '_watermark_contributor_ids', $contributor_ids );
	} else {
		delete_post_meta( $post_id, '_watermark_contributor_ids' );
	}
}
add_action( 'save_post', 'watermark_save_contributor_meta_box' );

/**
 * Get the contributors for a post.
 *
 * @param int $post_id Post ID. Default is current post.
 * @return array|false Array of contributor post objects or false if none set.
 */
function watermark_get_post_contributors( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$contributor_ids = get_post_meta( $post_id, '_watermark_contributor_ids', true );

	if ( ! empty( $contributor_ids ) && is_array( $contributor_ids ) ) {
		$contributors = array();
		foreach ( $contributor_ids as $contributor_id ) {
			$contributor = get_post( $contributor_id );
			if ( $contributor && $contributor->post_status === 'publish' ) {
				$contributors[] = $contributor;
			}
		}
		return ! empty( $contributors ) ? $contributors : false;
	}

	return false;
}

/**
 * Get the contributor for a post (backwards compatibility - returns first contributor).
 *
 * @param int $post_id Post ID. Default is current post.
 * @return WP_Post|false Contributor post object or false if none set.
 */
function watermark_get_post_contributor( $post_id = null ) {
	$contributors = watermark_get_post_contributors( $post_id );
	return $contributors ? $contributors[0] : false;
}

/**
 * Display the contributor(s) or author name.
 *
 * @param int $post_id Post ID. Default is current post.
 * @return string Contributor(s) or author name.
 */
function watermark_get_author_name( $post_id = null ) {
	$contributors = watermark_get_post_contributors( $post_id );

	if ( $contributors ) {
		$names = array();
		foreach ( $contributors as $contributor ) {
			$names[] = $contributor->post_title;
		}
		return implode( ', ', $names );
	}

	return get_the_author();
}

/**
 * Display the contributor or author link.
 *
 * @param int $post_id Post ID. Default is current post.
 * @return string Contributor or author link.
 */
function watermark_get_author_link( $post_id = null ) {
	$contributor = watermark_get_post_contributor( $post_id );

	if ( $contributor ) {
		return get_permalink( $contributor->ID );
	}

	return get_author_posts_url( get_the_author_meta( 'ID' ) );
}
