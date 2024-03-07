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
<section>
    <h2>About pacesetter</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam earum culpa dolorem sint deserunt voluptatem totam in praesentium ipsum, quibusdam officiis iste similique facere rem eius sit unde perspiciatis aliquam.</p>
    <img src="img/about-us-firstplaceholder.png" alt="View of the front of the Pacesetter Store">
</section>

<section>
    <h3>meet our staff!</h3>
    <?php
            $args=array(
                'post_type' => 'staff',
                'posts_per_page' => 8,
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div class="col">
                    <img src="<?php echo esc_html( get_field("staff_photo") );?>"/>
                    <h4><?php echo esc_html(get_field('staff_name'));?></h4>
                <p><?php echo esc_html(get_field('position'));?></p>
                </div>

                <?php
    }
        ?>
</section>