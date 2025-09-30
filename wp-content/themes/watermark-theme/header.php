<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div class="page">
		<a href="#main" class="skip-link visually-hidden"><?php esc_html_e( 'Skip to content', 'watermark-theme' ); ?></a>
		<header class="header__site" role="banner">
			<div class="container">
				<div class="columns is-align-items-center">
					<div class="column">
						<div class="navbar-brand pt-3">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-item logo" rel="home" itemprop="url">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/watermark-logo.png" class="logo__image" alt="" itemprop="logo" />
							</a>
							<a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false" data-menu-toggle>
								<span aria-hidden="true"></span>
								<span aria-hidden="true"></span>
								<span aria-hidden="true"></span>
							</a>

						</div>

					</div>
					<div class="column is-10-widescreen is-9-desktop is-hidden-touch">
						<nav class="nav__top"  aria-label="<?php esc_attr_e( 'Header Top Navigation', 'watermark-theme' ); ?>">
							<?php
								wp_nav_menu(
									array(
										'fallback_cb'    => false,
										'theme_location' => 'header-top',
										'menu_id'        => 'header-menu',
										'menu_class'     => 'menu menu--header',
										'container'      => false,
									)
								);
							?>
						</nav>
						<div class="navbar">
							<!-- <div class="navbar-brand">

								<a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false" data-menu-toggle>
									<span aria-hidden="true"></span>
									<span aria-hidden="true"></span>
									<span aria-hidden="true"></span>
								</a>

							</div> -->
							<div class="navbar-menu" data-header-nav>
								<nav class="nav__primary" aria-label="<?php esc_attr_e( 'Main Navigation', 'watermark-theme' ); ?>">
									<?php
										wp_nav_menu(
											array(
												'fallback_cb'    => false,
												'theme_location' => 'primary',
												'menu_id'        => 'primary-menu',
												'menu_class'     => 'menu menu--main',
												'container'      => false,
											)
										);
									?>
								</nav>
							</div>
							<div class="navbar-end navbar__search">
								<div class="navbar-item">
									<div class="header__search" data-search-form>
										<?php get_search_form(); ?>
									</div>
									<button class="button button--icon" data-search-toggle>
										<svg class="icon icon--search" role="img">
											<use xlink:href="#magnifying-glass"></use>
										</svg>
										<svg class="icon icon--close" role="img">
											<use xlink:href="#xmark"></use>
										</svg>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header__mobile" data-mobile-menu>
				<nav class="nav__mobile" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'watermark-theme' ); ?>">
					<div class="header__search" data-search-form>
						<?php get_search_form(); ?>
					</div>
					<?php
						wp_nav_menu(
							array(
								'fallback_cb'    => false,
								'theme_location' => 'primary',
								'menu_id'        => 'primary-mobile',
								'menu_class'     => 'menu menu--mobile menu--main',
								'container'      => false,
							)
						);

						wp_nav_menu(
							array(
								'fallback_cb'    => false,
								'theme_location' => 'header-top',
								'menu_id'        => 'header-mobile',
								'menu_class'     => 'menu menu--mobile menu--header',
								'container'      => false,
							)
						);
					?>
				</nav>
			</div>
		</header>
