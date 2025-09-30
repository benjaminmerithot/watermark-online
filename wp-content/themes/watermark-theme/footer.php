		<footer class="footer__site has-background-black" role="contentinfo">
			<div class="footer__upper">
				<div class="container gutter">
					<div class="columns">
						<div class="column">
							<div class="footer__brand">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" rel="home" itemprop="url">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/watermark-logo-white.png" class="logo__image" alt="Watermark Logo" itemprop="logo" />
								</a>
							</div>
						</div>
						<div class="column is-8-desktop">
							<nav class="nav__footer columns is-flex-touch is-multiline" aria-label="<?php esc_attr_e( 'Footer Navigation', 'watermark-theme' ); ?>">
								<?php
								$menu_class = 'menu menu--footer column is-3-desktop is-half-touch';
									wp_nav_menu(
										array(
											'fallback_cb'    => false,
											'theme_location' => 'footer-column-1',
											'menu_id'        => 'footer-column-1',
											'menu_class'     => $menu_class,
											'container'      => false,
										)
									);
									wp_nav_menu(
										array(
											'fallback_cb'    => false,
											'theme_location' => 'footer-column-2',
											'menu_id'        => 'footer-column-2',
											'menu_class'     => $menu_class,
											'container'      => false,
										)
									);
									wp_nav_menu(
										array(
											'fallback_cb'    => false,
											'theme_location' => 'footer-column-3',
											'menu_id'        => 'footer-column-3',
											'menu_class'     => $menu_class,
											'container'      => false,
										)
									);
									wp_nav_menu(
										array(
											'fallback_cb'    => false,
											'theme_location' => 'footer-column-4',
											'menu_id'        => 'footer-column-4',
											'menu_class'     => $menu_class,
											'container'      => false,
										)
									);
								?>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<div class="footer__lower mt-6">
				<div class="container gutter">

					<?php if ( is_active_sidebar( 'footer' ) ) : ?>
						<div class="level">
							<?php dynamic_sidebar( 'footer' ); ?>
						</div>
					<?php endif; ?>

					<div class="footer__copyright">
						<p>&copy; <?php echo date('Y'); ?> Watermark Online. All rights reserved.</p>
					</div>
				</div>
			</div>
		</footer>

		<?php wp_footer(); ?>
	</div>
</body>
</html>
