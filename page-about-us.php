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
<h2>About pacesetter</h2>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam earum culpa dolorem sint deserunt voluptatem totam in praesentium ipsum, quibusdam officiis iste similique facere rem eius sit unde perspiciatis aliquam.</p>
<img src="" alt="">
<section>
    <h3>Our History</h3>
    <img src="" alt="">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi sunt, adipisci in, excepturi officiis numquam sapiente, unde quaerat voluptatum fugiat est natus mollitia quisquam tempore! Nesciunt, obcaecati? Voluptates, consequatur quis.</p>
</section>

<section>
    <h3>Meet the owner</h3>
    <img src="" alt="">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi sunt, adipisci in, excepturi officiis numquam sapiente, unde quaerat voluptatum fugiat est natus mollitia quisquam tempore! Nesciunt, obcaecati? Voluptates, consequatur quis. teast test test</p>
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