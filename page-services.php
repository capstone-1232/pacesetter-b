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
$title = single_post_title();
$content = get_the_content();

?>

<main id="primary" class="site-main">
	<section class="section-services">
		<h2>
			<?php echo $title ?>
		</h2>
		<div>
			<img src="<?php echo $featured_img; ?>" alt="Image of a Ski and Snowboard full service being performed at Pacesetter Ski Shoppe">
			<?php echo $content ?>
		</div>
		<?php

		$args = array(
			'post_type' => 'services-post',
			'numberposts' => 20,
			'category' => 4
		);

		$services_query = new WP_Query($args);

		if ($services_query->have_posts()):
			while ($services_query->have_posts()):
				$services_query->the_post();
				echo '<div>';
				// Display the post title and content
				echo '<h2>' . get_the_title() . '</h2>';
				echo '<hr>';
				echo '<div class="entry-content">' . get_the_content() . '</div>';
				echo '</div>';

			endwhile;

			// Reset the post data
			wp_reset_postdata();

		else:
			// No posts found
			echo '<p>Nothing published so far.</p>';
		endif;
		?>
	</section>
	<section class="section-rentals">
		<h2>
			<?php $post_type_object = get_post_type_object('rentals');
			if ($post_type_object) {
				$plural_label = $post_type_object->labels->name;
				echo $plural_label;
			} ?>
		</h2>
		<p>To rent you must be 18 years of age or have a responsible adult (Parent or guardian) in attendance at
			time of reservation, with a current driver license or government identification and a valid Visa or
			MasterCard. (American Express, debit and cash cannot be used for rental security deposit)</p>
		<hr>
		<?php

		$args = array(
			'post_type' => 'rentals',
			'numberposts' => 20,
			'category' => 4
		);

		$services_query = new WP_Query($args);

		if ($services_query->have_posts()):
			while ($services_query->have_posts()):
				$services_query->the_post();

				// Display the post title and content
				echo '<div>';
				echo '<h2>' . get_the_title() . '</h2>';
				echo '<hr>';
				echo '<div class="entry-content">' . get_the_content() . '</div>';
				echo '</div>';

			endwhile;

			// Reset the post data
			wp_reset_postdata();

		else:
			// No posts found
			echo '<p>Nothing published so far.</p>';
		endif;
		?>
	</section>

</main><!-- #main -->
<?php
get_sidebar();
get_footer();
