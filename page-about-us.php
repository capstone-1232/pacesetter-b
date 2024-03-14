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
?>
<main>
    
    <section class="about-section">
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
                <img src="<?php echo esc_html(get_field("section_image")); ?>" alt="An image about <?php echo the_title(); ?>"/>
                <p>
                    <?php echo esc_html(get_field('about_us_text')); ?>
                </p>
            </div>
    
            <?php
        }
        ?>
    </section>
    <section class="staff-section">
        <h3>Meet our staff!</h3>
        <?php
        $args = array(
            'post_type' => 'employee',
            'posts_per_page' => 8,
            'post_status' => 'publish'
        );
        $loop = new WP_Query($args);
        while ($loop->have_posts()) {
            $loop->the_post();
            ?>
            <div class="col">
                <img src="<?php echo esc_html(get_field("employee_image"));?>" />
                <h4>
                    <?php echo esc_html(get_field('title')); ?>
                </h4>
                <p>
                    <?php echo esc_html(get_field('employee_position')); ?>
                </p>
            </div>
    
            <?php
        }
        ?>
    </section>
</main>

<?php
    get_footer();
?>