<?php
/**
 * Migration script: Custom Author Byline to Contributors
 *
 * This script migrates all custom author bylines from the "Custom Author Byline" plugin
 * to the new Contributors custom post type.
 *
 * WARNING: This is a one-time migration script. Back up your database before running!
 *
 * Usage:
 * 1. Upload this file to your theme directory
 * 2. Access it via: yoursite.com/wp-content/themes/watermark-theme/migrate-custom-authors.php
 * 3. Follow the on-screen instructions
 * 4. Delete this file after migration is complete
 *
 * @package WatermarkTheme
 */

// Load WordPress
require_once( '../../../../wp-load.php' );

// Security check - only allow admins
if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( 'You do not have permission to access this page.' );
}

// Check if migration should run
$run_migration = isset( $_POST['run_migration'] ) && $_POST['run_migration'] === 'yes';
$dry_run = isset( $_POST['dry_run'] ) && $_POST['dry_run'] === 'yes';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Custom Author Byline Migration</title>
	<style>
		body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
		.notice { padding: 15px; margin: 20px 0; border-left: 4px solid #00a0d2; background: #f0f6fc; }
		.notice.warning { border-left-color: #ffb900; background: #fff8e5; }
		.notice.success { border-left-color: #46b450; background: #ecf7ed; }
		.notice.error { border-left-color: #dc3232; background: #fbeaea; }
		table { width: 100%; border-collapse: collapse; margin: 20px 0; }
		th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
		th { background: #f5f5f5; font-weight: 600; }
		.button { display: inline-block; padding: 10px 20px; background: #0073aa; color: white; text-decoration: none; border: none; border-radius: 3px; cursor: pointer; font-size: 14px; }
		.button:hover { background: #005177; }
		.button-secondary { background: #f0f0f1; color: #2c3338; }
		.button-secondary:hover { background: #dcdcde; }
		.stats { display: flex; gap: 20px; margin: 20px 0; }
		.stat-box { flex: 1; padding: 20px; background: #f0f6fc; border-radius: 5px; }
		.stat-number { font-size: 32px; font-weight: 700; color: #0073aa; }
		.stat-label { font-size: 14px; color: #646970; margin-top: 5px; }
	</style>
</head>
<body>
	<h1>Custom Author Byline → Contributors Migration</h1>

	<?php if ( ! $run_migration ) : ?>

		<div class="notice warning">
			<strong>⚠️ Important:</strong> Back up your database before running this migration!
		</div>

		<?php
		// Get statistics
		global $wpdb;

		// Count posts with custom author byline
		$posts_with_custom_author = $wpdb->get_results( "
			SELECT post_id, meta_value as author_name
			FROM {$wpdb->postmeta}
			WHERE meta_key = 'author'
			AND meta_value != ''
			ORDER BY meta_value
		" );

		// Get unique author names
		$unique_authors = array();
		foreach ( $posts_with_custom_author as $row ) {
			$author_name = trim( $row->author_name );
			if ( ! isset( $unique_authors[ $author_name ] ) ) {
				$unique_authors[ $author_name ] = 0;
			}
			$unique_authors[ $author_name ]++;
		}

		?>

		<div class="stats">
			<div class="stat-box">
				<div class="stat-number"><?php echo count( $posts_with_custom_author ); ?></div>
				<div class="stat-label">Posts with Custom Authors</div>
			</div>
			<div class="stat-box">
				<div class="stat-number"><?php echo count( $unique_authors ); ?></div>
				<div class="stat-label">Unique Custom Authors</div>
			</div>
		</div>

		<?php if ( ! empty( $unique_authors ) ) : ?>

			<h2>Preview: Authors to be Created</h2>
			<table>
				<thead>
					<tr>
						<th>Author Name</th>
						<th># of Posts</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $unique_authors as $name => $count ) : ?>
						<tr>
							<td><?php echo esc_html( $name ); ?></td>
							<td><?php echo $count; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<h2>What This Migration Will Do:</h2>
			<ol>
				<li><strong>Create Contributors:</strong> Create a new Contributor post for each unique custom author name</li>
				<li><strong>Map Posts:</strong> Link each post to its corresponding Contributor</li>
				<li><strong>Preserve Data:</strong> Keep the original "author" meta field for backup</li>
				<li><strong>Safe Migration:</strong> Your existing content will remain unchanged</li>
			</ol>

			<div class="notice">
				<strong>Note:</strong> The "Custom Author Byline" plugin can be deactivated after migration.
				The new Contributors system will handle author attribution.
			</div>

			<form method="post" style="margin: 30px 0;">
				<p>
					<button type="submit" name="dry_run" value="yes" class="button button-secondary" style="margin-right: 10px;">
						🔍 Dry Run (Preview Only)
					</button>
					<button type="submit" name="run_migration" value="yes" class="button" onclick="return confirm('Are you sure you want to run the migration? Make sure you have backed up your database!');">
						▶️ Run Migration
					</button>
				</p>
			</form>

		<?php else : ?>
			<div class="notice">
				<p><strong>No custom author bylines found.</strong> There's nothing to migrate.</p>
			</div>
		<?php endif; ?>

	<?php else : ?>

		<?php
		// Run the migration
		global $wpdb;

		$created_contributors = array();
		$updated_posts = array();
		$errors = array();

		// Get all posts with custom authors
		$posts_with_custom_author = $wpdb->get_results( "
			SELECT pm.post_id, pm.meta_value as author_name, pm2.meta_value as author_uri
			FROM {$wpdb->postmeta} pm
			LEFT JOIN {$wpdb->postmeta} pm2 ON pm.post_id = pm2.post_id AND pm2.meta_key = 'uri'
			WHERE pm.meta_key = 'author'
			AND pm.meta_value != ''
		" );

		// Group by author name
		$authors_to_create = array();
		foreach ( $posts_with_custom_author as $row ) {
			$author_name = trim( $row->author_name );
			if ( ! isset( $authors_to_create[ $author_name ] ) ) {
				$authors_to_create[ $author_name ] = array(
					'name' => $author_name,
					'uri' => $row->author_uri,
					'posts' => array(),
				);
			}
			$authors_to_create[ $author_name ]['posts'][] = $row->post_id;
		}

		// Create contributors and map posts
		foreach ( $authors_to_create as $author_data ) {
			$author_name = $author_data['name'];

			if ( $dry_run ) {
				echo "<p>Would create contributor: <strong>" . esc_html( $author_name ) . "</strong> and link " . count( $author_data['posts'] ) . " posts</p>";
				continue;
			}

			// Check if contributor already exists
			$existing = get_page_by_title( $author_name, OBJECT, 'contributor' );

			if ( $existing ) {
				$contributor_id = $existing->ID;
			} else {
				// Create new contributor
				$contributor_id = wp_insert_post( array(
					'post_type'    => 'contributor',
					'post_title'   => $author_name,
					'post_status'  => 'publish',
					'post_content' => '', // Could add bio here if you have it
				) );

				if ( is_wp_error( $contributor_id ) ) {
					$errors[] = "Failed to create contributor: " . $author_name;
					continue;
				}

				$created_contributors[] = $author_name;
			}

			// Link posts to this contributor
			foreach ( $author_data['posts'] as $post_id ) {
				// Add to contributor IDs array
				$existing_contributors = get_post_meta( $post_id, '_watermark_contributor_ids', true );
				if ( ! is_array( $existing_contributors ) ) {
					$existing_contributors = array();
				}

				// Add if not already there
				if ( ! in_array( $contributor_id, $existing_contributors ) ) {
					$existing_contributors[] = $contributor_id;
					update_post_meta( $post_id, '_watermark_contributor_ids', $existing_contributors );
					$updated_posts[] = $post_id;
				}
			}
		}

		if ( $dry_run ) {
			echo '<div class="notice success"><strong>Dry run complete!</strong> No changes were made to your database.</div>';
		} else {
			?>
			<div class="notice success">
				<h3>✅ Migration Complete!</h3>
				<ul>
					<li><strong><?php echo count( $created_contributors ); ?></strong> contributors created</li>
					<li><strong><?php echo count( array_unique( $updated_posts ) ); ?></strong> posts updated</li>
					<?php if ( ! empty( $errors ) ) : ?>
						<li style="color: #dc3232;"><strong><?php echo count( $errors ); ?></strong> errors occurred</li>
					<?php endif; ?>
				</ul>
			</div>

			<?php if ( ! empty( $errors ) ) : ?>
				<div class="notice error">
					<h4>Errors:</h4>
					<ul>
						<?php foreach ( $errors as $error ) : ?>
							<li><?php echo esc_html( $error ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $created_contributors ) ) : ?>
				<h3>Created Contributors:</h3>
				<ul>
					<?php foreach ( $created_contributors as $name ) : ?>
						<li><?php echo esc_html( $name ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<div class="notice">
				<h4>Next Steps:</h4>
				<ol>
					<li>Verify the migration by checking a few posts to ensure contributors are displaying correctly</li>
					<li>Visit <a href="<?php echo admin_url( 'edit.php?post_type=contributor' ); ?>">Contributors</a> to review and add photos/bios</li>
					<li>Once verified, you can deactivate the "Custom Author Byline" plugin</li>
					<li><strong>Delete this migration script file for security</strong></li>
				</ol>
			</div>

			<p>
				<a href="<?php echo admin_url( 'edit.php?post_type=contributor' ); ?>" class="button">View Contributors</a>
				<a href="<?php echo admin_url(); ?>" class="button button-secondary">Go to Dashboard</a>
			</p>
			<?php
		}
		?>

	<?php endif; ?>

</body>
</html>
