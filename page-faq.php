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
    <main>
    <section class="faq-section">
        <h2>Frequently Asked Questions</h2>
    <p>Our FAQ page provides answers to common inquiries regarding ski equipment, maintenance, events, and more, ensuring you have a smooth and enjoyable skiing and snowboarding experience.</p>
</section>
<section>
    <h3>Commonly Asked Questions</h3>
    <?php $args=array(
                'post_type' => 'common_questions',
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div>
                    <h4><?php echo esc_html(get_field('title'));?></h4>
                    <p><?php esc_html(get_field('question_answer'));?></p>
                    <a href="<?php esc_html(get_field('question_guide'));?>">Read more</a>
                </div>



<?php }?>
</section>
<section>
    <h3>Skis and Poles</h3>
    <?php $args=array(
                'post_type' => 'ski_faq',
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div>
                    <h4><?php echo esc_html(get_field('title'));?></h4>
                    <p><?php echo esc_html(get_field('faq_answer'));?></p>
                </div>



<?php }?>
</section>
<section>
    <h3>Snowboards</h3>
    <?php $args=array(
                'post_type' => 'snowboard_faq',
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div>
                    <h4><?php echo esc_html(get_field('title'));?></h4>
                    <p><?php echo esc_html(get_field('faq_answer'));?></p>
                </div>

<?php }?>
</section>

<section>
    <h3>Care and Upkeep</h3>
    <?php $args=array(
                'post_type' => 'care_faq',
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div>
                    <h4><?php echo esc_html(get_field('title'));?></h4>
                    <p><?php echo esc_html(get_field('faq_answer'));?></p>
                </div>

<?php }?>
</section>
<section>
    <h3>Helmets</h3>
    <?php $args=array(
                'post_type' => 'helmet_faq',
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div>
                    <h4><?php echo esc_html(get_field('title'));?></h4>
                    <p><?php echo esc_html(get_field('faq_answer'));?></p>
                </div>

<?php }?>
</section>
<section>
    <h3>Shop Events/RSVP</h3>
    <?php $args=array(
                'post_type' => 'event_faq',
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div>
                    <h4><?php echo esc_html(get_field('title'));?></h4>
                    <p><?php echo esc_html(get_field('faq_answer'));?></p>
                </div>

<?php }?>
</section>
<section>
    <h3>Returns</h3>
    <?php $args=array(
                'post_type' => 'return_faq',
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div>
                    <h4><?php echo esc_html(get_field('title'));?></h4>
                    <p><?php echo esc_html(get_field('faq_answer'));?></p>
                </div>

<?php }?>
</section>

<section>
    <h3>Still have Questions?</h3>
    <p>Phone, email, fill out our contact form or visit us in person on 167th St.</p>
    <a href="<?php echo home_url('/contact-us');?>">Contact Us</a>
</section>

    </section>
</main>

<?php
get_footer();
?>