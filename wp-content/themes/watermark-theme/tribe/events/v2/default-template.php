<?php
/**
 * View: Default Template for Events
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/default-template.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 */

use Tribe\Events\Views\V2\Template_Bootstrap;

get_header(); ?>

	<main id="main" class="site-main" role="main">
		<div class="container">
			<?php if ( is_active_sidebar( 'leaderboard-header' ) ) : ?>
				<aside class="aside--header">
					<?php dynamic_sidebar( 'leaderboard-header' ); ?>
				</aside>
			<?php endif; ?>

			<div class="columns is-space-between">
				<div class="column is-8-desktop">
					<?php echo tribe( Template_Bootstrap::class )->get_view_html(); ?>
				</div>
				<div class="column is-3-desktop">
					<?php get_sidebar(); ?>
				</div>
			</div>

			<?php if ( is_active_sidebar( 'events-footer' ) && tribe_is_events_home() || tribe_is_list_view() || tribe_is_month() ) : ?>
				<aside class="aside--footer aside--events mb-6">
					<?php dynamic_sidebar( 'events-footer' ); ?>
				</aside>
			<?php endif; ?>
		</div>
	</main>
<?php get_footer(); ?>

