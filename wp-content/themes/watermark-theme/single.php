<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package watermark-theme
 */

get_header();

$main_category = get_category( watermark_get_post_category_ID() );
$main_category_link = get_category_link( $main_category->term_id );
$main_category_name = $main_category->name;
if ( has_category('en-espanol') ) {
	$leaderboard_header = 'leaderboard-header-es';
	$leaderboard_footer = 'leaderboard-footer-es';
	$sidebar = 'sidebar-es';
} else {
	$leaderboard_header = 'leaderboard-header';
	$leaderboard_footer = 'leaderboard-footer';
	$sidebar = 'sidebar-1';
}
?>

	<main id="main" class="site-main" role="main">

		<div class="container">
			<?php if ( is_active_sidebar( $leaderboard_header ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( $leaderboard_header ); ?>
				</aside>
			<?php endif; ?>

			<div class="columns is-space-between">
				<div class="column is-8-desktop">
					<?php
						while ( have_posts() ) :
							the_post();

							if ( 'post' !== get_post_type()) :
								get_template_part( 'partials/content', get_post_format() );
							else :
								get_template_part( 'partials/content', 'post' );
							endif;

						endwhile; // End of the loop.
					?>

					<section class="teaser__row">
						<header class="teaser__header level">
							<h2 class="teaser__heading">More in <?php echo $main_category_name; ?></h2>
							<a href="<?php echo $main_category_link; ?>" class="teaser--more is-hidden-touch">
								<span>See More</span>
								<svg class="icon-svg" role="img">
									<use xlink:href="#arrow-right"></use>
								</svg>
							</a>
						</header>
						<ul class="teaser__items columns is-gapless">
							<?php get_template_part( 'partials/teaser', 'row' ); ?>
						</ul>
						<div class="teaser__footer is-hidden-desktop mt-5 has-text-centered">
							<a href="<?php echo $main_category_link; ?>" class="teaser--more">
								<span>See More</span>
								<svg class="icon-svg" role="img">
									<use xlink:href="#arrow-right"></use>
								</svg>
							</a>
						</div>
					</section>
				</div>

				<?php if ( is_active_sidebar( $sidebar ) ) : ?>
					<div class="column is-3-desktop">
						<aside class="aside--sidebar sidebar widget-area">
							<?php dynamic_sidebar( $sidebar ); ?>
						</aside>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( is_active_sidebar( $leaderboard_footer ) ) : ?>
				<aside class="aside--footer">
					<?php dynamic_sidebar( $leaderboard_footer ); ?>
				</aside>
			<?php endif; ?>

		</div>
	</main>
<?php get_footer(); ?>
