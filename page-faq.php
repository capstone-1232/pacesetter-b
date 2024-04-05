<?php
/**
 * The template for displaying faq pages
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
<main class="faq">
    <section>
        <section class="faq-section">
            <div class="container">
                <h2 class="h1">Frequently Asked Questions <span class="offset-half-underline"></span></h2>
                <p>Our FAQ page provides answers to common inquiries regarding ski equipment, maintenance, events, and more,
                    ensuring you have a smooth and enjoyable skiing and snowboarding experience.</p>
            </div>
        </section>
        <section>
            <div class="gradient-background">
                <div class="container">
                    <h3 class="h2">Most Common Questions</h3>
                    <?php $args = array(
                        'post_type' => 'common_questions',
                        'post_status' => 'publish'
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) {
                        $loop->the_post();
                        ?>
                        <div class="common-questions">
                            <h4 class="h3">
                                <?php the_title(); ?>
                            </h4>
                            <p>
                                <?php echo esc_html(get_field('common_answer')); ?>
                            </p>

                            <a href="<?php echo esc_url(get_field('question_guide')); ?>" target="_blank">Read more</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <div class="container accordion-sections">
            <section>
                <h3 class="h2">Skis and Poles</h3>
                <div>
                    <?php $args = array(
                        'post_type' => 'ski_faq',
                        'post_status' => 'publish'
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) {
                        $loop->the_post();
                        ?>
                        <div class="accordion">
                            <h4>
                                <?php the_title(); ?>
                            </h4>
                            <div>
                                <p>
                                    <?php echo esc_html(get_field('faq_answer')); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
            <section>
                <h3 class="h2">Snowboards</h3>
                <?php $args = array(
                    'post_type' => 'snowboard_faq',
                    'post_status' => 'publish'
                );
                $loop = new WP_Query($args);
                while ($loop->have_posts()) {
                    $loop->the_post();
                    ?>
                    <div class="accordion">
                        <h4>
                            <?php the_title(); ?>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>
                    </div>
    
                <?php } ?>
            </section>
    
            <section>
                <h3 class="h2">Care and Upkeep</h3>
                <?php $args = array(
                    'post_type' => 'care_faq',
                    'post_status' => 'publish'
                );
                $loop = new WP_Query($args);
                while ($loop->have_posts()) {
                    $loop->the_post();
                    ?>
                    <div class="accordion">
                        <h4>
                            <?php the_title(); ?>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>
                    </div>
    
                <?php } ?>
            </section>
            <section>
                <h3 class="h2">Helmets</h3>
                <?php $args = array(
                    'post_type' => 'helmet_faq',
                    'post_status' => 'publish'
                );
                $loop = new WP_Query($args);
                while ($loop->have_posts()) {
                    $loop->the_post();
                    ?>
                    <div class="accordion">
                        <h4>
                            <?php the_title(); ?>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>
                    </div>
    
                <?php } ?>
            </section>
            <section>
                <h3 class="h2">Shop Events/RSVP</h3>
                <?php $args = array(
                    'post_type' => 'event_faq',
                    'post_status' => 'publish'
                );
                $loop = new WP_Query($args);
                while ($loop->have_posts()) {
                    $loop->the_post();
                    ?>
                    <div class="accordion">
                        <h4>
                            <?php the_title(); ?>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>
                    </div>
    
                <?php } ?>
            </section>
            <section>
                <h3 class="h2">Returns</h3>
                <?php $args = array(
                    'post_type' => 'return_faq',
                    'post_status' => 'publish'
                );
                $loop = new WP_Query($args);
                while ($loop->have_posts()) {
                    $loop->the_post();
                    ?>
                    <div class="accordion">
                        <h4>
                            <?php the_title(); ?>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>
                    </div>
    
                <?php } ?>
            </section>
    
            <section class="faq-question">
                <h3 class="h2">Still have Questions?</h3>
                <p>Phone, email, fill out our contact form or visit us in person on 167th St.</p>
                <a class="h3" href="<?php echo home_url('/contact-us'); ?>">Contact Us</a>
            </section>
        </div>
    </section>
</main>

<?php
get_footer();
?>