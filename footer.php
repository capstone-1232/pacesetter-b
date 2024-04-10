<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pacesetter
 */

?>

<?php
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
<button id="backToTopBtn">
	<svg viewBox="0 0 138 138" fill="none" xmlns="http://www.w3.org/2000/svg">
		<g filter="url(#filter0_d_383_972)">
			<circle cx="69" cy="67" r="65" fill="#FFDB57" />
		</g>
		<path fill-rule="evenodd" clip-rule="evenodd"
			d="M64.8727 49.4924C65.6113 49.0557 67.01 48.4285 68.0539 48.4285C69.0978 48.4285 70.3245 49.0557 71.0632 49.4924C71.8018 49.9291 111.276 78.4381 111.276 78.4381C111.972 78.8801 112.35 79.4648 112.332 80.0689C112.314 80.6731 111.901 81.2495 111.179 81.6767C110.457 82.104 109.484 82.3487 108.463 82.3594C107.443 82.37 106.455 82.1458 105.708 81.7339L68.0539 68.6442L32.4879 81.7339C32.1272 81.963 31.6923 82.1467 31.2091 82.2742C30.7258 82.4016 30.2042 82.4702 29.6752 82.4757C29.1463 82.4812 28.6209 82.4236 28.1304 82.3063C27.6398 82.1891 27.1942 82.0145 26.8202 81.7931C26.4461 81.5716 26.1512 81.3079 25.9531 81.0175C25.7549 80.7271 25.6576 80.4161 25.667 80.103C25.6763 79.7899 25.7921 79.4811 26.0074 79.1951C26.2227 78.909 26.5331 78.6516 26.9202 78.4381L64.8727 49.4924Z"
			fill="#01296B" />
		<defs>
			<filter id="filter0_d_383_972" x="0" y="0" width="138" height="138" filterUnits="userSpaceOnUse"
				color-interpolation-filters="sRGB">
				<feFlood flood-opacity="0" result="BackgroundImageFix" />
				<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
					result="hardAlpha" />
				<feOffset dy="2" />
				<feGaussianBlur stdDeviation="2" />
				<feComposite in2="hardAlpha" operator="out" />
				<feColorMatrix type="matrix"
					values="0 0 0 0 0.00392157 0 0 0 0 0.160784 0 0 0 0 0.419608 0 0 0 0.5 0" />
				<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_383_972" />
				<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_383_972" result="shape" />
			</filter>
		</defs>
	</svg>
</button>

<footer id="colophon" class="site-footer">
	<div class="store-info">
		<div>
			<section class="hours">
				<h3>Hours</h3>
				<p>Mon-Fri:
					<?php echo $hours_mon_fri; ?>
				</p>
				<p>Sat:
					<?php echo $hours_sat; ?>
				</p>
				<p>Sun:
					<?php echo $hours_sun; ?>
				</p>
			</section>
			<section class="location">
				<h3>Location</h3>
				<p>
					<?php echo $address; ?>,
				</p>
				<p>
					<?php echo $city . ', ' . $province . ' ' . $postal_code; ?>
				</p>
			</section>
		</div>
		<div class="flex-secondary">
			<section class="phone">
				<h3>Phone</h3>
				<p>
					<?php echo $phone_number; ?>
				</p>
			</section>
			<div class="social-media">
				<a href=""><svg fill="#000000" width="36px" height="36px" viewBox="0 0 24 24"
						xmlns="http://www.w3.org/2000/svg">
						<title>Facebook Logo</title>
						<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
						<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
						<g id="SVGRepo_iconCarrier">
							<path
								d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z">
							</path>
						</g>
					</svg></a>
				<a href=""><svg fill="#000000" height="36px" width="36px" version="1.1"
						xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
						viewBox="-143 145 512 512" xml:space="preserve">
						<title>Instagram Logo</title>
						<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
						<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
						<g id="SVGRepo_iconCarrier">
							<g>
								<path
									d="M113,446c24.8,0,45.1-20.2,45.1-45.1c0-9.8-3.2-18.9-8.5-26.3c-8.2-11.3-21.5-18.8-36.5-18.8s-28.3,7.4-36.5,18.8 c-5.3,7.4-8.5,16.5-8.5,26.3C68,425.8,88.2,446,113,446z">
								</path>
								<polygon points="211.4,345.9 211.4,308.1 211.4,302.5 205.8,302.5 168,302.6 168.2,346 ">
								</polygon>
								<path
									d="M183,401c0,38.6-31.4,70-70,70c-38.6,0-70-31.4-70-70c0-9.3,1.9-18.2,5.2-26.3H10v104.8C10,493,21,504,34.5,504h157 c13.5,0,24.5-11,24.5-24.5V374.7h-38.2C181.2,382.8,183,391.7,183,401z">
								</path>
								<path
									d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M241,374.7v104.8 c0,27.3-22.2,49.5-49.5,49.5h-157C7.2,529-15,506.8-15,479.5V374.7v-52.3c0-27.3,22.2-49.5,49.5-49.5h157 c27.3,0,49.5,22.2,49.5,49.5V374.7z">
								</path>
							</g>
						</g>
					</svg></a>
				<a href=""><svg fill="#000000" height="36px" width="36px" version="1.1" id="Layer_1"
						xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
						viewBox="-143 145 512 512" xml:space="preserve">
						<title>Twitter Logo</title>
						<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
						<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
						<g id="SVGRepo_iconCarrier">
							<path
								d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M215.2,361.2 c0.1,2.2,0.1,4.5,0.1,6.8c0,69.5-52.9,149.7-149.7,149.7c-29.7,0-57.4-8.7-80.6-23.6c4.1,0.5,8.3,0.7,12.6,0.7 c24.6,0,47.3-8.4,65.3-22.5c-23-0.4-42.5-15.6-49.1-36.5c3.2,0.6,6.5,0.9,9.9,0.9c4.8,0,9.5-0.6,13.9-1.9 C13.5,430-4.6,408.7-4.6,383.2v-0.6c7.1,3.9,15.2,6.3,23.8,6.6c-14.1-9.4-23.4-25.6-23.4-43.8c0-9.6,2.6-18.7,7.1-26.5 c26,31.9,64.7,52.8,108.4,55c-0.9-3.8-1.4-7.8-1.4-12c0-29,23.6-52.6,52.6-52.6c15.1,0,28.8,6.4,38.4,16.6 c12-2.4,23.2-6.7,33.4-12.8c-3.9,12.3-12.3,22.6-23.1,29.1c10.6-1.3,20.8-4.1,30.2-8.3C234.4,344.5,225.5,353.7,215.2,361.2z">
							</path>
						</g>
					</svg></a>
			</div>
		</div>
		<div class="footer-nav">
			<nav id="site-navigation" class="main-navigation">
				<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<?php //esc_html_e('Primary Menu', 'pacesetter');   ?>
				</button> -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id' => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>