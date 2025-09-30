<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package watermark-theme
 */
global $wp_query;
$result_count = $wp_query->found_posts;

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<div class="container">

			<?php if ( is_active_sidebar( 'leaderboard-header' ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( 'leaderboard-header' ); ?>
				</aside>
			<?php endif; ?>

			<div class="columns">
				<div class="column">
					<?php if ( have_posts() ) : ?>

						<header class="page-header mb-6">
							<h1 class="page-title is-size-4">
								<span class="has-text-weight-bold"><?php echo $result_count; ?></span> items matched your search for <span class="has-text-weight-bold"><?php echo get_search_query(); ?></span>
							</h1>
							<?php get_search_form(); ?>
						</header><!-- .page-header -->

						<section class="teaser__list teaser--archives teaser--search">
							<ul class="teaser__items">
								<?php
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									/**
										* Run the loop for the search to output the results.
										* If you want to overload this in a child theme then include a file
										* called content-search.php and that will be used instead.
										*/
									get_template_part( 'partials/teaser-loop' );
								endwhile;
								?>
							</ul>

							<?php
								watermark_numeric_pagination();

							else :
								get_template_part( 'partials/content', 'none' ); ?>

						</section>
						<?php	endif;?>
				</div>

				<div class="column is-3-desktop">
					<?php get_sidebar(); ?>
				</div>
			</div>

			<?php if ( is_active_sidebar( 'leaderboard-footer' ) ) : ?>
				<aside class="aside--footer">
					<?php dynamic_sidebar( 'leaderboard-footer' ); ?>
				</aside>
			<?php endif; ?>

		</div>

	</main><!-- #main -->

<?php get_footer(); ?>
