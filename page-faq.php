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
            <div class="container banner">
                <h2 class="h1">Frequently Asked Questions <span class="offset-half-underline"></span></h2>
                <p>Our FAQ page provides answers to common inquiries regarding ski equipment, maintenance, events, and
                    more,
                    ensuring you have a smooth and enjoyable skiing and snowboarding experience.</p>
                <img src="<?php echo home_url(); ?>/wp-content/themes/pacesetter-b/img/faq-banner.jpg" alt="">
            </div>
        </section>
        <section>
            <h3 class="h2 container">Most Common Questions</h3>
            <div class="gradient-background">
                <div class="container common-questions-section">
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
                    <div class="accordion">
                        <?php $args = array(
                            'post_type' => 'ski_faq',
                            'post_status' => 'publish'
                        );
                        $loop = new WP_Query($args);
                        while ($loop->have_posts()) {
                            $loop->the_post();
                            ?>

                            <h4>
                                <?php the_title(); ?>

                                <span class="toggled-icon">
                                    <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <svg class="minus-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                    </svg>
                                </span>
                            </h4>
                            <div>
                                <p>
                                    <?php echo esc_html(get_field('faq_answer')); ?>
                                </p>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </section>
            <section>
                <h3 class="h2">Snowboards</h3>
                <div class="accordion">
                    <?php $args = array(
                        'post_type' => 'snowboard_faq',
                        'post_status' => 'publish'
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) {
                        $loop->the_post();
                        ?>
                        <h4>
                            <?php the_title(); ?>
                            <span class="toggled-icon">
                                <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <svg class="minus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </span>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>

                    <?php } ?>
                </div>
            </section>

            <section>
                <h3 class="h2">Care and Upkeep</h3>
                <div class="accordion">
                    <?php $args = array(
                        'post_type' => 'care_faq',
                        'post_status' => 'publish'
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) {
                        $loop->the_post();
                        ?>
                        <h4>
                            <?php the_title(); ?>
                            <span class="toggled-icon">
                                <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <svg class="minus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </span>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>

                    <?php } ?>
                </div>
            </section>
            <section>
                <h3 class="h2">Helmets</h3>
                <div class="accordion">
                    <?php $args = array(
                        'post_type' => 'helmet_faq',
                        'post_status' => 'publish'
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) {
                        $loop->the_post();
                        ?>
                        <h4>
                            <?php the_title(); ?>
                            <span class="toggled-icon">
                                <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <svg class="minus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </span>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>

                    <?php } ?>
                </div>
            </section>
            <section>
                <h3 class="h2">Shop Events/RSVP</h3>
                <div class="accordion">
                    <?php $args = array(
                        'post_type' => 'event_faq',
                        'post_status' => 'publish'
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) {
                        $loop->the_post();
                        ?>
                        <h4>
                            <?php the_title(); ?>
                            <span class="toggled-icon">
                                <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <svg class="minus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </span>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>

                    <?php } ?>
                </div>
            </section>
            <section>
                <h3 class="h2">Returns</h3>
                <div class="accordion">
                    <?php $args = array(
                        'post_type' => 'return_faq',
                        'post_status' => 'publish'
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) {
                        $loop->the_post();
                        ?>
                        <h4>
                            <?php the_title(); ?>
                            <span class="toggled-icon">
                                <svg class="plus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <svg class="minus-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </span>
                        </h4>
                        <div>
                            <p>
                                <?php echo esc_html(get_field('faq_answer')); ?>
                            </p>
                        </div>

                    <?php } ?>
                </div>
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