<?php
/**
 * The template for displaying contact us pages
 *
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */

get_header();
?>
<main class="contact">
    <section class="contact-details">
        <h2>Contact us</h2>
        <span class="offset-underline"></span>
        <p>Give us a call, fill out our contact form, or come in person if you have any questions.
            We’re happy to help and have our expert staff available during hours of operation. </p>
            
            <div class="loop-flex">

        <?php $args = array(
            'post_type' => 'business',
            'post_status' => 'publish'
        );
        $loop = new WP_Query($args);
        while ($loop->have_posts()) {
            $loop->the_post();
            ?>
            <div>
                <h3>Phone</h3>
                <p>
                    <?php echo esc_html(get_field('phone_number')); ?>
                </p>
            </div>
            <div>
                <h3>Hours of Operation</h3>
                <p>Mon-Fri:
                    <?php echo esc_html(get_field('hours_mon-fri')) ?>
                </p>
                <p>Sat:
                    <?php echo esc_html(get_field('hours_sat')) ?>
                </p>
                <p>Sun:
                    <?php echo esc_html(get_field('hours_sun')) ?>
                </p>

            </div>
           
            </div>
        <p>Have questions about our store, gear, prices and anything in between?</p>
    </section>
    <div class="section-flex">

        <section class="email">
            <div class="contact-form">
                <h3>Send us an email!</h3>
                <?php  echo do_shortcode('[forminator_form id="139"]'); ?>
            </div>
            <p class="or">or</p>
        </section>
        <section class="faq-section">
            <div>

                <h3>FAQs</h3>
                <p>Check out our FAQ page to find common questions</p>
                
                <a class="faq-button" href="<?php echo home_url('/faq');?>"> FAQs</a>
            </div>
            </section>
    </div>
    <section class="map" style= "background: url(<?php echo home_url()?>/wp-content/themes/pacesetter-b/img/store-front-background.webp)">
        <h2>Location</h2>
        <p><?php echo get_field('address'); ?></p>
        <p><?php echo get_field('city');?>, <?php echo get_field('province');?> <?php echo get_field('postal_code');?></p>
            <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d151740.59956275974!2d-113.8983764132812!3d53.54086290000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x53a02103230e0325%3A0xdb9361d3d0c6e002!2sPacesetter%20Ski%20Shoppe!5e0!3m2!1sen!2sca!4v1708037539783!5m2!1sen!2sca"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
</main>
    <?php
        }
get_footer()
    ?>

