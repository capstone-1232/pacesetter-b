<?php
/**
 * The template for displaying the about us page
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */

get_header();
?>
<h2>About pacesetter</h2>
<?php
$args = array(
    'post_type' => 'about_section',
    'posts_per_page' => 8,
    'post_status' => 'publish'
);
$loop = new WP_Query($args);
while ($loop->have_posts()) {
    $loop->the_post();
    ?>
    <div>
        <img src="<?php echo esc_html(get_field("section_image")); ?>" />
        <p>
            <?php echo esc_html(get_field('about_us_text')); ?>
        </p>
    </div>

    <?php
}
?>
</section>


