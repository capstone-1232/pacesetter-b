<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pacesetter
 */


?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<title>
		<?php 
		// bloginfo('name');
		// wp_title(); 

		echo the_title( $before = '', $after = ' | ' ) . get_bloginfo("name") . ' - ' . get_bloginfo("description");
		?>
	</title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="keywords"
		content="Ski, Snowboard, Edmonton, Sports, Store, Online, Alberta, Services, Rentals, Events, Experienced, Local, West">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Racing+Sans+One&display=swap" rel="stylesheet">

	<?php wp_head(); ?>

	<!-- Link for compiled css -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.css" />
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<div style="background-color: #013562;">
			<div>
				<p>
					Mon-Fri: 9:30am - 5:30pm
				</p>
				<p>
					(780) 483-2005
				</p>

			</div>
			<div>
				<?php get_search_form(); ?>
				<a href="<?php echo wc_get_cart_url(); ?>">
					<svg width="33px" height="33px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<title>This is an image of a cart</title>
						<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
						<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
						<g id="SVGRepo_iconCarrier">
							<path
								d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z"
								stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
						</g>
					</svg>
				</a>
			</div>
		</div>

		<a class="skip-link screen-reader-text" href="#primary">
			<?php esc_html_e('Skip to content', 'pacesetter'); ?>
		</a>

		<header id="masthead" class="site-header">
			<div class="site-branding">
				<?php
				the_custom_logo();
				if (is_front_page() && is_home()):
					?>
					<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<?php bloginfo('name'); ?>
						</a></h1>
					<?php
				else:
					?>
					<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<?php bloginfo('name'); ?>
						</a></p>
					<?php
				endif;
				?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"
					aria-label="Main Menu toggle">
					<?php esc_html_e('Primary Menu', 'pacesetter'); ?>
				</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id' => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->