<?php
/**
 * Template Name: Authors
 *
 * The template for displaying the authors page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */
get_header(); ?>

	<main id="main" class="site-main" role="main">
		<div class="container">
			<?php if ( is_active_sidebar( 'leaderboard-header' ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( 'leaderboard-header' ); ?>
				</aside>
			<?php endif; ?>

			<header class="page__header has-background-color has-background-white mb-0">
				<div class="inner has-background-white">
					<h1 class="page__title mb-0"><?php the_title(); ?></h1>
				</div>
			</header>

			<div class="columns is-space-between has-background-white">
				<div class="author__list column is-8-desktop">
					<?php

					$number = 8;
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$offset = ($paged - 1) * $number;


				 	$args = [
						'has_published_posts' => ['post'],
					];

					$authors = get_users( $args );
					$total_authors = count( $authors );

					$args = [
						'has_published_posts' => ['post'],
						'number' => $number,
						'offset' => $offset,
						'fields' => [
							'ID',
							'display_name',
						],
					];

					$query = get_users( $args );
					$total_query = count( $query );

					$total_pages = intval( $total_authors / $number ) + 1;

					?>

					<?php foreach ( $query as $author ) : ?>
						<?php $description = get_user_meta( $author->ID, 'description', true ) ?: null; ?>

						<div class="author__item media">
							<div class="media-left">
								<?php echo get_avatar( $author->ID, 235 ); ?>
							</div>
							<div class="media-content">
								<h2><?php echo $author->display_name; ?></h2>
								<?php if ( $description ) : ?>
									<p><?php echo $description; ?></p>
								<?php endif; ?>
								<a href="<?php echo get_author_posts_url( $author->ID ); ?>" class="button button--wide">Learn More</a>
							</div>
						</div>

					<?php endforeach; ?>

					<?php if ( $total_authors > $total_query ) :
						$current_page = max( 1, get_query_var('paged') );
						 echo '<nav class="pagination" aria-label="' . esc_attr( 'numeric pagination', 'watermark-theme' ) . '">';

						 echo paginate_links( [
							'base' => get_pagenum_link(1) . '%_%',
							'format' => 'page/%#%/',
							'current' => $current_page,
							'total' => $total_pages,
							'prev_text' => __( '&larr;', 'watermark-theme' ),
							'next_text' => __( '&rarr;', 'watermark-theme' ),
						] );
						echo '</nav>';

					endif; ?>

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

	</main>

<?php get_footer(); ?>
