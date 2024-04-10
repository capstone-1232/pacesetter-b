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
<section class="about-pacesetter">
    <h2>About Pacesetter <span class="offset-underline"></span></h2>
    <?php
    $args = array(
        'post_type' => 'about_section',
        'posts_per_page' => 8,
        'post_status' => 'publish',
        'orderby' => 'date', 
        'order' => 'ASC' 
    );
    $loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();
        ?>
        <div class="about-content">
            <div class="about-max-width">
                <div>
                    <h3><?php the_title()?></h3>
                    <p>
                        <?php echo esc_html(get_field('about_us_text')); ?>
                    </p>
                </div>
                <img src="<?php echo esc_html(get_field("section_image")); ?>" />
            </div>
        </div>

        <?php
    }
    ?>
</section>
<?php
get_footer()
?>