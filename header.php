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

$page_slug = 'pacesetter-edmonton';

// Get the page object by slug and post type
$page = get_page_by_path($page_slug, OBJECT, 'business');

// Check if the page is found
if ($page) {
	// Get the post ID
	$post_id = $page->ID;

	// Retrieve meta values
	$phone_number = get_post_meta($post_id, 'phone_number', true);
	$address = get_post_meta($post_id, 'address', true);
	$city = get_post_meta($post_id, 'city', true);
	$postal_code = get_post_meta($post_id, 'postal_code', true);
	$province = get_post_meta($post_id, 'province', true);
	$hours_mon_fri = get_post_meta($post_id, 'hours_mon-fri', true);
	$hours_sat = get_post_meta($post_id, 'hours_sat', true);
	$hours_sun = get_post_meta($post_id, 'hours_sun', true);
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<title>
		<?php 
			echo the_title($before = '', $after = ' | ') .  get_bloginfo("name") . ' - ' . get_bloginfo("description");
		?>

	</title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<!-- Link for compiled css -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.css" />
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<div style="background-color: #013562;">
			<div>
				<p>Mon-Fri:
					<?php echo $hours_mon_fri; ?>
				</p>
				<p>
					<?php echo $phone_number; ?>
				</p>
			</div>
			<div>
				<?php get_search_form(); ?>
				<a href="<?php echo wc_get_cart_url(); ?>">
					<svg width="33px" height="33px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
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