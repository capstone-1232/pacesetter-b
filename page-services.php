<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */

get_header();

$featured_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
$id = get_the_ID();
$post = get_post($id);
$content = get_the_content();

?>

<main id="primary" class="site-main">
	<section class="section-services">
		<div>
			<?php echo $content ?>
		</div>
</main><!-- #main -->
<?php
get_footer();
