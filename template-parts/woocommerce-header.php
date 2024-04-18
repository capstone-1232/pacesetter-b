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
		$category = get_queried_object();

		echo ucfirst($category->name) . ' | ' . get_bloginfo("name") . ' - ' . get_bloginfo("description");
		?>
	</title>
	<meta name="description" content="<?php bloginfo("description"); ?>">
	<meta name="keywords"
		content="Ski, Snowboard, Edmonton, Sports, Store, Online, Alberta, Services, Rentals, Events, Experienced, Local, West">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="/favicon.ico">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Racing+Sans+One&display=swap"
		rel="stylesheet">

	<?php wp_head(); ?>

	<!-- Link for compiled css -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.css" />
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header id="masthead" class="site-header">
		<div id="page" class="site">
			<div class="navbar">
				<div class="info-nav">
					<div class="operation-hours">
						<p>
							Mon-Fri: 9:30am - 5:30pm
						</p>
						<p>
							(780) 483-2005
						</p>
					</div>
					<div class="nav-utils">
						<div class="search-section">
							<div id="main-search" class="hidden">
								<?php get_search_form(); ?>
							</div>
							<button type="button" id="show-search" class="show-search unstyle-btn">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
									stroke-width="1.5" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
								</svg>
							</button>
						</div>
					</div>
				</div>

				<a class="skip-link screen-reader-text" href="#primary">
					<?php esc_html_e('Skip to content', 'pacesetter'); ?>
				</a>
				<div class="main-nav relative">
					<div class="site-branding">
						<?php
						the_custom_logo();
						if (is_front_page() && is_home()):
							?>
							<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
									<img src="<?php echo home_url() ?>/wp-content/themes/pacesetter-b/img/pacesetter-logo.svg"
										alt="">
								</a></h1>
							<?php
						else:
							?>
							<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
									<img src="<?php echo home_url() ?>/wp-content/themes/pacesetter-b/img/pacesetter-logo.svg"
										alt="">
								</a></p>
							<?php
						endif;
						?>
					</div><!-- .site-branding -->
					<nav class="toggle-nav">
						<button type="button" class="main-nav-toggle">
							<svg xmlns="http://www.w3.org/2000/svg" class="open" fill="none" viewBox="0 0 24 24"
								stroke-width="1.5" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
							</svg>

							<svg xmlns="http://www.w3.org/2000/svg" class="close hidden" fill="none" viewBox="0 0 24 24"
								stroke-width="1.5" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
							</svg>

						</button>
						<div class="toggle-menu hidden full-width">
							<div class="column-container full-width container relative">
								<div class="left-column">
									<h2>Products</h2>
									<div class="categories billboard">
										<?php

										$product_categories = get_terms(
											array(
												'taxonomy' => 'product_cat',
												'hide_empty' => false,
											)
										);

										foreach ($product_categories as $category) {

											if ($category->parent == 0 && $category->slug != "uncategorized") {
												echo "<div class=\"category-select\">";
												echo "<a href=\"" . get_term_link($category) . "\">" . $category->name . "</a>";
												echo "</div>";
											}
										}

										?>
									</div>
									<div>
										<?php

										// $menu = wp_get_nav_menu_items('18');
										$menu_object = wp_get_nav_menu_object('main-menu');
										$menu = wp_get_nav_menu_items($menu_object->term_id);

										echo "<ul class=\"navlinks\">";
										foreach ($menu as $link) {
											if ($link->title != "Products") {
												echo "<li>";
												echo "<a href=\"$link->url\">$link->title</a>";
												echo "</li>";
											}
										}
										echo "</ul>";

										?>
									</div>
								</div>
								<div class="right-column hidden">
									<button type="button">
										Close
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
											stroke-width="1.5" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
										</svg>
									</button>

									<?php

									foreach ($product_categories as $category) {
										$subcategories = get_terms(
											array(
												'taxonomy' => 'product_cat',
												'hide_empty' => false,
												'parent' => $category->term_id,
											)
										);

										if ($category->parent == 0 && $category->slug != "uncategorized") {
											echo "<div class=\"subcategories " . $category->name . "\">";
											echo "<ul class=\"subcategory-list\">";

											foreach ($subcategories as $subcat) {
												$link = get_term_link($subcat);
												$name = $subcat->name;
												echo "<li><a href=\"$link\">$name</a></li>";
											}

											echo "</div>";
											echo "</ul>";
										}
									}
									?>
								</div>
							</div>
						</div>
					</nav>
					<nav class="desktop-nav">
						<div class="navlinks">
							<?php
							// $menu = wp_get_nav_menu_items('18');
							foreach ($menu as $link) {
								if ($link->title == "Products") {
									echo "<a href=\"$link->url\" class=\"dropdown-toggle\"><p>$link->title</p><svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z\" clip-rule=\"evenodd\" /></svg></a>";
								} else {
									echo "<a href=\"$link->url\">$link->title</a>";
								}
							}
							?>
						</div>
						<div class="dropdown-menu absolute">
							<?php
							foreach ($product_categories as $category) {
								if ($category->parent == 0 && $category->slug != "uncategorized") {
									$subcategories = get_terms(
										array(
											'taxonomy' => 'product_cat',
											'hide_empty' => false,
											'parent' => $category->term_id,
										)
									);

									echo "<div>";
									echo "<h3><a href=\"" . get_term_link($category) . "\">" . $category->name . "</a><span class=\"underline\"><span></h3>";
									echo "<ul>";
									foreach ($subcategories as $subcat) {
										$link = get_term_link($subcat);
										$name = $subcat->name;
										echo "<li><a href=\"$link\">$name</a></li>";
									}
									echo "</ul>";
									echo "</div>";
								}
							}
							?>
						</div>
					</nav>
				</div>
			</div>
	</header><!-- #masthead -->