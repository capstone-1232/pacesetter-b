<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package pacesetter
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( '404', 'pacesetter' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( '...Wait, where are we?', 'pacesetter' ); ?></p>
				<p><?php esc_html_e( 'It seems we’ve gone down the wrong slope!', 'pacesetter' ); ?></p>
				<p><?php esc_html_e( 'This Page No longer exists', 'pacesetter' ); ?></p>

				<ul>
					<li><a href="<?php echo home_url();?>"> Home </a></li>|
					<li><a href="<?php echo home_url('/products');?>">Products </a></li>|
					<li><a href="<?php echo home_url('/events');?>">Events </a></li>|
					<li><a href="<?php echo home_url('/home');?>">Blog </a></li>
				</ul>
				</ul>
				</ul>

					

					

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
