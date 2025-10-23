<?php
/**
 * Template Name: Staff and Contributors
 *
 * The template for displaying the staff and contributors page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package watermark-theme
 */
get_header(); ?>

	<main id="main" class="site-main page--staff-contributors" role="main">
		<div class="container">
			<?php if ( is_active_sidebar( 'leaderboard-header' ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( 'leaderboard-header' ); ?>
				</aside>
			<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

			<header class="page__header has-background-color has-background-white mb-5">
				<div class="inner has-background-white">
					<h1 class="page__title mb-3"><?php the_title(); ?></h1>
					<?php if ( get_the_content() ) : ?>
						<div class="page__description">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
				</div>
			</header>

			<div class="columns is-space-between">
				<div class="column is-8-desktop">
					<!-- Staff Section -->
					<section class="staff-section mb-6 has-background-white p-5">
						<h2 class="section__title mb-4">Staff</h2>

						<?php
						// Query users marked to show on staff page
						$staff_args = array(
							'meta_query' => array(
								array(
									'key'     => 'show_on_staff_page',
									'value'   => '1',
									'compare' => '='
								)
							),
							'orderby' => 'display_name',
							'order'   => 'ASC',
						);
						$staff_members = get_users( $staff_args );

						if ( ! empty( $staff_members ) ) : ?>
							<div class="columns is-multiline">
								<?php foreach ( $staff_members as $staff ) :
									$job_title = get_user_meta( $staff->ID, 'job_title', true );
									$avatar_url = get_avatar_url( $staff->ID, array( 'size' => 300 ) );
									?>
									<div class="column is-6-desktop is-12-tablet">
										<div class="staff-card">
											<div class="staff-card__image">
												<?php if ( $avatar_url ) : ?>
													<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $staff->display_name ); ?>" style="width: 100%; height: auto; aspect-ratio: 1/1; object-fit: cover;">
												<?php else : ?>
													<div style="width: 100%; aspect-ratio: 1/1; background-color: #ddd;"></div>
												<?php endif; ?>
											</div>
											<div class="staff-card__content mt-3">
												<h3 class="staff-card__name mb-1"><?php echo esc_html( $staff->display_name ); ?></h3>
												<?php if ( $job_title ) : ?>
													<p class="staff-card__title mb-2"><?php echo esc_html( $job_title ); ?></p>
												<?php endif; ?>
												<a href="<?php echo esc_url( get_author_posts_url( $staff->ID ) ); ?>" class="button button--small">Read Bio</a>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<p><em>No staff members to display.</em></p>
						<?php endif; ?>
					</section>

					<!-- Contributors Section -->
					<section class="contributors-section mb-6 has-background-white p-5">
						<h2 class="section__title mb-4">Contributors</h2>

						<?php
						// Query contributors marked to show on staff page
						$contributors_args = array(
							'post_type'      => 'contributor',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
							'meta_query'     => array(
								array(
									'key'     => 'show_on_staff_page',
									'value'   => '1',
									'compare' => '='
								)
							),
						);
						$contributors = get_posts( $contributors_args );

						if ( ! empty( $contributors ) ) : ?>
							<div class="columns is-multiline">
								<?php foreach ( $contributors as $contributor ) :
									$job_title = get_post_meta( $contributor->ID, 'job_title', true );
									$thumbnail_id = get_post_thumbnail_id( $contributor->ID );
									?>
									<div class="column is-6-desktop is-12-tablet">
										<div class="staff-card">
											<div class="staff-card__image">
												<?php if ( $thumbnail_id ) : ?>
													<?php echo get_the_post_thumbnail( $contributor->ID, 'medium', array( 'style' => 'width: 100%; height: auto; aspect-ratio: 1/1; object-fit: cover;' ) ); ?>
												<?php else : ?>
													<div style="width: 100%; aspect-ratio: 1/1; background-color: #ddd;"></div>
												<?php endif; ?>
											</div>
											<div class="staff-card__content mt-3">
												<h3 class="staff-card__name mb-1"><?php echo esc_html( $contributor->post_title ); ?></h3>
												<?php if ( $job_title ) : ?>
													<p class="staff-card__title mb-2"><?php echo esc_html( $job_title ); ?></p>
												<?php endif; ?>
												<a href="<?php echo esc_url( get_permalink( $contributor->ID ) ); ?>" class="button button--small">Read Bio</a>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<p><em>No contributors to display.</em></p>
						<?php endif; ?>
					</section>
				</div>

				<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
					<div class="column is-3-desktop">
						<aside class="aside--sidebar sidebar widget-area">
							<?php dynamic_sidebar( 'sidebar-1' ); ?>
						</aside>
					</div>
				<?php endif; ?>
			</div>

			<?php endwhile; ?>

			<?php if ( is_active_sidebar( 'leaderboard-footer' ) ) : ?>
				<aside class="aside--footer">
					<?php dynamic_sidebar( 'leaderboard-footer' ); ?>
				</aside>
			<?php endif; ?>
		</div>

	</main>

<?php get_footer(); ?>
